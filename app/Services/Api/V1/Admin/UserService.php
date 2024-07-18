<?php

namespace App\Services\Api\V1\Admin;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserService
{
    public function index(Request $request): array
    {
        $users = User::when($request->search, function ($query) use ($request) {
            $query->search($request->search);
        })->when($request->role, function ($query) use ($request) {
            if ($request->role == 'admin') {
                $query->where('role_id', Role::ADMIN->value);
            } else {
                $query->where('role_id', Role::USER->value);
            }
        })->with(['role', 'profile']);

        $result = $request->limit ? $users->paginate($request->limit) : $users->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }

    public function store(array $validated): User
    {
        return User::create($validated);
    }

    public function update(array $validated, User $user): User
    {
        $user->update($validated);

        return $user;
    }

    public function destroy(User $user): void
    {
        $user->delete();
    }
}
