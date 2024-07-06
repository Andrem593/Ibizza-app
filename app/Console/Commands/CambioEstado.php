<?php

namespace App\Console\Commands;

use App\Models\Pedidos_pendiente;
use App\Models\ReservarCambiosDetalle;
use App\Models\ReservarCambiosPedido;
use App\Models\Separado;
use App\Producto;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CambioEstado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cambio:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar los cambios con mas de 3 dias en espera';

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
        //Se ejecutaria despues de media noche
        $date = date("Y-m-d");
        $reservarCambiosDetalle = ReservarCambiosDetalle::with('reserveChangesOrder')
            ->whereHas('reserveChangesOrder', function ($query) use($date) {
                $query->where([
                        ['fecha_vencimiento', '<=',$date],
                        ['estado', 1]
                    ]);
            })->get();
    
        $ids = [] ;
        
        foreach ($reservarCambiosDetalle as $key => $detail) {
            $ids[] = $detail->reserveChangesOrder->id ;
            $product = Producto::where('id', $detail->id_producto)->first();
            if ($product) {
                $product->stock += $detail->cantidad ;
                $product->save();
            }
        }
        
        ReservarCambiosPedido::whereIn('id', $ids)->update([
            'estado' => 4
        ]);
    }
}
