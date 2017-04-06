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
      ),
    );
  }

  /**
   * Test assertions.
   *
   * @dataProvider basicDataProvider
   */
  public function testBasic($input, $json, $php) {
    print_r($json);
    $text = new TagConverter($input);
    $this->assertEquals($php, $text->php());
    $this->assertEquals($json, $text->json());
  }

}
