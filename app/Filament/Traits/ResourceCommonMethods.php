<?php

namespace App\Filament\Traits;

trait ResourceCommonMethods
{
    public static function getModelLabel(): string
    {
        return __("filament/resources.". parent::getModelLabel() .".label");
    }

    public static function getPluralModelLabel(): string
    {
        return __("filament/resources.". parent::getModelLabel() .".plural_label");
    }

    public static function getNavigationGroup(): ?string
    {
        if (! isset(self::$navigationGroup)) {
            return null;
        }
        return __(self::$navigationGroup);
    }
}