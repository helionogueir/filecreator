<?php

namespace helionogueir\filecreator\data;

use helionogueir\typeBoxing\type\String;

/**
 * Text replace:
 * - Replace TAGs in the text;
 *
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.0.0
 */
class ReplaceText {

  /**
   * Replace TAGs:
   * - Find and replace TAGs in the text
   * 
   * @param helionogueir\typeBoxing\type\String $text
   * @param Array $data
   * @return helionogueir\typeBoxing\type\String
   */
  public function replace(String $text, Array $data) {
    $replaceText = "{$text}";
    if (!$text->isEmpty() && count($data)) {
      foreach ($data as $key => $value) {
        $replaceText = preg_replace("#(\{data\:{$key}\})#i", $value, $replaceText);
      }
    }
    return new String($replaceText);
  }

}
