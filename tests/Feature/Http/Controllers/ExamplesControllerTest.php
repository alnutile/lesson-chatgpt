<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use OpenAI\Laravel\Facades\OpenAI;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class ExamplesControllerTest extends TestCase
{
    use RefreshDatabase;



    public function test_barber_shop_ui() {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->get(route('examples.barber'))
            ->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
        ->component("BarberShop/Index")
        ->has("days")
        ->has("start_time")
        ->has("end_time")
        );
    }

}
