<?php

namespace App\Services\Api\V1\Admin;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationService
{
    public function index(Request $request): array
    {
        $notifications = Notification::when($request->search, function ($query) use ($request) {
            $query->search($request->search);
        })->orderByDesc('id');

        $result = $request->limit ? $notifications->paginate($request->limit) : $notifications->get();
        $total = $request->limit ? $result->total() : $result->count();

        return [$result, $total];
    }

    public function store(array $validated): Notification
    {
        $validated['title'] = [
            'ltn' => $validated['title_ltn'],
            'cyr' => $validated['title_cyr'],
        ];

        $validated['description'] = [
            'ltn' => $validated['description_ltn'],
            'cyr' => $validated['description_cyr'],
        ];

        return Notification::create($validated);
    }

    public function update(array $validated, Notification $notification): Notification
    {
        $validated['title'] = [
            'ltn' => $validated['title_ltn'],
            'cyr' => $validated['title_cyr'],
        ];

        $validated['description'] = [
            'ltn' => $validated['description_ltn'],
            'cyr' => $validated['description_cyr'],
        ];

        $notification->update($validated);

        return $notification;
    }

    public function destroy(Notification $notification): void
    {
        $notification->delete();
    }
}
