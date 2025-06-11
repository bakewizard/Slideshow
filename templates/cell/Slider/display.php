<?php
/**
 * @var \App\View\AppView $this
 * @var object $block
 * @var array $slides
 */
?>
<?php if (!empty($slides)): ?>
    <div id="carousel-<?= $block->alias ?>" class="carousel slide" data-bs-ride="carousel" data-bs-interval="<?= $slides[0]->slider->delay ?>">
        <?php if (count($slides) > 1): ?>
            <div class="carousel-indicators">
                <?php foreach ($slides as $i => $slide): ?>
                    <button type="button" data-bs-target="#carousel-<?= $block->alias ?>" data-bs-slide-to="<?= $i ?>" <?= $i === 0 ? 'class="active"' : '' ?> aria-current="true" aria-label="Slide 1"></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="carousel-inner">
            <?php foreach ($slides as $i => $slide): ?>
                <div class="carousel-item<?= $i === 0 ? ' active' : '' ?>">
                    <a href="<?= $slide->url ?>" target="<?= $slide->target ?>">
                        <?=
                        $this->Html->image($this->getImageUrl($slide, 'lg'), [
                            'title' => $slide->title,
                            'alt' => $slide->title,
                            'width' => $slides[0]->slider->width,
                            'height' => $slides[0]->slider->height,
                            'class' => 'd-block w-100'
                        ]);
                        ?>
                        <div class="carousel-caption">
                            <h5><?= $slide->title ?></h5>
                            <?= $slide->description ?>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (count($slides) > 1): ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?= $block->alias ?>" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?= $block->alias ?>" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        <?php endif; ?>
    </div>
<?php endif; ?>