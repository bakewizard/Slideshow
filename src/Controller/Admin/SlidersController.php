<?php
declare(strict_types=1);

namespace Slideshow\Controller\Admin;

use App\Attribute\Resource;
use App\Controller\Admin\AppController;
use App\Lib\ImageUploadHandler;
use Cake\Cache\Cache;
use Cake\Event\EventInterface;

/**
 * Sliders Controller
 *
 * @property \Slideshow\Model\Table\SlidersTable $Sliders
 * @method \Cake\Datasource\ResultSetInterface<\Slideshow\Model\Entity\Slider> paginate(\Cake\Datasource\RepositoryInterface|\Cake\Datasource\QueryInterface|string|null $object = null, array $settings = [])
 * @property \Search\Controller\Component\SearchComponent $Search
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class SlidersController extends AppController
{
    /**
     * @inheritDoc
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        if (!$this->request->is('get') && $this->request->getParam('action') !== 'add') {
            Cache::clear('slideshow');
        }
    }

    /**
     * Sliders list
     *
     * Displays a sliders list
     *
     * @return \Cake\Http\Response|void
     */
    #[Resource(label: 'List sliders')]
    public function index()
    {
        $sliders = $this->paginate($this->Sliders);

        $this->set(compact('sliders'));
    }

    /**
     * View method
     *
     * @param string|null $id Slider id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    #[Resource(label: 'View slider slides')]
    public function view(?string $id = null)
    {
        $slider = $this->Sliders->get($id, contain: ['SliderSlides']);

        $this->set('slider', $slider);
    }

    /**
     * New Slider
     *
     * Creates a slider
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    #[Resource(label: 'Create a slider')]
    public function add()
    {
        $slider = $this->Sliders->newEmptyEntity();
        if ($this->request->is('post')) {
            $slider = $this->Sliders->patchEntity($slider, $this->request->getData());
            $savedSlider = $this->Sliders->save($slider);
            if ($savedSlider) {
                $this->Flash->success(__('The slider has been saved. Now you can add some slides.'));

                return $this->redirect(['action' => 'view', $savedSlider->id]);
            }
            $this->Flash->error(__('The slider could not be saved. Please, try again.'));
        }
        $this->set(compact('slider'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Slider id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    #[Resource(label: 'Edit a slider')]
    public function edit(?string $id = null)
    {
        $slider = $this->Sliders->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $slider = $this->Sliders->patchEntity($slider, $this->request->getData());
            if ($this->Sliders->save($slider)) {
                $this->Flash->success(__('The slider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The slider could not be saved. Please, try again.'));
        }
        $this->set(compact('slider'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Slider id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    #[Resource(label: 'Delete a slider')]
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $slider = $this->Sliders->get($id, contain: ['SliderSlides']);
        if ($this->Sliders->delete($slider)) {
            $handler = new ImageUploadHandler();
            $handler->remove($slider->slider_slides);

            $this->Flash->success(__('The slider has been deleted.'));
        } else {
            $this->Flash->error(__('The slider could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
