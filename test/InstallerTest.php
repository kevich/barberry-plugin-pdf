<?php
namespace Barberry\Plugin\Pdf;

use Barberry\Direction;
use Barberry\Direction\Composer;
use Barberry\Monitor;

class InstallerTest extends \PHPUnit_Framework_TestCase
{
    private $directionDir;
    private $monitorDir;

    protected function setUp()
    {
        $this->directionDir = realpath(__DIR__ . '/../tmp') . '/test-directions/';
        $this->monitorDir = realpath(__DIR__ . '/../tmp') . '/test-monitors/';
        @mkdir($this->directionDir, 0777, true);
        @mkdir($this->monitorDir, 0777, true);
    }

    protected function tearDown()
    {
        exec("rm -rf " . $this->directionDir);
        exec("rm -rf " . $this->monitorDir);
    }

    public function testInstallsPDFtoTXTDirection()
    {
        $installer = new Installer('/tmp/');
        $installer->install(new Composer($this->directionDir), new Monitor\Composer($this->monitorDir));

        include $this->directionDir . 'PdfToTxt.php';
        $pdfToTxt = new Direction\PdfToTxtDirection('');
        $this->assertNotNull($pdfToTxt->convert(file_get_contents(__DIR__ . '/data/sample.pdf')));
    }

    public function testInstallsPDFtoJpegDirection()
    {
        $installer = new Installer('/tmp/');
        $installer->install(new Composer($this->directionDir), new Monitor\Composer($this->monitorDir));

        include $this->directionDir . 'PdfToJpg.php';
        $pdfToJpg = new Direction\PdfToJpgDirection('');
        $this->assertNotNull($pdfToJpg->convert(file_get_contents(__DIR__ . '/data/sample.pdf')));
    }
}
