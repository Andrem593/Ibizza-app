<?php

namespace App\Console\Commands;

use App\Catalogo;
use App\Producto;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Empresaria;

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
        $catalogos = Catalogo::where('fecha_fin_catalogo', '<', Carbon::now()->format('Y-m-d'))
            ->where('estado', 'PUBLICADO')
            ->get();

        if (count($catalogos) > 0) {
            foreach ($catalogos as $catalogo) {
                try {
                    $empresarias = Empresaria::with('pedidos')->where('estado', 'A')->get();                    
                    foreach ($empresarias as $empresaria) {
                        if ($empresaria->tipo_cliente == 'NUEVA') {
                            $empresaria->update([
                                'campana_anterior' => 'NUEVA'
                            ]);
                            $this->info('Empresarias NUEVAS actuaizadas.');
                        } 
                        if ($empresaria->tipo_cliente == 'CONTINUA') {
                            $pedidos = $empresaria->pedidos;
                            $empresaria->update([
                                'campana_anterior' => 'CONTINUA'
                            ]);
                            $this->info('Empresarias CONTINUA actuaizadas.');
                        } 
                        if ($empresaria->tipo_cliente == 'REACTIVA') {
                            $empresaria->update([
                                'campana_anterior' => 'REACTIVA'
                            ]);
                            $this->info('Empresarias REACTIVA actuaizadas.');
                        }
                        if ($empresaria->tipo_cliente == 'NUEVA') {
                            $pedidos = $empresaria->pedidos;
                            $resp = $pedidos->where('id_catalogo', $catalogo->id);
                            if (count($resp) == 0) {
                                $empresaria->update([
                                    'tipo_cliente' => 'INACTIVA-1',
                                    'campana_anterior' => 'INACTIVA-1'
                                ]);
                            }
                        } else if ($empresaria->tipo_cliente == 'CONTINUA') {
                            $pedidos = $empresaria->pedidos;
                            $resp = $pedidos->where('id_catalogo', $catalogo->id);
                            if (count($resp) == 0) {
                                $empresaria->update([
                                    'tipo_cliente' => 'INACTIVA-1',
                                    'campana_anterior' => 'INACTIVA-1'
                                ]);
                            }
                        } else if ($empresaria->tipo_cliente == 'INACTIVA-1') {
                            $pedidos = $empresaria->pedidos;
                            $resp = $pedidos->where('id_catalogo', $catalogo->id);
                            if (count($resp) == 0) {
                                $empresaria->update([
                                    'tipo_cliente' => 'INACTIVA-2',
                                    'campana_anterior' => 'INACTIVA-2'
                                ]);
                            }
                        } else if ($empresaria->tipo_cliente == 'INACTIVA-2') {
                            $pedidos = $empresaria->pedidos;
                            $resp = $pedidos->where('id_catalogo', $catalogo->id);
                            if (count($resp) == 0) {
                                $empresaria->update([
                                    'tipo_cliente' => 'INACTIVA-3',
                                    'campana_anterior' => 'INACTIVA-3'
                                ]);
                            }
                        } else if ($empresaria->tipo_cliente == 'INACTIVA-3') {
                            $pedidos = $empresaria->pedidos;
                            $resp = $pedidos->where('id_catalogo', $catalogo->id);
                            if (count($resp) == 0) {
                                $empresaria->update([
                                    'tipo_cliente' => 'POSIBLE BAJA',
                                    'campana_anterior' => 'POSIBLE BAJA'
                                ]);
                            }
                        } else if ($empresaria->tipo_cliente == 'POSIBLE BAJA') {
                            $pedidos = $empresaria->pedidos;
                            $resp = $pedidos->where('id_catalogo', $catalogo->id);
                            if (count($resp) == 0) {
                                $empresaria->update([
                                    'tipo_cliente' => 'BAJA',
                                    'campana_anterior' => 'BAJA'
                                ]);
                            }
                        } else if ($empresaria->tipo_cliente == 'REACTIVA') {
                            $pedidos = $empresaria->pedidos;
                            $resp = $pedidos->where('id_catalogo', $catalogo->id);
                            if (count($resp) == 0) {
                                $empresaria->update([
                                    'tipo_cliente' => 'INACTIVA-1',
                                    'campana_anterior' => 'INACTIVA-1'
                                ]);
                            }
                        } else if ($empresaria->tipo_cliente == 'RE-INGRESO') {
                            $pedidos = $empresaria->pedidos;
                            $resp = $pedidos->where('id_catalogo', $catalogo->id);
                            if (count($resp) == 0) {
                                $empresaria->update([
                                    'tipo_cliente' => 'INACTIVA-1',
                                    'campana_anterior' => 'INACTIVA-1'
                                ]);
                            }
                        } else if ($empresaria->tipo_cliente == 'PROSPECTO') {
                            $pedidos = $empresaria->pedidos;
                            $resp = $pedidos->where('id_catalogo', $catalogo->id);
                            if (count($resp) == 0) {
                                $empresaria->update([
                                    'campana_anterior' => 'PROSPECTO'
                                ]);
                            }
                        }                         
                    }
                } catch (\Throwable $th) {
                    $this->info('Error: ' . $th->getMessage());
                }
            }
            $this->info('Catalogos actualizados.');
        } else {
            $this->info('Sin cambios.');
        }
    }
}
