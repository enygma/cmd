<?php
namespace Cmd;

class CommandTest extends \PHPUnit_Framework_TestCase
{
  /**
   * Test the parsing of a full set of arguments as if it
   * 	came from the $_SERVER['argv'] input
   */
  public function testParseValidOptions()
  {
    $arguments = [
      'script-name.php',
      '--foo',
      '--bar=baz',
      '--funny="spam=eggs"',
      '--also-funny=spam=eggs',
      '-abc',
      "'plain arg 2'"
    ];

    $parsedResult = [
      'foo' => true,
      'bar' => 'baz',
      'funny' => '"spam=eggs"',
      'also-funny' => 'spam=eggs',
      'abc' => true
    ];
    // Add an item to the list with no index (plain argument)
    $parsedResult[] = "'plain arg 2'";

    $cmd = new Command();
    $result = $cmd->execute($arguments);

    $this->assertEquals($parsedResult, $result);
  }

  /**
   * Test that a value repeated will override the value (last in wins)
   */
  public function testParseValidOverride()
  {
    $arguments = [
      'script-name.php',
      '--bar=baz',
      '-s=test',
      '--s=foo'
    ];

    $cmd = new Command();
    $result = $cmd->execute($arguments);

    // The value of "s" should equal "foo"
    $this->assertEquals('foo', $result['s']);
  }

  /**
   * Test that the script passes when the required params are provided
   */
  public function testParseRequiredParamsValid()
  {
    $config = ['required' => ['test']];
    $arguments = [
      'script-name.php',
      '--test'
    ];
    $cmd = new Command();
    $result = $cmd->execute($arguments);

    $this->assertTrue(isset($result['test']));
    $this->assertEquals(true, $result['test']);
  }

  /**
   * Test that an exception is thrown when a required input is missing
   *
   * @expectedException \Cmd\Exception\MissingRequiredException
   */
  public function testParseRequiredParamsMissing()
  {
    $config = ['required' => ['test']];
    $arguments = [
      'script-name.php',
      '--foo=bar'
    ];
    $cmd = new Command();
    $result = $cmd->execute($arguments, $config);
  }

  /**
   * Test that the default values are assigned when none
   * 	are given for that param
   */
  public function testParseDefaultValues()
  {
    $config = ['default' => ['test' => 'testing1234'] ];
    $arguments = [
      'script-name.php'
    ];

    $cmd = new Command();
    $result = $cmd->execute($arguments, $config);

    $this->assertEquals('testing1234', $result['test']);
  }

  /**
   * Test that the default value is overwritten when the parameter
   * 	is defined.
   */
  public function testParseDefaultValueIsDefined()
  {
    $config = ['default' => ['test' => 'testing1234'] ];
    $arguments = [
      'script-name.php',
      '--test=foobar'
    ];

    $cmd = new Command();
    $result = $cmd->execute($arguments, $config);

    $this->assertEquals('foobar', $result['test']);
  }
}
