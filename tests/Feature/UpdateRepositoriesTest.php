<?php

namespace Tests\Feature;

use App\Models\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class UpdateRepositoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_update_name_of_repository()
    {
        $this->withExceptionHandling();

        $repository = create(Repository::class);

        $this->put(route('repositories.update_name', $repository))
            ->assertRedirect('/login');
    }

    public function test_guest_cannot_update_description_of_repository()
    {
        $this->withExceptionHandling();

        $repository = create(Repository::class);

        $this->put(route('repositories.update_description', $repository))
            ->assertRedirect('/login');
    }

    public function test_unauthorized_user_cannot_update_name_of_repository()
    {
        $this->signIn()->withExceptionHandling();

        $repository = create(Repository::class);

        $this->put(route('repositories.update_name', $repository))
            ->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_update_description_of_repository()
    {
        $this->signIn()->withExceptionHandling();

        $repository = create(Repository::class);

        $this->put(route('repositories.update_description', $repository))
            ->assertStatus(403);
    }


    public function test_authorized_user_can_update_name_of_repository()
    {
        $this->signIn();

        $repository = create(Repository::class, ['user_id' => auth()->id()]);

        $this->put(route('repositories.update_name', $repository), ['name' => 'test'])
            ->assertStatus(302);

        $this->assertDatabaseHas('repositories', ['name' => 'test']);
    }

    public function test_authorized_user_can_update_description_of_repository()
    {
        $this->signIn();

        $repository = create(Repository::class, ['user_id' => auth()->id()]);

        $description = Str::random(14);
        $this->put(route('repositories.update_description', $repository), ['description' => $description])
            ->assertStatus(302);

        $this->assertDatabaseHas('repositories', ['description' => '<p>' . $description. '</p>']);
    }

    public function test_name_length_between_3_and_60()
    {
        $this->signIn()->withExceptionHandling();

        $repository = create(Repository::class, ['user_id' => auth()->id()]);

        $this->put(route('repositories.update_name', $repository), ['name' => Str::random(2)])
            ->assertSessionHasErrors('name');
        $this->put(route('repositories.update_name', $repository), ['name' => Str::random(3)])
            ->assertSessionDoesntHaveErrors('name');
        $this->put(route('repositories.update_name', $repository), ['name' => Str::random(60)])
            ->assertSessionDoesntHaveErrors('name');
        $this->put(route('repositories.update_name', $repository), ['name' => Str::random(61)])
            ->assertSessionHasErrors('name');
    }


    // public function test_description_must_lengther_than_3()
    // {
    //     $this->signIn()->withExceptionHandling();

    //     $repository = create(Repository::class, ['user_id' => auth()->id()]);

    //     $this->put(route('repositories.update_description', $repository), ['description' => 'xx'])
    //         ->assertInvalid('description');

    //     $this->put(route('repositories.update_name', $repository), ['name' => 'xxx'])
    //         ->assertValid('description');
    // }

    //<p>xxx<br></p>
    public function test_description_length_between_14_and_30k()
    {
        $this->signIn()->withExceptionHandling();

        $repository = create(Repository::class, ['user_id' => auth()->id()]);

        $this->put(route('repositories.update_description', $repository), ['description' => Str::random(3)])
            // ->assertValid('description');
            ->assertSessionHasErrors('description');
        $this->put(route('repositories.update_description', $repository), ['description' => Str::random(14)])
            ->assertSessionDoesntHaveErrors('description');
        $this->put(route('repositories.update_description', $repository), ['description' => Str::random(30 * 1024 + 1)])
            ->assertSessionHasErrors('description');
    }


    /**
     * @group online
     */
    public function test_get_slug_when_update_a_repository_name()
    {
        $this->signIn();

        $repository = create(Repository::class, ['name' => '英语 英语', 'user_id' => auth()->id()]);

        $this->put(route('repositories.update_name', $repository), ['name' => '中文 中文']);

        $storedRepository = Repository::first();

        $this->assertEquals('chinese-chinese', $storedRepository->slug);
    }
}
