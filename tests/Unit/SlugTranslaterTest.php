<?php

namespace Tests\Unit;

use App\Handlers\SlugTranslateHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;

/**
 * @group online
 */
class SlugTranslaterTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_translate_chinese_to_englisth()
    {
        $translater = new SlugTranslateHandler();

        $result = $translater->translate('英语 英语');

        $this->assertEquals('english-english', Str::lower($result));
    }
}
