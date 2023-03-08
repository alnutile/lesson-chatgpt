<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExamplesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_gets_data() {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('examples.ask'), [
            'question' => "PHP Is"
        ])
            ->assertStatus(200);
    }


}
