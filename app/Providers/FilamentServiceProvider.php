<?php

namespace App\Providers;

use App\Filament\Resources\TaskResource;
use Filament\Facades\Filament;
use Filament\Navigation\MenuItem;
use App\Filament\Resources\TaskResource\Pages;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                MenuItem::make()
                    ->label('Import/Export Tasks')
                    ->icon('heroicon-o-arrow-down-on-square-stack')
                    ->url(TaskResource::getUrl('import-export'))
                    ->sort(3), // Adjust this number to change the position in the menu
            ]);
        });
    }
}
