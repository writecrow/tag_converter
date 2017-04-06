<?php

namespace markfullmer\TagConverter;

/**
 * Test basic strings are converted correctly.
 */
class CharactersTest extends \PHPUnit_Framework_TestCase {

  /**
   * Provides data.
   */
  public function basicDataProvider() {
    return array(
      'Non-allowed characters are ignored' => array(
        'input' => '<My/Tag: 12:3>My tagged text here',
        'json'  => '{"text":"&lt;My\/Tag: 12:3&gt;My tagged text here"}',
        'php' => array('text' => '&lt;My/Tag: 12:3&gt;My tagged text here'),
      ),
    );
  }

  /**
   * Test assertions.
   *
   * @dataProvider basicDataProvider
   */
  public function testBasic($input, $json, $php) {
    $text = new TagConverter($input);
    $this->assertEquals($php, $text->php());
    $this->assertEquals($json, $text->json());
  }

}
