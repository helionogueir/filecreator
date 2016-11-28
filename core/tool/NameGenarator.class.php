<?php

namespace helionogueir\filecreator\tool;

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
   * @return string
   */
  public static final function uniqueName() {
    sleep(1);
    return Date('Ymdhis') . md5(mt_rand(strtotime('-20 years'), time()));
  }

}
