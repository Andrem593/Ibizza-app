<div>

    <div id="nueva_condicion">
        <div class="row">
            <div class="col">
                {{-- @section('plugins.Select2', true) --}}
                <select id="nombre_tabla" class="no-editable" data-width="100%">
                    <option value="" selected>Seleccionar tabla</option>
                    <option value="empresarias">Empresaria</option>
                    <option value="pedidos">Pedido</option>
                </select>
            </div>
        </div>
        <div id="nueva_regla">
            <div class="row py-2 clone-div">
                <div class="col col-sm-4">
                    <select name="campo" class="campo no-editable" data-width="100%">
                        <option value="" selected>Seleccionar campo</option>
                        <option value="tipo_cliente">Tipo Cliente</option>
                        <option value="empresarias">Empresaria</option>
                        <option value="pedidos">Venta</option>
                    </select>
                </div>
                <div class="col col-sm-2">
                    <select name="operador" class="operador no-editable" data-width="100%">
                        <option value="" selected>Operador</option>
                        <option value="=">igual</option>
                        <option value=">">mayor que</option>
                        <option value="<">menor que</option>
                        <option value=">=">mayor igual que</option>
                        <option value="<=">menor igual que</option>
                        <option value="contiene">contiene</option>
                        <option value="no contiene">no contiene</option>
                    </select>
                </div>
                <div class="col col-sm-4">
                    <select name="valor" class="valor editable" data-width="100%">
                        <option value="" selected>Ingrese un valor</option>
                        <option value="NUEVA">Nueva</option>
                        <option value="CONTINUA">Continua</option>
                        <option value="INACTIVA-1">Inactiva 1</option>
                        <option value="INACTIVA-2">Inactiva 2</option>
                        <option value="INACTIVA-3">Inactiva 3</option>
                        <option value="REACTIVA">Reactiva</option>
                        <option value="BAJA">Baja</option>
                    </select>
                </div>
                <div class="col col-sm-1">
                    <select name="condicion" class="condicion no-editable" data-width="100%">
                        <option value="and" selected>Y</option>
                        <option value="or">O</option>
                    </select>
                </div>
                <div class="col col-sm-1 remover_regla">
                    <button id="btn_regla" class="btn btn-ibizza"><i class="fas fa-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
    <button id="btn_condicion" class="btn btn-ibizza btn-block btn-sm"><i class="fas fa-plus"></i>
        Agregar condición</button>
</div>
