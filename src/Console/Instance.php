<?php

namespace Overlu\Reget\Console;

use Illuminate\Console\Command;
use Overlu\Reget\Reget;
use Overlu\Reget\Utils\Tools;

class Instance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reget:instance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'pull instance detail information';

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
            $this->info(Tools::json_pretty(Reget::getInstance()->init()->instance()));
        } catch (\Exception $exception) {
            $this->error("pull instance info failed. error message: " . $exception->getMessage() . ', on file: ' . $exception->getFile() . ', at line: ' . $exception->getLine());
        }
    }
}
