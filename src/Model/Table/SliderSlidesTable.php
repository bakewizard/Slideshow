<?php
declare(strict_types=1);

namespace Slideshow\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SliderSlides Model
 *
 * @method \Slideshow\Model\Entity\SliderSlide get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Slideshow\Model\Entity\SliderSlide newEntity(array $data, array $options = [])
 * @method array<\Slideshow\Model\Entity\SliderSlide> newEntities(array $data, array $options = [])
 * @method \Slideshow\Model\Entity\SliderSlide|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Slideshow\Model\Entity\SliderSlide saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Slideshow\Model\Entity\SliderSlide patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Slideshow\Model\Entity\SliderSlide> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Slideshow\Model\Entity\SliderSlide findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @property \Slideshow\Model\Table\SlidersTable&\Cake\ORM\Association\BelongsTo $Sliders
 * @property \Cake\ORM\Table&\Cake\ORM\Association\HasMany $SlideshowSliderSlidesI18n
 * @method \Slideshow\Model\Entity\SliderSlide newEmptyEntity()
 * @method \Cake\Datasource\ResultSetInterface<\Slideshow\Model\Entity\SliderSlide>|false saveMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Slideshow\Model\Entity\SliderSlide> saveManyOrFail(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Slideshow\Model\Entity\SliderSlide>|false deleteMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Slideshow\Model\Entity\SliderSlide> deleteManyOrFail(iterable $entities, array $options = [])
 * @mixin \Cake\ORM\Behavior\TranslateBehavior
 * @mixin \ADmad\Sequence\Model\Behavior\SequenceBehavior
 * @extends \Cake\ORM\Table<array{Sequence: \ADmad\Sequence\Model\Behavior\SequenceBehavior, Translate: \Cake\ORM\Behavior\TranslateBehavior}>
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
            'translationTable' => 'SlideshowSliderSlidesI18n',
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
