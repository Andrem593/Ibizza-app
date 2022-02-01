<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PedidoEstado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pedido:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar pedidos con mas de 3 dias en espera';

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
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
