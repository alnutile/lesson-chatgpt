<?php

namespace Tests\Feature;

use App\PromptTransformers\ImageRequestToPromptData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImageRequestToPromptDataTest extends TestCase
{
    public function test_dto() {

        $data = [
            'prompt' => "portrait of bob belcher",
            'genres' => [
                'fantasy',
                'Science Fiction'
            ],
            "styles" => [
                'vintage'
            ]
        ];

        $results = ImageRequestToPromptData::from($data);

        $this->assertNotEmpty($results->prompt);
        $this->assertNotEmpty($results->genres);
    }

    public function test_prompt_generator() {

        $data = [
            'prompt' => "portrait of bob belcher",
            'genres' => [
                'fantasy',
                'Science Fiction'
            ],
            "styles" => [
                'vintage'
            ]
        ];

        $results = ImageRequestToPromptData::from($data);

        $this->assertEquals(
            "portrait of bob belcher in the genres of fantasy and Science Fiction in the styles of vintage",
            $results->generatePrompt());
    }

    public function test_prompt_generator_no_genre() {

        $data = [
            'prompt' => "portrait of bob belcher",
            'genres' => [],
            "styles" => [
                'vintage'
            ]
        ];

        $results = ImageRequestToPromptData::from($data);

        $this->assertEquals(
            "portrait of bob belcher in the styles of vintage",
            $results->generatePrompt());
    }

    public function test_prompt_generator_no_genre_or_style() {

        $data = [
            'prompt' => "portrait of bob belcher",
            'genres' => [],
            "styles" => []
        ];

        $results = ImageRequestToPromptData::from($data);

        $this->assertEquals(
            "portrait of bob belcher",
            $results->generatePrompt());
    }
}
