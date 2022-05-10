<?php

namespace Tests\Feature;

use App\Models\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilterRepositoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_will_redirect_to_recent_order_without_order_param()
    {
        $this->get(route('repositories.index'))
            ->assertRedirect('/repositories?order=recent');
    }

    public function test_user_can_filter_repositories_by_recent()
    {
        create(Repository::class,['created_at' => now()->subDay()]);
        create(Repository::class,['created_at' => now()]);
        create(Repository::class,['created_at' => now()->subDays(2)]);

        $resposne = $this->get('/repositories?order=recent');

        $ids = $resposne->data('repositories')->pluck('id')->toArray();

        $this->assertEquals([2,1,3], $ids);
    }

    public function test_user_can_filter_repositories_by_star()
    {
        create(Repository::class,['star_count' => 2]);
        create(Repository::class,['star_count' => 1]);
        create(Repository::class,['star_count' => 3]);

        $resposne = $this->get('/repositories?order=star');

        $ids = $resposne->data('repositories')->pluck('id')->toArray();

        $this->assertEquals([3,1,2], $ids);
    }
}
