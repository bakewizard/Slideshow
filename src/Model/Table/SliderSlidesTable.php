<?php

declare(strict_types=1);

namespace Slideshow\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SliderSlides Model
 *
 * @property \Slideshow\Model\Table\SlideshowSlidersTable&\Cake\ORM\Association\BelongsTo $SlideshowSliders
 *
 * @method \Slideshow\Model\Entity\SliderSlide get($primaryKey, $options = [])
 * @method \Slideshow\Model\Entity\SliderSlide newEntity($data = null, array $options = [])
 * @method \Slideshow\Model\Entity\SliderSlide[] newEntities(array $data, array $options = [])
 * @method \Slideshow\Model\Entity\SliderSlide|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Slideshow\Model\Entity\SliderSlide saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Slideshow\Model\Entity\SliderSlide patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Slideshow\Model\Entity\SliderSlide[] patchEntities($entities, array $data, array $options = [])
 * @method \Slideshow\Model\Entity\SliderSlide findOrCreate($search, callable $callback = null, $options = [])
 */
class SliderSlidesTable extends Table
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

        $this->setTable('slideshow_slider_slides');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Sliders', [
            'foreignKey' => 'slider_id',
            'joinType' => 'INNER',
            'className' => 'Slideshow.Sliders',
        ]);

        $this->addBehavior('Translate', [
            'fields' => ['title', 'description', 'url'],
            'translationTable' => 'SlideshowSliderSlidesI18n'
        ]);

        $this->addBehavior('ADmad/Sequence.Sequence', [
            'scope' => ['slider_id'],
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
                ->nonNegativeInteger('id')
                ->allowEmptyString('id', null, 'create');

        $validator
                ->scalar('title')
                ->maxLength('title', 100)
                ->allowEmptyString('title');

        $validator
                ->scalar('description')
                ->allowEmptyString('description');

        $validator
                ->scalar('url')
                ->maxLength('url', 255)
                ->requirePresence('url', 'create')
                ->notEmptyString('url');

        $validator
                ->scalar('target')
                ->maxLength('target', 10)
                ->allowEmptyString('target');

        $validator
                ->nonNegativeInteger('position')
                ->allowEmptyString('position');

        $validator
                ->boolean('enabled')
                ->notEmptyString('enabled');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['slider_id'], 'Sliders'));

        return $rules;
    }
}
