<div>
    <div wire:loading wire:target="image" class="alert alert-info w-100" role="alert">
        <div class="d-flex align-items-center">
            <strong>¡Imagen Cargando!...</strong>
            <div class="spinner-border text-primary ms-auto" role="status" aria-hidden="true"></div>
        </div>
    </div>

    @if ($image)
        <img src="{{ 'data:' . $image->getMimeType() . ';base64,' . base64_encode($image->get()) }}" class="rounded" alt="imagen-producto"
            style="max-width: 15rem; max-height: 15rem">
    @elseif ($ruta_imagen)
        <img src="{{ asset('storage/images/productos/' . $ruta_imagen) }}" class="rounded" alt="imagen-producto"
            style="max-width: 15rem; max-height: 15rem">
    @else
        <img src="https://catalogoibizza.com/img/imagen-no-disponible.jpg" class="rounded" alt="imagen-producto"
            style="max-width: 15rem;">
    @endif

    {{-- <input class="btn btn-ibizza w-100 m-1">CAMBIAR</input> --}}
    {{-- <input type="file" class="form-control w-100 m-1" wire:model="image"> --}}
    <div style="position:relative;">
        <a class='btn bg-ibizza w-100 m-1'>
            Nueva imagen
            <input wire:model="image" type="file"
                style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;'
                name="{{ $name }}" size="40" onchange='$("#upload-file-info").html($(this).val());'>
        </a>
    </div>
    @error('image')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
