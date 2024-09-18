<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum Priority: int implements HasLabel, HasColor
{
    case none = 0;
    case low = 1;
    case medium = 2;
    case high = 3;
    case immediate = 4;

    public function getLabel(): string
    {
        return match ($this)
        {
            self::none => __('None'),
            self::low => __('Low'),
            self::medium => __('Medium'),
            self::high => __('High'),
            self::immediate => __('Immediate'),
        };
    }

    public function getColor(): string|array
    {
        return match ($this)
        {
          self::none => Color::Slate,
          self::low => Color::Emerald,
          self::medium => Color::Sky,
          self::high => Color::Amber,
          self::immediate => Color::Rose,
        };
    }
}
