<?php
declare(strict_types=1);

namespace AlexGodbehere\LaravelPremiumFeatures;

use AlexGodbehere\LaravelPremiumFeatures\Console\FeatureMakeCommand;
use AlexGodbehere\LaravelPremiumFeatures\Console\FeatureMakeTestCommand;
use AlexGodbehere\LaravelPremiumFeatures\Feature;
use AlexGodbehere\LaravelPremiumFeatures\Console\FeatureMakeClassCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Class AchievementsServiceProvider
 *
 * @package AlexGodbehere/LaravelPremiumFeatures
 */
class AchievementsServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    : void
    {

        $this->loadMigrationsFrom(__DIR__.'/Migrations');
        if ($this->app->runningInConsole()) {
            $this->commands(
              [
                FeatureMakeCommand::class,
                FeatureMakeClassCommand::class,
                FeatureMakeTestCommand::class,
              ]
            );
        }
        $this->app[Feature::class] = static function ($app) {

            return $app['alexgodbehere.features'];
        };

        $this->publishes(
          [
            __DIR__.'/Migrations/0000_00_00_000000_create_features_tables.php' => database_path('migrations'),
            __DIR__.'/Migrations/2021_09_16_210126_add_marketing_lines_to_features.php' => database_path('migrations'),
          ],
          'migrations'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }

}
