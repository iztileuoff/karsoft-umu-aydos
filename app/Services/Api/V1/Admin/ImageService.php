<?php

namespace App\Services\Api\V1\Admin;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageService
{
    public function index(Request $request): array
    {
        $images = Image::where(column: 'imageable_id', value: null)
            ->orderBy('id', 'desc');

        $result = $request->limit ? $images->paginate($request->limit) : $images->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }

    public function store(array $validated): array
    {
        $result = [];
        $total = 0;

        foreach ($validated['images'] as $file)
        {
            $file_name = $this->uploadFile($file);

            $image = Image::create([
                'file_name' => $file_name
            ]);

            array_unshift($result, $image);
            $total++;
        }

        return [$result, $total];
    }

    public function destroy(Image $image): void
    {
        $image->delete();
    }

    private function uploadFile($file): string
    {
        $file_name = 'image-' . $file->hashName();
        $file->storeAs('images', $file_name, 'public');

        return $file_name;
    }
}
