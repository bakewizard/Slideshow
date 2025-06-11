<?php
/**
 * @var \App\View\AppView $this
 * @var object $block
 * @var object $settings
 */
?>
<div class="card card-primary card-outline">
    <div class="card-header">
        <div class="card-title"><i class="fa-solid fa-edit"></i><?= __('Slider cell') ?></div>
    </div>
    <?= $this->Form->create($settings, ['align' => 'horizontal']) ?>
    <div class="card-body">
        <?= $this->Form->control('slider', ['options' => $settings->getSliders(), 'empty' => '------']); ?>
    </div>
    <div class="card-footer">
        <?= $this->Form->button('<i class="fa-solid fa-save"></i> ' . __('Save'), ['class' => 'btn-success float-end', 'escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-times-circle"></i> ' . __('Cancel'), ['controller' => 'Regions', 'action' => 'view', $block->region_id], ['class' => 'btn btn-danger', 'escape' => false]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>