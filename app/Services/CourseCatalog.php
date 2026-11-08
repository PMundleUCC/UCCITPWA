<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class CourseCatalog
{
    /** @return array<int, array{code: string, name: string, credits: int, prerequisites: string, description: string, level: int, category: string}> */
    public function all(): array
    {
        $url = config('department.firebase_url');

        // Firebase is required for course data.
        if (! $url) {
            throw new RuntimeException('A Firebase Realtime Database URL is required.');
        }

        if (! preg_match('~^https://[a-z0-9-]+(?:\.[a-z0-9-]+)*\.(?:firebaseio\.com|firebasedatabase\.app)/?$~i', $url)) {
            throw new RuntimeException('A valid Firebase Realtime Database URL is required.');
        }

        // Reuse successful Firebase reads for five minutes.
        return Cache::remember('department-courses-'.hash('sha256', $url), 300, function () use ($url): array {
            $response = Http::acceptJson()->connectTimeout(3)->timeout(8)
                ->get(rtrim($url, '/').'/courses.json')->throw();
            $data = json_decode($response->body(), true, flags: JSON_THROW_ON_ERROR);

            if ($data === null) {
                return [];
            }

            // Check course fields before displaying external data.
            $validated = Validator::make(['courses' => $data], [
                'courses' => ['required', 'array', 'max:500'],
                'courses.*' => ['required', 'array'],
                'courses.*.code' => ['required', 'string', 'max:30', 'distinct'],
                'courses.*.name' => ['required', 'string', 'max:150'],
                'courses.*.credits' => ['required', 'integer', 'between:1,30'],
                'courses.*.prerequisites' => ['required', 'string', 'max:300'],
                'courses.*.description' => ['required', 'string', 'max:3000'],
                'courses.*.level' => ['required', 'integer', 'between:1,4'],
                'courses.*.category' => ['required', 'string', 'max:80'],
            ])->validate();

            return collect($validated['courses'])->sortBy('code')->values()->all();
        });
    }
}
