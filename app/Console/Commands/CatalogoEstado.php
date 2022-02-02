<?php

namespace App\Console\Commands;

use App\Catalogo;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class CatalogoEstado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'estado:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar estado de catalogos';

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
        Catalogo::where('fecha_fin_catalogo', '<', Carbon::now()->format('Y-m-d'))
        ->update(['estado' => 'FINALIZADO']);

        $this->info('Catalogos actualizados.');
        //return Command::SUCCESS;
    }
}
