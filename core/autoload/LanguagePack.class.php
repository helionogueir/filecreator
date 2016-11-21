<?php

namespace helionogueir\filecreator\autoload;

/**
 * Language pattern:
 * - Define package of language
 * - Define directory of languages
 *
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.0.0
 */
class LanguagePack {

  const PACKAGE = 'helionogueir/filecreator';
  const PATH = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

  /**
   * Block construct the class, because this class is static
   * @return false
   */
  public function __construct() {
    return false;
  }

}
