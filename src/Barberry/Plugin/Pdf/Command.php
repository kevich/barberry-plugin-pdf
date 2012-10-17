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
        $this->width = is_numeric($commandString) ? intval($commandString) : null;
        return $this;
    }

    public function width()
    {
        return is_null($this->width) ? 800 : min(2000, max(10, $this->width));
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
