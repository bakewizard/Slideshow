<?php
/**
 * @var \App\View\AppView $this
 * @var array $config
 * @var mixed $targets
 * @var \Slideshow\Model\Entity\SliderSlide $sliderSlide
 */
?>
<?= $this->Html->script(['/backend/plugins/tinymce/tinymce.min', '/backend/js/menus', 'Slideshow.backend/slide'], ['block' => true, 'type' => 'module']) ?>

<?= $this->element('form/link_select_modal') ?>

<div class="card card-success card-outline">
    <div class="card-header">
        <div class="card-title"><i class="fa-solid fa-edit me-2"></i><?= __('Edit slide') ?></div>
        <?php if (count($config['App']['I18n']['languages']) > 1): ?>
            <div class="card-tools">
                <?= $this->element('form/locales', ['locale' => $sliderSlide->_locale]) ?>
            </div>
        <?php endif; ?>
    </div>
    <?= $this->Form->create($sliderSlide, ['align' => 'horizontal', 'type' => 'file', 'id' => 'sliders-edit-image-form']) ?>
    <div class="card-body">
        <?= $this->Form->control('title'); ?>
        <div class="row">
            <label class="col-form-label col-md-2" for="image">Slide</label>
            <div class="col-md-10">
                <?=
                $this->Html->image($this->getImageUrl($sliderSlide, 'sm'), [
                    'title' => $sliderSlide->name,
                    'alt' => $sliderSlide->name,
                    'width' => 200,
                    'height' => 200,
                    'class' => 'img-thumbnail',
                    'id' => 'image-preview'
                ]);
                ?>
                <div class="my-2">
                    <?= $this->Form->file('uploads', ['accept' => 'image/*',  'id' => 'image-input']); ?>
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
            ])
        ]);
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
