<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Emojipedia
{
    const BASE_URI = 'https://emojipedia.org';

    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function random()
    {
        $response = $this->client->get(self::BASE_URI . '/random');
        return $this->parse((string) $response->getBody());
    }

    public function show($slug)
    {
        $response = $this->client->get(self::BASE_URI . '/' . $slug);
        return $this->parse((string) $response->getBody());
    }

    protected function parse($📜)
    {
        $🔧 = new Crawler($📜);
        $📙 = [];

        // Main
        $📙['slug'] = trim($🔧->filter('meta[property="og:url"]')->attr('content'), '/');

        $full_name = $🔧->filter('article > h1')->text();
        $native_emoji = $🔧->filter('article > h1 > span.emoji')->text();

        $📙['name'] = trim(str_replace($native_emoji, '', $full_name));
        $📙['emoji'] = $native_emoji;

        // Description
        $description = $🔧->filter('section.description > p')->each(function (Crawler $node) {
            return $node->text();
        });

        $📙['description'] = implode("\r\n", $description);

        // Representations (vendor-list)
        $📚 = [];

        $📚 = $🔧->filter('section.vendor-list > ul > li')->each(function (Crawler $node) {
            return [
                'vendor' => [
                    'slug' => trim($node->filter('.vendor-info > h2 > a')->attr('href'), '/'),
                    'name' => $node->filter('.vendor-info')->text()
                ],
                'image' => [
                    'src' => $node->filter('.vendor-image > img')->attr('src'),
                    'alt' => $node->filter('.vendor-image > img')->attr('alt'),
                ],
            ];
        });

        $😀 = array_merge($📙, [
            'representations' => $📚,
        ]);

        return $😀;
    }
}
