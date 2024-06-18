<div class="box box-info padding-1">
    <div class="box-body">

        <div class="row">
            <div class="col-sm-4 text-center">
                @livewire('image',['ruta_imagen'=>"$catalogo->foto_path", 'path' => '/storage/images/catalogo/', 'name'
                => 'foto_path'])

                @if (!empty($catalogo->pdf_path))
                    <div>
                        <x-adminlte-button label="Ver Catálogo cargado" data-toggle="modal" data-target="#modalCustom"
                            class="btn-ibizza btn-block m-1" icon="fas fa-book-open" />
                    </div>
                @endif
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('nombre') }}
                    {{ Form::text('nombre', $catalogo->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
                    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('descripción') }}
                    {{ Form::textarea('descripcion', $catalogo->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripción', 'rows' => 3, 'style' => 'resize: none']) }}
                    {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="row form-group">
                    <div class="col">
                        @php
                            $config = [
                                'format' => 'YYYY-MM-DD',
                                //'minDate' => "js:moment().format()",
                                //'defaultDate' => "js:moment().format()"
                            ];
                        @endphp
                        <x-adminlte-input-date name="fecha_publicacion" :config="$config"
                            placeholder="Fecha Publicación" label="Fecha Publicación"
                            value="{{ $catalogo->fecha_publicacion }}">
                            <x-slot name="appendSlot"
                                class="form-control{{ $errors->has('fecha_publicacion') ? ' is-invalid' : '' }}">
                                <div class="input-group-text btn-ibizza">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                        {!! $errors->first('fecha_publicacion', '<div class="invalid-feedback">:message</p>') !!}
                        {{-- {{ Form::label('fecha_publicación') }}
                        {{ Form::text('fecha_publicacion', $catalogo->fecha_publicacion, ['class' => 'form-control' . ($errors->has('fecha_publicacion') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Publicación']) }}
                        {!! $errors->first('fecha_publicacion', '<div class="invalid-feedback">:message</p>') !!} --}}
                    </div>

                    <div class="col">
                        {{-- @php
                            $config = [
                                'format' => 'YYYY-MM-DD',
                                'minDate' => "js:moment().format()"
                            ];
                        @endphp --}}
                        <x-adminlte-input-date name="fecha_fin_catalogo" :config="$config"
                            placeholder="Fecha Fin Catálogo" label="Fecha Fin Catálogo"
                            value="{{ $catalogo->fecha_fin_catalogo }}">
                            <x-slot name="appendSlot"
                                class="form-control{{ $errors->has('fecha_fin_catalogo') ? ' is-invalid' : '' }}">
                                <div class="input-group-text btn-ibizza">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                        {!! $errors->first('fecha_fin_catalogo', '<div class="invalid-feedback">:message</p>') !!}

                        {{-- {{ Form::label('fecha_fin_catálogo') }}
                        {{ Form::text('fecha_fin_catalogo', $catalogo->fecha_fin_catalogo, ['class' => 'form-control' . ($errors->has('fecha_fin_catalogo') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Fin Catálogo']) }}
                        {!! $errors->first('fecha_fin_catalogo', '<div class="invalid-feedback">:message</p>') !!} --}}
                    </div>
                    <div class="col">
                        @php
                            $configSwitch = [
                                'onText' => 'PUBLICADO',
                                'offText' => 'SIN PUBLICAR',
                                'state' => !empty($catalogo->estado) && $catalogo->estado == 'PUBLICADO' ? true : false,
                            ];
                        @endphp
                        @section('plugins.BootstrapSwitch', true)
                            @if(!empty($catalogo->estado) && $catalogo->estado == 'PUBLICADO')
                            <x-adminlte-input-switch name="estado" label="Estado" igroup-size="sm" data-on-color="teal" :config="$configSwitch" checked/>
                            @else
                            <x-adminlte-input-switch name="estado" label="Estado" igroup-size="sm" data-on-color="teal" :config="$configSwitch" />
                            @endif
                        </div>
                    </div>


                @section('plugins.BsCustomFileInput', true)

                    <x-adminlte-input-file name="pdf_path" class="" igroup-size="sm" label="Carga archivo (.pdf)"
                        legend="Seleccionar" placeholder="Escoger un archivo .pdf" accept="application/pdf">

                        <x-slot name="prependSlot">
                            <div class="input-group-text btn-ibizza">
                                <i class="fas fa-upload"></i>
                            </div>
                        </x-slot>

                    </x-adminlte-input-file>

                    {{-- <div class="form-group">
                    {{ Form::label('Subir PDF') }}
                    {{ Form::text('pdf_path', $catalogo->pdf_path, ['class' => 'form-control' . ($errors->has('pdf_path') ? ' is-invalid' : ''), 'placeholder' => 'Pdf Path']) }}
                    {!! $errors->first('pdf_path', '<div class="invalid-feedback">:message</p>') !!}
                </div> --}}
                </div>

                <div>
                    <table class="table table-light">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Valor</th>
                                <th>Estado</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody id="parametros-table-body">
                            @foreach ($parametros as $parametro)
                            <tr>
                                <td>
                                    <input type="text" name="parametros[{{ $loop->index }}][id]" value="{{ $parametro->id }}">
                                </td>
                                <td>
                                    <input type="text" name="parametros[{{ $loop->index }}][nombre]" value="{{ $parametro->nombre }}" class="form-control" required>
                                </td>
                                <td>
                                    <input type="text" name="parametros[{{ $loop->index }}][valor]" value="{{ $parametro->valor }}" class="form-control" required>
                                </td>
                                <td>
                                    <input type="text" name="parametros[{{ $loop->index }}][estado]" value="{{ $parametro->estado }}" class="form-control" required>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" onclick="removeRow(this)">Eliminar</button>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success" onclick="addRow()">Agregar</button>
                </div>
            </div>

        </div>
        <div class="box-footer mt20">
            <button type="submit" class="btn bg-ibizza w-100">Guardar</button>
        </div>
    </div>

    {{-- Custom --}}
    <x-adminlte-modal id="modalCustom" title="Catálogo {{ !empty($catalogo->pdf_path) ? $catalogo->nombre : '' }}"
        size="lg" theme="teal" icon="fas fa-book-open" v-centered static-backdrop scrollable>
        <object class="PDFdoc" width="100%" height="500px" type="application/pdf"
            data="/storage/pdf/catalogo/{{ $catalogo->pdf_path }}#toolbar=0"></object>
        <x-slot name="footerSlot">
            {{-- <x-adminlte-button class="mr-auto" theme="success" label="Decargar"/> --}}
            <a href="/storage/pdf/catalogo/{{ $catalogo->pdf_path }}" target="_blank"
                class="btn btn-ibizza mr-auto">Descargar</a>
            <x-adminlte-button theme="danger" label="Cerrar" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    {{-- Example button to open modal --}}

    <script>
        function addRow() {
            var tableBody = document.getElementById('parametros-table-body');
            var rowCount = tableBody.rows.length;
            var newRow = tableBody.insertRow();

            newRow.innerHTML = `
                <td><input type="text" name="parametros[${rowCount}][id]" value="" class="form-control" readonly></td>
                <td><input type="text" name="parametros[${rowCount}][nombre]" value="" class="form-control" required></td>
                <td><input type="text" name="parametros[${rowCount}][valor]" value="" class="form-control" required></td>
                <td><input type="text" name="parametros[${rowCount}][estado]" value="Pendiente" class="form-control" required></td>
                <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Eliminar</button></td>
            `;
        }

        function removeRow(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }
    </script>
