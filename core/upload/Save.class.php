<?php

namespace helionogueir\filecreator\upload;

use Exception;
use helionogueir\languagepack\Lang;
use helionogueir\typeBoxing\type\String;
use helionogueir\typeBoxing\type\Integer;
use helionogueir\foldercreator\folder\Create;
use helionogueir\filecreator\tool\NameGenarator;

/**
 * Read file:
 * - Check if file exists;
 * - Flush the file;
 *
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.0.0
 */
class Save {

  private $pattern = '/^(.*)\.(.*)$/';
  private $chmod = 0777;

  public function mount(String $filename, String $directoryDestiny, Array $extentions = Array()) {
    $filepath = null;
    if (!$filename->isEmpty() && !$directoryDestiny->isEmpty()) {
      $this->filename = $filename;
      $this->directoryDestiny = $directoryDestiny;
      if (count($extentions)) {
        $this->extentions = $extentions;
      }
      if ($this->prepareDirectory($directoryDestiny) && $this->checkExtention($filename, $extentions)) {
        if ($destination = $this->prepareFileObject($filename, $directoryDestiny)) {
          @chmod($destination, $this->chmod);
          $filepath = new String($destination);
        }
      }
    } else {
      Lang::addRoot(new String(\helionogueir\filecreator\autoload\LanguagePack::PACKAGE), new String(\helionogueir\filecreator\autoload\LanguagePack::PATH));
      throw new Exception(Lang::get(new String('filecreator:upload:save:notfound'), new String('filecreator:upload')));
    }
    return $filepath;
  }

  private function prepareDirectory(String $directory) {
    $dir = new Create();
    return $dir->make($directory, new Integer($this->chmod));
  }

  private function prepareFileObject(String $filename, String $directoryDestiny) {
    $filepath = false;
    if (isset($_FILES["{$filename}"], $_FILES["{$filename}"]['name'], $_FILES["{$filename}"]['type'], $_FILES["{$filename}"]['tmp_name'], $_FILES["{$filename}"]['error'])) {
      if (!(bool) $_FILES["{$filename}"]['error'] && is_uploaded_file($_FILES["{$filename}"]['tmp_name'])) {
        if ($destination = $directoryDestiny . DIRECTORY_SEPARATOR . $this->prepareFilename($filename)) {
          if (move_uploaded_file($_FILES["{$filename}"]['tmp_name'], $destination)) {
            $filepath = $destination;
          }
        }
      }
    }
    return $filepath;
  }

  private function checkExtention(String $filename, Array $extentions) {
    $auth = true;
    if (count($extentions)) {
      if (isset($_FILES["{$filename}"], $_FILES["{$filename}"]['type'])) {
        $pattern = '/(' . implode(')|(', $extentions) . ')/i';
        $auth = preg_match($pattern, $_FILES["{$filename}"]['type']);
      }
    }
    return $auth;
  }

  private function prepareFilename(String $filename) {
    $name = null;
    if (isset($_FILES["{$filename}"], $_FILES["{$filename}"]['name']) && preg_match($this->pattern, $_FILES["{$filename}"]['name'])) {
      sleep(1);
      $extention = preg_replace($this->pattern, '$2', $_FILES["{$filename}"]['name']);
      $name = new String(NameGenarator::uniqueName() . ".{$extention}");
    }
    return $name;
  }

}
