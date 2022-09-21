<?php
namespace GLC\Platform\Migration\Commands;

use Illuminate\Console\Command;

/**
 * (Fake) migrate:resetを無効化するためのコマンドクラス。
 *
 * @package GLC\Platform\Migration\Commands
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class FakeResetCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'migrate:reset';

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