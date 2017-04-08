<?php

namespace markfullmer\TagConverter;

/**
 * Test basic strings are converted correctly.
 */
class BasicTest extends \PHPUnit_Framework_TestCase {

  /**
   * Provides data.
   */
  public function basicDataProvider() {
    return array(
      'Readme usage' => array(
        'input' => '<MyTag: 123>My tagged text here',
        'json'  => '{"MyTag":"123","text":"My tagged text here"}',
        'php' => array('MyTag' => '123', 'text' => 'My tagged text here'),
        'xml' => '<?xml version="1.0"?>
<root><MyTag>123</MyTag><text>My tagged text here</text></root>
',
      ),
    );
  }

  /**
   * Test assertions.
   *
   * @dataProvider basicDataProvider
   */
  public function testBasic($input, $json, $php, $xml) {
    $this->assertEquals($php, TagConverter::php($input));
    $this->assertEquals($json, TagConverter::json($input));
    $this->assertEquals($xml, TagConverter::xml($input));
  }

}
