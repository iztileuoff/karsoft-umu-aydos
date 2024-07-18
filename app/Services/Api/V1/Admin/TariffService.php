<?php

namespace App\Services\Api\V1\Admin;

use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffService
{
    public function index(Request $request): array
    {
        $tariffs = Tariff::orderBy('id', 'desc');

        $result = $request->limit ? $tariffs->paginate($request->limit) : $tariffs->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }

    public function update(array $validated, Tariff $tariff): Tariff
    {
        $validated['title'] = [
            'ltn' => $validated['title_ltn'],
            'cyr' => $validated['title_cyr'] ?? null,
        ];

        $validated['description'] = [
            'ltn' => $validated['description_ltn'],
            'cyr' => $validated['description_cyr'] ?? null,
        ];

        $tariff->update($validated);

        return $tariff;
    }
}
