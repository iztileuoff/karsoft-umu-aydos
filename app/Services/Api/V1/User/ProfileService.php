<?php

namespace App\Services\Api\V1\User;

use App\Models\User;

class ProfileService
{
    public function update(array $validated, User $user): User
    {
        $user->update($validated);

        return  $user;
    }
}
