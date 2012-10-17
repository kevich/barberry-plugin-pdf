#!/usr/bin/php
<?php
error_reporting(E_ALL | E_STRICT);

echo "\nChecking pre-requisites required to install, develop, and run the plugin:\n\n";

reportVersion('PHP', '5.3.0', PHP_VERSION);

reportUnixCommand('pdftops', 'Please install poppler (http://poppler.freedesktop.org)');
reportUnixCommand('pdftotext', 'Please install poppler (http://poppler.freedesktop.org)');
reportUnixCommand('convert', 'Please install imagemagic (http://www.imagemagick.org)');

echo "\nAll dependencies tests are passed!\n";

//==================================================================================================

function reportVersion($componentName, $requiredVersion, $currentVersion, $whiteList = array())
{
    echo "$componentName version: $currentVersion - ";

    if (!empty($whiteList) && in_array($currentVersion, $whiteList)) {
        echo "OK\n";
    } else {
        if (version_compare($requiredVersion, $currentVersion) <= 0) {
            echo "OK\n";
        } else {
            echo "INSUFFICIENT - $requiredVersion required\n\n";
            exit(1);
        }
    }
}

//--------------------------------------------------------------------------------------------------

function reportUnixCommand($command, $messageIfMissing)
{
    echo "$command command - ";

    if (preg_match('/^\/\w+/', exec("which $command"))) {
        echo "FOUND\n";
    } else {
        echo "MISSING - $messageIfMissing\n\n";
        exit;
    }
}
