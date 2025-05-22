<?php
declare(strict_types=1);

namespace Slideshow\Model\Entity;

use Cake\ORM\Entity;

/**
 * Slider Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $width
 * @property int $height
 * @property int $delay
 */
class Slider extends Entity
{
    protected array $_accessible = [
        'title' => true,
        'description' => true,
        'width' => true,
        'height' => true,
        'delay' => true,
    ];
}
