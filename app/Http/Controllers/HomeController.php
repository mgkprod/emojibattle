<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Emoji;
use App\Models\Vendor;
use App\Facades\Emojipedia;
use Illuminate\Http\Request;
use App\Models\Representation;

class HomeController extends Controller
{
    public function home()
    {
        $emoji = Emoji::inRandomOrder()->first();

        return redirect()->route('show', $emoji->slug);
    }

    public function show($slug)
    {
        $emoji = Emoji::query()
            ->where('slug', $slug)
            ->with('representations')
            ->with('representations.vendor')
            ->first();

        return inertia('show', compact('emoji'));
    }

    public function submit(Request $request)
    {
        // Find representation
        $representation = Representation::findOrFail($request->representation_id);

        // Save vote
        $vote = $representation->votes()->firstOrCreate([
            'representation_id' => $representation->id,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Caching
        if ($vote->wasRecentlyCreated) {
            $representation->down_votes_count++;
            $representation->save();
        }

        return redirect()->route('home');
    }
}
