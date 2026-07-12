<?php

namespace Nohara\LaravelLatexEditor;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class LaravelLatexEditorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Menggabungkan file konfigurasi bawaan paket
        $this->mergeConfigFrom(
            __DIR__ . '/../config/latex-editor.php', 'laravel-latex-editor'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Memuat folder views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-latex-editor');

        // Mempublikasikan konfigurasi ke aplikasi Laravel utama
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/latex-editor.php' => config_path('laravel-latex-editor.php'),
            ], 'laravel-latex-editor-config');
        }

        // Mendaftarkan Blade Components secara manual
        Blade::component('laravel-latex-editor::components.editor', 'latex-editor');
        Blade::component('laravel-latex-editor::components.render', 'latex-render');
    }
}
