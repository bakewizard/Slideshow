<?php
declare(strict_types=1);

namespace Slideshow\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SlidersFixture
 */
class SlidersFixture extends TestFixture
{
    public string $table = 'slideshow_sliders';

    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'title' => 'Test Slider 1',
                'description' => 'This is a test slider description.',
                'width' => 800,
                'height' => 600,
                'delay' => 5000,
            ],
            [
                'id' => 2,
                'title' => 'Test Slider 2',
                'description' => null,
                'width' => 1024,
                'height' => 768,
                'delay' => 3000,
            ],
        ];
        parent::init();
    }
}
