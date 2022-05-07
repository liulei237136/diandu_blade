<?php

namespace Tests\Feature;

use App\Models\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StarRepositoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_may_not_star_or_unstar_repositories()
    {
        $this->withExceptionHandling();

        $repository = create(Repository::class);

        $this->post(route('repository-stars.store', $repository))
            ->assertRedirect('/login');
        $this->delete(route('repository-stars.destroy', $repository))
            ->assertRedirect('/login');
    }

    public function test_a_user_can_star_repository_of_others()
    {
        $this->signIn();

        $repository = create(Repository::class);

        $this->post(route('repository-stars.store', $repository));

        $this->assertCount(1, $repository->stars);
        $this->assertEquals(1, $repository->refresh()->star_count);
    }

    public function test_a_user_can_star_repository_of_owns()
    {
        $this->signIn();

        $repository = create(Repository::class,['user_id' => auth()->id()]);

        $this->post(route('repository-stars.store', $repository));

        $this->assertCount(1, $repository->stars);
        $this->assertEquals(1, $repository->refresh()->star_count);
    }

    public function test_a_user_can_unstar_repository_of_others()
    {
        $this->signIn();

        $repository = create(Repository::class);

        $this->post(route('repository-stars.store', $repository));
        $this->delete(route('repository-stars.destroy', $repository));

        $this->assertCount(0, $repository->stars);
    }

    public function test_a_user_can_unstar_repository_of_owns()
    {
        $this->signIn();

        $repository = create(Repository::class,['user_id' => auth()->id()]);

        $this->post(route('repository-stars.store', $repository));
        $this->delete(route('repository-stars.destroy', $repository));

        $this->assertCount(0, $repository->stars);
    }

    public function test_can_know_if_starred()
    {
        $this->signIn();

        $repository = create(Repository::class);

        $this->post(route('repository-stars.store', $repository));

        $this->assertTrue($repository->isStaredBy(auth()->user()));
    }

    public function test_can_know_star_count()
    {
        $this->signIn();

        $repository = create(Repository::class);

        $this->post(route('repository-stars.store', $repository));

        $this->assertEquals(1, $repository->refresh()->star_count);
    }
}
