<?php

namespace App\Enum;

enum UserRoles :string{

    case SuperAdmin = 'superAdmin';
    case Provider = 'provider';
    case Client = 'client';
}
