<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Messages Controller
 *
 * @property \App\Model\Table\MessagesTable $Messages
 *
 * @method \App\Model\Entity\Message[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MessagesController extends AppController
{

    public $uses = array('Messages', 'Users');
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
//        $this->paginate = [
//            'contain' => ['Senders', 'Recipients']
//        ];
        $messages = $this->paginate($this->Messages);

        $this->set(compact('messages'));
    }

    /**
     * View method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        //get all messages from this user
        $messages_in_thread = $this->Messages->find('all', array(
            'conditions' => array(
                'OR' => array(
                    array('sender' => $id, 'recipient' => $this->Auth->user('id')),
                    array('recipient' => $id, 'sender' => $this->Auth->user('id')),
                )

            )
        ));

        //sending messages from within message view
        $message = $this->Messages->newEntity();
        if ($this->request->is('post')) {

            $message_data = $this->request->getData();
            $message_data['sender'] = $this->Auth->user('id');
            $message_data['recipient'] = $id;
            $message_data['sent'] = date('Y-m-d h:i');
            $message = $this->Messages->patchEntity($message, $message_data);
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('Message sent'));
            } else {
                $this->Flash->error(__('The message could not be sent. Please, try again.'));
            }
        }
        $this->loadModel('Users');
        $this->set(compact('messages_in_thread', 'message'));
    }

    public function inbox() {


        //find all messages relating to current user
        $messages = $this->Messages->find('all', array(
            'conditions' => array(
                'OR' => array(
                    array('sender' => $this->Auth->user('id')),
                    array('recipient' => $this->Auth->user('id')),
                )

            )
        ));
        //find all users who have either sent or received messages relating to current user
        $messaged = [];
        foreach ($messages as $message) {
            if ($message->sender != $this->Auth->user('id') && !in_array($message->sender, $messaged)) {
                array_push($messaged, $message->sender);
            }
            if ($message->recipient != $this->Auth->user('id') && !in_array($message->recipient, $messaged)) {
                array_push($messaged, $message->recipient);
            }
        }
        //for each user find all related messages
        $message_threads = [];
        foreach ($messaged as $messaged_user) {
            $messages_in_thread = $this->Messages->find('all', array(
                'conditions' => array(
                    'OR' => array(
                        array('sender' => $messaged_user),
                        array('recipient' => $messaged_user),
                    )

                )
            ));
            array_push($message_threads, $messages_in_thread);
        }
        $this->set(compact('messages', 'messaged', 'message_threads'));
    }

    public function outbox() {
        $messages = $this->Messages->find('all', array(
            'conditions' => array(
                'OR' => array(
                    array('sender' => $this->Auth->user('id')),
                    array('recipient' => $this->Auth->user('id')),
                )

            )
        ));
        $this->set('messages', $messages);
    }

    public function compose($recipient = null) {
        $message = $this->Messages->newEntity();
        if ($this->request->is('post')) {

            $message_data = $this->request->getData();
            $message_data['sender'] = $this->Auth->user('id');
            $message_data['recipient'] = $recipient;
            $message_data['sent'] = date('Y-m-d h:i');
            $message = $this->Messages->patchEntity($message, $message_data);
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('Message sent'));
                return $this->redirect(['action' => 'outbox']);
            }
            $this->Flash->error(__('The message could not be sent. Please, try again.'));

        }
        $this->loadModel('Users');
        $recipients = $this->Users->find('list', ['limit' => 200]);
        $this->set(compact('message', 'recipients'));

    }
    /**
     * Edit method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $message = $this->Messages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $message = $this->Messages->patchEntity($message, $this->request->getData());
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message could not be saved. Please, try again.'));
        }
//        $senders = $this->Messages->Senders->find('list', ['limit' => 200]);
//        $recipients = $this->Messages->Recipients->find('list', ['limit' => 200]);
        $this->set(compact('message'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $message = $this->Messages->get($id);
        if ($this->Messages->delete($message)) {
            $this->Flash->success(__('The message has been deleted.'));
        } else {
            $this->Flash->error(__('The message could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}