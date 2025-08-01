<?php
declare(strict_types=1);

namespace Slideshow\View\Cell;

use App\View\Cell\BlockCell as Cell;

/**
 * Slider cell
 */
class SliderCell extends Cell
{
    /**
     * Slider
     *
     * Displays slides
     *
     * @return void
     */
    public function display(): void
    {
        $lang = $this->request->getParam('lang');
        $id = $this->block->params['slider'] ?? null;

        $slides = $this->fetchTable('Slideshow.SliderSlides')
                ->find()
                ->where(['enabled' => true, 'slider_id is' => $id])
                ->contain(['Sliders'])
                ->orderBy(['position' => 'ASC'])
                ->cache(function ($q) use ($id, $lang) {
                    if (!is_null($id)) {
                        return $lang ? "{$id}_{$lang}" : $id;
                    }
                }, 'slideshow')
                ->toArray();

        $this->set(compact('slides'));
    }
}
