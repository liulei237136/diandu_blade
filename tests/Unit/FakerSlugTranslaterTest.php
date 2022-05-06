<?php

namespace Tests\Unit;

use App\Handlers\FakerTranslaterHandler;
use Tests\TestCase;
use Illuminate\Support\Str;

class FakerSlugTranslaterTest extends TestCase
{
    public function test_can_translate_chinese_to_englisth()
    {
        $translater = new FakerTranslaterHandler();

        $result = $translater->translate('英语 英语');

        $this->assertEquals('english-english', Str::lower($result));
    }
}
