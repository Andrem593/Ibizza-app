<div>
    <div class="row">
        {{ $venta_id }}
        <div class="col">
            <label class="form-label">Valor a Pagar:</label>
            <input type="text" class="form-control p-1" wire:model='valor_pagar' placeholder="Valor a Pagar">
        </div>
        <div class="col">
            <label class="form-label">Valor Recaudado:</label>
            <input type="text" class="form-control p-1" wire:model='valor_recaudado' placeholder="Valor Recaudado">
        </div>
        <div class="col">
            <label class="form-label">Valor Pendiente:</label>
            <input type="text" class="form-control p-1" wire:model='valor_pendiente' placeholder="Valor Pendiente">
        </div>
    </div>
</div>