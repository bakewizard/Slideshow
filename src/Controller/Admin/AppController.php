<?php
declare(strict_types=1);

namespace Slideshow\Controller\Admin;

use App\Controller\Admin\AppController as BaseController;
use Cake\Event\EventInterface;

/**
 * @property \Search\Controller\Component\SearchComponent $Search
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Blogger\Model\Table\ArticlesTable $Articles
 */
class AppController extends BaseController
{
    /**
     * Before filter callback.
     *
     * @param \Cake\Event\EventInterface $event The beforeRender event.
     * @return void
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $controller = $this->request->getParam('controller');
        $action = $this->request->getParam('action');

        $this->addCrumb(
            'Slideshow',
            [
                'prefix' => 'Admin',
                'plugin' => 'Slideshow',
                'controller' => 'Dashboard',
                'action' => 'index',
            ],
        );

        $this->addCrumb(
            'Sliders',
            [
                'prefix' => 'Admin',
                'plugin' => 'Slideshow',
                'controller' => 'Sliders',
                'action' => 'index',
            ],
        );

        if ($controller === 'Sliders' && in_array($action, ['view', 'add', 'edit'])) {
            $this->addCrumb($action);
        }
    }
}
