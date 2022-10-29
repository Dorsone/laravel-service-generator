<?php

namespace Dorsone\LaravelService\Console\Commands;

use Dorsone\LaravelService\ServiceGenerator;
use Illuminate\Filesystem\Filesystem;

class MakeServiceCommand extends ServiceGenerator
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name} {--controller=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service';

    /**
     * Type of generated file
     *
     * @var string
     */
    protected $type = 'Service';


    public function handle()
    {
//        parent::handle();
        $this->generateService();
    }
}
