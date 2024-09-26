<?php

namespace Tests\Feature;

use Tests\TestCase;

class WaterJugControllerTest extends TestCase
{
    public function test_water_jug_solver_valid_solution()
    {
        $response = $this->postJson('/api/water-jug-solution', [
            'x_capacity' => 3,
            'y_capacity' => 5,
            'z_amount_wanted' => 4
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'solution' => [
                    '*' => [
                        'bucketX',
                        'bucketY',
                        'action'
                    ]
                ]
            ]);
    }

    public function test_water_jug_solver_no_solution()
    {
        $response = $this->postJson('/api/water-jug-solution', [
            'x_capacity' => 2,
            'y_capacity' => 6,
            'z_amount_wanted' => 5
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'error' => 'No solution possible'
            ]);
    }

    public function test_water_jug_solver_invalid_input()
    {
        $response = $this->postJson('/api/water-jug-solution', [
            'x_capacity' => 3,
            'z_amount_wanted' => 4
        ]);

        $response->assertStatus(422);
    }

    public function test_water_jug_solver_negative_values()
    {
        $response = $this->postJson('/api/water-jug-solution', [
            'x_capacity' => -3,
            'y_capacity' => 5,
            'z_amount_wanted' => 4
        ]);

        $response->assertStatus(422);
    }

    public function test_water_jug_solver_target_zero()
    {
        $response = $this->postJson('/api/water-jug-solution', [
            'x_capacity' => 3,
            'y_capacity' => 5,
            'z_amount_wanted' => 0
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'solution' => [
                    ['bucketX' => 0, 'bucketY' => 0, 'action' => 'No action needed']
                ]
            ]);
    }
}
