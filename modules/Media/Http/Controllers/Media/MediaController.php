<?php

namespace Modules\Media\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('media::index');
    }

    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('uploads', 'public');

            return response()->json([
                'path' => asset('storage/' . $path)  // Ensure the path is correct
            ]);
        }

        return response()->json(['message' => 'No file uploaded'], 400);
    }


}
