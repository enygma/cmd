Command line argument parsing
=================================

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
