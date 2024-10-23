<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TraitMakeCommand extends Command
{
    protected $name = 'make:trait';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name : Traits name you want to use. }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait';

    /**
     * Execute the console command.
     */
    public function handle($rootNamespace)
    {
        return $rootNamespace . '\Traits';
    }

    public function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Traits';
    }

}
