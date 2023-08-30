<div>
    <div class="{{ $bandera ? '' : 'd-none' }}">
        <form wire:submit.prevent="guardar">
            <div class="row">
                <div class="col">
                    <label class="form-label">Valor a Pagar:</label>
                    <input type="text" class="form-control p-1" wire:model='valor_pagar' placeholder="Valor a Pagar"
                        readonly>
                </div>
                <div class="col">
                    <label class="form-label">Valor Recaudado:</label>
                    <input type="text" class="form-control p-1" wire:model='valor_recaudado' wire:change='calcular()'
                        placeholder="Valor Recaudado">
                    @error('valor_recaudado')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Valor Pendiente:</label>
                    <input type="text" class="form-control p-1" wire:model='valor_pendiente'
                        placeholder="Valor Pendiente" readonly>
                </div>
            </div>
            <div class="row" wire:ignore>
                <div class="col pt-2">
                    @section('plugins.BsCustomFileInput', true)
                    <x-adminlte-input-file name="comprobante_pago" wire:model="comprobante" igroup-size="sm"
                        legend="Cargar" placeholder="Cargar comprobante de pago" accept="image/*">

                        <x-slot name="prependSlot">
                            <div class="input-group-text btn-ibizza">
                                <i class="fas fa-upload"></i>
                            </div>
                        </x-slot>

                    </x-adminlte-input-file>
                    @error('comprobante')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-center" wire:ignore>
                <div class="col col-sm-6 p-2 text-center">
                    <button type="submit" class="btn bg-ibizza" id="btn_guardar">Guardar Pago</button>
                    <button type="button" class="btn bg-ibizza d-none" id="btn_actualizar" wire:click='actualizar()'>Actualizar Pago</button>
                    <button type="button" class="btn bg-secondary d-none" id="btn_cancelar" wire:click='cancelar()'>Cancelar</button>
                </div>
            </div>
        </form>
    </div>

    <div wire:loading>
        <div class="card-body text-center">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <strong>Actualizando...</strong>
        </div>
    </div>

    <div wire:loading.remove>

        @empty($pagos)
            <div class="card-body text-center">
                <strong>No hay Registros</strong>
            </div>
        @else
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Opción</th>
                                <th>Fecha de Pago</th>
                                <th>Valor a Pagar</th>
                                <th>Valor Recaudado</th>
                                <th>Valor Pendiente</th>
                                <th>Comprobante</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pagos as $item)
                                <tr>
                                    <td><button class="btn btn-ibizza" wire:click='editar({{ $item->id }})'><i class="fas fa-edit"></i></td>
                                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $item->valor_pagar }}</td>
                                    <td>{{ $item->valor_recaudado }}</td>
                                    <td>{{ $item->valor_pendiente }}</td>
                                    <td><a href="{{ $item->comprobante }}" class="btn btn-sm btn-ibizza" target="_blank">Ver
                                            comprobante</a></td>
                                    <td>{{ $item->usuario->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endempty
    </div>

    @push('js')
    <script>
        window.addEventListener('actualizar', event => {
            $('#btn_guardar').prop('disabled', true);
            $('#btn_guardar').addClass('d-none');
            $('#btn_actualizar').removeClass('d-none');
            $('#btn_cancelar').removeClass('d-none');
            // alert('Name updated to: ' + event.detail.newName);
        })
        window.addEventListener('cancelar', event => {
            $('#btn_guardar').prop('disabled', false);
            $('#btn_guardar').removeClass('d-none');
            $('#btn_actualizar').addClass('d-none');
            $('#btn_cancelar').addClass('d-none');
            // alert('Name updated to: ' + event.detail.newName);
        })
        </script>
    @endpush
</div>
