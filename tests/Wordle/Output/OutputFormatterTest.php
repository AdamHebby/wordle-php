<?php

namespace Wordle\Tests\Output;

use PHPUnit\Framework\TestCase;
use Wordle\Output\OutputFormatter as OF;

class OutputFormatterTest extends TestCase
{
    public function testFormatDef()
    {
        $this->assertStringContainsString(
            "\e[" . OF::COLOR_TXT_DEF . ";" . OF::COLOR_BG_DEF . "mtest" .
            "\e[" . OF::COLOR_TXT_DEF . ";" . OF::COLOR_BG_DEF,
            OF::formatString('test', OF::FORMAT_DEF)
        );
    }

    public function testFormatGreen()
    {
        $this->assertStringContainsString(
            "\e[" . OF::COLOR_TXT_WHITE . ";" . OF::COLOR_BG_GREEN . "mtest" .
            "\e[" . OF::COLOR_TXT_DEF . ";" . OF::COLOR_BG_DEF,
            OF::formatString('test', OF::FORMAT_GREEN)
        );
    }

    public function testFormatAmber()
    {
        $this->assertStringContainsString(
            "\e[" . OF::COLOR_TXT_WHITE . ";" . OF::COLOR_BG_AMBER . "mtest" .
            "\e[" . OF::COLOR_TXT_DEF . ";" . OF::COLOR_BG_DEF,
            OF::formatString('test', OF::FORMAT_AMBER)
        );
    }

    public function testFormatNone()
    {
        $this->assertStringContainsString(
            'test',
            OF::formatString('test', OF::FORMAT_NONE)
        );
    }

    public function testFormatError()
    {
        $this->assertStringContainsString(
            "\e[" . OF::COLOR_TXT_RED . "mtest" .
            "\e[" . OF::COLOR_TXT_DEF . ";" . OF::COLOR_BG_DEF,
            OF::formatString('test', OF::FORMAT_ERROR)
        );
    }

    public function testFormatInvalid()
    {
        $this->assertStringContainsString(
            "\e[" . OF::COLOR_TXT_BLACK . ";" . OF::COLOR_BG_GREY . "mtest" .
            "\e[" . OF::COLOR_TXT_DEF . ";" . OF::COLOR_BG_DEF,
            OF::formatString('test', OF::FORMAT_INVALID)
        );
    }
}
