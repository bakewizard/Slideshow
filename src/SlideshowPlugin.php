<?php
declare(strict_types=1);

namespace Slideshow;

use App\Core\CmsPlugin;
use Cake\Cache\Cache;
use Cake\Cache\Engine\FileEngine;
use Cake\Core\PluginApplicationInterface;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/**
 * Plugin for Slideshow
 */
class SlideshowPlugin extends CmsPlugin
{
    protected ?string $name = 'Slideshow';
    protected bool $consoleEnabled = false;
    protected bool $middlewareEnabled = false;
    protected bool $servicesEnabled = false;

    /**
     * @inheritDoc
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        Cache::setConfig('slideshow', [
            'className' => FileEngine::class,
            'prefix' => 'sldr_',
            'path' => CACHE . 'slideshow' . DS,
            'duration' => '+6 months',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function routes(RouteBuilder $routes): void
    {
        $routes->prefix('Admin', function (RouteBuilder $builder): void {
            $builder->plugin($this->name ?? 'Slideshow', function (RouteBuilder $builder): void {
                $builder->applyMiddleware('auth');
                $builder->connect('/', ['controller' => 'Dashboard']);
                $builder->fallbacks(DashedRoute::class);
            });
        });
    }
}
