<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurrencyTest extends TestCase
{

    /**
     * @test
     * @group can_see_currency_page
     */
    public function can_see_currency_page()
    {
        // Arrange
        $this->withoutExceptionHandling();

        // Act
        $response = $this->get(route('home'));

        // Assert
        $response->assertOk();
    }

    /**
     * @test
     * @group returns_ajax_data
     */
    public function returns_ajax_data()
    {
        // Arrange
        $this->withoutExceptionHandling();

        // Act
        $response = $this->post(route('converter'), [
            'currency_select_a' => 'GBP',
            'currency_value_a'  => 1,
            'currency_select_b' => 'AFN',
            'currency_value_b'  => 1,
        ], array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

        // Assert
        $response->assertStatus(200);
        $response->assertJson(['master_value' => 1,'secondary_value' => 96.98]);
        // dd($response->content());
    }
}
