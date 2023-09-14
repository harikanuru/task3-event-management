<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\Response;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('api/events');
       // dd($response);
        $response->assertStatus(200);
    }

    public function test_get_events(): void
    {
        $response = $this->get('api/events?include=user,attendees');
        $response->assertStatus(200);
    }

    public function test_create_a_task()
    {

        $userLogin = [
            'email' => 'mayert.ruben@example.org',
            'password' => 'password23'
        ];

        $token = $this->withHeaders([
            'Accept' => "application/json",
        ])->post('api/login', $userLogin);
       // dd($token);


        $eventData = [
            'name' => 'New Task',
            'start_time' => '2023-07-01 15:00:00',
            'end_time' => '2023-07-01 16:00:00'
        ];

        $response = $this->withHeaders([
            'HTTP_AUTHORIZATION' => 'Bearer '.$token['token'],
        ])->post('api/events', $eventData);


        $response->assertStatus(201); 

    }

    public function test_create_a_taskWithoutToken()
    {

        $userLogin = [
            'email' => 'mayert.ruben@example.org',
            'password' => 'password23'
        ];
        $eventData = [
            'name' => 'New Task',
            'start_time' => '2023-07-01 15:00:00',
            'end_time' => '2023-07-01 16:00:00'
        ];

        $response = $this->withHeaders([
            'HTTP_AUTHORIZATION' => 'Bearer ',
            'Accept' => "application/json"
        ])->post('api/events', $eventData);
        $response->assertStatus(401); 

    }

    public function test_create_a_task_update()
    {

        $userLogin = [
            'email' => 'kveum@example.org',
            'password' => 'password23'
        ];

        $token = $this->withHeaders([
            'Accept' => "application/json",
        ])->post('api/login', $userLogin);
        print_r($token['token']);


        $eventData = [
            'name' => 'New Task',
            'start_time' => '2023-07-01 15:00:00',
            'end_time' => '2023-07-01 16:00:00'
        ];

        $response = $this->withHeaders([
            'HTTP_AUTHORIZATION' => 'Bearer '.$token['token'],
        ])->get('api/events/2', $eventData);


        $response->assertStatus(201); 

    }
}
