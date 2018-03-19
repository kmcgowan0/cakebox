<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Interests']
        ]);

        $ids = [];

        foreach ($user->interests as $interest) {
            $id = $interest->id;
            array_push($ids, $id);
        }

        $related_users = $this->Users->find()->matching('Interests', function ($q) use ($ids) {
            $related = $q->where(['Interests.id IN' => $ids]);
            if ($related) {
                return $related;
            }
        });

        $this->set(compact('user', 'related_users', 'commonInterests'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }


        $interests = $this->Users->Interests->find('list', ['limit' => 200]);
        $this->set(compact('user', 'interests'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Interests']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user_data = $this->request->getData();
            $imageFileName = null;
            if (!empty($user_data['upload']['name'])) {
                $file = $user_data['upload'];
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                $arr_ext = ['jpg', 'png']; //set allowed extensions
                $setNewFileName = time() . "_" . rand(000000, 999999);
                //only process if the extension is valid
                if (in_array($ext, $arr_ext)) {
                    //do the actual uploading of the file. First arg is the tmp name, second arg is
                    //where we are putting it
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName . '.' . $ext);

                    //prepare the filename for database entry
                    $imageFileName = $setNewFileName . '.' . $ext;

                    /*
                                  $image = new ImageResize('img/reports/' . $imageFileName . '.jpg');
                                  $image->scale(50);
                                  $image->save('img/reports/' . $imageFileName . '_thumb.jpg');
                    */
                }
                $user_data['upload'] = $imageFileName;
            }
            var_dump($user_data);
            $user = $this->Users->patchEntity($user, $user_data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }



        $users_interests = $this->Users->UsersInterests->find('all');
        $users_interests->distinct('interest_id');

        //get count of each interest
        $number_of_interests = [];
        foreach ($users_interests as $users_interest) {
            $query = $this->Users->UsersInterests->find('all');
            $query->where(['interest_id' => $users_interest['interest_id']]);
            $number = $query->count();
            $number_of_interests[$users_interest['interest_id']] = $number;
        }
        //sort by count
        arsort($number_of_interests);

        //take the first 4 from the array
        $largest = array_slice($number_of_interests, 0, 4, true);

        //get array of just interest ids for query
        $top_interest_array = [];
        foreach ($largest as $key => $value) {
            array_push($top_interest_array, $key);
        }
        $top_interests = $this->Users->Interests->find('list')->where(['id IN' => $top_interest_array]);
        $interests = $this->Users->Interests->find('list', ['limit' => 200]);

        $this->set(compact('user', 'interests', 'top_interests'));
    }

    public function editInterests($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Interests']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $this->log($this->request->getData(), 'debug');
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
            $this->log($this);
        }

        $users_interests = $this->Users->UsersInterests->find('all');
        $users_interests->distinct('interest_id');

        //get count of each interest
        $number_of_interests = [];
        foreach ($users_interests as $users_interest) {
            $query = $this->Users->UsersInterests->find('all');
            $query->where(['interest_id' => $users_interest['interest_id']]);
            $number = $query->count();
            $number_of_interests[$users_interest['interest_id']] = $number;
        }
        //sort by count
        arsort($number_of_interests);

        //take the first 4 from the array
        $largest = array_slice($number_of_interests, 0, 4, true);

        //get array of just interest ids for query
        $top_interest_array = [];
        foreach ($largest as $key => $value) {
            array_push($top_interest_array, $key);
        }
        $top_interests = $this->Users->Interests->find('list')->where(['id IN' => $top_interest_array]);

        $interests = $this->Users->Interests->find('list', ['limit' => 200]);
        $this->set(compact('user', 'interests', 'top_interests'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your username or password is incorrect.');
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function passwordReset()
    {
        $user = $this->Users->get($this->Auth->user('id'));
        if (!empty($this->request->data)) {
            $user = $this->Users->patchEntity($user, [
                'old_password' => $this->request->data['old_password'],
                'password' => $this->request->data['password1'],
                'password1' => $this->request->data['password1'],
                'password2' => $this->request->data['password2']
            ],
                ['validate' => 'password']
            );
            if ($this->Users->save($user)) {
                $this->Flash->success('The password is successfully changed');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('There was an error during the save!');
            }
        }
        $this->set('user', $user);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['add', 'logout', 'login']);
    }


}
