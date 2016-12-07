<?php

use PHPUnit\Framework\TestCase;
use helionogueir\filecreator\tool\NameGenarator;

class NameGenaratorTest extends TestCase {

  public function testUniqueName() {
    $name = NameGenarator::uniqueName();
    $this->assertTrue((bool) strlen($name));
  }

}
