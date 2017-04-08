<?php

namespace markfullmer\TagConverter;

use PHPUnit\Framework\TestCase;

/**
 * Test basic strings are converted correctly.
 */
class SpacingTest extends TestCase {

  /**
   * Provides data.
   */
  public function basicDataProvider() {
    return array(
      'Spaces padding tag name & values' => array(
        'input' => '< MyTag : 123 >My tagged text here',
        'json'  => '{"MyTag":"123","text":"My tagged text here"}',
        'php' => array('MyTag' => '123', 'text' => 'My tagged text here'),
      ),
      'Spaces in tag name & values' => array(
        'input' => '< My Tag : 12 3 >My tagged text here',
        'json'  => '{"My Tag":"12 3","text":"My tagged text here"}',
        'php' => array('My Tag' => '12 3', 'text' => 'My tagged text here'),
      ),
      'Hyphens in tag name & values' => array(
        'input' => '< My-Tag : 12-3 >My tagged text here',
        'json'  => '{"My-Tag":"12-3","text":"My tagged text here"}',
        'php' => array('My-Tag' => '12-3', 'text' => 'My tagged text here'),
      ),
      'Underscores in tag name & values' => array(
        'input' => '< My_Tag : 12_3 >My tagged text here',
        'json'  => '{"My_Tag":"12_3","text":"My tagged text here"}',
        'php' => array('My_Tag' => '12_3', 'text' => 'My tagged text here'),
      ),
    );
  }

  /**
   * Test assertions.
   *
   * @dataProvider basicDataProvider
   */
  public function testBasic($input, $json, $php) {
    $this->assertEquals($php, TagConverter::php($input));
    $this->assertEquals($json, TagConverter::json($input));
  }

}
