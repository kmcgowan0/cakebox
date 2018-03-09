<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Interests Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Interest get($primaryKey, $options = [])
 * @method \App\Model\Entity\Interest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Interest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Interest|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Interest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Interest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Interest findOrCreate($search, callable $callback = null, $options = [])
 */
class InterestsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('interests');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Users', [
            'foreignKey' => 'interest_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'users_interests'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 32)
            ->requirePresence('name', 'create')
            ->notEmpty('name');


        $validator
            ->scalar('description')
            ->allowEmpty('description');

        return $validator;
    }
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['name']));
        return $rules;
    }

}
