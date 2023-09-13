<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
        $eventData = [
            'name' => 'New Task',
            'start_time' => '2023-07-01 15:00:00',
            'end_time' => '2023-07-01 16:00:00'
        ];

        $response = $this->withHeaders([
            'Accept' => "application/json",
        ])->post('api/events', $eventData);


        $response->assertStatus(Response::HTTP_FOUND); // 302 Found
        unset($taskData['id']);

        //  $this->assertDatabaseHas('tasks', $taskData);


        $this->withoutMiddleware();
        $this->post(route('tasks.store'), $taskData);
    }
}
