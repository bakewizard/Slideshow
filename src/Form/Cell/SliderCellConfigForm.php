<?php
declare(strict_types=1);

namespace Slideshow\Form\Cell;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * CellConfig Form.
 */
class SliderCellConfigForm extends Form
{
    /**
     * @var array
     */
    private array $sliders;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $labels = TableRegistry::getTableLocator()->get('Slideshow.Sliders');
        $this->sliders = $labels->find('list')->toArray();
    }

    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addField('slider', 'integer');
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        return $validator->nonNegativeInteger('slider');
    }

    /**
     * Sliders list
     *
     * @return array
     */
    public function getSliders(): array
    {
        return $this->sliders;
    }
}
