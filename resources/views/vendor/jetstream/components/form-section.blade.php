@props(['submit'])

<div {{ $attributes->merge(['class' => 'row']) }}>
    <div class="text-center d-flex justify-content-center">
        <x-jet-section-title >
            <x-slot name="title">{{ $title }}</x-slot>
            <x-slot name="description">
                <span class="small">
                    {{ $description }}
                </span>
            </x-slot>
        </x-jet-section-title>
    </div>
    <div class="row">
        <div class="recuadro card shadow-sm mx-auto">
            <form wire:submit.prevent="{{ $submit }}">
                <div class="card-body">
                {{ $form }}
                </div>

                @if (isset($actions))
                    <div class="card-footer d-flex justify-content-end">
                        {{ $actions }}
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
