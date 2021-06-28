<?php
declare(strict_types=1);

namespace AlexGodbehere\LaravelPremiumFeatures\Console;

use Illuminate\Console\GeneratorCommand;

/**
 * Creates a feature class stub.
 *
 * @category Command
 * @package  AlexGodbehere/LaravelPremiumFeatures\Command
 * @author   Gabriel Simonetti <simonettigo@gmail.com>
 * @license  MIT License
 */
class FeatureMakeClassCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:feature-class';

    protected $signature = 'make:feature-class {name} {domain} {title} {description} {cancel} {check}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new feature class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Feature';

    protected function buildClass($name)
    {

        $stub = $this->files->get(__DIR__.'/stubs/feature_class.stub');

        $stub = str_replace(['__TITLE__', '__DESCRIPTION__', '__CANCEL_WARNING__', '__CHECK_STRING__'], [
          $this->argument('title'), $this->argument('description'), $this->argument('cancel'), $this->argument('check'),
        ], $stub);

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {

        return __DIR__.'/stubs/feature_class.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace  The root namespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    : string {

        return $rootNamespace.'\Domain\\'.$this->argument('domain').'\Features';
    }

}
