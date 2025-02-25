<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasDynamicPermission
{
    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_' . static::getPermissionName());
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create_' . static::getPermissionName());
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('update_' . static::getPermissionName());
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('delete_' . static::getPermissionName());
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('view_' . static::getPermissionName());
    }
}
