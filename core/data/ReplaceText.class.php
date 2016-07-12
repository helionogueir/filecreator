<?php

namespace helionogueir\filecreator\data;

use SplFileObject;
use helionogueir\typeBoxing\type\String;
use helionogueir\foldercreator\folder\Create;

/**
 * File text replace:
 * - Check if file exists;
 * - Replace data;
 *
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.0.0
 */
class ReplaceText {

  /**
   * Make file:
   * - Relaplce data;
   * 
   * @param helionogueir\typeBoxing\type\String $filename Filename
   * @param Array $data Data Replace
   * @return null Without return
   */
  public final function make(String $filename, Array $data) {
    global $PATH;
    $filenameCache = $filename;
    if (!$filename->isEmpty() && file_exists($filename) && is_file($filename) && count($data)) {
      $folder = new Create();
      $directory = $PATH->cache . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'notify' . DIRECTORY_SEPARATOR . 'exception';
      if ($folder->make(new String($directory))) {
        sleep(1);
        $file = new SplFileObject($filename, 'r');
        $filecache = new SplFileObject($directory . DIRECTORY_SEPARATOR . time() . "_{$file->getBasename()}", 'w+');
        while (!$file->eof()) {
          $text = $file->fgets();
          if (!empty($text)) {
            foreach ($data as $key => $value) {
              $text = preg_replace("#(\{data\:{$key}\})#i", $value, $text);
            }
          }
          $filecache->fwrite($text);
          $filecache->fflush();
        }
        @chmod($filecache->getPathname(), 0777);
        $filenameCache = new String($filecache->getPathname());
      }
    }
    return $filenameCache;
  }

}
