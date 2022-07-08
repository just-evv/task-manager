<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Collective\Html\FormFacade;

class AppServiceProvider extends ServiceProvider
{
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
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
        FormFacade::component(
            'bsText',
            'components.form.text',
            ['name', 'text' ?? 'name', 'value' => null, 'attributes' => []]
        );

        FormFacade::component(
            'bsTextarea',
            'components.form.textarea',
            ['name', 'text' ?? 'name', 'value' => null, 'attributes' => []]
        );

        FormFacade::component(
            'bsSelectOne',
            'components.form.selectOne',
            ['name', 'text' ?? 'name', 'array', 'value' => null, 'attributes' => []]
        );

        FormFacade::component(
            'bsSelectMany',
            'components.form.selectMany',
            ['name', 'text' ?? 'name', 'array', 'value' => null, 'attributes' => []]
        );
    }
}
