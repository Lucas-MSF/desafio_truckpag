<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductsTest extends TestCase
{
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_CaseAProductIsCreatedSuccessfully()
    {
        $response = $this->json('POST', '/api/products/', [
            'code' => '01',
            'creator' => 'tester'
        ]);

        $response->assertStatus(201);

        return ['product_code' => json_decode($response->content())->code];
    }
     /**
     * @depends test_CaseAProductIsCreatedSuccessfully
     */
    public function test_CaseProductIsDisplayedSuccessfully($params)
    {

        $response = $this->json('GET', '/api/products/'.$params['product_code']);

        $response->assertStatus(200);
        return ['product' => json_decode($response->content())];
    }


    /**
     * @depends test_CaseAProductIsCreatedSuccessfully
     */
    public function test_CaseAProductIsUpdatedSuccessfully($params)
    {

        $response = $this->json('PUT', '/api/products/' . $params['product_code'], [
            'creator' => 'tester'
        ]);

        $response->assertStatus(200);
    }


   
 
   
}