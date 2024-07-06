<div>
    <div class="{{ $bandera ? '' : 'd-none' }}">
        <form wire:submit.prevent="guardar">
            <div class="row">
                <div class="col">
                    <label class="form-label">Valor a Pagar:</label>
                    <input type="number" class="form-control p-1" wire:model='valor_pagar' placeholder="Valor a Pagar"
                        readonly>
                </div>
                <div class="col">
                    <label class="form-label">Valor Recaudado:</label>
                    <input type="number" class="form-control p-1 currency" wire:model.lazy='valor_recaudado'
                        wire:change='calcular()' placeholder="Valor Recaudado">
                    @error('valor_recaudado')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Valor Pendiente:</label>
                    <input type="number" class="form-control p-1" wire:model='valor_pendiente'
                        placeholder="Valor Pendiente" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tipo de pago</label>
                    <select class="form-select form-select" wire:model.lazy="tipo_pago" name="tipo_pago" id="tipo_pago"
                        wire:change="validarTipoPago()">
                        <option value="">Seleccione un tipo de pago...</option>
                        <option value="TR">TRANSFERENCIA</option>
                        <option value="TC">TARJETA DE CRÉDITO</option>
                        <option value="SF">SALDO A FAVOR</option>
                        <option value="LI">PAGO LOCAL IBIZZA</option>
                        <option value="RI">RETIRAR LOCAL IBIZZA</option>
                        <option value="CP">CAMBIO SE VA CON PEDIDO</option>
                        <option value="CL">CAMBIO LOCAL IBIZZA</option>

                    </select>
                    @error('tipo_pago')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Valor pagado:</label>
                    <input type="text" class="form-control p-1" wire:model='valor_recaudado_total'
                        placeholder="Valor pagado" readonly>
                </div>
            </div>
            <div class="row {{ $esPagoLocalIbizza ? 'd-none' : '' }}">
                <div class="col-md-12 pt-2">
                    {{-- Se utiliza el input file nativo de HTML para seleccionar el archivo de comprobante porque el anterior no permitia limpiar el valor anterior --}}
                    <input type="file" class="form-control form-control-sm" id="{{ $resetearFileInput }}"
                        name="comprobante_pago" wire:model.defer="comprobante" placeholder="Cargar comprobante de pago"
                        onchange="showImage(event)" accept="image/*">
                    @error('comprobante')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="text-center">
                        <img id="preview" src="{{$previewUrl}}" alt="">
                    </div>

                </div>

            </div>

            <div class="row justify-content-center" wire:ignore>
                <div class="col col-sm-6 p-2 text-center">
                    <button type="submit" class="btn bg-ibizza" id="btn_guardar" wire:loading.attr="disabled">Guardar
                        Pago</button>
                    <button type="button" class="btn bg-ibizza d-none" id="btn_actualizar"
                        wire:click='actualizar()'>Actualizar Pago</button>
                    <button type="button" class="btn bg-secondary d-none" id="btn_cancelar"
                        wire:click='cancelar()'>Cancelar</button>
                </div>
            </div>
        </form>
    </div>



    <div class="row">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="d-none">Opción</th>
                            <th>Fecha de Pago</th>
                            <th class="d-none">Valor a Pagar</th>
                            <th>Valor Recaudado</th>
                            <th>Valor Pendiente</th>
                            <th>Comprobante</th>
                            <th>Tipo de pago</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($pagos) == 0)
                            <tr class="text-center">
                                <td colspan="7"><strong>No se ha subido ningún comprobante</strong></td>
                            </tr>
                        @else
                            @foreach ($pagos as $item)
                                <tr>
                                    <td class="d-none"><button class="btn btn-ibizza"
                                            wire:click='editar({{ $item->id }})'><i class="fas fa-edit"></i></td>
                                    <td>{{ $item->created_at }}</td>
                                    <td class="d-none">{{ $item->valor_pagar }}</td>
                                    <td class="text-center">{{ $item->valor_recaudado }}</td>
                                    <td class="text-center">{{ $item->valor_pendiente }}</td>
                                    <td>
                                        @if (!is_null($item->comprobante))
                                            <a href="{{ $item->comprobante }}" class="btn btn-sm btn-ibizza"
                                                target="_blank">Ver comprobante</a>
                                        @endif
                                    </td>
                                    <td>{{ $item->tipo_pago }}</td>
                                    <td>{{ $item->user->name }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr class="border">
                            <td class="align-middle fs-6" colspan="1">Valor recaudado total</td>
                            <td class="border text-center align-middle fs-6">{{ $valor_recaudado_total }}</td>
                            <td class="border text-center align-middle fs-6">{{ $valor_pendiente }}</td>
                            <td colspan="5"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <div class="text-center">
            <div wire:loading>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <strong>Actualizando...</strong>
            </div>
        </div>
    </div>
    @push('css')
        <style>
            .lol {
                display: flex;
                justify-content: center;
                flex-direction: column;
                flex-wrap: wrap;
                text-align: center;
                align-content: center;
            }

            #preview {
                width: 50%;
                max-height: 200px;
                border: 1px solid #ccc;
                box-shadow: 0px 3px 8px #ccc;
                border-radius: 5px;
                padding: 4px;
                margin-top: 10px;  
                object-fit: cover;
                text-align: center;
            }

            img.show {
                display: block;
            }

            input {
                width: 100%;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"
            integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

            function showImage(event) {
                const input = event.target;
                const preview = document.getElementById('preview');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        Livewire.emit('updatePreviewUrl', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = '';
                    preview.style.display = 'none';
                }
            }
        </script>
    @endpush
</div>
