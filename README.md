Command line argument parsing
=================================

[![Travis-CI Build Status](https://secure.travis-ci.org/enygma/cmd.png?branch=master)](http://travis-ci.org/enygma/cmd)

This library provides a simple interface for parsing the `$_SERVER['argv']` input values out into key/value pairs.

### Installation

Using Composer:

```
composer require enygma/cmd
```

### Example Usage:

```php
<?php

require_once 'vendor/autoload.php';
use Cmd\Command;

$cmd = new Command();
$args = $cmd->execute($_SERVER['argv']);

echo 'RESULT: '.var_export($args, true)."\n";

?>
```

### Example Output

For the command line call of:

```bash
php test.php plain-arg --foo --bar=baz --funny="spam=eggs" --also-funny=spam=eggs 'plain arg 2' -abc -k=value "plain arg 3" --s="original" --s='overwrite' --s
```

The result would be:

```
Array
(
    [0] => plain-arg
    [foo] => 1
    [bar] => baz
    [funny] => spam=eggs
    [also-funny] => spam=eggs
    [1] => plain arg 2
    [abc] => 1
    [k] => value
    [2] => plain arg 3
    [s] => 1
)
```

Options that are either plain arguments (like `plain-arg` or `plain arg 3`) will just be added to the results with numeric indexes. The other options will be assiged as key/value pairs in the resulting array. For values that are set (like `-abc` or `--foo`) but don't have a value, the value will be set to the boolean `true`.

### Required and default

You can also set up default values and required parameters for your command line options. Use the optional second paramster on the `execute` method call to define these:

```
<?php

require_once 'vendor/autoload.php';
use Cmd\Command;

$cmd = new Command();
$config = [
  'default' => ['foo' => true],
  'required' => ['bar']
];

$args = $cmd->execute($_SERVER['argv'], $config);

echo 'RESULT: '.var_export($args, true)."\n";

?>
```

The `default` values are defined as an array of parameter name => default value. The `required` settings are just presented as an array of option names.
