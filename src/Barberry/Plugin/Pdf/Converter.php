<?php
namespace Barberry\Plugin\Pdf;

use Barberry\Plugin;
use Barberry\ContentType;
use Barberry\Pipe;

class Converter implements Plugin\InterfaceConverter
{

    /**
     * @var string
     */
    private $tempPath;

    /**
     * @var ContentType
     */
    private $targetContentType;

    public function __construct(ContentType $targetContentType, $tempPath)
    {
        $this->tempPath = $tempPath;
        $this->targetContentType = $targetContentType;
    }

    public function convert($bin, Plugin\InterfaceCommand $command = null)
    {
        if ($this->targetContentType->standartExtention() == 'txt') {
            return $this->convertToText($bin);
        }
        return $this->convertToJpeg($bin, $command);
    }

//--------------------------------------------------------------------------------------------------

    private function convertToText($bin)
    {
        $pipe = new Pipe('pdftotext - -');
        return $pipe->process($bin);
    }

    private function convertToJpeg($bin, Plugin\Pdf\Command $command)
    {
        $filename = tempnam($this->tempPath, 'pftops_');
        file_put_contents($filename, $bin);

        $jpeg = $this->convertPdfPageToJpeg($filename, $command->page(), $command->width());
        unlink($filename);
        return $jpeg;
    }

    private function convertPdfPageToJpeg($filename, $pageNumber, $width)
    {
        $pipePdf2Ps = new Pipe(self::pdfToPsPopplerCommand($filename, $pageNumber));
        $pipePs2Jpeg = new Pipe(self::psToJpegImagemagic($width));
        $jpeg = $pipePs2Jpeg->process($pipePdf2Ps->process());
        return $jpeg;
    }

    private static function pdfToPsPopplerCommand($tmpFilename, $page)
    {
        return 'pdftops -level3 -f ' . $page . ' -l ' . $page . ' -expand ' . escapeshellarg($tmpFilename) . ' -';
    }

    private static function psToJpegImagemagic($width)
    {
        return "convert -density 150 -[0] -background white -flatten -depth 8 -resize $width jpeg:-";
    }
}
