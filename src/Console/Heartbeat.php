<?php

namespace Overlu\Reget\Console;

use Illuminate\Console\Command;
use Overlu\Reget\Reget;

class Heartbeat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reget:heartbeat
                            {--cron : Run the worker in cron mode (Deprecated)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send service heartbeat';

    /**
     * @var int
     */
    protected $loop = false;

    /**
     * @var int
     */
    protected $interval = 5000;

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
            $res = Reget::getInstance()->heartbeat();
            $this->loop = $res['lightBeatEnabled'] ?? $this->loop;
            $this->interval = $res['clientBeatInterval'] ?? $this->interval;
            $this->info('send heartbeat: ok');
        } catch (\Exception $exception) {
            $this->error("service heartbeat failed. error message: " . $exception->getMessage() . ', on file: ' . $exception->getFile() . ', at line: ' . $exception->getLine());
        }
        if ($this->option('cron') && $this->loop) {
            usleep($this->interval * 1000);
            $this->handle();
        }
    }
}
