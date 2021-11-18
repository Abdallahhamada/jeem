<?php

// namespace Tests\Feature;

// use App\User;
// use Tests\TestCase;
// use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

// class AuthTest extends TestCase
// {
    /**
     ** Test Registration.
    */
    // public function testRegister()
    // {
    //     //User's data
    //     $data = [
    //         'email' => 'test@gmail.com',
    //         'name' => 'Test',
    //         'password' => 'secret1234',
    //         'password_confirmation' => 'secret1234',
    //     ];

        //Send post request
//         $response = $this->json('POST', route('api.register'), $data);
//         //Assert it was successful
//         $response->assertStatus(201);
//         //Assert we received a token
//         $this->assertArrayHasKey('token', $response->json());
//         //Delete data
//         User::where('email', 'test@gmail.com')->delete();
//     }
// }