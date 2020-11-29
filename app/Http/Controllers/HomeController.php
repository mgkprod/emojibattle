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
        $emoji = $this->import(Emojipedia::random());

        return redirect()->route('show', $emoji->slug);
    }

    public function show($slug)
    {
        // Refresh it
        $emoji = Emoji::query()
            ->where('slug', $slug)
            ->with('representations')
            ->with('representations.vendor')
            ->first();

        if (!$emoji) {
            $emoji = $this->import(Emojipedia::show($slug));
            return redirect()->route('show', $emoji->slug);
        }

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

    protected function import($emojipedia)
    {
        $emoji = Emoji::firstOrCreate([
            'name' => $emojipedia['name'],
            'slug' => $emojipedia['slug'],
            'emoji' => $emojipedia['emoji'],
        ]);

        $representations = [];

        foreach ($emojipedia['representations'] as $o_representation) {
            $vendor = Vendor::firstOrCreate([
                'name' => $o_representation['vendor']['name'],
                'slug' => $o_representation['vendor']['slug'],
            ]);

            $representations[] = $emoji->representations()->firstOrCreate([
                'vendor_id' => $vendor->id,
                'src' => $o_representation['image']['src'],
                'alt' => $o_representation['image']['alt'],
            ]);
        }

        return $emoji;
    }
}
