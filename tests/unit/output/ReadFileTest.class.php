<?php

use PHPUnit\Framework\TestCase;
use helionogueir\filecreator\output\ReadFile;

class ReadFileTest extends TestCase {

  public function testRead() {
    $this->assertInstanceOf("helionogueir\\filecreator\\output\\ReadFile", (new ReadFile()));
  }

}
