<?php

namespace App\Services\Api\V1\Admin;

use App\Models\Audio;
use Illuminate\Http\Request;

class AudioService
{
    public function index(Request $request): array
    {
        $audios = Audio::where(column: 'audioable_id', value: null)
            ->orderBy('id', 'desc');

        $result = $request->limit ? $audios->paginate($request->limit) : $audios->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }

    public function store(array $validated): array
    {
        $result = [];
        $total = 0;

        foreach ($validated['audio'] as $file)
        {
            $file_name = $this->uploadFile($file);

            $audio = Audio::create([
                'file_name' => $file_name
            ]);

            array_unshift($result, $audio);
            $total++;
        }

        return [$result, $total];
    }

    public function destroy(Audio $audio): void
    {
        $audio->delete();
    }

    private function uploadFile($file): string
    {
        $file_name = 'audio-' . $file->hashName();
        $file->storeAs('audio', $file_name, 'public');

        return $file_name;
    }
}
