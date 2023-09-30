<?php

namespace App\Facades;

use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\Facade;

/**
 * @method static total()
 * @method static get()
 */
class Cart extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return CartRepository::class;
    }
}
