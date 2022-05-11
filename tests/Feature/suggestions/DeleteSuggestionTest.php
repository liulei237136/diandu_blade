<?php

namespace Tests\Feature\suggestions;

use App\Models\Suggestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteSuggestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthorized_user_cannot_delete_suggestion()
    {
        $this->signIn()->withExceptionHandling();

        create(Suggestion::class);

        $this->delete(route('suggestions.destroy', 1))
            ->assertStatus(403);
       $this->assertDatabaseCount('suggestions', 1);

    }

    public function test_authorized_user_can_delete_suggestion()
    {
        $this->signIn()->withExceptionHandling();

        $suggestion = create(Suggestion::class, ['user_id' => auth()->id()]);

        $this->delete(route('suggestions.destroy', $suggestion))
            ->assertStatus(302);
        $this->assertDatabaseCount('suggestions', 0);
    }
}
