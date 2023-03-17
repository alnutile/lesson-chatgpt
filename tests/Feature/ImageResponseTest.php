<?php

namespace Tests\Feature;

use App\Transformers\ImageResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImageResponseTest extends TestCase
{

    public function test_dto() {
        $data = get_fixture("image_response.json");

        $response = ImageResponse::from($data);

        $this->assertEquals("https://oaidalleapiprodscus.blob.core.windows.net/private/org-ClL1biAi0m1pC2J2IV5C22TQ/user-i08oJb4T3Lhnsh2yJsoErWJ4/img-ZY37ZIt7HXXGO2d6eJCel1Ap.png?st=2023-03-09T11%3A07%3A58Z&se=2023-03-09T13%3A07%3A58Z&sp=r&sv=2021-08-06&sr=b&rscd=inline&rsct=image/png&skoid=6aaadede-4fb3-4698-a8f6-684d7786b067&sktid=a48cca56-e6da-484e-a814-9c849652bcb3&skt=2023-03-08T23%3A18%3A10Z&ske=2023-03-09T23%3A18%3A10Z&sks=b&skv=2021-08-06&sig=dAqXKZkEYFckXkpDbb9/kxrgN0aDOmXelJ643BLJbZA%3D", $response->returnFirstImage());

        $this->assertCount(1, $response->returnAllImageUrls());
    }
}
