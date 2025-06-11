<?php
declare(strict_types=1);

namespace Slideshow\Model\Entity;

use Cake\ORM\Entity;

/**
 * SliderSlide Entity
 *
 * @property int $id
 * @property int $slider_id
 * @property string|null $title
 * @property string|null $description
 * @property string $url
 * @property string|null $target
 * @property bool $enabled
 *
 * @property string $path
 * @property int|null $position
 * @property \Slideshow\Model\Entity\Slider $slider
 * @property array<\Cake\ORM\Entity> $_i18n
 */
class SliderSlide extends Entity
{
    protected array $_accessible = [
        'slider_id' => true,
        'title' => true,
        'description' => true,
        'url' => true,
        'target' => true,
        'position' => true,
        'enabled' => true,
        'slider' => true,
        'files' => true,
    ];
}
