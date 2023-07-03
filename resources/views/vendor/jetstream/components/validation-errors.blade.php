@if ($errors->any())
    <div {!! $attributes->merge(['class' => 'alert alert-danger text-sm p-2']) !!} role="alert">
        <div class="font-weight-bold">{{ __('¡Existe un problema!') }}</div>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
