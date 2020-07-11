<?php


namespace App\Application\Providers\Http;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    const HTTP_FRONTEND_NAMESPACE = 'Http/Frontend/*';

    const HTTP_RESOURCES_DIR = 'resources';
    const HTTP_VIEWS_DIR_NAME = 'views';


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach (glob(app_path($this->getFrontendRecourcesPathPattern()), GLOB_ONLYDIR) as $dir) {
            $moduleName = basename(realpath(substr($dir, 0, -strlen(self::HTTP_RESOURCES_DIR))));
            $viewsPath = $dir .'/'. self::HTTP_VIEWS_DIR_NAME;
            if (is_dir($viewsPath)) {
                $moduleName = 'Frontend/'. $moduleName;

                $this->loadViewsFrom($viewsPath, $moduleName);
            }
        }
    }

    private function getFrontendRecourcesPathPattern()
    {
        return self::HTTP_FRONTEND_NAMESPACE .'/'. self::HTTP_RESOURCES_DIR;
    }
}
