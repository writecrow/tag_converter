<?php

namespace markfullmer\TagConverter;

/**
 * Class TagConverter.
 *
 * A helper class to convert Tagged corpus text to universal formats.
 *
 * @author markfullmer <mfullmer@gmail.com>
 *
 * @link https://github.com/markfullmer/tag-converter/ Latest version on GitHub.
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class TagConverter {
  /**
   * An array of processed text, manipulable by the 'json' & 'php' methods.
   *
   * @var array
   */
  protected $array = array();

  /**
   * Constructor.
   *
   * @param string $text
   *   The text, in tagged corpus format.
   */
  public function __construct($text = '') {
    $array = [];
    preg_match_all("/<([a-zA-Z0-9_ -]*):([a-zA-Z0-9_ -]*)>/", $text, $matches, PREG_SET_ORDER);
    if (isset($matches[0])) {
      // Store <TAGNAME: VALUE> strings.
      foreach ($matches as $key => $values) {
        $array[trim($values[1])] = trim($values[2]);
      }
    }

    // Remove tags and parse each line into an array element.
    $untagged = preg_replace("/<([a-zA-Z0-9_ -]*):([a-zA-Z0-9_ -]*)>/", "", $text);
    $clean = '';
    $tags = preg_split('/((\r?\n)|(\n?\r))/', htmlspecialchars($untagged, ENT_NOQUOTES));
    $end = end($tags);
    foreach ($tags as $key => $line) {
      if ($line != '') {
        $clean .= $line;
        if ($key != $end) {
          $clean .= PHP_EOL;
        }
      }
    }
    // Add a new array element, 'text', to the array. If nothing else, the
    // $array array will now contain the 'text' element with an empty string.
    $array['text'] = $clean;
    $this->array = $array;
  }

  /**
   * Convert to JSON.
   *
   * @return string
   *   A JSON object as a string.
   */
  public function json() {
    return str_replace('\\ufeff', '', json_encode($this->array));
  }

  /**
   * Convert to PHP array.
   *
   * @return string[]
   *   A PHP array.
   */
  public function php() {
    return $this->array;
  }

}
