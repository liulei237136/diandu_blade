<?php

namespace Tests\Feature;

use App\Models\Suggestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class UpdateSuggestionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_update_suggestion()
    {
        $this->withExceptionHandling();

        $suggestion = create(Suggestion::class);

        $this->put(route('suggestions.update', $suggestion))
            ->assertRedirect('/login');
    }

    public function test_unauthorized_user_cannot_update_repository()
    {
        $this->signIn()->withExceptionHandling();

        $suggestion = create(Suggestion::class);

        $this->put(route('suggestions.update', $suggestion))
            ->assertStatus(403);
    }

    public function test_authorized_user_can_update_suggestions()
    {
        $this->signIn()->withExceptionHandling();

        $suggestion = create(Suggestion::class, ['user_id' => auth()->id()]);

        $title = Str::random(3);
        $content = Str::random(20);
        $this->put(route('suggestions.update', $suggestion), ['title' => $title])
            ->assertStatus(302);

        $this->assertDatabaseHas('suggestions', ['title' => $title]);
    }

    public function test_title_is_required()
    {
        $this->signIn()->withExceptionHandling();

        $suggestion = create(Suggestion::class, ['user_id' => auth()->id()]);

        $this->put(route('suggestions.update', $suggestion), ['title' => null, 'content' => Str::random(20)])
        ->assertStatus(302)
        ->assertSessionHasErrors('title')
        ->assertSessionDoesntHaveErrors('content');
    }

    public function test_content_is_required()
    {
        $this->signIn()->withExceptionHandling();

        $suggestion = create(Suggestion::class, ['user_id' => auth()->id()]);

        $this->put(route('suggestions.update', $suggestion), ['title' => Str::random(20), 'content' => null])
        ->assertStatus(302)
        ->assertSessionHasErrors('content')
        ->assertSessionDoesntHaveErrors('title');
    }

    public function test_title_length_between_3_and_60()
    {
        $this->signIn()->withExceptionHandling();

        $suggestion = create(Suggestion::class, ['user_id' => auth()->id()]);

        $this->put(route('suggestions.update', $suggestion), ['title' => Str::random(2) ])
            ->assertStatus(302)
            ->assertSessionHasErrors('title');
        $this->put(route('suggestions.update', $suggestion), ['title' => Str::random(3)])
            ->assertStatus(302)
            ->assertSessionDoesntHaveErrors('title');
        $this->put(route('suggestions.update', $suggestion), ['title' => Str::random(60)])
            ->assertStatus(302)
            ->assertSessionDoesntHaveErrors('title');
        $this->put(route('suggestions.update', $suggestion), ['title' => Str::random(61)])
            ->assertStatus(302)
            ->assertSessionHasErrors('title');
    }

    //<p>xxx<br></p>
    public function test_content_length_between_14_and_30k()
    {
        $this->signIn()->withExceptionHandling();

        $suggestion = create(Suggestion::class, ['user_id' => auth()->id()]);

        $this->put(route('suggestions.update', $suggestion), ['content' => Str::random(2)])
            ->assertStatus(302)
            ->assertSessionHasErrors('content');
        $this->put(route('suggestions.update', $suggestion), ['content' => Str::random(14)])
            ->assertStatus(302)
            ->assertSessionDoesntHaveErrors('content');
        $this->put(route('suggestions.update', $suggestion), ['content' => Str::random(30 * 1024 + 1)])
            ->assertStatus(302)
            ->assertSessionHasErrors('content');
    }

}
