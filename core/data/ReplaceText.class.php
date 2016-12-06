<?php

namespace helionogueir\filecreator\data;

/**
 * - Replace text tagname(s)
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.1.0
 */
class ReplaceText {

  /**
   * - Get text and replace tagname(s)
   * @param string $text Text with tagname(s)
   * @param Array $data Array with value(s) of tagname(s)
   * @return string Return text with tagname(s) replaced
   */
  public function replace(string $text, Array $data): string {
    $replaceText = $text;
    if (!empty($text) && count($data)) {
      foreach ($data as $key => $value) {
        $replaceText = preg_replace("#(\{data\:{$key}\})#i", $value, $replaceText);
      }
    }
    return $replaceText;
  }

}
