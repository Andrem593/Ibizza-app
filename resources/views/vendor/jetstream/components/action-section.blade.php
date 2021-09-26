<div {{ $attributes->merge(['class' => 'row']) }}>
    <div class="row">
        <x-jet-section-title>
            <x-slot name="title">{{ $title }}</x-slot>
            <x-slot name="description">{{ $description }}</x-slot>
        </x-jet-section-title>
    </div>

    <div class="row">
        <div class="card shadow-sm">
            <div class="card-body">
                {{ $content }}
            </div>
        </div>
    </div>
</div>
