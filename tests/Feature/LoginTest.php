<?php
namespace Tests\Feature;

use Tests\TestCase;

//use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase {

    /**
     * @test
     */
    public function test() {
        $this->get('/api/login_user')
            ->assertStatus(405);
    }

    /**
     * @test
     */
    public function normal_login_test() {

        $this->post('/api/login_user',
            [
                'email' => 'testx@mail.com',
                'password' => 'testPassword'
            ])
            ->assertStatus(200)
            ->assertJsonStructure(['data' => ['token']]);
    }

    /**
     * @test
     */
    public function login_email_format_error() {
        $this->post('/api/login_user',
            [
                'email' => 'fajarzuhrihadiyanto',
                'password' => 'fajarzuhrihadiyanto'
            ])
            ->assertStatus(400)
            ->assertJson([
                'success' => false
            ]);
    }

    /**
     * @test
     */
    public function login_no_data() {
        $this->post('/api/login_user', [])
            ->assertStatus(400)
            ->assertJson([
                'success' => false
            ]);
    }
}
