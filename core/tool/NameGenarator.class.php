<?php

namespace helionogueir\filecreator\tool;

/**
 * - Generate unique name text
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.1.0
 */
abstract class NameGenarator {

  /**
   * - Create unique name
   * @param string $pathname Pathname by file to be read
   * @param bool $download Force download info
   * @return null
   */
  public static final function uniqueName(): string {
    sleep(1);
    return Date('Ymdhis') . md5(mt_rand(strtotime('-20 years'), time()));
  }

}
