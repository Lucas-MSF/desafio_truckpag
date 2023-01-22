<?php

namespace Tests\Feature;

use App\Http\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReturnStatusTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_case_put_route_return_success()
    {
        $response = $this->getJson('/api/products/0000000000017');
        $productRepository = new ProductRepository();
        $expectedReturn = [
            
            
        ];

        $response->assertSame($expectedReturn, $response->original);

        $response->assertStatus(200);
    }
}
