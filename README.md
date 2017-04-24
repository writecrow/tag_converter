# Corpus-tagged Text Converter

[![Circle CI](https://circleci.com/gh/writecrow/tag-converter.svg?style=shield)](https://circleci.com/gh/writecrow/tag-converter)

A PHP library for converting files tagged with corpus metadata to JSON, PHP,
or XML.

![Screenshot of Conversion](https://raw.githubusercontent.com/markfullmer/tag-converter/master/demo/tagging-example.png)

## History
Corpus linguistics researchers use a markup-like syntax to provide metadata
about texts. For consumption by applications, this syntax needs to be converted
into a more universal, machine-readable format. The format chosen was JSON.

## Basic Usage
The included `/demo/index.php` file contains a conversion form demonstration.

Make your code aware of the TagConverter class via your favorite method (e.g.,
`use` or `require`)

Then pass a string of text into the class:
```php
$text = TagConverter::json('<MyTag: 123>My tagged text here');
echo $text;
// Returns {"MyTag":"123","text":"My tagged text here"}

$text = TagConverter::php('<MyTag: 123>My tagged text here');
echo $text;
// Returns array('MyTag' => '123', 'text' => 'My tagged text here')

$text = TagConverter::xml('<MyTag: 123>My tagged text here');
echo $text;
// Returns <?xml version="1.0"?><root><MyTag>123</MyTag><text>My tagged text here</text></root>
```

## Expected input format
The corpus style tagging syntax expected by the library is defined as follows:
1. Tags must be wrapped in ```<``` and ```>```
2. Tag names and tag values may only alphanumeric characters, spaces,
underscores, and hypens.
3. Tag names must be separated from tag values by a ```:```
4. Spaces at the beginning at end of tag names or tag values are ignored;
spaces within tag values will be preserved
5. Everything not wrapped in ```<``` and ```>``` will be considered "text"

| Status | Tag Example | Explanation
| --- | --- | --- |
| Good | ```<MyTag:SomeText>``` | |
| Good | ```<My Tag:Some Text>``` | Spaces in tag names & values OK |
| Good | ```< My Tag : Some Text >``` | Spaces padding tag names & values OK|
| Good | ```< My-Tag : Some_Text >``` | Underscores & hyphens OK|
| Bad | ```< My/Tag : Some:Text >``` | Other characters not OK|

## Testing
Unit Tests can be run (after ```composer install```) by executing ```phpunit```
