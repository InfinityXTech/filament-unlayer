<?php

namespace InfinityXTech\FilamentUnlayer\Forms\Components;

use Filament\Forms\Components\Select;
use Filament\Forms;
use InfinityXTech\FilamentUnlayer\Services\GetTemplates;

class SelectTemplate extends Select
{
    protected string $view = 'filament-unlayer::select-template';

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->configure();
        $static->columnSpanFull()
            ->getSearchResultsUsing(fn (string $search): array => GetTemplates::all($search))
            ->allowHtml()
            ->searchable()
            ->searchValues()
            ->searchLabels(false)
            ->searchDebounce(200)
            ->options(GetTemplates::all())
            ->placeholder(__('Pick Template'))
            ->optionsLimit(500)
            ->extraAttributes(['class' => 'template-select'])
            ->live(onBlur: true)
            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $set('content', GetTemplates::find($state)));

        return $static;
    }
}
