<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $targets
 * @var \Slideshow\Model\Entity\SliderSlide $sliderSlide
 */
?>
<?= $this->Html->script(['/backend/plugins/tinymce/tinymce.min', '/backend/js/menus', 'Slideshow.backend/slide'], ['block' => true, 'type' => 'module']) ?>

<?= $this->element('form/link_select_modal') ?>

<div class="card card-success card-outline">
    <div class="card-header">
        <div class="card-title"><i class="fa-solid fa-edit me-2"></i><?= __('Add slide') ?></div>
    </div>
    <?= $this->Form->create($sliderSlide, ['align' => 'horizontal', 'type' => 'file', 'id' => 'sliders-add-image-form']) ?>
    <div class="card-body">
        <?= $this->Form->control('title'); ?>
        <div class="row">
            <label class="col-form-label col-md-2" for="image">Image</label>
            <div class="col-md-10">
                <?=
                $this->Html->image($this->getImageUrl($sliderSlide, 'sm'), [
                    'title' => $sliderSlide->name,
                    'alt' => $sliderSlide->name,
                    'width' => 200,
                    'height' => 200,
                    'class' => 'img-thumbnail',
                    'id' => 'sliders-image'
                ]);
                ?>
                <div class="my-2">
                    <?= $this->Form->file('uploads', ['accept' => 'image/*', 'id' => 'sliders-image-input']); ?>
                </div>
            </div>
        </div>
        <?=
        $this->Form->control('url', [
            'id' => 'link-select-input',
            'append' => $this->Form->button('...', [
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'link-select-button',
                'title' => __('Select url'),
                'data-url' => $this->Url->build(['controller' => 'SliderSlides', 'action' => 'getLinks', $sliderSlide->slider_id])
        ])]);
        ?>
        <?= $this->Form->control('target', ['options' => $targets]); ?>
        <?= $this->Form->control('description'); ?>
        <?= $this->Form->control('enabled', ['switch' => true]); ?>
    </div>
    <div class="card-footer">
        <?= $this->element('form/save_buttons') ?>
        <?= $this->Html->link('<i class="fa-solid fa-times-circle"></i> ' . __('Cancel'), ['controller' => 'Sliders', 'action' => 'view', $sliderSlide->slider_id, '?' => $this->request->getQueryParams()], ['class' => 'btn btn-outline-danger', 'escape' => false]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
