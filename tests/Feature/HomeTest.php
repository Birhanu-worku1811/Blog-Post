<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_home_page_is_wiorking(): void
    {
        $response = $this->get('/');

        $response->assertSeeText('Home page');
        $response->assertStatus(200);
    }

    public function test_contact_page_is_wiorking()
    {
        $response = $this->get('/contact');
        $response->assertSeeText('Contact page');
        $response->assertStatus(200);
    }
}
