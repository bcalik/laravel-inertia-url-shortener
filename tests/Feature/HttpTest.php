<?php

namespace Tests\Feature;

use App\Models\Link;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class HttpTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_health_response(): void
    {
        $response = $this->get('/health');
        $response->assertStatus(200);
    }

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(302);

        $response = $this->get('/default');
        $response->assertStatus(404);
    }

    public function test_default_redirect(): void
    {
        $link = Link::factory()->create(['slug' => 'default']);

        $response = $this->get('/');
        $response->assertStatus(302);

        $this->followRedirects($response)
            ->assertStatus(200)
            ->assertSeeText('...');
    }

    public function test_the_link_page(): void
    {
        $link = Link::factory()->create();

        $response = $this->get('/'.$link->slug);
        $response->assertStatus(200);
        $response->assertSeeText('...');
    }
}
