<?php

namespace Overlu\Reget\Console;

use Illuminate\Console\Command;
use Overlu\Reget\Listeners\ConfigListener;
use Overlu\Reget\Reget;
use Psr\SimpleCache\InvalidArgumentException;

class Listen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reget:listen {config}
                            {--handle= : add handle class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'listen remote config data and update the local cache';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @throws InvalidArgumentException
     */
    public function handle()
    {
        try {
            if ($handle = $this->option('handle')) {
                ConfigListener::add($handle);
            }
            $config = $this->argument('config');
            Reget::getInstance()->listen($config);
        } catch (\Exception $exception) {
            $this->error("listen failed. error message: " . $exception->getMessage() . ', on file: ' . $exception->getFile() . ', at line: ' . $exception->getLine());
        }
    }
}
