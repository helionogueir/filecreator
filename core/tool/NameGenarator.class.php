<?php

namespace helionogueir\filecreator\tool;

use helionogueir\typeBoxing\type\String;

/**
 * Name generator:
 * - Generate unique name text
 *
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.0.0
 */
class NameGenarator {

  /**
   * Block construct the class, because this class is static
   * @return false
   */
  public function __construct() {
    return false;
  }

  /**
   * Create name:
   * - Create unique name
   * 
   * @return helionogueir\typeBoxing\type\String
   */
  public static final function uniqueName() {
    sleep(1);
    return new String(Date('Ymdhis') . md5(mt_rand(strtotime('-20 years'), time())));
  }

}
