<?php

namespace writecrow\TagConverter;

/**
 * Class TagConverter.
 *
 * A helper class to convert Tagged corpus text to universal formats.
 *
 * @author markfullmer <mfullmer@gmail.com>
 *
 * @link https://github.com/writecrow/tag-converter/
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
    $array = self::convert($original);
    $xml_data = new \SimpleXMLElement('<?xml version="1.0"?><data></data>');
    self::arrayToXml($array, $xml_data);
    return $xml_data->asXML();
  }

  /**
   * Additional logic to convert to XML syntax.
   */
  public static function arrayToXml($data, &$xml_data) {
    foreach ($data as $key => $value) {
      if (is_numeric($key)) {
        $key = 'item' . $key;
      }
      if (is_array($value)) {
        $subnode = $xml_data->addChild($key);
        self::arrayToXml($value, $subnode);
      }
      else {
        $xml_data->addChild("$key", htmlspecialchars("$value"));
      }
    }
  }

  /**
   * Convert tag format into PHP array.
   *
   * @param string $original
   *   The text, in tagged corpus format.
   */
  protected static function convert($original = '') {
    $array = [];
    // Only search for tags within header section, if demarcated.
    $header_split = preg_split('/<End Header>/', $original);
    preg_match_all("/<([a-zA-Z0-9_ -\(\)\/]*):([a-zA-Z0-9_&;, \-\(\)\/]*)>/", $original, $matches, PREG_SET_ORDER);
    if (isset($matches[0])) {
      // Store <TAGNAME: VALUE> strings.
      foreach ($matches as $key => $values) {
        $values[2] = trim($values[2]);
        $multiple_terms = preg_grep('/;/', explode("\n", $values[2]));
        if (!empty($multiple_terms)) {
          $terms = preg_split('/;/', $values[2]);
          foreach ($terms as $i => &$term) {
            if (empty($term)) {
              unset($terms[$i]);
            }
            $term = (string) trim($term);
          }
        }
        else {
          $terms = (string) trim($values[2]);
        }
        $array[trim($values[1])] = $terms;
      }
    }

    // Remove tags and parse each line into an array element.
    if (isset($header_split[1])) {
      $untagged = $header_split[1];
    }
    else {
      $untagged = preg_replace("/<([a-zA-Z0-9_ -\(\)\/]*):([a-zA-Z0-9_&;, \-\(\)\/]*)>/", "", $original);
      $untagged = str_replace('<End Header>', '', $untagged);
    }
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
