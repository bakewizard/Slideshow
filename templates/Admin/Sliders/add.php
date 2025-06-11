<?php
/**
 * @var \App\View\AppView $this
 * @var \Slideshow\Model\Entity\Slider $slider
 */
?>
<div class="card card-success card-outline">
    <div class="card-header">
        <div class="card-title"><i class="fa-solid fa-edit me-2"></i><?= __('Add Slider') ?></div>
    </div>
    <?= $this->Form->create($slider, ['align' => 'horizontal', 'type' => 'file', 'id' => 'sliders-add-form']) ?>
    <div class="card-body">
        <?= $this->Form->control('title'); ?>
        <?= $this->Form->control('description'); ?>
        <?= $this->Form->control('width'); ?>
        <?= $this->Form->control('height'); ?>
        <?= $this->Form->control('delay'); ?>
    </div>
    <div class="card-footer">
        <?= $this->element('form/save_buttons') ?>
        <?= $this->Html->link('<i class="fa-solid fa-times-circle"></i> ' . __('Cancel'), ['action' => 'index', '?' => $this->request->getQueryParams()], ['class' => 'btn btn-outline-danger', 'escape' => false]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>