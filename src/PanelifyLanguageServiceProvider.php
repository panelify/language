<?php

namespace Panelify\Language;

use Illuminate\Support\Facades\View;
use JobMetric\Language\Models\Language;
use JobMetric\PackageCore\Exceptions\AssetFolderNotFoundException;
use JobMetric\PackageCore\Exceptions\ViewFolderNotFoundException;
use JobMetric\PackageCore\PackageCore;
use JobMetric\PackageCore\PackageCoreServiceProvider;

class PanelifyLanguageServiceProvider extends PackageCoreServiceProvider
{
    /**
     * @throws ViewFolderNotFoundException
     * @throws AssetFolderNotFoundException
     */
    public function configuration(PackageCore $package): void
    {
        $package->name('panelify-language')
            ->hasAsset()
            ->hasTranslation()
            ->hasView()
            ->hasRoute();
    }

    /**
     * After Boot Package
     *
     * @return void
     */
    public function afterBootPackage(): void
    {
        if (checkDatabaseConnection() && !$this->app->runningInConsole() && !$this->app->runningUnitTests()) {
            $languages = Language::active()->get();

            View::composer('*', function ($view) use ($languages) {
                $view->with('languages', $languages);

                $defaultLanguage = $languages->where('locale', $this->app->getLocale())->first();
                $view->with('languageInfo', $defaultLanguage);
            });

            DomiLocalize('languages', json_decode($languages));
        }
    }
}
