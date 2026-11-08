<?php

namespace App\Http\Controllers;

use App\Services\CourseCatalog;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use JsonException;
use RuntimeException;

class CourseController extends Controller
{
    /** Display courses or a friendly unavailable page. */
    public function index(CourseCatalog $catalog): Response
    {
        try {
            return response()->view('courses', [
                'courses' => $catalog->all(),
                'unavailable' => false,
            ]);
        } catch (ConnectionException|RequestException|ValidationException|RuntimeException|JsonException $exception) {
            Log::warning('Course catalogue unavailable.', ['type' => $exception::class]);

            return response()->view('courses', [
                'courses' => [], 'unavailable' => true,
            ], 503);
        }
    }
}
