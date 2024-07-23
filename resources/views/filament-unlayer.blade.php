@use('Filament\Support\Facades\FilamentAsset')

<x-dynamic-component 
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        ax-load
        ax-load-src="{{ FilamentAsset::getAlpineComponentSrc('filament-unlayer', 'InfinityXTech/filament-unlayer') }}"
        x-data="initUnlayer({
            state: $wire.entangle('{{ $getStatePath() }}'),
            displayMode: '{{ $getDisplayMode() }}',
            id: '{{ $getId() }}',
            uploadUrl: '{{ $getUploadUrl() }}'
        })"
    >
        <div wire:ignore x-ref="unlayer" id="{{$getId()}}" style="height: {{ $getHeight() }};"></div>
    </div>
</x-dynamic-component>
