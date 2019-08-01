<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace AdminApp\Controller;

use AdminApp\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\i18n\Time;

/**
 * Contacts Controller
 */
class ContactsController extends AppController
{
    // *********************************************************
    // * Actions
    // *********************************************************
    /**
     * Detail
     *
     * @param string $contactId The contact id.
     * @return \Cake\Http\Response|void
     */
    public function detail($contactId)
    {
        if ($this->request->is('post')) {
            $conn = ConnectionManager::get('default');
            $conn->begin();
        }

        $contact = $this->Contacts->get($contactId, [
            'conditions' => ['deleted IS NULL']
        ]);

        $defaults = ['note' => $contact->note];
        $errors = [];
        if ($this->request->is('post')) {
            $note = $this->request->getData('note');
            $contact = $this->Contacts->patchEntity($contact, compact('note'));
            if ($this->Contacts->save($contact)) {
                $conn->commit();
                $this->Flash->success(__d('contacts', 'The note has been saved'));

                return $this->redirect(['action' => $this->request->action, $contactId]);
            }
            $conn->rollback();
            $this->Flash->error(__d('contacts', 'The note could not be saved'));
            $defaults = $this->request->getData();
            $errors = $contact->errors();
        }
        $this->set(compact('contact', 'defaults', 'errors'));

        $this->setPageTitle(__d('contacts', 'Contact detail'));
    }

    /**
     * List
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // Delete
        if ($this->request->getData('action') === 'delete') {
            try {
                $contactId = $this->request->getData('contact_id');
                $contact = $this->Contacts->get($contactId);
                $this->Contacts->updateAll(['deleted' => Time::now()], ['Contacts.id' => $contactId]);
                $this->Flash->success(__d('contacts', 'The contact has been deleted'));
            } catch (InvalidArgumentException $excp) {
                $this->Flash->error(__('Please press the delete button again'));
            }

            return $this->redirect(['action' => $this->request->action]);
        }

        $query = $this->Contacts->find()
            ->where(['deleted IS NULL'])
            ->order(['created' => 'DESC']);
        $contacts = $this->paginate($query);
        $this->set(compact('contacts'));

        $this->setPageTitle(__d('contacts', 'Contacts'));
    }
}
