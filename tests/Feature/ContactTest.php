<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{
    public function testRoot()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testUpdateEmptyInvalid() 
    {
        $response = $this->postJson(
            '/api/v1/contact/save/update-empty', 
            ['newContact' => []]
        );

        $response->assertStatus(422);
    }

    public function testUpdateEmptyValid() 
    {
        $response = $this->postJson(
            '/api/v1/contact/save/update-empty', 
            ['newContact' => [['phone' => '111', 'team_id' => 1, ]]]
        );

        $response->assertStatus(200);
    }

    public function testUpdateValueInvalid() 
    {
        $response = $this->postJson(
            '/api/v1/contact/save/update-value', 
            ['newContact' => []]
        );

        $response->assertStatus(422);
    }

    public function testUpdateValueValid() 
    {
        $response = $this->postJson(
            '/api/v1/contact/save/update-value', 
            ['newContact' => [['phone' => '111', 'team_id' => 1, ]]]
        );

        $response->assertStatus(200);
    }

        public function testDontUpdateInvalid() 
    {
        $response = $this->postJson(
            '/api/v1/contact/save/dont-update', 
            ['newContact' => []]
        );

        $response->assertStatus(422);
    }

    public function testDontUpdateValid() 
    {
        $response = $this->postJson(
            '/api/v1/contact/save/dont-update', 
            ['newContact' => [['phone' => '111', 'team_id' => 1, ]]]
        );

        $response->assertStatus(200);
    }
}
