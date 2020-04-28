<?php

namespace Overlu\Reget\Console;

use Illuminate\Console\Command;
use Overlu\Reget\Reget;
use Overlu\Reget\Utils\Env;

class Register extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reget:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'register service';

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
            $this->serverInit();
            $this->info(Reget::getInstance()->init()->register());
        } catch (\Exception $exception) {
            $this->error("register service failed. error message: " . $exception->getMessage() . ', on file: ' . $exception->getFile() . ', at line: ' . $exception->getLine());
        }
    }

    private function serverInit()
    {
        $register_host = $this->ask("Enter the register host address(eg:http://127.0.0.1:8848)");
        if (!preg_match('|[a-zA-z]+://[^\s]*|', $register_host)) {
            $this->error("Illegal input");
            $this->serverInit();
        }
        $instance_name = $this->ask("Enter the instance name(" . env('APP_NAME') . ")") ?? env('APP_NAME');
        exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'", $arr);
        $num = count($arr);
        $ip_info = 'The instance ips as follow:' . PHP_EOL;
        for ($i = 1; $i <= $num; $i++) {
            $ip_info .= '(' . $i . ') ' . $arr[$i - 1] . ($i == $num ? '' : PHP_EOL);
        }
        $this->info($ip_info);
        $index = $this->ask("Choose the instance ip address (1)") ?? 1;
        if (!isset($arr[$index - 1])) {
            $this->error("Illegal input");
            $this->serverInit();
        }
        $port = $this->ask("Enter the instance port (80)") ?? 80;
        if ($port > 65535 || $port < 1) {
            $this->error("Illegal input");
            $this->serverInit();
        }
        $env = new Env();
        $server = [
            'NACOS_REGISTER_HOST' => $register_host,
            'NACOS_SERVICE_NAME' => $instance_name,
            'NACOS_SERVICE_HOST' => $arr[$index - 1],
            'NACOS_SERVICE_PORT' => $port
        ];
        $env->setEnvs($server);
    }
}
