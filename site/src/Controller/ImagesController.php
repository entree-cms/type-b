<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace SiteApp\Controller;

use Cake\Core\Exception\Exception;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\NotFoundException;
use SiteApp\Controller\AppController;

/**
 * Images Controller
 */
class ImagesController extends AppController
{
    // *********************************************************
    // * Actions
    // *********************************************************
    /**
     * Show upload image.
     *
     * @param string $name File name.
     * @return void
     */
    public function show($name)
    {
        $this->loadModel([
            'Images'
        ]);

        $image = $this->Images->findByName($name)
            ->first();
        if (!$image) {
            throw new NotFoundException;
        }

        $fullpath = $image->fullpath;
        if (!file_exists($fullpath)) {
            throw new NotFoundException;
        }

        header("Content-Type: {$image->mime}");
        readfile($fullpath);
        exit;
    }
}
