<?php
/**
 * @var \App\View\AppView $this
 * @var \Slideshow\Model\Entity\Slider $slider
 */
?>
<div class="card card-primary card-outline">
    <div class="card-header">
        <div class="card-title"><i class="fa-solid fa-eye me-2"></i><?= h($slider->title) ?> <?= __('slides') ?></div>
        <div class="card-tools">
            <?= $this->Html->link('<i class="fa-solid fa-plus-circle"></i>', ['controller' => 'SliderSlides', 'action' => 'add', $slider->id], ['class' => 'btn btn-sm btn-outline-success', 'escape' => false]) ?>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="banner_images">
                <thead>
                    <tr>
                        <th scope="col"><?= __('Image') ?></th>
                        <th scope="col"><?= __('Title') ?></th>
                        <th scope="col"><?= __('Url') ?></th>
                        <th scope="col"><?= __('Target') ?></th>
                        <th scope="col"><?= __('Enabled') ?></th>
                        <th scope="col"></th>
                        <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($slider->slider_slides as $slide): ?>
                        <tr>
                            <td class="text-center">
                                <?=
                                $this->Html->image($this->getImageUrl($slide, 'sm'), [
                                    'alt' => $slide->title,
                                    'title' => $slide->title,
                                    'width' => 200,
                                    'height' => 200,
                                    'data-id' => $slide->id
                                ]);
                                ?>
                            </td>
                            <td><?= h($slide->title) ?></td>
                            <td><?= $this->Html->link($slide->url, $slide->url, ['target' => '_blank']) ?></td>
                            <td><?= $slide->target ?></td>
                            <td class="text-center">
                                <?= $slide->enabled ? '<i class="fa-solid fa-check text-success fa-lg"></i>' : '<i class="fa-solid fa-xmark text-danger fa-lg"></i>' ?>
                            </td>
                            <td class="text-center">
                                <?= $this->Form->postLink('<i class="fa-solid fa-arrow-down"></i>', ['controller' => 'SliderSlides', 'action' => 'moveDown', $slide->id], ['escape' => false, 'class' => 'btn btn-outline-secondary']) ?>
                                <?= $this->Form->postLink('<i class="fa-solid fa-arrow-up"></i>', ['controller' => 'SliderSlides', 'action' => 'moveUp', $slide->id], ['escape' => false, 'class' => 'btn btn-outline-secondary']) ?>
                            </td>
                            <td class="text-center actions">
                                <?= $this->Html->link('<i class="fa-solid fa-edit"></i>', ['controller' => 'SliderSlides', 'action' => 'edit', $slide->id], ['escape' => false, 'class' => 'btn btn-outline-success']) ?>
                                <?=
                                $this->Form->deleteLink('<i class="fa-solid fa-trash"></i>', ['controller' => 'SliderSlides', 'action' => 'delete', $slide->id],
                                        [
                                            'block' => true,
                                            'escape' => false,
                                            'confirm' => __('Are you sure you want to delete {0}?', $slide->title),
                                            'class' => 'btn btn-outline-danger',
                                            'data-bs-toggle' => 'modal',
                                            'data-bs-target' => '#confirm-modal'
                                        ]
                                )
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
