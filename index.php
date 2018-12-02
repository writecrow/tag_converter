<?php

/**
 * @file
 * Demonstration file of using TagConverter library.
 */

require 'vendor/autoload.php';

use writecrow\TagConverter\TagConverter;

$file = file_get_contents('demo_text.txt', FILE_USE_INCLUDE_PATH);
if (isset($_POST['text'])) {
  $file = $_POST['text'];
}
echo '<!DOCTYPE html>
<html>
<head>
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.css">
<style>
  .textbox { height:-webkit-fill-available; }
  pre > code {
    white-space: pre-line;
  }
</style>
</head>
<body>';

echo '
<div class="container">
<h1>Tagged corpus text converter</h1>
<a href="https://github.com/writecrow/tag_converter">Source code</a>
<hr />
</div>
<div class="container">
  <form action="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '" method="POST">
    <div class="row">
      <div class="six columns">
        <label for="text">Tagged text to be converted</label>
        <textarea class="u-full-width textbox" placeholder="Place tagged text here..." name="text">' . $file . '</textarea>
      </div>
      <div class="six columns">
      <input type="submit" name="json" value="Convert to JSON" />
      <input type="submit" name="php" value="Convert to PHP" />
      <input type="submit" name="xml" value="Convert to XML" />';

if (isset($_POST['text']) && isset($_POST['json'])) {
  $text = TagConverter::json($_POST['text']);
  $json = json_decode($text);
  echo '<div><pre><code>';
  echo json_encode($json, JSON_PRETTY_PRINT);
  echo '</code></pre></div>';
}
elseif (isset($_POST['text']) && isset($_POST['php'])) {
  $text = TagConverter::php($_POST['text']);
  echo '<div><pre><code>';
  print_r($text);
  echo '</code></pre></div>';
}
elseif (isset($_POST['text']) && isset($_POST['xml'])) {
  $text = TagConverter::xml($_POST['text']);
  echo '<div><pre><code>';
  // Deal with XML-specific non-visible space for display.
  $text = str_replace('&#xFEFF;', '', $text);
  echo htmlspecialchars($text);
  echo '</code></pre></div>';
}

echo '
      </div>
    </div>
  </form>
</div>
</body>
</html>';
