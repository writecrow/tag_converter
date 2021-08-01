<?php

/**
 * @file
 * Demonstration file of using TagConverter library.
 */

require 'vendor/autoload.php';

use writecrow\TagConverter\TagConverter;

$file = file_get_contents('test/data/file-with-traditional-structure.txt', FILE_USE_INCLUDE_PATH);

$text = TagConverter::php($file);

  echo '<div><pre><code>';
  print_r($text);
  echo '</code></pre></div>';
