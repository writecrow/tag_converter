<?php

namespace writecrow\TagConverter;

use PHPUnit\Framework\TestCase;

/**
 * Test basic strings are converted correctly.
 */
class BasicTest extends TestCase {

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
<data><MyTag>123</MyTag><text>My tagged text here</text></data>
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
