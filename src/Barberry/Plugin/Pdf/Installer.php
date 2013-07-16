<?php

namespace Barberry\Plugin\Pdf;

use Barberry\Plugin;
use Barberry\Direction;
use Barberry\Monitor;
use Barberry\ContentType;

class Installer implements Plugin\InterfaceInstaller
{

    public function install(Direction\ComposerInterface $composer, Monitor\ComposerInterface $monitorComposer,
        $pluginParams = array())
    {

        foreach (self::directions() as $pair) {
            $composer->writeClassDeclaration(
                $pair[0],
                $pair[1],
                'new Plugin\\Pdf\\Converter',
                'new Plugin\\Pdf\\Command'
            );
        }

        $monitorComposer->writeClassDeclaration('Pdf');
    }

    private static function directions()
    {
        return array(
            array(ContentType::pdf(), \Barberry\ContentType::jpeg()),
            array(ContentType::pdf(), \Barberry\ContentType::txt()),
        );
    }

}
