<?php

namespace writecrow\TagConverter;

use PHPUnit\Framework\TestCase;

/**
 * Test basic strings are converted correctly.
 */
class CharactersTest extends TestCase {

  /**
   * Provides data.
   */
  public function basicDataProvider() {
    return array(
      'Non-allowed characters are ignored' => array(
        'input' => '<My/Tag: 12:3>My tagged text here',
        'json'  => '{"text":"&lt;My\/Tag: 12:3&gt;My tagged text here"}',
        'php' => array('text' => '&lt;My/Tag: 12:3&gt;My tagged text here'),
        'xml' => '<?xml version="1.0"?>
<root><text>&lt;My/Tag: 12:3&gt;My tagged text here</text></root>
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
