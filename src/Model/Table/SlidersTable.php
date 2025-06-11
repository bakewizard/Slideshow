<?php
declare(strict_types=1);

namespace Slideshow\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sliders Model
 *
 * @method \Slideshow\Model\Entity\Slider get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Slideshow\Model\Entity\Slider newEntity(array $data, array $options = [])
 * @method array<\Slideshow\Model\Entity\Slider> newEntities(array $data, array $options = [])
 * @method \Slideshow\Model\Entity\Slider|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Slideshow\Model\Entity\Slider saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Slideshow\Model\Entity\Slider patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Slideshow\Model\Entity\Slider> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Slideshow\Model\Entity\Slider findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @property \Slideshow\Model\Table\SliderSlidesTable&\Cake\ORM\Association\HasMany $SliderSlides
 * @method \Slideshow\Model\Entity\Slider newEmptyEntity()
 * @method \Cake\Datasource\ResultSetInterface<\Slideshow\Model\Entity\Slider>|false saveMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Slideshow\Model\Entity\Slider> saveManyOrFail(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Slideshow\Model\Entity\Slider>|false deleteMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Slideshow\Model\Entity\Slider> deleteManyOrFail(iterable $entities, array $options = [])
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
            'className' => 'Slideshow.SliderSlides',
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
