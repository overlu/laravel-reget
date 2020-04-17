<?php

namespace Overlu\Reget\Console;

use Illuminate\Console\Command;
use Overlu\Reget\Reget;

class Lists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reget:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list service';

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
     */
    public function handle()
    {
        try {
            echo Reget::getInstance()->init()->servers();
        } catch (\Exception $exception) {
            $this->error("list service failed. error message: " . $exception->getMessage() . ', on file: ' . $exception->getFile() . ', at line: ' . $exception->getLine());
        }
    }
}
