<?php
namespace GLC\Platform\Migration\Commands;

use Illuminate\Console\Command;

/**
 * (Fake) migrate:freshを無効化するためのコマンドクラス。
 *
 * @package GLC\Platform\Migration\Commands
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class FakeFreshCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'migrate:fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'RESTRICTED...';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->error('This command is restricted.');
    }
}