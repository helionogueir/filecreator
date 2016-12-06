<?php

namespace helionogueir\filecreator\tests\unit\data;

use PHPUnit\Framework\TestCase;
use helionogueir\filecreator\data\ReplaceText;

class ReplaceTextTest extends TestCase {

  public function testReplace() {
    $text = "Point A to B";
    $replace = "Point {data:v1} to {data:v2}";
    $data = Array("v1" => "A", "v2" => "B");
    $this->assertEquals($text, (new ReplaceText())->replace($replace, $data));
  }

  public function testReplaceFail() {
    $replace = "Point {data:v1} to {data:v2}";
    $data = Array("v3" => "A", "v4" => "B");
    $this->assertEquals($replace, (new ReplaceText())->replace($replace, $data));
  }

}
