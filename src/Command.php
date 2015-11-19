<?php

namespace Cmd;

class Command
{
    /**
     * Execute the argument parsing given the input from the command line
     *     in $_SERVER['argv']
     *
     * @param array $args Arguments list from the PHP input
     * @return array Parsed argument results
     */
    public function execute($args)
    {
        // Strip off the first item, it's the script name
        array_shift($args);
        $values = [];

        foreach ($args as $argument) {
            list($name, $value) = Parse::execute($argument);

            // see if we can find a matching option
            if ($name !== null) {
                $values[$name] = $value;
            } else {
                $values[] = $value;
            }
        }

        return $values;
    }
}
