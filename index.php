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

include 'head.html';

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
<h3>Design & behavior</h3>
<ol>
<li>Tags must be wrapped in <code>&lt;</code> and <code>&gt;</code></li>
<li>Tag names and tag values may only alphanumeric characters, spaces, underscores, and hypens.</li>
<li>Tag names must be separated from tag values by a <code>:</code></li>
<li>Spaces at the beginning at end of tag names or tag values are ignored; spaces within tag values will be preserved</li>
<li>Items with multiple values may be indicated by a pipe (|) character or semicolon (;)</li>
<li>Everything not wrapped in <code>&lt;</code> and <code>&gt;</code> will be considered "text"</li>
</ol>

<table>
<thead>
<tr>
<th>Status</th>
<th>Tag Example</th>
<th>Explanation</th>
</tr>
</thead>
<tbody>
<tr>
<td>Good</td>
<td><code>&lt;MyTag:SomeText&gt;</code></td>
<td></td>
</tr>
<tr>
<td>Good</td>
<td><code>&lt;My Tag:Some Text&gt;</code></td>
<td>Spaces in tag names &amp; values OK</td>
</tr>
<tr>
<td>Good</td>
<td><code>&lt; My Tag : Some Text &gt;</code></td>
<td>Spaces padding tag names &amp; values OK</td>
</tr>
<tr>
<td>Good</td>
<td><code>&lt; My-Tag : Some_Text &gt;</code></td>
<td>Underscores &amp; hyphens OK</td>
</tr>
<tr>
<td>Good</td>
<td><code>&lt; My-Tag : First value | Second value&gt;</code></td>
<td>Pipe or semicolon used to indicate multiple values</td>
</tr>
<tr>
<td>Bad</td>
<td><code>&lt; My/Tag : Some:Text &gt;</code></td>
<td>Other characters not OK</td>
</tr>
</tbody>
</table>
</div>
</body>
</html>';
