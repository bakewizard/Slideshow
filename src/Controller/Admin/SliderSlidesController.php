<?php
declare(strict_types=1);

namespace Slideshow\Controller\Admin;

use App\Attribute\Resource;
use App\Event\ImageFileHandler;
use App\Lib\ResourcesExplorer;
use Cake\Cache\Cache;
use Cake\Event\EventInterface;
use Laminas\Diactoros\UploadedFile;
use Override;

/**
 * SliderSlides Controller
 *
 * @property \Slideshow\Model\Table\SliderSlidesTable $SliderSlides
 * @property \Search\Controller\Component\SearchComponent $Search
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class SliderSlidesController extends AppController
{
    /**
     * @inheritDoc
     */
    #[Override]
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
     * @param string $id Slider id.
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    #[Resource(label: 'Add a slide')]
    public function add(string $id)
    {
        $sliderSlide = $this->SliderSlides->newEmptyEntity();
        $sliderSlide->slider_id = (int)$id;
        if ($this->request->is('post')) {
            $upload = $this->request->getUploadedFile('uploads');
            $error = $upload?->getError() ?? UPLOAD_ERR_NO_FILE;

            if ($error !== UPLOAD_ERR_OK) {
                $message = UploadedFile::ERROR_MESSAGES[$error] ?? __('Unknown upload error.');
                $this->Flash->error($message);

                return $this->redirect(['action' => 'add', $id]);
            }

            $sliderSlide = $this->SliderSlides->patchEntity($sliderSlide, $this->request->getData());
            $sliderSlide->path = '/slides';

            $slider = $this->SliderSlides->Sliders->get($id);

            if ($this->SliderSlides->save($sliderSlide)) {
                $images = $this->getConfig('System.images');
                $handler = new ImageFileHandler($this->getStorage(WWW_ROOT . 'media'), [
                    'thumbs' => [
                        'lg' => [$slider->width, $slider->height],
                        'sm' => 200,
                    ],
                    'format' => $images['format'],
                    'quality' => $images['quality'],
                ]);

                // @phpstan-ignore property.notFound
                $sliderSlide->tmp_name = $upload->getStream()->getMetadata('uri');
                $handler->handle([$sliderSlide]);

                $this->Flash->success(__('Slide has been added.'));

                return $this->redirect(['controller' => 'Sliders', 'action' => 'view', $id]);
            }

            $this->Flash->error(__('There were errors while adding the slide. Please, try again.'));
        }

        $this->addBreadcrumb(
            'Slides',
            [
                'prefix' => 'Admin',
                'plugin' => 'Slideshow',
                'controller' => 'Sliders',
                'action' => 'view',
                $sliderSlide->slider_id,

            ],
        );
        $this->addBreadcrumb('add');

        $targets = ['_self' => __('This tab'), '_blank' => __('New tab')];
        $this->set(compact('sliderSlide', 'targets'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Slider Slide id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    #[Resource(label: 'Edit a slide')]
    public function edit(?string $id = null)
    {
        $sliderSlide = $this->SliderSlides->get($id, contain: ['Sliders']);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $sliderSlide = $this->SliderSlides->patchEntity($sliderSlide, $this->request->getData());
            $sliderSlide->path = '/slides';

            if ($this->SliderSlides->save($sliderSlide)) {
                $images = $this->getConfig('System.images');
                $handler = new ImageFileHandler($this->getStorage(WWW_ROOT . 'media'), [
                    'thumbs' => [
                        'lg' => [$sliderSlide->slider->width, $sliderSlide->slider->height],
                        'sm' => 200,
                    ],
                    'format' => $images['format'],
                    'quality' => $images['quality'],
                ]);

                $upload = $this->request->getUploadedFile('uploads');

                if ($upload !== null && $upload->getError() === UPLOAD_ERR_OK) {
                    // @phpstan-ignore property.notFound
                    $sliderSlide->tmp_name = $upload->getStream()->getMetadata('uri');
                    $handler->handle([$sliderSlide]);
                }

                $this->Flash->success(__('The slide has been saved.'));

                return $this->redirect(['controller' => 'Sliders', 'action' => 'view', $sliderSlide->slider_id]);
            }
            $this->Flash->error(__('The slide could not be saved. Please, try again.'));
        }

        $this->addBreadcrumb(
            'Slides',
            [
                'prefix' => 'Admin',
                'plugin' => 'Slideshow',
                'controller' => 'Sliders',
                'action' => 'view',
                $sliderSlide->slider_id,

            ],
        );
        $this->addBreadcrumb('edit');

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
    #[Resource(label: 'Delete a slide')]
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sliderSlide = $this->SliderSlides->get($id);
        if ($this->SliderSlides->delete($sliderSlide)) {
            $handler = new ImageFileHandler($this->getStorage(WWW_ROOT . 'media'));
            $handler->remove([$sliderSlide]);

            $this->Flash->success(__('The slide has been deleted.'));
        } else {
            $this->Flash->error(__('The slide could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Sliders', 'action' => 'view', $sliderSlide->slider_id]);
    }

    /**
     * Moves slide up
     *
     * @param string $id
     * @return \Cake\Http\Response|null
     */
    public function moveUp(?string $id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $sliderSlide = $this->SliderSlides->get($id);

        /** @var \ADmad\Sequence\Model\Behavior\SequenceBehavior $sequence */
        $sequence = $this->SliderSlides->getBehavior('Sequence');

        if ($sequence->moveUp($sliderSlide)) {
            $this->Flash->success('The slide has been moved up.');
        } else {
            $this->Flash->error('The slide could not be moved up. Please, try again.');
        }

        return $this->redirect(['controller' => 'Sliders', 'action' => 'view', $sliderSlide->slider_id]);
    }

    /**
     * Moves slide down
     *
     * @param string $id
     * @return \Cake\Http\Response|null
     */
    public function moveDown(?string $id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $sliderSlide = $this->SliderSlides->get($id);

        /** @var \ADmad\Sequence\Model\Behavior\SequenceBehavior $sequence */
        $sequence = $this->SliderSlides->getBehavior('Sequence');

        if ($sequence->moveDown($sliderSlide)) {
            $this->Flash->success('The slide has been moved down.');
        } else {
            $this->Flash->error('The slide could not be moved down. Please, try again.');
        }

        return $this->redirect(['controller' => 'Sliders', 'action' => 'view', $sliderSlide->slider_id]);
    }

    /**
     * Gets plugin links
     *
     * @param \App\Lib\ResourcesExplorer $re
     * @return void
     */
    public function getLinks(ResourcesExplorer $re)
    {
        /** @var \App\Model\Table\PluginsTable $table */
        $table = $this->fetchTable('Plugins');
        $activePlugins = $table->getActivePlugins();

        $data = $re->getLinks($activePlugins);

        $this->set(compact('data'));
    }
}
