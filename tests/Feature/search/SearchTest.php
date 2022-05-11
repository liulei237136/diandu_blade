<?php

namespace Tests\Feature\search;

use App\Models\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_search_by_title()
    {
        $repository_1 = create(Repository::class);
        $repository_2 = create(Repository::class);

        $this->get(route('search', ['q' => $repository_1->name]))
            ->assertSee($repository_1->user->name)
            ->assertDontSee($repository_2->user->name);
    }
}
