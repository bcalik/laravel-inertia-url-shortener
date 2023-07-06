<?php

namespace Tests\Unit;

use App\Models\Link;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class LinkTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_link_visit(): void
    {
        $link = Link::factory()->create();

        $link->visit();
        $this->assertDatabaseHas('visits', ['link_id' => $link->id]);
        $this->assertDatabaseCount('visits', 1);
        $this->assertDatabaseHas('links', ['id' => $link->id, 'visits' => 1]);

        $link->visit();
        $this->assertDatabaseCount('visits', 2);
        $this->assertDatabaseHas('links', ['id' => $link->id, 'visits' => 2]);
    }

    public function test_link_url(): void
    {
        $link = new Link;
        $link->slug = 'test';
        $link->domain = 'https://get.alternatif.app';
        $link->save();

        $this->assertDatabaseHas('links', ['domain' => 'https://get.alternatif.app', 'slug' => 'test']);

        $this->assertEquals('https://get.alternatif.app', $link->domain);
        $this->assertEquals('test', $link->slug);
        $this->assertEquals('https://get.alternatif.app/test', $link->url);
    }
}
