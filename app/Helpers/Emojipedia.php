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

    protected function parse($body)
    {
        $crawler = new Crawler($body);

        $emoji = [];
        $representations = [];

        // Main
        $emoji['slug'] = trim($crawler->filter('meta[property="og:url"]')->attr('content'), '/');

        $full_name = $crawler->filter('article > h1')->text();
        $native_emoji = $crawler->filter('article > h1 > span.emoji')->text();

        $emoji['name'] = trim(str_replace($native_emoji, '', $full_name));
        $emoji['emoji'] = $native_emoji;

        // Description
        $description = $crawler->filter('section.description > p')->each(function (Crawler $node) {
            return $node->text();
        });

        $emoji['description'] = implode("\r\n", $description);

        // Representations (vendor-list)
        $representations = $crawler->filter('section.vendor-list > ul > li')->each(function (Crawler $node) {
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

        return array_merge($emoji, [
            'representations' => $representations,
        ]);
    }
}
