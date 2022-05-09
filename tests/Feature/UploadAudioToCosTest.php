<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UploadAudioToCosTest extends TestCase
{
    use RefreshDatabase;
    public function test_guest_cannot_upload_audio_to_cos()
    {

    }
}
