<?php

namespace App\Policies;

use App\Models\User;
use Facades\App\Services\UserService;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user |null
     *
     * @return bool
     */
    public function canBook($user)
    {
        if ($user == null) return false;
        else {
            return UserService::hasPaymentInfo($user);
        }
    }
}
