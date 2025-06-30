<?php
declare(strict_types=1);

namespace Slideshow\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SliderSlidesFixture
 */
class SliderSlidesFixture extends TestFixture
{
    public string $table = 'slideshow_slider_slides';

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
                'slider_id' => 1,
                'title' => 'Slide 1',
                'description' => 'Description for slide 1',
                'url' => 'https://example.com/slide1',
                'target' => '_blank',
                'path' => 'slide1.jpg',
                'position' => 1,
                'enabled' => true,
            ],
            [
                'id' => 2,
                'slider_id' => 1,
                'title' => 'Slide 2',
                'description' => 'Description for slide 2',
                'url' => 'https://example.com/slide2',
                'target' => '_self',
                'path' => 'slide2.jpg',
                'position' => 2,
                'enabled' => true,
            ],
        ];
        parent::init();
    }
}
