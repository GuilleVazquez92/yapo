<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

trait ItunesApiRequestTrait
{
    public function RequestItunesApi($bandName)
    {
        $response = Http::get('https://itunes.apple.com/search?attribute=allArtistTerm&limit=25&term='.$bandName);
        return $response->json();
    }
}
