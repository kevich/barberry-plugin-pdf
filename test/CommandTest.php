<?php
namespace Barberry\Plugin\Pdf;

class CommandTest extends \PHPUnit_Framework_TestCase
{

    public function testCommandStringContainsTheWidth()
    {
        $this->assertEquals(
            150,
            self::command('150')->width()
        );
    }

    public function testWidthIsLimitedWithMinimalValue()
    {
        $this->assertEquals(
            10,
            self::command('0')->width()
        );
    }

    public function testWidthIsLimitedWithMaximalValue()
    {
        $this->assertEquals(
            2000,
            self::command('500000')->width()
        );
    }

    public function testNoDefaultCommand()
    {
        $this->assertEquals(
            800,
            self::command()->width()
        );
    }

    public function testAmbiguityTest()
    {
        $this->assertFalse(self::command('200sda')->conforms('200'));
    }

//--------------------------------------------------------------------------------------------------

    private static function command($commandString = null)
    {
        $command = new Command();
        return $command->configure($commandString);
    }
}
