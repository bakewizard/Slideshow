<?php

declare(strict_types=1);

namespace Slideshow\Form\Cell;

use Cake\Datasource\FactoryLocator;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * CellConfig Form.
 */
class SliderCellConfigForm extends Form
{

    private $sliders;

    public function __construct()
    {
        parent::__construct();
        $labels = FactoryLocator::get('Table')->get('Slideshow.Sliders');
        $this->sliders = $labels->find('list');
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

    public function getSliders()
    {
        return $this->sliders;
    }

}
