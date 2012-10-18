<?php

namespace Barberry\Plugin\Pdf;

use Barberry\Plugin;
use Barberry\Direction;
use Barberry\Monitor;
use Barberry\ContentType;

class Installer implements Plugin\InterfaceInstaller
{
    /**
     * @var string
     */
    private $tempDirectory;

    public function __construct($tempDirectory)
    {
        $this->tempDirectory = $tempDirectory;
    }

    public function install(Direction\ComposerInterface $composer, Monitor\ComposerInterface $monitorComposer,
        $pluginParams = array())
    {

        foreach (self::directions() as $pair) {
            $composer->writeClassDeclaration(
                $pair[0],
                eval('return ' . $pair[1] . ';'),
                <<<PHP
new Plugin\Pdf\Converter ($pair[1], '{$this->tempDirectory}');
PHP
                ,
                'new Plugin\Pdf\Command'
            );
        }

        $monitorComposer->writeClassDeclaration('Pdf', "parent::__construct('{$this->tempDirectory}')");
    }

    private static function directions()
    {
        return array(
            array(ContentType::pdf(), '\Barberry\ContentType::jpeg()'),
            array(ContentType::pdf(), '\Barberry\ContentType::txt()'),
        );
    }

}
