# [File Creator](https://github.com/helionogueir/filecreator)

A simple library for read, create, manipulate files.

## Installation

Composer (https://getcomposer.org/) and (https://packagist.org/)
```sh
composer require helionogueir/filecreator
```
Manual
```php
require_once ("./filecreator/core/autoload/register.inc");
```
------
## Usage

### helionogueir\filecreator\data\ReplaceText

Replace TAGs in file
```php
use helionogueir\filecreator\data\ReplaceText;
$text = "Point {data:v1} to {data:v2}";
echo (new ReplaceText())->replace($text, $data);
```
------
### helionogueir\filecreator\output\ReadFile

Read file by path name
```php
use helionogueir\filecreator\output\ReadFile;
(new ReadFile())->read(__FILE__, true);
```
------
### helionogueir\filecreator\tool\NameGenarator

Create unique random namespace
```php
use helionogueir\filecreator\tool\NameGenarator;
echo NameGenarator::uniqueName();
```
------
## TDD (Test Driven Development)

PHPUnit (https://phpunit.de/)
```sh
phpunit -c ./filecreator/tests/unit.xml
```
