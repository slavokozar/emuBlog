<?php

namespace App\Policies;

use App\Models\Resort;
use App\Models\User;
use Facades\App\Services\FieldPriceService;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResortPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether anyone can book the resort.
     *
     * @param User   $user |null
     * @param Resort $resort
     *
     * @return boolean
     */
    public function bookable($user, $resort)
    {
        foreach ($resort->fields as $field) {
            if (FieldPriceService::getPrices($field)->count() > 0) {
                return true;
            }
        }

        return false;
    }

}
