<?php

namespace Ybaruchel\LaravelFileManager\Providers;

use Illuminate\Support\Facades\Blade;
use ReflectionClass;
use Illuminate\Support\ServiceProvider;
use Ybaruchel\LaravelFileManager\Services\Cropper\CropperService;
use Ybaruchel\LaravelFileManager\Services\FileManager\FileManagerService;

class FacadesServiceProvider extends ServiceProvider
{
    /**
     * App entities
     * @var array
     */
    private $services = [
        'fileManager' => [
            'service' => FileManagerService::class,
            'dependencies' => [
            ]
        ],
        'cropper' => [
            'service' => CropperService::class,
            'dependencies' => [
            ]
        ],
    ];
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // bsImage directive
        Blade::directive('bsImage', function ($expression) {
            $view = view('FileManager::components.image', $expression)->render();
            return "<?php echo $view ?>";
        });

        // bsMultiImage directive
        Blade::directive('bsMultiImage', function ($expression) {
            $view = view('FileManager::components.multiimage', $expression)->render();
            return "<?php echo $view ?>";
        });

        // bsFile directive
        Blade::directive('bsFile', function ($expression) {
            $view = view('FileManager::components.file', $expression)->render();
            return "<?php echo $view ?>";
        });

        // bsMultiFile directive
        Blade::directive('bsMultiFile', function ($expression) {
            $view = view('FileManager::components.multifile', $expression)->render();
            return "<?php echo $view ?>";
        });
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->services as $serviceName => $serviceData) {
            $this->app->bind($serviceName, function ($app) use ($serviceData) {
                $dependencies = array_map(function ($dependency) use ($app) {
                    return $app->make($dependency);
                }, $serviceData['dependencies']);
                $classReflection = new ReflectionClass($serviceData['service']);
                return $classReflection->newInstanceArgs($dependencies);
            });
        }
    }
}