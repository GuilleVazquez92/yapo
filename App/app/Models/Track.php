<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    public $trackId;
    public $collectionId;
    public $trackName;
    public $previewUrl;
    public $releaseDate;
    public $price;


    public function __construct($trackId, $collectionId,$trackName,$previewUrl,$releaseDate,$price)
    {
        $this->trackId = $trackId;
        $this->collectionId = $collectionId;
        $this->trackName = $trackName;
        $this->previewUrl = $previewUrl;
        $this->releaseDate = $releaseDate;
        $this->price = $price;
    }
}
