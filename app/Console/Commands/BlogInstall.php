<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BlogInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the blog';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //生成key
        $this->execShellWithPrettyPrint('php artisan key:generate');
        //运行迁移
        $this->execShellWithPrettyPrint('php artisan migrate --seed');
        //生成文件管理软连接
        $this->execShellWithPrettyPrint('php artisan storage:link');
    }

    /**
     * Exec sheel with pretty print.
     *
     * @param  string $command
     * @return mixed
     */
    public function execShellWithPrettyPrint($command)
    {
        $this->info('---');
        $this->info($command);
        $output = shell_exec($command);
        $this->info($output);
        $this->info('---');
    }
}
