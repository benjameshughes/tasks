<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: int implements HasLabel, HasColor
{
    case backlog = 0;
    case in_progress = 1;
    case complete = 3;

    public function getLabel(): string
    {
        return match ($this){
            self::backlog => __('Backlog'),
            self::in_progress => __('Doing'),
            self::complete => __('Completed'),
        };
    }

    public function getColor(): string|array
    {
        return match ($this){
            self::backlog => Color::Red,
            self::in_progress => Color::Amber,
            self::complete => Color::Emerald,
        };
    }
}
