<?php

declare(strict_types=1);

namespace Slideshow\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sliders Model
 *
 * @method \Slideshow\Model\Entity\Slider get($primaryKey, $options = [])
 * @method \Slideshow\Model\Entity\Slider newEntity($data = null, array $options = [])
 * @method \Slideshow\Model\Entity\Slider[] newEntities(array $data, array $options = [])
 * @method \Slideshow\Model\Entity\Slider|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Slideshow\Model\Entity\Slider saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Slideshow\Model\Entity\Slider patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Slideshow\Model\Entity\Slider[] patchEntities($entities, array $data, array $options = [])
 * @method \Slideshow\Model\Entity\Slider findOrCreate($search, callable $callback = null, $options = [])
 */
class SlidersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('slideshow_sliders');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('SliderSlides', [
            'foreignKey' => 'slider_id',
            'className' => 'Slideshow.SliderSlides'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): \Cake\Validation\Validator
    {
        $validator
                ->nonNegativeInteger('id')
                ->allowEmptyString('id', null, 'create');

        $validator
                ->scalar('title')
                ->maxLength('title', 100)
                ->requirePresence('title', 'create')
                ->notEmptyString('title');

        $validator
                ->scalar('description')
                ->maxLength('description', 500)
                ->allowEmptyString('description');

        $validator
                ->nonNegativeInteger('width')
                ->requirePresence('width', 'create')
                ->notEmptyString('width');

        $validator
                ->nonNegativeInteger('height')
                ->requirePresence('height', 'create')
                ->notEmptyString('height');

        $validator
                ->nonNegativeInteger('delay')
                ->notEmptyString('delay');

        return $validator;
    }
}
