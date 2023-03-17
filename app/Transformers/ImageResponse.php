<?php

namespace App\Transformers;

class ImageResponse extends \Spatie\LaravelData\Data
{

    public function __construct(
        public string $created,
        public array $data,
    )
    {}

    public function returnFirstImage() : string {
        return data_get($this->data, "0.url");
    }

    public function returnAllImageUrls() : array {
        return collect($this->data)->pluck("url")->toArray();
    }

}
