<?php

namespace App\Services\Api\V1\Admin;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleService
{
    public function index(Request $request): array
    {
        $modules = Module::when($request->search, function ($query) use ($request) {
            $query->search($request->search);
        })->orderBy('id', 'desc');

        $result = $request->limit ? $modules->paginate($request->limit) : $modules->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }

    public function store(array $validated): Module
    {
        $validated['title'] = [
            'ltn' => $validated['title_ltn'],
            'cyr' => $validated['title_cyr'] ?? null
        ];

        $validated['description'] = [
            'ltn' => $validated['description_ltn'],
            'cyr' => $validated['description_cyr'] ?? null
        ];

        return Module::create($validated);
    }

    public function update(array $validated, Module $module): Module
    {
        $validated['title'] = [
            'ltn' => $validated['title_ltn'],
            'cyr' => $validated['title_cyr'] ?? null
        ];

        $validated['description'] = [
            'ltn' => $validated['description_ltn'],
            'cyr' => $validated['description_cyr'] ?? null
        ];

        $module->update($validated);

        return $module;
    }

    public function destroy(Module $module): void
    {
        $module->delete();
    }
}
