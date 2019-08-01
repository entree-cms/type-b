<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace SiteApp\Controller;

use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use SiteApp\Controller\AppController;

/**
 * Contacts controller
 */
class ContactsController extends AppController
{
    // *********************************************************
    // * Actions
    // *********************************************************
    /**
     * Contact Form
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->loadModel([
            'Contacts'
        ]);

        $defaults = [];
        $errors = [];
        if ($this->request->is('post')) {
            $conn = ConnectionManager::get('default');
            try {
                // IP & User Aagent
                $sendUser = [
                    'ip' => $this->request->clientIp(false),
                    'user_agent' => $this->request->getHeaderLine('User-Agent'),
                ];
                // Save
                $defaults = $this->normalize($this->request->getData());
                $contact = $this->Contacts->newEntity(array_merge(
                    $defaults,
                    $sendUser
                ));
                $result = $this->Contacts->save($contact);
                if (!$result) {
                    $errors = $contact->getErrors();
                    throw new Exception;
                }
                // Send Email
                $email = new Email('default');
                $email->viewBuilder()->setTemplate('contact');
                $email
                    ->setEmailFormat('text')
                    ->setFrom(Configure::read('Site.contact.from'))
                    ->setTo(Configure::read('Site.contact.to'))
                    ->setViewVars(compact('contact'))
                    ->setSubject(__d('contacts', 'Contact from website'))
                    ->send();
                // Commit
                $conn->commit();

                return $this->redirect(['action' => $this->request->action, '?' => ['m' => 'c']]);
            } catch (Exception $e) {
                $errorMsg = '<p class="text-center">' . __d('contacts', 'Failed to send message') . '</p>';
                if (count($errors) > 0) {
                    $errorMsg .= '<p>' . __('Fix the following errors') . '</p>';
                } else {
                    $errorMsg .= '<p>' . __('The service is temporarily unavailable') . '</p>';
                }
                $errorMsg = "<div class=\"alert alert-danger\">{$errorMsg}</div>";
                $conn->rollback();
                $this->Flash->error($errorMsg);
            }
        }

        $this->set(compact('defaults', 'errors'));

        $this->setPageTitle(__d('contacts', 'Contact'));
    }

    // *********************************************************
    // * Private functions
    // *********************************************************
    /**
     * Normalize post data.
     *
     * @param array $post Raw submit data.
     * @return array Normalized data.
     */
    private function normalize($post)
    {
        $output = [
            'name' => '',
            'email' => '',
            'body' => ''
        ];
        foreach ($output as $name => $value) {
            if (isset($post[$name]) && is_string($post[$name])) {
                $output[$name] = $post[$name];
            }
        }

        return $output;
    }
}
