<?php

namespace Tests\Feature;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateRepositoriesTest extends TestCase
{
    public function test_guest_may_not_create_repository()
    {
        $this->withExceptionHandling();

        $this->post(route('repositories.store'), [])
        ->assertRedirect('/login');
    }

    public function test_an_authenticated_user_can_create_new_repository()
    {
        $this->signIn();

        $repository = make(Repository::class);

        $this->assertCount(0, Repository::all());

        $this->post(route('repositories.store'), $repository->toArray());

        $this->assertCount(1, Repository::all());
    }

    public function test_name_is_required()
    {
        $this->signIn()->withExceptionHandling();

        $response = $this->post(route('repositories.store'), ['name' => null]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('name');
    }

    public function test_name_length_must_greater_or_equal_than_three_letters()
    {
        $this->signIn()->withExceptionHandling();

        $response = $this->post(route('repositories.store'), ['name' => 'xx']);

        $response->assertRedirect();
        $response->assertSessionHasErrors('name');
    }

    public function test_description_is_required()
    {
        $this->signIn()->withExceptionHandling();

        $response = $this->post(route('repositories.store'), ['description' => null]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('description');
    }

    public function test_description_length_must_greater_or_equal_than_three_letters()
    {
        $this->signIn()->withExceptionHandling();

        $response = $this->post(route('repositories.store'), ['description' => 'xx']);

        $response->assertRedirect();
        $response->assertSessionHasErrors('description');
    }

    public function test_authenticated_users_must_confirm_email_address_before_creating_repositories()
    {
        $this->signIn(create(User::class, ['email_verified_at' => null]));

        $repository = make(Repository::class);

        $this->post(route('repositories.store'), $repository->toArray())
            ->assertRedirect(route('verification.notice'));
    }

    public function test_get_slug_when_create_a_repository()
    {
        $this->signIn();

        $repository = make(Repository::class, ['name' => '英语 英语']);

        $this->post(route('repositories.store'), $repository->toArray());

        $storedRepository = Repository::first();

        $this->assertEquals('english-english', $storedRepository->slug);
    }

    public function test_get_slug_when_update_a_repository_name()
    {
        $this->signIn();

        $repository = create(Repository::class, ['name' => '英语 英语']);

        $this->put(route('repositories.update', $repository), ['name' => '中文 中文']);

        $storedRepository = Repository::first();

        $this->assertEquals('chinese-chinese', $storedRepository->slug);
    }
}
