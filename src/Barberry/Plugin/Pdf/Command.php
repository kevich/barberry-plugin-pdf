<?php
namespace Barberry\Plugin\Pdf;

use Barberry\Plugin\InterfaceCommand;

class Command implements InterfaceCommand
{

    private $width;
    private $page;

    /**
     * @param string $commandString
     * @return self
     */
    public function configure($commandString)
    {
        $params = explode("_", $commandString);
        $params = explode("_", $commandString);
        foreach ($params as $val) {
            if (preg_match("@^([\d]*)p([\d]*)$@", $val, $regs)) {
                $this->width = strlen($regs[1]) ? (int)$regs[1] : null;
                $this->page = strlen($regs[2]) ? (int)$regs[2] : null;
            }
        }
        return $this;
    }

    public function width()
    {
        return is_null($this->width) ? 800 : min(2000, max(10, $this->width));
    }

    public function page()
    {
        return is_null($this->page) ? 1 : $this->page;
    }

    public function __toString()
    {
        return ($this->width || $this->page) ? strval($this->width . 'p' . $this->page) : '';
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
