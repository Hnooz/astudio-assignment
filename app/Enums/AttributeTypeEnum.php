<?php

namespace App\Enums;

enum AttributeTypeEnum: string
{
    case TEXT = 'text';
    case NUMBER = 'number';
    case DATE = 'date';
    case SELECT = 'select';

    public function label(): string
    {
        return match ($this) {
            self::TEXT => 'Text',
            self::NUMBER => 'Number',
            self::DATE => 'Date',
            self::SELECT => 'Select',
        };
    }

    public static function labels(): array
    {
        return array_map(fn ($case) => $case->label(), self::cases());
    }

    public static function labelsWithIds(): array
    {
        return array_map(fn ($case) => ['id' => $case->value, 'label' => $case->label()], self::cases());
    }
}
