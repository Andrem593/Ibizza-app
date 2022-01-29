<?php

namespace App\Console\Commands;

use App\Catalogo;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CatalogoEstado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        Catalogo::where('fecha_fin_publicacion', '>', Carbon::now())
        ->update(['estado' => 'FINALIZADO']);

        return Command::SUCCESS;
    }
}
