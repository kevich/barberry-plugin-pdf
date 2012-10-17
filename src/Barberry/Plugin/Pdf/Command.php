<?php
namespace Barberry\Plugin\Pdf;

use Barberry\Plugin\InterfaceCommand;

class Command implements InterfaceCommand
{

    private $width;

    /**
     * @param string $commandString
     * @return Command
     */
    public function configure($commandString)
    {
        $width = is_numeric($commandString) ? intval($commandString) : '';
        $this->width = ($width !== '') ? min(2000, max(10, $width)) : '';
        return $this;
    }

    public function width()
    {
        if ($this->width == '') {
            return 800;
        }
        return $this->width;
    }

    public function __toString()
    {
        return strval($this->width);
    }

    /**
     * Command should have only one string representation
     *
     * @param string $commandString
     * @return boolean
     */
    public function conforms($commandString)
    {
        return strval($this) === $commandString;
    }
}
