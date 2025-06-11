<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="fa-solid fa-tachometer-alt me-2"></i>Dashboard</div>
    </div>
    <div class="card-body">
        <?= $this->Html->link('<i class="fa-solid fa-plus-circle"></i> ' . __('Add slider'), ['controller' => 'Sliders', 'action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
    </div>
</div>