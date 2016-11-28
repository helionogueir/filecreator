<?php

namespace helionogueir\filecreator\data;

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
   * @param string $text
   * @param Array $data
   * @return string
   */
  public function replace(string $text, Array $data) {
    $replaceText = "{$text}";
    if (!empty($text) && count($data)) {
      foreach ($data as $key => $value) {
        $replaceText = preg_replace("#(\{data\:{$key}\})#i", $value, $replaceText);
      }
    }
    return $replaceText;
  }

}
