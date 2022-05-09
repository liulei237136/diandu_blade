<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StsTest extends TestCase
{
    use RefreshDatabase;

    //route('sts.store')
    //method, PUT
    //type, audio,download
    //filename
    public function test_guest_cannot_make_sts()
    {
        $this->withExceptionHandling()
            ->post(route('sts.store'))
            ->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_put_sts_for_audio()
    {
        $this->signIn();

        $this->post(route('sts.store'), [
            'method' => 'PUT',
            'type' => 'audio',
            'filename' => 'test.mp3',
        ])
            // 'tempKeys' => $tempKeys,
            // 'allowPrefix' => $allowPrefix,
            ->assertJsonStructure([
                'tempKeys', 'allowPrefix'
            ]);
    }

    public function test_authenticated_user_can_create_put_sts_for_download()
    {
        $this->signIn();

        $this->post(route('sts.store'), [
            'method' => 'PUT',
            'type' => 'download',
            'filename' => 'test.rar',
        ])
            // 'tempKeys' => $tempKeys,
            // 'allowPrefix' => $allowPrefix,
            ->assertJsonStructure([
                'tempKeys', 'allowPrefix'
            ]);
    }

    public function test_cannot_use_uncorrect_method()
    {
        $this->signIn()->withExceptionHandling();

        $this->post(route('sts.store'), [
            'method' => 'GET',
            'type' => 'audio',
            'filename' => 'test.mp3',
        ])
            ->assertSessionHasErrors('method');
    }
}
