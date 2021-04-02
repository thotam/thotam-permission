<?php

namespace Thotam\ThotamPermission;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Thotam\ThotamPermission\Skeleton\SkeletonClass
 */
class ThotamPermissionFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'thotam-permission';
    }
}
