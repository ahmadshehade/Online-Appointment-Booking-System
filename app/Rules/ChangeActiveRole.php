<?php

namespace App\Rules;

use App\Enum\UserRoles;
use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ChangeActiveRole implements Rule
{
    public function passes($attribute, $value): bool
    {
        $user = Auth::user();

        return $user && $user->hasRole(UserRoles::SuperAdmin);
    }

    public function message(): string{
         return 'Only Super Admin can change the user Active.';
    }
}
