<?php
declare(strict_types=1);

namespace Slideshow;

use App\Core\BasePlugin;
use Cake\Cache\Cache;
use Cake\Cache\Engine\FileEngine;
use Cake\Core\PluginApplicationInterface;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/**
 * Plugin for Slideshow
 */
class SlideshowPlugin extends BasePlugin
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
        if (!Cache::getConfig('slideshow')) {
            Cache::setConfig('slideshow', [
                'className' => FileEngine::class,
                'path' => CACHE . 'slideshow' . DS,
                'duration' => '+1 years',
                'prefix' => 'sldr_',
                'serialize' => true,
            ]);
        }
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
