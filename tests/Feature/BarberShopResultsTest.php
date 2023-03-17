<?php

namespace Tests\Feature;

use Facades\App\Transformers\BarberShopResults;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class BarberShopResultsTest extends TestCase
{

    public function test_results() {
        $results = File::get(base_path("tests/fixtures/barber_shop_results.txt"));

        $transformed = BarberShopResults::handle($results);

        $this->assertCount(2, $transformed);
        $this->assertEquals('1. 10:00 AM - 10:30 AM with Bob', $transformed[0]);
    }
}
