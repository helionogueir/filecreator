<?php

namespace helionogueir\filecreator\tool;

use helionogueir\typeBoxing\type\String;

/**
 * Read file:
 * - Check if file exists;
 * - Flush the file;
 *
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.0.0
 */
class NameGenarator {

  public function __construct() {
    return false;
  }

  public static final function uniqueName() {
    return new String(Date('Ymdhis') . md5(mt_rand(strtotime('-20 years'), time())));
  }

}
