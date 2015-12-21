<?php
namespace Cmd;

class ParseTest extends \PHPUnit_Framework_TestCase
{
  public function argumentStringProvider()
  {
    return [
      ['--foo', ['foo', true] ],
      ['--bar=baz', ['bar', 'baz'] ],
      ['--funny="spam=eggs"', ['funny', '"spam=eggs"'] ],
      ['--also-funny=spam=eggs', ['also-funny', 'spam=eggs'] ],
      ["'plain arg 2'", [null, "'plain arg 2'"] ],
      ['-abc', ['abc', true] ],
      ['-k=value', ['k', 'value'] ],
      ['"plain arg 3"', [null, '"plain arg 3"'] ],
      ['--s="original"', ['s', '"original"'] ]
    ];
  }

  /**
   * @dataProvider argumentStringProvider
   */
  public function testParseValidArgumentString($argument, $result)
  {
    $parse = new Parse();
    $parseResult = $parse->execute($argument);

    $this->assertEquals($parseResult, $result);
  }
}
