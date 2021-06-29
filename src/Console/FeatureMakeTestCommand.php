<?php
/*
 * Copyright (c) FSCharter Ltd. - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Proprietary and confidential.
 * Last modified 28/01/2021, 14:33.
 */

namespace AlexGodbehere\LaravelPremiumFeatures\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class FeatureMakeTestCommand extends GeneratorCommand
{

    protected $name = 'make:feature-test';

    protected $signature = 'make:feature-test {name} {domain}';

    protected $description = 'Create a new feature test class';

    protected $type = 'Test';

    protected function getStub()
    : string
    {

        return __DIR__.'/stubs/action_test.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     *
     * @return string
     */
    protected function getPath($name)
    {

        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path('tests').str_replace('\\', '/', $name).'Test.php';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {

        return $rootNamespace.'\Domain\\'.$this->argument('domain').'\Features';
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {

        return 'Tests';
    }

}
