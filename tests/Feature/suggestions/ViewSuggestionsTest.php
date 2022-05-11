<?php

namespace Tests\Feature\suggestions;

use App\Models\Suggestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewSuggestionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_suggestions_list()
    {
        $suggestion = create(Suggestion::class);

        $this->get(route('suggestions.index'))
            ->assertStatus(200)
            ->assertSee($suggestion->title)
            ->assertSee($suggestion->user->name);
    }

    public function test_guest_can_view_a_suggestion()
    {
        $suggestion = create(Suggestion::class);

        $this->get(route('suggestions.show', 1))
            ->assertStatus(200)
            ->assertSee($suggestion->title)
            ->assertSee($suggestion->user->name);
    }
}
