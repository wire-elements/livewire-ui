<?php

namespace LivewireUI;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LivewireUIServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerDirectives();
    }

    private function registerDirectives()
    {
        Blade::directive('livewireUIScripts', function () {
            return $this->getComponentScripts();
        });
    }

    private function getComponentScripts()
    {
        return collect($this->app->getProviders('LivewireUI\Modal\LivewireModalServiceProvider'))
            ->map(function ($provider) {
                return collect($provider::$scripts)->map(fn($file) => asset("/vendor/livewire-ui/{$file}"));
            })->flatten()->map(fn($scriptUrl) => '<script src="' . $scriptUrl . '"></script>')->implode(PHP_EOL);
    }
}