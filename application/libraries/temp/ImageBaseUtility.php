<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'TypeVerify.php';

class ImageBaseUtility extends TypeVerify {
  private $fileName = null;

  public function __construct ($fileName = null) {
    if ($this->verifyArrayFormat ($fileName, array ('fileName'))) $fileName = $fileName['fileName'];

    if ($this->verifyFileReadable ($fileName)) {
      $this->fileName = $fileName;
    } else {
      $this->showError("<fr>Error!</fr> The image file : " . $fileName . " not found or not readable!\nPlease confirm your program again.");
    }
  }

  protected function getFileName () { return $this->fileName; }

  protected function createDimension ($width, $height) {
    return ($this->verifyNumber ($width, 1) && $this->verifyNumber ($height, 1)) ? array (
      'width'  => intval ($width),
      'height' => intval ($height)
    ) : $this->showError ("<fr>Error!</fr> Create dimension Error!\nPlease confirm your program again.");
  }

  protected function verifyDegree ($degree) {
    return $this->verifyNumber ($degree);
  }

  protected function verifyColor ($color, $type = null) {
    if (!$this->verifyItemInArray ($type, array ('Array', 'String'))) return ($this->verifyArray ($color, 3) && $this->verifyNumber ($color[0], 0, 255) && $this->verifyNumber ($color[1], 0, 255) && $this->verifyNumber ($color[2], 0, 255)) || ($this->verifyString ($color));
    else return $type == 'Array' ? ($this->verifyArray ($color, 3) && $this->verifyNumber ($color[0], 0, 255) && $this->verifyNumber ($color[1], 0, 255) && $this->verifyNumber ($color[2], 0, 255)) : ($type == 'String' ? ($this->verifyString ($color)) : false);
  }

  protected function verifyStartXY ($startX, $startY, $min = 0) {
    return $this->verifyNumber ($startX, $min) && $this->verifyNumber ($startY, $min);
  }

  protected function verifyPercent ($percent, $min = 1, $max = 100) {
    return $this->verifyNumber ($percent, $min, $max);
  }

  protected function calcWidth ($dimension, $newDimension) {
    $newWidthPercentage = (100 * $newDimension['width']) / $dimension['width'];
    $height             = ($dimension['height'] * $newWidthPercentage) / 100;
    return $this->createDimension ($newDimension['width'], $height);
  }

  protected function calcHeight ($dimension, $newDimension) {
    $newHeightPercentage  = (100 * $newDimension['height']) / $dimension['height'];
    $width                = ($dimension['width'] * $newHeightPercentage) / 100;
    return $this->createDimension ($width, $newDimension['height']);
  }

  protected function calcImageSize ($dimension, $newDimension) {
    $newSize = $this->createDimension ($dimension['width'], $dimension['height']);

    if ($newDimension['width'] > 0) {
      $newSize = $this->calcWidth ($dimension, $newDimension);
      if (($newDimension['height'] > 0) && ($newSize['height'] > $newDimension['height']))
        $newSize = $this->calcHeight($dimension, $newDimension);
    }
    
    if ($newDimension['height'] > 0) {
      $newSize = $this->calcHeight ($dimension, $newDimension);
      if (($newDimension['width'] > 0) && ($newSize['width'] > $newDimension['width']))
        $newSize = $this->calcWidth ($dimension, $newDimension);
    }
    
    return $newSize;
  }

  protected function calcImageSizePercent ($percent, $dimension) {
    $width  = ceil (($dimension['width'] * $percent) / 100);
    $height = ceil (($dimension['height'] * $percent) / 100);
    
    return $this->createDimension ($width, $height);
  }

  protected function calcImageSizeStrict ($dimension, $newDimension) {
    $newSize = $this->createDimension ($newDimension['width'], $newDimension['height']);
    
    if ($newDimension['width'] >= $newDimension['height']) {
      if ($dimension['width'] > $dimension['height'])  {
        $newSize = $this->calcHeight ($dimension, $newDimension);
        
        if ($newSize['width'] < $newDimension['width']) {
          $newSize = $this->calcWidth ($dimension, $newDimension);
        }
      } else if ($dimension['height'] >= $dimension['width']) {
        $newSize = $this->calcWidth ($dimension, $newDimension);
        
        if ($newSize['height'] < $newDimension['height']) {
          $newSize = $this->calcHeight ($dimension, $newDimension);
        }
      }
    } else if ($newDimension['height'] > $newDimension['width']) {
      if ($dimension['width'] >= $dimension['height']) {
        $newSize = $this->calcWidth ($dimension, $newDimension);
        
        if ($newSize['height'] < $newDimension['height']) {
          $newSize = $this->calcHeight ($dimension, $newDimension);
        }
      } else if ($dimension['height'] > $dimension['width']) {
        $newSize = $this->calcHeight ($dimension, $newDimension);
        
        if ($newSize['width'] < $newDimension['width']) {
          $newSize = $this->calcWidth ($dimension, $newDimension);
        }
      }
    }
    return $newSize;
  }
}