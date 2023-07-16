<?php

namespace SolutionForest\FilamentTree;

use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Database\Schema\Blueprint;
use Livewire\Livewire;
use SolutionForest\FilamentTree\Macros\BlueprintMarcos;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentTreeServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-tree';
    
    public static string $viewNamespace = 'filament-tree';

//    protected array $styles = [
//        'filament-tree-min' => __DIR__ . '/../resources/dist/filament-tree.css',
//    ];
//
//    protected array $scripts = [
//        'https://code.jquery.com/jquery-3.6.1.slim.min.js',
//        'filament-tree-min' => __DIR__ . '/../resources/dist/filament-tree.js',
//    ];

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasConfigFile()
            ->hasViews(static::$viewNamespace)
            ->hasTranslations()
            ->hasCommands([
                Commands\MakeTreePageCommand::class,
                Commands\MakeTreeWidgetCommand::class,
            ]);
    }

    public function boot()
    {
        parent::boot();

        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackage()
        );

        $this->registerBlueprintMacros();
    }

    protected function registerBlueprintMacros()
    {
        Blueprint::mixin(new BlueprintMarcos);
    }

    protected function getAssetPackage(): ?string
    {
        return 'solutionforest/filament-tree';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('filament-tree-view', __DIR__ . '/../resources/dist/components/filament-tree-view.js'),
            Css::make('filament-tree-styles', __DIR__ . '/../resources/dist/filament-tree.css'),
            Js::make('filament-tree-jquery', 'https://code.jquery.com/jquery-3.6.1.slim.min.js'),
            Js::make('filament-tree-scripts', __DIR__ . '/../resources/dist/filament-tree.js'),
        ];
    }
}
