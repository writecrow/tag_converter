# TagConverter

A PHP library for converting files tagged with corpus metadata to JSON or PHP.

[![Circle CI](https://circleci.com/gh/markfullmer/tag-converter.svg?style=shield)](https://circleci.com/gh/markfullmer/tag-converter)

**Requires**: PHP 5.3+

**Requires**: Composer

**Lead Developer**: [@markfullmer](https://github.com/markfullmer)

## Basic Usage
The included `index.php` file contains conversion form to try out.

Installation
```bash
git clone git@github.com:markfullmer/tag-converter.git
cd tag-converter
composer install
```
As shown in `index.php`, add the library to your file & the Composer autoloader:

```php
require 'vendor/autoload.php';

use markfullmer\TagConverter\TagConverter;
```

Then pass a string of text into the class:
```php
$text = new TagConverter('<MyTag: 123>My tagged text here');
```

Then choose which of the formats you want to convert to:
```php
$json = $text->json();
echo $json;
// Returns {"MyTag":"123","text":"My tagged text here"}

$php = $text->php();
echo $php;
// Returns array('MyTag' => '123', 'text' => 'My tagged text here')
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

## History

Corpus linguistics researchers use a markup-like syntax to provide metadata
about texts. For consumption by applications, this syntax needs to be converted
into a more universal, machine-readable format. The format chosen was JSON.

## Testing
Unit Tests can be run (after ```composer install```) simply by executing:
```bash
phpunit
```
