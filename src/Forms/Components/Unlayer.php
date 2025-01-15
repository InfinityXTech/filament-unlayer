<?php

namespace InfinityXTech\FilamentUnlayer\Forms\Components;

use Filament\Forms\Components\Field;

class Unlayer extends Field
{
    protected string $view = 'filament-unlayer::filament-unlayer';

    protected string $displayMode = 'email';

    protected array $additionalOptions = [];

    // protected mixed $defaultState = [
    //     'html' => '', 'design' => []
    // ];
    // protected bool $hasDefaultState = true;
    protected $height = '70svh';

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->configure();
        $static->columnSpanFull();

        return $static;
    }

    public function displayMode(string $mode): static
    {
        $this->displayMode = $mode;

        return $this;
    }

    public function height($height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getDisplayMode(): string
    {
        return $this->displayMode;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getUploadUrl(): string
    {
        return route(config('filament-unlayer.upload.url_name'));
    }

    public function additionalOptions(array $additionalOptions): static
    {
        $this->additionalOptions = $additionalOptions;

        return $this;
    }

    public function getAdditionalOptions(): array
    {
        return $this->additionalOptions;
    }
}
