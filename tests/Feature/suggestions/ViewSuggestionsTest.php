<?php

namespace Tests\Feature\suggestions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewSuggestionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_suggestions()
    {
        $response = $this->get(route('repositories.index', ['order' => 'recent']));

        $response->assertStatus(200);
    }

    public function test_user_can_view_audio_tab_page_when_repository_created()
    {

        $repository = create(Repository::class);

        $response = $this->get(route('repository_audio.show', $repository));

        $response->assertStatus(200);
    }

}
