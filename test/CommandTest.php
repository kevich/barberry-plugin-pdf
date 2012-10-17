<?php
namespace Barberry\Plugin\Pdf;

class CommandTest extends \PHPUnit_Framework_TestCase
{

    public function testCommandStringContainsTheWidth()
    {
        $this->assertEquals(
            150,
            self::command('150p')->width()
        );
    }

    public function testWidthIsLimitedWithMinimalValue()
    {
        $this->assertEquals(
            10,
            self::command('0p')->width()
        );
    }

    public function testWidthIsLimitedWithMaximalValue()
    {
        $this->assertEquals(
            2000,
            self::command('500000p')->width()
        );
    }

    public function testNoDefaultCommand()
    {
        $this->assertEquals(
            800,
            self::command()->width()
        );
    }

    public function testEmptyDefaultCommand()
    {
        $this->assertEquals(
            800,
            self::command('')->width()
        );
    }

    public function testAmbiguityTest()
    {
        $this->assertFalse(self::command('200sda')->conforms('200'));
    }

    public function testReadsPageOnly()
    {
        $this->assertEquals(
            10,
            self::command('p10')->page()
        );
    }

    public function testSetsDefaultPage()
    {
        $this->assertEquals(
            1,
            self::command('100p')->page()
        );
    }

    public function testReadsWidthOnly()
    {
        $this->assertEquals(
            100,
            self::command('100p')->width()
        );
    }

    public function testReadsPageAndWidthBoth()
    {
        $command = self::command('100p10');
        $this->assertEquals(100, $command->width());
        $this->assertEquals(10, $command->page());
    }

    public function testFailsWithoutPSign()
    {
        $this->assertFalse(self::command('100')->conforms('100'));
    }

//--------------------------------------------------------------------------------------------------

    private static function command($commandString = null)
    {
        $command = new Command();
        return $command->configure($commandString);
    }
}
