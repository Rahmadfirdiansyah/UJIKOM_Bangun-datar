<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_render_the_calculate_form()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Kalkulator Bangun Datar');
    }

    /** @test */
    public function it_can_store_calculation_data_without_error()
    {
        $postData = [
            'name' => 'Budi Santoso',
            'school' => 'SMK Negeri 1',
            'age' => 17,
            'address' => 'Jl. Mawar No. 10',
            'phone' => '08123456789',
            'flatShape' => 'square',
            'flatDimensions' => [
                'side' => 5
            ],
            'solidShape' => 'cube',
            'solidDimensions' => [
                'side' => 4
            ]
        ];

        $response = $this->post('/store', $postData);
        $response->assertRedirect('/data');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('calculations', [
            'name' => 'Budi Santoso',
            'school' => 'SMK Negeri 1',
        ]);
    }
}
