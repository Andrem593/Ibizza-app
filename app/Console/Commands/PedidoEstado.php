<?php

namespace App\Console\Commands;

use App\Models\Pedidos_pendiente;
use App\Models\Separado;
use App\Producto;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

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
        //Carbon::now()->subDays(3);
        $pedidos = Pedidos_pendiente::where('created_at','<', Carbon::now()->subDays(3))->get();        
        if(count($pedidos) > 0){    
            $separados = [];        
            foreach ($pedidos as $pedido) {
                try {                    
                    $producto = Producto::find($pedido->id_producto);
                    $nuevo_stock = $producto->stock + $pedido->cantidad;
                    Producto::find($pedido->id_producto)->update([
                        'stock'=>$nuevo_stock
                    ]);
                    Separado::find($pedido->id_separados)->delete(); 

                    array_push($separados, $pedido->id_separados);
                } catch (\Throwable $th) {
                    $this->info('Error: ' . $th->getMessage());
                }
            }
            if(count($separados) > 0)
            {
                $separados = array_unique($separados);
                Pedidos_pendiente::whereIn('id_separados', $separados)->delete();
                // where('id_separados',$pedido->id_separados)->
            }

            $this->info('Pedidos actualizados');
        }else{
            $this->info('Sin cambios');
        }
    }
}
