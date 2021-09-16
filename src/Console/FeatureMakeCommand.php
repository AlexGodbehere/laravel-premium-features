<?php
/*
 * Copyright (c) FSCharter Ltd. - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Proprietary and confidential.
 * Last modified 29/05/2021, 18:18.
 */

namespace AlexGodbehere\LaravelPremiumFeatures\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

class FeatureMakeCommand extends Command
{

    protected $name = 'make:feature';

    protected $signature = 'make:feature';

    protected $description = 'Create a new premium feature';

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private Filesystem $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {

        $this->files = $files;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('What is the name of the feature? (e.g. EnableAutomaticMaintenanceFeature)');
        $domain = $this->ask('What domain should this feature belong to?');
        $title = $this->ask('What is the title of the feature? This will be used as the error text "You must be premium to ..." (e.g. Enable Automatic Maintenance)');
        $description = $this->ask('What does the feature do? (e.g. A restriction on enabling automatic maintenance.)');
        $cancel = $this->ask('What will happen if the user cancels? (e.g. Maintenance for all of your aircraft will need to be performed manually.)');
        $marketing_title = $this->ask('What should the user be shown as the title of this feature? (e.g. Automatic maintenance checks)');
        $marketing_description = $this->ask('What should the user be shown below the title of this feature? (e.g. Enable automatic maintenance checks and repairs for aircraft, making the management of your fleet that much easier.)');
        $marketing_icon = $this->ask('What icon should be shown next to the feature? (e.g. fa fa-wrench)');

        // Generate the feature class
        Artisan::call('make:feature-class', [
            'name'        => $name,
            'domain'      => $domain,
            'title'       => $title,
            'description' => $description,
            'cancel'      => $cancel,
        ]);

        // Generate the feature test
        Artisan::call('make:feature-test', [
            'name'   => $name,
            'domain' => $domain,
        ]);

        // Create a migration to seed the new feature to the database
        $migrationName = 'seed__'.strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
        Artisan::call('make:migration '.$migrationName);
        $dirArray = scandir(base_path().'/database/migrations');
        $latestMigrationName = $dirArray[count($dirArray) - 1];
        $latestMigrationPath = base_path().'/database/migrations/'.$latestMigrationName;
        if (!str_contains($latestMigrationName, 'seed__')) {
            return;
        }

        // Import Feature
        $find = "use Illuminate\Support\Facades\Schema;\n";
        $replace = "use Illuminate\Support\Facades\Schema;\nuse AlexGodbehere\LaravelPremiumFeatures\Model\Feature;\n";
        file_put_contents($latestMigrationPath, str_replace($find, $replace, file_get_contents($latestMigrationPath)));

        // Add the seeder
        $find = "public function up()\n    {\n        //\n    }\n";
        $replace = "public function up()\n    {\n        Feature::create([
          'name'           => '".$title."',
          'description'    => '".$description."',
          'cancel_warning' => '".$cancel."',
          'class_name'     => 'App\Domain\\".$domain."\Features\\".$name."',
          'marketing_title'     => '".$marketing_title."',
          'marketing_description'     => '".$marketing_description."',
          'marketing_icon'     => '".$marketing_icon."',
        ]);\n    }\n";
        file_put_contents($latestMigrationPath, str_replace($find, $replace, file_get_contents($latestMigrationPath)));

        $latestMigrationPath = base_path().'/database/migrations/'.$latestMigrationName;
//        dump(file_get_contents($latestMigrationPath));

        return true;
    }

    protected function makeDirectory($path)
    {

        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

}
