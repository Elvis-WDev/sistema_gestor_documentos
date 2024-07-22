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
    public function boot()
    {
        $generalSetting = configuraciones_generales::where('nombre', 'General')->first();
        $archivosSetting = configuraciones_generales::where('nombre', 'Archivos')->first();

        if ($generalSetting) {
            Config::set('config_general.general.nombre', $generalSetting->nombre);
            Config::set('config_general.general.archivos_permitidos', $generalSetting->archivos_permitidos);
            Config::set('config_general.general.cantidad_permitidos', $generalSetting->cantidad_permitidos);
            Config::set('config_general.general.tamano_maximo_permitido', $generalSetting->tamano_maximo_permitido);
        }

        if ($archivosSetting) {
            Config::set('config_general.archivos.nombre', $archivosSetting->nombre);
            Config::set('config_general.archivos.archivos_permitidos', $archivosSetting->archivos_permitidos);
            Config::set('config_general.archivos.cantidad_permitidos', $archivosSetting->cantidad_permitidos);
            Config::set('config_general.archivos.tamano_maximo_permitido', $archivosSetting->tamano_maximo_permitido);
        }
    }
}
