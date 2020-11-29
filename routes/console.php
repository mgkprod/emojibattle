<?php

use App\Models\Emoji;
use App\Models\Vendor;
use App\Facades\Emojipedia;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('import', function () {
    $categories = [
        'people' => '😃 Smileys & People',
        'nature' => '🐻 Animals & Nature',
        'food-drink' => '🍔 Food & Drink',
        'activity' => '⚽ Activity',
        'travel-places' => '🌇 Travel & Places',
        'objects' => '💡 Objects',
        'symbols' => '🔣 Symbols',
        // 'flags' => '🎌 Flags',
    ];

    foreach ($categories as $category_slug => $category) {
        $this->info('Fetching category ' . $category);
        $emojis = Emojipedia::category($category_slug);

        foreach ($emojis as $o_emoji) {
            $this->info('Fetching emoji ' . $o_emoji['full_name']);

            $emojipedia = Emojipedia::show($o_emoji['slug']);

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
        }
    }
});
