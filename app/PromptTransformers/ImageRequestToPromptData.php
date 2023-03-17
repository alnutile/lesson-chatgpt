<?php

namespace App\PromptTransformers;

use Spatie\LaravelData\Data;

class ImageRequestToPromptData extends Data
{
    public function __construct(
        public string $prompt,
        public array $genres,
        public array $styles
    ) {}

    public function generatePrompt() : string {

        $genres = implode(" and ", $this->genres);

        if($genres) {
            $this->prompt = sprintf("%s in the genres of %s",
            $this->prompt, $genres);
        }

        $styles = implode(" and ", $this->styles);
        if($styles) {
            $this->prompt = sprintf("%s in the styles of %s",
                $this->prompt, $styles);
        }


        return $this->prompt;

    }
}
