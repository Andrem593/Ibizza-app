<div>

    <div id="nueva_condicion">
        <div class="row">
            <div class="col col-sm-6">
                <div class="form-group">
                    {{-- @section('plugins.Select2', true) --}}
                    <select id="tipo_empresaria" class="form-control selectpicker show-tick" data-live-search="true"
                        data-width="100%">
                        <option value="" selected>Seleccionar tipo empresaria</option>
                        <option value="TODOS">Todos</option>
                        <option value="PROSPECTOS">Prospectos</option>
                        <option value="NUEVA">Nueva</option>
                        <option value="CONTINUA">Continua</option>
                        <option value="INACTIVA-1">Inactiva 1</option>
                        <option value="INACTIVA-2">Inactiva 2</option>
                        <option value="INACTIVA-3">Inactiva 3</option>
                        <option value="POSIBLE-BAJA">Posible Baja</option>
                        <option value="REACTIVA">Reactiva</option>
                        <option value="BAJA">Baja</option>
                        <option value="RE-INGRESO">Re-Ingreso</option>
                    </select>
                </div>
                {{-- <select id="nombre_tabla" class="no-editable" data-width="100%">
                    <option value="" selected>Seleccionar tabla</option>
                    <option value="empresarias">Empresaria</option>
                    <option value="pedidos">Pedido</option>
                </select> --}}
            </div>
            <div class="col col-sm-6">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="chk_acumular">
                        <label class="custom-control-label" for="chk_acumular">Pedidos Acumulados</label>
                    </div>
                </div>
            </div>
        </div>
        <div id="nueva_regla">
            <div class="row py-2 clone-div">
                <div class="col col-sm-6">
                    <div class="form-group">
                        {{-- @section('plugins.Select2', true) --}}
                        <select id="nivel" class="form-control selectpicker show-tick" data-live-search="true"
                            data-width="100%">
                            <option value="" selected>Seleccionar nivel</option>
                            <option value="1">Nivel 1</option>
                            <option value="2">Nivel 2</option>
                            <option value="3">Nivel 3</option>
                        </select>
                    </div>
                </div>
                <div class="col col-sm-3">
                    <div class="form-group">
                        {{-- <label for="rango_desde">Desde</label> --}}
                        <input type="number" class="form-control" id="rango_desde" placeholder="Desde">
                    </div>
                </div>
                <div class="col col-sm-3">
                    <div class="form-group">
                        {{-- <label for="rango_hasta">Hasta</label> --}}
                        <input type="number" class="form-control" id="rango_hasta" placeholder="Hasta">
                    </div>
                </div>
                {{-- <div class="col col-sm-1">
                    <select name="condicion" class="condicion no-editable" data-width="100%">
                        <option value="and" selected>Y</option>
                        <option value="or">O</option>
                    </select>
                </div>
                <div class="col col-sm-1 remover_regla">
                    <button id="btn_regla" class="btn btn-ibizza"><i class="fas fa-plus"></i></button>
                </div> --}}
            </div>
        </div>
    </div>
    <button id="btn_condicion" class="btn btn-ibizza btn-block btn-sm"><i class="fas fa-plus"></i>
        Agregar condición</button>
</div>
