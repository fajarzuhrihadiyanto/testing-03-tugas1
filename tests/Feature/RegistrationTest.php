<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegistrationTest extends TestCase
{

    /**
     * @test
     */
    public function route_test()
    {
        $this->get('/api/register_user')
            ->assertStatus(405);
    }

    /**
     * @test
     */
    public function register_email_format_error_test()
    {
        $this->post('/api/register_user', [
            "email" => "fajarzuhrihadiyanto",
            "password" => "fajarzuhrihadiyanto",
            "name" => "Fajar Zuhri Hadiyanto"
        ])
            ->assertStatus(400)
            ->assertJson([
                "success" => false,
                "message" => "invalid email format"
            ]);
    }

    /**
     * @test
     */
    public function normal_registration_test()
    {
        $this->post('/api/register_user', [
            "email" => "test1@mail.com",
            "password" => "testPassword",
            "name" => "John Doe"
        ])
            ->assertCreated()
            ->assertJson([
                'success' => true
            ])
            ->assertJsonStructure([
                'data' => ['user_id']
            ]);
    }

    /**
     * @test
     */
    public function user_exist_test()
    {
        $this->post('/api/register_user', [
            "email" => "testx@mail.com",
            "password" => "testPassword",
            "name" => "John Doe"
        ])
            ->assertJson([
                "success" => false,
                "message" => "User already exists"
            ]);
    }

    /**
     * @test
     */
    public function register_no_data()
    {
        $this->post('/api/register_user', [])
            ->assertStatus(400)
            ->assertJson([
                "success" => false,
            ]);

    }
}
