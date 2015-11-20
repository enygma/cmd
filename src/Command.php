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
    public function execute($args, array $config = array())
    {
        // Strip off the first item, it's the script name
        array_shift($args);
        $values = [];

        // Set any defaults we may have
        if (isset($config['default'])) {
          foreach ($config['default'] as $key => $value) {
            $values[$key] = $value;
          }
        }

        foreach ($args as $argument) {
            echo print_r($argument, true)."\n";

            list($name, $value) = Parse::execute($argument);

            // see if we can find a matching option
            if ($name !== null) {
                $values[$name] = $value;
            } else {
                $values[] = $value;
            }
        }

        // See if we have ann required params
        if (isset($config['required'])) {
            $missing = [];
            foreach ($config['required'] as $index => $param) {
              if (!isset($values[$param])) {
                $missing[] = $param;
              }
            }
            if (!empty($missing)) {
              throw new Exception\MissingRequiredException('Missing required params: '.implode(', ', $missing));
            }
        }

        return $values;
    }
}
