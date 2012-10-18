<?php
namespace Barberry\Plugin\Pdf;

use Barberry\Plugin;

class Monitor implements Plugin\InterfaceMonitor
{
    private $checkDirectories = array();

    private $dependencies = array(
        'pdftops' => 'Please install poppler (http://poppler.freedesktop.org)',
        'pdftotext' => 'Please install poppler (http://poppler.freedesktop.org)',
        'convert' => 'Please install imagemagic (http://www.imagemagick.org)'
    );

    public function __construct($tmpDir)
    {
        $this->checkDirectories[] = $tmpDir;
    }

    public function dependencies()
    {
        return $this->dependencies;
    }

    public function reportUnmetDependencies()
    {
        $errors = array();
        foreach ($this->dependencies() as $command => $message) {
            $answer = $this->reportUnixCommand($command, $message);
            if (!is_null($answer)) {
                $errors[] = $answer;
            }
        }
        return $errors;
    }

    public function reportMalfunction()
    {
        $errors = array();
        foreach ($this->checkDirectories as $directory) {
            $answer = $this->reportWritableDirectory($directory);
            if (!is_null($answer)) {
                $errors[] = $answer;
            }
        }
        return $errors;
    }

//-------------------------------------------------------------------------

    private function reportWritableDirectory($directory)
    {
        return (!is_writeable($directory)) ? 'ERROR: Plugin Pdf temporary directory is not writeable.' : null;
    }

    private function reportUnixCommand($command, $messageIfMissing)
    {
        return preg_match('/^\/\w+/', exec("which $command")) ? null : "MISSING - $messageIfMissing\n\n";
    }
}
