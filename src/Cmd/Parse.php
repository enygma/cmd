<?php

namespace Cmd;

class Parse
{
    /**
     * Execute the parse of the argument string provided
     *
     * @param string $argument Command line argument string
     * @return array Key/value pair of the argument parsing
     */
    public static function execute($argument)
    {
        // If it's an option defined with double/single dash
        if (strpos($argument, '-') == 0) {
            if (substr($argument, 0, 1) == '-') {
                return self::parseExtended($argument);
            }
        }
        return [null, $argument];
    }

    /**
     * Parse the extended argument (ex: --foo=bar)
     *
     * @param string $argument Argument input string
     * @return array Key/value result of argument parsing
     */
    private static function parseExtended($argument)
    {
        // strip the -- or -
        if (substr($argument, 0, 2) === '--') {
            $argument = substr($argument, 2);
        } elseif (substr($argument, 0, 1) == '-') {
            $argument = substr($argument, 1);
        }

        $pos = strpos($argument, '=');

        if ($pos === false) {
            $name = $argument;
            $value = true;
        } else {
            $name = substr($argument, 0, $pos);
            $value = substr($argument, $pos + 1);
        }

        return [$name, $value];

    }
}
