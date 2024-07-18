<?php

namespace App\Services\Api\V1\User;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleService
{
    public function index(Request $request): array
    {
        $modules = Module::select(['id', 'title', 'position'])
            ->orderBy('position', 'asc')
            ->withCount(['lessons']);

        $result = $request->limit ? $modules->paginate($request->limit) : $modules->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }
}
