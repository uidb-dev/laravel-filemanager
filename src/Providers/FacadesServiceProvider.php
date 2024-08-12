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
            return "<?php echo view('FileManager::components.image', $expression)->render(); ?>";
        });

        // bsMultiImage directive
        Blade::directive('bsMultiImage', function ($expression) {
            return "<?php echo view('FileManager::components.multiimage', $expression)->render(); ?>";
        });

        // bsFile directive
        Blade::directive('bsFile', function ($expression) {
            return "<?php echo view('FileManager::components.file', $expression)->render(); ?>";
        });

        // bsMultiFile directive
        Blade::directive('bsMultiFile', function ($expression) {
            return "<?php echo view('FileManager::components.multifile', $expression)->render(); ?>";
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