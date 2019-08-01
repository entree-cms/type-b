<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace AdminApp\Controller;

use AdminApp\Controller\AppController;
use Cake\Core\Exception\Exception;
use Cake\Datasource\ConnectionManager;
use \RuntimeException;

/**
 * Images Controller
 */
class ImagesController extends AppController
{
    // Number of images to get at one time.
    const IMG_LIMIT = 20;

    // *********************************************************
    // * Actions (Sub window)
    // *********************************************************
    /**
     * Image list
     *
     * @return void
     */
    public function subList()
    {
        $this->loadModel('Images');

        $images = $this->Images->getImages(self::IMG_LIMIT);
        $this->set(compact('images'));

        // Max size
        $maxFileSize = ini_get('upload_max_filesize');
        $this->set(compact('maxFileSize'));

        // Calculate last page number
        $countImg = $this->Images->find()->count();
        $lastPage = ceil($countImg / self::IMG_LIMIT);
        $this->set(compact('lastPage'));

        // Page Title
        $this->setPageTitle(__d('images', 'Choose image'));
    }

    // *********************************************************
    // * Ajax
    // *********************************************************
    /**
     * Delete image
     *
     * @return void
     */
    public function ajaxDelete()
    {
        $conn = ConnectionManager::get('default');
        $conn->begin();

        $output = ['result' => false];
        try {
            $imageId = $this->request->getData('image_id');
            if (!is_numeric($imageId)) {
                throw new Exception;
            }
            $image = $this->Images->get($imageId);
            if (file_exists($image->fullpath)) {
                unlink($image->fullpath);
            }
            $result = $this->Images->delete($image);
            $conn->commit();
            $output['result'] = true;
        } catch (Exception $e) {
            $conn->rollback();
        }

        echo json_encode($output);
    }

    /**
     * Get image
     *
     * @param string $page The number of page.
     * @return void
     */
    public function ajaxGetImages($page)
    {
        $images = $this->Images->getImages(self::IMG_LIMIT, $page);
        $output = [
            'result' => false,
            'images' => []
        ];
        foreach ($images as $image) {
            $output['images'][] = [
                'id' => $image->id,
                'src' => $image->src
            ];
        }
        $output['result'] = true;
        echo json_encode($output);
    }

    /**
     * Upload image
     *
     * @return void
     */
    public function ajaxUpload()
    {
        $this->loadComponent('Utility');
        $this->loadModel('Images');

        $output = ['result' => false];
        try {
            $files = $this->request->getUploadedFiles();
            if (!isset($files['upfile'])) {
                $output['error'] = __d('files', 'Please choose file');
            }
            $file = $files['upfile'];
            $error = $this->validateFile($file);
            if ($error) {
                throw new RuntimeException($error);
            }
            $path = $this->makePath($file);
            $savePath = UP_IMG_DIR . str_replace('/', DS, $path);
            $file->moveTo($savePath);
            // Save to database
            $info = getimagesize($savePath);
            $image = $this->Images->newEntity([
                'name' => $file->getClientFilename(),
                'path' => $path,
                'width' => $info[0],
                'height' => $info[1],
                'mime' => $info['mime'],
                'size' => filesize($savePath)
            ]);
            if (!$this->Images->save($image)) {
                throw new RuntimeException($this->Utility->arrToStr($image->getErrors()));
            }
            $output['result'] = true;
            $output['image'] = [
                'id' => $image->id,
                'src' => $image->src
            ];
        } catch (RuntimeException $e) {
            $output['error'] = $e->getMessage();
        }
        echo json_encode($output);
    }

    // *********************************************************
    // * Private functions
    // *********************************************************
    /**
     * Make path
     *
     * @param Zend\Diactoros\UploadedFile $file Uploaded file.
     * @return string Save path.
     */
    private function makePath($file)
    {
        $y = date('Y');
        $m = date('m');
        if (!file_exists(UP_IMG_DIR . $y)) {
            mkdir(UP_IMG_DIR . $y);
        }
        if (!file_exists(UP_IMG_DIR . $y . DS . $m)) {
            mkdir(UP_IMG_DIR . $y . DS . $m);
        }
        $saveName = sha1($file->getClientFilename());
        $path = "{$y}/{$m}/{$saveName}";

        return $path;
    }

    /**
     * Validate uploaded file.
     *
     * @param Zend\Diactoros\UploadedFile $file Uploaded file.
     * @return string|null Error message or NULL.
     */
    private function validateFile($file)
    {
        // Error check
        switch ($file->getError()) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                return __d('images', 'Please choose file.');
            case UPLOAD_ERR_FORM_SIZE:
            case UPLOAD_ERR_INI_SIZE:
                return __d('images', 'Requested file size limit is greater than maximum.');
            default:
                return __('Unknown errors');
        }

        return null;
    }
}
