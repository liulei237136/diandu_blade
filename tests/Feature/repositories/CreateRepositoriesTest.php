<?php

namespace Tests\Feature;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class CreateRepositoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_may_not_create_repository()
    {
        $this->withExceptionHandling();

        $this->post(route('suggestions.store'), [])
            ->assertRedirect('/login');
    }

    public function test_an_authenticated_user_can_create_new_repository()
    {
        $this->signIn();

        $repository = make(Repository::class);

        $this->assertCount(0, Repository::all());

        $this->post(route('suggestions.store'), $repository->toArray());

        $this->assertCount(1, Repository::all());
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

    public function test_description_is_required()
    {
        $this->signIn()->withExceptionHandling();

        $response = $this->post(route('suggestions.store'), ['description' => null]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('description');
    }

    //<p>xxx<br></p>
    public function test_description_length_between_14_and_30k()
    {
        $this->signIn()->withExceptionHandling();

        $this->post(route('suggestions.store'), ['title'=> 'test','description' => Str::random(13)])
            ->assertSessionHasErrors('description');
        $this->post(route('suggestions.store'), ['title' => 'test', 'description' => Str::random(14)])
            ->assertSessionDoesntHaveErrors('description');
        $this->post(route('suggestions.store'), ['title'=> 'test','description' => Str::random(30*1024 + 1)])
            ->assertSessionHasErrors('description');

    }

    public function test_authenticated_users_must_confirm_email_address_before_creating_suggestions()
    {
        $this->signIn(create(User::class, ['email_verified_at' => null]));

        $repository = make(Repository::class);

        $this->post(route('suggestions.store'), $repository->toArray())
            ->assertRedirect(route('verification.notice'));
    }

    public function test_get_slug_when_create_a_repository()
    {
        $this->signIn();

        $repository = make(Repository::class, ['title' => '英语 英语']);

        $this->post(route('suggestions.store'), $repository->toArray());

        $storedRepository = Repository::first();

        $this->assertEquals('english-english', $storedRepository->slug);
    }
}
