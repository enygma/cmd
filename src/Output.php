<?php

namespace Cmd;

class Output
{
    protected $types = [
        'error' => ['white', 'red'],
        'info' => ['white', 'blue'],
        'warning' => ['white', 'yellow'],
        'success' => ['white', 'green']
    ];

    const RESET = "\033[0m";
    const BOLD = "\033[1m";
    const UNDERLINE = "\033[4m";

    const FG_BLACK = '0;30';
    const FG_DARKGRAY = '1;30';
    const FG_BLUE = '0;34';
    const FG_LIGHTBLUE = '1;34';
    const FG_GREEN = '0;32';
    const FG_LIGHTGREEN = '1;32';
    const FG_CYAN = '0;36';
    const FG_LIGHTCYAN = '1;36';
    const FG_RED = '0;31';
    const FG_LIGHTRED = '1;31';
    const FG_PURPLE = '0;35';
    const FG_LIGHTPURPLE = '1;35';
    const FG_BROWN = '0;33';
    const FG_YELLOW = '1;33';
    const FG_LIGHTGRAY = '0;37';
    const FG_WHITE = '1;37';

    const BG_BLACK = '40';
    const BG_RED = '41';
    const BG_GREEN = '42';
    const BG_YELLOW = '43';
    const BG_BLUE = '44';
    const BG_MAGENTA = '45';
    const BG_CYAN = '46';
    const BG_LIGHTGRAY = '47';

    protected function resolvefg($color)
    {
        $const = 'FG_'.strtoupper($color);

        if (!defined('static::'.$const)) {
            throw new \Exception('Invalid foreground color: '.$color);
        }
        return "\033[".constant('self::'.$const).'m';
    }

    protected function resolvebg($color)
    {
        $const = 'BG_'.strtoupper($color);

        if (!defined('static::'.$const)) {
            throw new \Exception('Invalid background color: '.$color);
        }
        return "\033[".constant('self::'.$const).'m';
    }

    public function output($message, array $colors, $return = false)
    {
        $fg = $this->resolvefg($colors[0]);
        $bg = $this->resolvebg($colors[1]);

        $string = $fg.$bg.self::BOLD.$message.self::RESET;
        if ($return === true) {
            return $string;
        } else {
            echo $string;
        }
    }

    public function addType($name, $fg, $bg)
    {
        $this->types[$name] = [$fg, $bg];
    }

    public function __call($name, $args)
    {
        $name = strtolower($name);

        // See if there's a type matching the function
        if (!isset($this->types[$name])) {
            throw new \Exception('Invalid message type: '.$name);
        }
        $arguments = [$args[0], $this->types[$name]];
        if (isset($args[1])) {
            $arguments[] = $args[1];
        }
        return call_user_func_array([$this, 'output'], $arguments);
    }
}
