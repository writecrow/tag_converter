<?php

namespace writecrow\TagConverter;

use PHPUnit\Framework\TestCase;

/**
 * Test basic strings are converted correctly.
 */
class SpecialCharactersTest extends TestCase {

  /**
   * Provides data.
   */
  public function basicDataProvider() {
    return array(
      'HTML character behavior' => array(
        'input' => '<MyTag: 123>My <span>tagged</span> text here',
        'json'  => '{"MyTag":"123","text":"My &lt;span&gt;tagged&lt;\/span&gt; text here"}',
        'php' => array('MyTag' => '123', 'text' => 'My &lt;span&gt;tagged&lt;/span&gt; text here'),
      ),
      'Double quote behavior' => array(
        'input' => '<MyTag: 123>My "tagged" text here',
        'json'  => '{"MyTag":"123","text":"My \"tagged\" text here"}',
        'php' => array('MyTag' => '123', 'text' => 'My "tagged" text here'),
      ),
      'Single quote behavior' => array(
        'input' => '<MyTag: 123>My \'tagged\' text here',
        'json'  => '{"MyTag":"123","text":"My \'tagged\' text here"}',
        'php' => array('MyTag' => '123', 'text' => 'My \'tagged\' text here'),
      ),
      'Smart quote behavior' => array(
        'input' => '<MyTag: 123>My “tagged” text here',
        'json'  => '{"MyTag":"123","text":"My \u201ctagged\u201d text here"}',
        'php' => array('MyTag' => '123', 'text' => 'My “tagged” text here'),
      ),
      'Ampersand behavior' => array(
        'input' => '<MyTag: 123>My & text here',
        'json'  => '{"MyTag":"123","text":"My &amp; text here"}',
        'php' => array('MyTag' => '123', 'text' => 'My &amp; text here'),
      ),
      'Accent characters' => array(
        'input' => '<MyTag: 123>My tággéd text here',
        'json'  => '{"MyTag":"123","text":"My t\u00e1gg\u00e9d text here"}',
        'php' => array('MyTag' => '123', 'text' => 'My tággéd text here'),
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
