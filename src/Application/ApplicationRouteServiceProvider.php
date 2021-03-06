<?php

namespace Fjord\Application;

use Fjord\Application\Controllers\FileController;
use Fjord\Support\Facades\FjordRoute;
use Fjord\Translation\Controllers\LoadTranslationsController;
use Fjord\Translation\Controllers\SetLocaleController;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as LaravelRouteServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class ApplicationRouteServiceProvider extends LaravelRouteServiceProvider
{
    /**
     * Map routes.
     *
     * @return void
     */
    public function map()
    {
        $this->mapFjordRoutes();
        $this->mapFileRoutes();
        $this->mapAppRoutes();
    }

    /**
     * Map application routes.
     *
     * @return void
     */
    protected function mapAppRoutes()
    {
        if (File::exists(base_path('fjord/routes/fjord.php'))) {
            FjordRoute::group(base_path('fjord/routes/fjord.php'));
        }
    }

    /**
     * Map fjord routes.
     *
     * @return void
     */
    protected function mapFjordRoutes()
    {
        FjordRoute::group(function () {
            Route::post('/set-locale', SetLocaleController::class)->name('set-locale');
            Route::get('/lang.js', LoadTranslationsController::class.'@i18n')->name('fjord-translations');
        });
    }

    /**
     * Map file routes.
     *
     * @return void
     */
    protected function mapFileRoutes()
    {
        FjordRoute::get('js/app.js', FileController::class.'@fjordJs')->name('js');
        FjordRoute::public()->get('js/app2.js', FileController::class.'@fjord2Js')->name('app2.js');
        FjordRoute::public()->get('js/prism.js', FileController::class.'@prismJs')->name('prism.js');
        FjordRoute::public()->get('js/ctk.js', FileController::class.'@ctkJs')->name('ctk.js');
        FjordRoute::public()->get('css/app.css', FileController::class.'@fjordCss')->name('css');
        FjordRoute::public()->get('images/fjord-logo.png', FileController::class.'@fjordLogo')->name('logo');
        FjordRoute::public()->get('favicon/favicon-32x32.png', FileController::class.'@fjordFaviconBig')->name('favicon-big');
        FjordRoute::public()->get('favicon/favicon-16x16.png', FileController::class.'@fjordFaviconSmall')->name('favicon-small');
    }
}
