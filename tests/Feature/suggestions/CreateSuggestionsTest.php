<?php

namespace Tests\Feature;

use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class CreateSuggestionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_create_suggestion()
    {
        $this->withExceptionHandling();

        $this->post(route('suggestions.store'), [])
            ->assertRedirect('/login');
    }

    public function test_an_authenticated_user_can_create_new_suggestion()
    {
        $this->signIn();

        $suggestion = make(suggestion::class);

        $this->assertCount(0, suggestion::all());

        $this->post(route('suggestions.store'), $suggestion->toArray());

        $this->assertCount(1, suggestion::all());
    }

    public function test_title_is_required()
    {
        $this->signIn()->withExceptionHandling();

        $response = $this->post(route('suggestions.store'), ['title' => null]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('title');
    }

    public function test_title_length_between_3_and_60()
    {
        $this->signIn()->withExceptionHandling();

        $this->post(route('suggestions.store'), ['title'=> Str::random(2),'description' => Str::random(20)])
            ->assertSessionHasErrors('title');
        $this->post(route('suggestions.store'), ['title'=> Str::random(3),'title' => Str::random(20)])
            ->assertSessionDoesntHaveErrors('title');
        $this->post(route('suggestions.store'), ['title'=> Str::random(61),'description' => Str::random(20)])
            ->assertSessionHasErrors('title');
    }

    public function test_content_is_required()
    {
        $this->signIn()->withExceptionHandling();

        $response = $this->post(route('suggestions.store'), ['content' => null]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('content');
    }

    //<p>xxx<br></p>
    public function test_content_length_between_14_and_30k()
    {
        $this->signIn()->withExceptionHandling();

        $this->post(route('suggestions.store'), ['name'=> 'test','content' => Str::random(13)])
            ->assertSessionHasErrors('content');
        $this->post(route('suggestions.store'), ['name' => 'test', 'content' => Str::random(14)])
            ->assertSessionDoesntHaveErrors('content');
        $this->post(route('suggestions.store'), ['name'=> 'test','content' => Str::random(30*1024 + 1)])
            ->assertSessionHasErrors('content');

    }

    public function test_authenticated_users_must_confirm_email_address_before_creating_suggestions()
    {
        $this->signIn(create(User::class, ['email_verified_at' => null]));

        $suggestion = make(suggestion::class);

        $this->post(route('suggestions.store'), $suggestion->toArray())
            ->assertRedirect(route('verification.notice'));
    }
}
