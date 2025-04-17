<?php

declare(strict_types=1);

namespace Slideshow\Controller\Admin;

use App\Controller\Admin\AppController;
use App\Lib\ImageUploadHandler;
use App\Lib\PluginManager;
use Cake\Cache\Cache;
use Cake\Event\EventInterface;

/**
 * SliderSlides Controller
 *
 * @property \Slideshow\Model\Table\SliderSlidesTable $SliderSlides
 *
 * @method \Slideshow\Model\Entity\SliderSlide[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SliderSlidesController extends AppController
{

    #[\Override]
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        if (!$this->request->is('get')) {
            Cache::clear('slideshow');
        }
    }

    /**
     * Add method
     *
     * @param string|null $id Slider id.
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $sliderSlide = $this->SliderSlides->newEmptyEntity();
        $sliderSlide->slider_id = $id;
        if ($this->request->is('post')) {
            $sliderSlide = $this->SliderSlides->patchEntity($sliderSlide, $this->request->getData());
            $sliderSlide->path = '/slides';

            $slider = $this->SliderSlides->Sliders->get($id);

            if ($this->SliderSlides->save($sliderSlide)) {
                $images = $this->getConfig('Cms.images');
                $handler = new ImageUploadHandler([
                    'thumbs' => [
                        'lg' => [$slider->width, $slider->height],
                        'sm' => 200
                    ],
                    'format' => $images['format'],
                    'quality' => $images['quality']
                ]);

                $upload = $this->request->getUploadedFile('uploads');

                if (!$upload->getError()) {
                    $sliderSlide->tmp_name = $upload->getStream()->getMetadata('uri');
                    $handler->handle([$sliderSlide->toArray()]);
                }

                $this->Flash->success(__('Slide has been added.'));
                return $this->redirect(['controller' => 'Sliders', 'action' => 'view', $id]);
            }

            $this->Flash->error(__('There were errors while adding the slide. Please, try again.'));
        }
        $targets = ['_self' => __('This tab'), '_blank' => __('New tab')];
        $this->set(compact('sliderSlide', 'targets'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Slider Slide id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sliderSlide = $this->SliderSlides->get($id, contain: ['Sliders']);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $sliderSlide = $this->SliderSlides->patchEntity($sliderSlide, $this->request->getData());
            $sliderSlide->path = '/slides';

            if ($this->SliderSlides->save($sliderSlide)) {
                $images = $this->getConfig('Cms.images');
                $handler = new ImageUploadHandler([
                    'thumbs' => [
                        'lg' => [$sliderSlide->slider->width, $sliderSlide->slider->height],
                        'sm' => 200
                    ],
                    'format' => $images['format'],
                    'quality' => $images['quality']
                ]);

                $upload = $this->request->getUploadedFile('uploads');

                if (!$upload->getError()) {
                    $sliderSlide->tmp_name = $upload->getStream()->getMetadata('uri');
                    $handler->handle([$sliderSlide->toArray()]);
                }

                $this->Flash->success(__('The slide has been saved.'));
                return $this->redirect(['controller' => 'Sliders', 'action' => 'view', $sliderSlide->slider_id]);
            }
            $this->Flash->error(__('The slide could not be saved. Please, try again.'));
        }

        $targets = ['_self' => __('This tab'), '_blank' => __('New tab')];
        $this->set(compact('sliderSlide', 'targets'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Slider Slide id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sliderSlide = $this->SliderSlides->get($id);
        if ($this->SliderSlides->delete($sliderSlide)) {
            $handler = new ImageUploadHandler();
            $handler->remove([$sliderSlide]);

            $this->Flash->success(__('The slide has been deleted.'));
        } else {
            $this->Flash->error(__('The slide could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Sliders', 'action' => 'view', $sliderSlide->slider_id]);
    }

    public function moveUp($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $sliderSlide = $this->SliderSlides->get($id);
        if ($this->SliderSlides->moveUp($sliderSlide)) {
            $this->Flash->success('The slide has been moved up.');
        } else {
            $this->Flash->error('The slide could not be moved up. Please, try again.');
        }
        return $this->redirect(['controller' => 'Sliders', 'action' => 'view', $sliderSlide->slider_id]);
    }

    public function moveDown($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $sliderSlide = $this->SliderSlides->get($id);
        if ($this->SliderSlides->moveDown($sliderSlide)) {
            $this->Flash->success('The slide has been moved down.');
        } else {
            $this->Flash->error('The slide could not be moved down. Please, try again.');
        }
        return $this->redirect(['controller' => 'Sliders', 'action' => 'view', $sliderSlide->slider_id]);
    }

    public function deleteFiles($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sliderSlide = $this->SliderSlides->get($id);
        $handler = new ImageUploadHandler();
        $handler->remove([$sliderSlide]);

        return $this->redirect($this->referer());
    }

    public function getLinks()
    {
        $pm = new PluginManager();
        $data = $pm->getLinks();

        $this->set(compact('data'));
    }
}
