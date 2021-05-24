<?php


namespace AsayDev\LaraTickets\Tests\Unit;

use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelsTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
     function can_agent_model_work(){

        $post = factory(Agent::class)->create(['title' => 'Fake Title']);
        $this->assertEquals('Fake Title', $post->title);

    }

}