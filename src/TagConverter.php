<?php

namespace markfullmer\TagConverter;

/**
 * Class TagConverter.
 *
 * A helper class to convert Tagged corpus text to universal formats.
 *
 * @author markfullmer <mfullmer@gmail.com>
 *
 * @link https://github.com/markfullmer/tag-converter/
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class TagConverter {

  /**
   * Convert to JSON.
   *
   * @param string $original
   *   The text, in tagged corpus format.
   *
   * @return string
   *   A JSON object as a string.
   */
  public static function json($original) {
    return str_replace('\\ufeff', '', json_encode(self::convert($original)));
  }

  /**
   * Return PHP array.
   *
   * @param string $original
   *   The text, in tagged corpus format.
   *
   * @return string[]
   *   A PHP array.
   */
  public static function php($original) {
    return self::convert($original);
  }

  /**
   * Return XML object.
   *
   * @param string $original
   *   The text, in tagged corpus format.
   *
   * @return object
   *   An XML object.
   */
  public static function xml($original) {
    $array = array_flip(self::convert($original));
    $xml = new \SimpleXMLElement('<root/>');
    array_walk_recursive($array, array($xml, 'addChild'));
    return $xml->asXML();
  }

  /**
   * Convert tag format into PHP array.
   *
   * @param string $original
   *   The text, in tagged corpus format.
   */
  protected static function convert($original = '') {
    $array = [];
    preg_match_all("/<([a-zA-Z0-9_ -]*):([a-zA-Z0-9_ -]*)>/", $original, $matches, PREG_SET_ORDER);
    if (isset($matches[0])) {
      // Store <TAGNAME: VALUE> strings.
      foreach ($matches as $key => $values) {
        $array[trim($values[1])] = trim($values[2]);
      }
    }

    // Remove tags and parse each line into an array element.
    $untagged = preg_replace("/<([a-zA-Z0-9_ -]*):([a-zA-Z0-9_ -]*)>/", "", $original);
    $clean = '';
    $lines = preg_split('/((\r?\n)|(\n?\r))/', htmlspecialchars($untagged, ENT_NOQUOTES));
    $end = end($lines);
    foreach ($lines as $key => $line) {
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
    return $array;
  }

}
