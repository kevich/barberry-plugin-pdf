<?php
namespace Barberry\Plugin\Pdf;

use Barberry\ContentType;
use Mockery as m;

class ConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConvertsPdfToTxt()
    {
        $converter = new Converter(ContentType::txt(), __DIR__ . '/../tmp/');
        $bin = $converter->convert(file_get_contents(__DIR__ . '/data/sample.pdf'));
        $this->assertEquals(ContentType::txt(), ContentType::byString($bin));
    }

    public function testConvertsPdfToJpeg()
    {
        $converter = new Converter(ContentType::jpeg(), __DIR__ . '/../tmp/');
        $bin = $converter->convert(file_get_contents(__DIR__ . '/data/sample.pdf'), self::resize900Command());
        $this->assertEquals(ContentType::jpeg(), ContentType::byString($bin));
    }

    public function testConvertsPdfToJpegWithEmptyComandWidth()
    {
        $converter = new Converter(ContentType::jpeg(), __DIR__ . '/../tmp/');
        $bin = $converter->convert(file_get_contents(__DIR__ . '/data/sample.pdf'), self::resizeEmptyCommand());
        $this->assertEquals(ContentType::jpeg(), ContentType::byString($bin));
    }

    public function testConvertsWithPageParameter()
    {
        $command = new Command();
        $command->configure('p10');
        $converter = m::mock(new Converter(ContentType::jpeg(), __DIR__ . '/../tmp/'));
        $converter
            ->shouldReceive('convertPdfPageToJpeg')
            ->with(anything(), '10', anything());
        $converter->convert(file_get_contents(__DIR__ . '/data/sample.pdf'), $command);
    }

//--------------------------------------------------------------------------------------------------


    private static function resize900Command()
    {
        $command = new Command();
        $command->configure('900p');
        return $command;
    }

    private static function resizeEmptyCommand()
    {
        $command = new Command();
        $command->configure('');
        return $command;
    }
}
