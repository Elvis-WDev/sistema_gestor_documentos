<?php

namespace App\Providers;

use App\Models\configuraciones_generales;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $generalSetting = configuraciones_generales::first();

        Config::set('config_general.general.nombre', $generalSetting->host ?? 'General');
        Config::set('config_general.general.archivos_permitidos', $generalSetting->archivos_permitidos ?? 'jpg,jpeg,png,pdf,doc,docx,xls,xlsx');
        Config::set('config_general.general.cantidad_permitidos', $generalSetting->cantidad_permitidos ?? 1);
        Config::set('config_general.general.tamano_maximo_permitido', $generalSetting->tamano_maximo_permitido ?? 1);
    }
}
