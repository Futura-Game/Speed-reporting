<?php

namespace Src\Models\Enums\Type;

use Src\Models\Enums\BaseEnum;

class WorkType extends BaseEnum
{
    public const TRAVAIL = 'travail';
    public const CONGE = 'conge';
    public const ABSENCE = 'absence';

    public static function getEnumOptions(): array
    {
        return [
            self::TRAVAIL => 'Travail',
            self::CONGE => 'Congé',
            self::ABSENCE => 'Absence',
        ];
    }

    public static function getDefault(): string
    {
        return self::TRAVAIL;
    }
}
