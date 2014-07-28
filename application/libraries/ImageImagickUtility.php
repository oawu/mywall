<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'ImageBaseUtility.php';

class ImageImagickUtility extends ImageBaseUtility {
  private $isError      = true;
  private $options      = null;
  private $mime         = null;
  private $format       = null;
  private $image        = null;
  private $dimension    = null;

  private $d4_valid_formats = null;
  private $d4_options       = null;

  public function __construct ($fileName = null, $options = array ()) {
    if ($this->verifyArrayFormat ($fileName, array ('fileName'))) $fileName = $fileName['fileName'];

    if ($this->verifyFileReadable ($fileName) && $this->verifyArray ($options, 0)) {
      parent::__construct ($fileName);
      
      $this->_initD4Variable ();
      $this->_setOptions ($options);
      $this->_setSavePath ();

      if (!$this->verifyFolderWriteable ($this->options['absolute_path'])) $this->showError ("<fr>Error!</fr> The save folder path is not exist or not folder or can not be <fr>write</fr>!\nFolder path : " . $this->options['absolute_path'] . "\nPlease confirm your program again.");
      
      $this->_setBaseInfo ();
      ini_set("memory_limit", $this->options['memory_limit']);
      $this->isError = false;

    }
  }

  public function saveAnalysisChart ($fileName, $maxCount = 10, $fontSize = 14, $font = "monaco.ttf", $rawData = true) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyFileReadable ($font)) $this->showError("<fr>Error!</fr> The font file - " . $font . " not found or not readable!\nPlease confirm your program again.");

    $format = pathinfo ($fileName, PATHINFO_EXTENSION);
    if (!$this->verifyItemInArray ($format, $this->d4_valid_formats)) $this->showError ("<fr>Error!</fr> This save file format is no support!\nPlease confirm your file save format again.");
    
    $datas = $this->getAnalysisDatas ($maxCount);
    if (!$this->verifyArray ($datas)) $this->showError ("<fr>Error!</fr> The image get analysis datas error!\nPlease confirm your permissions again.");
    
    $workingImage = new Imagick ();

    foreach ($datas as $data) {
      $workingImage->newImage (400, 20, new ImagickPixel ('white'));
      
      $draw = new ImagickDraw ();
      $draw->setFont ($font);
      $draw->setFontSize ($fontSize);
      $workingImage->annotateImage ($draw, 25, 14, 0, 'Percentage of total pixels : ' . (strlen ($data['percent'])<2?' ':'') . $data['percent'] . '% (' . $data['count'] . ')');
      
      $tile = new Imagick ();
      $tile->newImage (20, 20, new ImagickPixel('rgb(' . $data['color']['r'] . ',' . $data['color']['g'] . ',' . $data['color']['b'] . ')'));

      $workingImage->compositeImage ($tile, Imagick::COMPOSITE_OVER, 0, 0);
    }

    $workingImage = $workingImage->montageImage (new imagickdraw (), "1x".count ($datas)."+0+0", "400x20+4+2>", imagick::MONTAGEMODE_UNFRAME, "0x0+3+3" );

    $workingImage->setImageFormat ($format);
    $workingImage->setFormat ($format);
    
    $fileName = $this->utilitySameLevelPath ($this->options['absolute_path'] . '/' . $fileName);
    $workingImage->writeImages ($fileName, $rawData);
    return $this;
  }

  public function getAnalysisDatas ($maxCount = 10) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    
    $temp = $this->image->clone ();

    $temp->quantizeImage ($maxCount, Imagick::COLORSPACE_RGB, 0, false, false );
    $pixels = $temp->getImageHistogram();

    $datas = array ();
    $index = 0;
    $pixelCount = $this->dimension['width'] * $this->dimension['height'];

    if (count($pixels) && ($maxCount > 0)) {
      foreach($pixels as $pixel) {
        if ($index++ < $maxCount) {
          $datas[] = array ( 'color'   => $pixel->getColor(),
                             'count'   => $pixel->getColorCount(),
                             'percent' => round (($pixel->getColorCount()/$pixelCount)*100));
        }
      }
    }
    return $this->_sort2dArray ('count', $datas);
  }

  private function _sort2dArray ($key, $list) {
    if (count ($list)) {
      $tmp = array ();
      foreach($list as &$ma) $tmp[] = &$ma[$key]; 
      array_multisort ($tmp, SORT_DESC, $list); 
    }
    return $list;
  }

  public function addFont ($text, $startX = 0, $startY = 12, $color = 'black', $fontSize = 12, $alpha = 1, $degree = 0, $font = 'monaco.ttf') {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyString ($text)) $this->showError ("<fr>Error!</fr> The text format error.\nIt must be a string!\nPlease confirm your program again.");
    if (!$this->verifyStartXY ($startX, $startY, 0)) $this->showError ("<fr>Error!</fr> The start point format error.\nIt must be a numeric bigger or equal than zero.\nPlease confirm your program again.");
    if (!$this->verifyColor ($color, 'String')) $this->showError ("<fr>Error!</fr> The new color format error.\nIt must be a string, which format like 'blue', '#0000ff', 'rgb(0,0,255)', 'cmyk(100,100,100,10)'.\nPlease confirm your program again.");
    if (!$this->verifyNumber ($fontSize, 1)) $this->showError ("<fr>Error!</fr> The font size format error.\nIt must be a numeric bigger or equal than one.\nPlease confirm your program again.");
    if (!$this->verifyNumber ($alpha, 0, 1)) $this->showError ("<fr>Error!</fr> The alpha format error.\nIt must be a float from 0 to 1.\nPlease confirm your program again.");
    if (!$this->verifyDegree ($degree)) $this->showError ("<fr>Error!</fr> The degree format error.\nIt must be a numeric.\nPlease confirm your program again.");
    if (!$this->verifyFileReadable ($font)) $this->showError("<fr>Error!</fr> The font file - " . $font . " not found or not readable!\nPlease confirm your program again.");

    $draw = $this->_createFont ($font, $fontSize, $color, $alpha);

    if ($this->format == 'gif') {
      $workingImage = new Imagick ();
      $workingImage->setFormat ($this->format);

      $imagick = $this->image->clone ()->coalesceImages ();

      do {
        $temp = new Imagick ();
        
        $temp->newImage ($this->dimension['width'], $this->dimension['height'], new ImagickPixel ('transparent'));
        $temp->compositeImage ($imagick, imagick::COMPOSITE_DEFAULT, 0, 0);
        $temp->annotateImage ($draw, $startX, $startY, $degree, $text);
        
        $workingImage->addImage ($temp);
        $workingImage->setImageDelay ($imagick->getImageDelay ());
      } while ($imagick->nextImage ());
    } else {
      $workingImage = $this->image->clone ();
      $workingImage->annotateImage ($draw, $startX, $startY, $degree, $text);
    }

    return $this->_updateImage ($workingImage);
  }

  private function _createFont ($font, $fontSize, $color, $alpha) {
    $draw = new ImagickDraw ();
    $draw->setFont ($font);
    $draw->setFontSize ($fontSize);
    $draw->setFillColor ($color);
    $draw->setFillAlpha ($alpha);
    return $draw;
  }

  public function lomography () {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    
    $workingImage = new Imagick ();
    $workingImage->setFormat ($this->format);

    if ($this->format == 'gif') {
      $imagick = $this->image->clone ()->coalesceImages();
      do {
        $temp = new Imagick();

        $imagick->setimagebackgroundcolor ("black");
        $imagick->gammaImage (0.75);
        $imagick->vignetteImage (0, max ($this->dimension['width'], $this->dimension['height']) * 0.2, 0 - ($this->dimension['width'] * 0.05), 0 - ($this->dimension['height'] * 0.05));

        $temp->newImage ($this->dimension['width'], $this->dimension['height'], new ImagickPixel ('transparent'));
        $temp->compositeImage ($imagick, imagick::COMPOSITE_DEFAULT, 0, 0);
         
        $workingImage->addImage ($temp);
        $workingImage->setImageDelay ($imagick->getImageDelay ());
      } while ($imagick->nextImage ());
    } else {
      $workingImage = $this->image->clone ();
      $workingImage->setimagebackgroundcolor("black");
      $workingImage->gammaImage (0.75);
      $workingImage->vignetteImage (0, max ($this->dimension['width'], $this->dimension['height']) * 0.2, 0 - ($this->dimension['width'] * 0.05), 0 - ($this->dimension['height'] * 0.05));
    }
    return $this->_updateImage ($workingImage);
  }

  private function _machiningImageFilter ($radius, $sigma, $channel) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    
    $workingImage = $this->image->clone ();

    if ($this->format == 'gif') {
      $workingImage = $workingImage->coalesceImages();
      do {
        $workingImage->adaptiveBlurImage ($radius, $sigma, $channel);
      } while ($workingImage->nextImage());
      $workingImage = $workingImage->deconstructImages();
    } else {
      $workingImage->adaptiveBlurImage ($radius, $sigma, $channel);
    }
    return $workingImage;
  }

  public function filter ($radius, $sigma, $channel = Imagick::CHANNEL_DEFAULT) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    
    $items = array (imagick::CHANNEL_UNDEFINED, imagick::CHANNEL_RED,     imagick::CHANNEL_GRAY,  imagick::CHANNEL_CYAN,
                    imagick::CHANNEL_GREEN,     imagick::CHANNEL_MAGENTA, imagick::CHANNEL_BLUE,  imagick::CHANNEL_YELLOW,
                    imagick::CHANNEL_ALPHA,     imagick::CHANNEL_OPACITY, imagick::CHANNEL_MATTE, imagick::CHANNEL_BLACK,
                    imagick::CHANNEL_INDEX,     imagick::CHANNEL_ALL,     imagick::CHANNEL_DEFAULT);
    
    if (!$this->verifyNumber ($radius)) $this->showError ("<fr>Error!</fr> The radius format error.\nIt must be a numeric.\nPlease confirm your program again.");
    if (!$this->verifyNumber ($sigma)) $this->showError ("<fr>Error!</fr> The sigma format error.\nIt must be a numeric.\nPlease confirm your program again.");
    if (!$this->verifyItemInArray ($channel, $items)) $this->showError ("<fr>Error!</fr> The filter error.\nIt must be one of Imagick channel constants of 'CHANNEL_UNDEFINED', 'CHANNEL_RED', 'CHANNEL_GRAY', 'CHANNEL_CYAN',\n'CHANNEL_GREEN', 'CHANNEL_MAGENTA', 'CHANNEL_BLUE', 'CHANNEL_YELLOW', 'CHANNEL_ALPHA', 'CHANNEL_OPACITY', 'CHANNEL_MATTE',\n'CHANNEL_BLACK', 'CHANNEL_INDEX', 'CHANNEL_ALL' or 'CHANNEL_DEFAULT'!\nPlease confirm your program again.");
    
    $workingImage = $this->_machiningImageFilter ($radius, $sigma, $channel);
    
    return $this->_updateImage ($workingImage);
  }

  public function rotateCW ($direction = 'CW', $color = 'transparent') {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyItemInArray ($direction, array ('CW', 'CCW'))) $this->showError ("<fr>Error!</fr> The direction error.\nIt must be one of uppercase string of 'CW' or 'CCW'!\nPlease confirm your program again.");
    if (!$this->verifyColor ($color, 'String')) $this->showError ("<fr>Error!</fr> The new color format error.\nIt must be a string, which format like 'blue', '#0000ff', 'rgb(0,0,255)', 'cmyk(100,100,100,10)'.\nPlease confirm your program again.");
    return $this->rotate ($direction == 'CW' ? 90: -90);
  }

  private function _machiningImageRotate ($degree, $color = 'transparent') {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    
    $workingImage = new Imagick ();
    $workingImage->setFormat ($this->format);
    $imagick = $this->image->clone ();

    if ($this->format == 'gif') {
      $imagick->coalesceImages();
      do {
        $temp = new Imagick ();

        $imagick->rotateImage (new ImagickPixel ($color), $degree);
        $newDimension = $this->getDimension ($imagick);
        $temp->newImage ($newDimension['width'], $newDimension['height'], new ImagickPixel ($color));
        $temp->compositeImage ($imagick, imagick::COMPOSITE_DEFAULT, 0, 0);
         
        $workingImage->addImage ($temp);
        $workingImage->setImageDelay ($imagick->getImageDelay ());
      } while ($imagick->nextImage ());
    } else {
      $imagick->rotateImage (new ImagickPixel ($color), $degree);
      $newDimension = $this->getDimension ($imagick);
      $workingImage->newImage ($newDimension['width'], $newDimension['height'], new ImagickPixel ($color));
      $workingImage->compositeImage ($imagick, imagick::COMPOSITE_DEFAULT, 0, 0);
    }
    return $workingImage;
  }

  public function rotate ($degree, $color = 'transparent') {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyDegree ($degree)) $this->showError ("<fr>Error!</fr> The degree format error.\nIt must be a numeric.\nPlease confirm your program again.");
    if (!$this->verifyColor ($color, 'String')) $this->showError ("<fr>Error!</fr> The new color format error.\nIt must be a string, which format like 'blue', '#0000ff', 'rgb(0,0,255)', 'cmyk(100,100,100,10)'.\nPlease confirm your program again.");
    if (($degree % 360) == 0) return $this;
    
    $workingImage = $this->_machiningImageRotate ($degree, $color);
    
    return $this->_updateImage ($workingImage);
  }

  public function cropFromCenter ($width, $height) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyDimension ($this->createDimension ($width, $height))) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");
    
    if (($width == $this->dimension['width']) && ($height == $this->dimension['height'])) {
      return $this;
    } else if (($width > $this->dimension['width']) && ($height > $this->dimension['height'])) {
      return $this->pad ($width, $height);
    } else {
      $width  = ($this->dimension['width'] < $width) ? $this->dimension['width'] : $width;
      $height = ($this->dimension['height'] < $height) ? $this->dimension['height'] : $height;
      $cropX = intval (($this->dimension['width'] - $width) / 2);
      $cropY = intval (($this->dimension['height'] - $height) / 2);
      return $this->crop ($cropX, $cropY, $width, $height);
    }
  }
  
  public function crop ($startX, $startY, $width, $height) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyStartXY ($startX, $startY, 0)) $this->showError ("<fr>Error!</fr> The start point format error.\nIt must be a numeric bigger or equal than zero.\nPlease confirm your program again.");
    if (!$this->verifyDimension ($this->createDimension ($width, $height))) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");
    if (($startX == 0) && ($startY == 0) && ($width == $this->dimension['width']) && ($height == $this->dimension['height'])) return $this;
   
    $width  = ($this->dimension['width'] < $width) ? $this->dimension['width'] : $width;
    $height = ($this->dimension['height'] < $height) ? $this->dimension['height'] : $height;
    if (!$this->verifyDimension ($this->createDimension ($width, $height))) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");

    if (($startX + $width) > $this->dimension['width']) $startX = ($this->dimension['width'] - $width);
    if (($startY + $height) > $this->dimension['height']) $startY = ($this->dimension['height'] - $height);
    if (!$this->verifyStartXY ($startX, $startY, 0)) $this->showError ("<fr>Error!</fr> The start point format error.\nIt must be a numeric bigger or equal than zero.\nPlease confirm your program again.");
    
    $workingImage = $this->_machiningImageCrop ($startX, $startY, $width, $height);
    
    return $this->_updateImage ($workingImage);
  }

  public function resizePercent ($percent = 0) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyPercent ($percent, 1, null)) $this->showError ("<fr>Error!</fr> The percent of the position error.\nIt must be a numeric bigger or equal than one.\nPlease confirm your program again.");
    if ($percent == 100) return $this;

    $newDimension = $this->calcImageSizePercent ($percent, $this->dimension);
    if (!$this->verifyDimension ($newDimension)) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");

    return $this->resize ($newDimension['width'], $newDimension['height']);
  }

  public function adaptiveResizeQuadrant ($width, $height, $item = 'C') {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyDimension ($this->createDimension ($width, $height))) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");
    if (!$this->verifyItemInArray ($item, array ('C', 'R', 'L', 'T', 'B'))) $this->showError ("<fr>Error!</fr> The quadrant error.\nIt must be one of uppercase characters of 'C', 'T', 'B', 'L' or 'R'!\nPlease confirm your program again.");
    
    if(($width == $this->dimension['width']) && ($height == $this->dimension['height'])) {
      return $this;
    } else if ($this->options['resizeUp'] === false) {
      $newDimension['height']  = (intval ($height) > $this->dimension['height']) ? $this->dimension['height'] : $height;
      $newDimension['width']   = (intval ($width) > $this->dimension['width']) ? $this->dimension['width'] : $width;
    } else {
      $newDimension['height']  = intval ($height);
      $newDimension['width']   = intval ($width);
    }

    $newDimension = $this->calcImageSizeStrict ($this->dimension, $newDimension);
    if (!$this->verifyDimension ($newDimension)) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");

    $this->resize ($newDimension['width'], $newDimension['height']);

    if ($this->options['resizeUp'] === false) {
      $newDimension['height']  = (intval ($height) > $this->dimension['height']) ? $this->dimension['height'] : $height;
      $newDimension['width']   = (intval ($width) > $this->dimension['width']) ? $this->dimension['width'] : $width;
    } else {
      $newDimension['height']  = intval ($height);
      $newDimension['width']   = intval ($width);
    }
    if (!$this->verifyDimension ($newDimension)) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");

    $cropX = 0;
    $cropY = 0;

    if ($this->dimension['width'] > $newDimension['width']) {
      switch ($item) {
        case 'L': $cropX = 0; break;
        case 'R': $cropX = intval(($this->dimension['width'] - $newDimension['width'])); break;
        case 'C':
        default: $cropX = intval(($this->dimension['width'] - $newDimension['width']) / 2); break;
      }
    } else if ($this->dimension['height'] > $newDimension['height']) {
      switch ($item) {
        case 'T': $cropY = 0; break;
        case 'B': $cropY = intval(($this->dimension['height'] - $newDimension['height'])); break;
        case 'C':
        default: $cropY = intval(($this->dimension['height'] - $newDimension['height']) / 2); break;
      }
    }

    $workingImage = $this->_machiningImageCrop ($cropX, $cropY, $newDimension['width'], $newDimension['height']);
    
    return $this->_updateImage ($workingImage);
  }

  public function adaptiveResize ($width, $height) {
    return $this->adaptiveResizePercent ($width, $height, 50);
  }

  private function _machiningImageCrop ($cropX, $cropY, $width, $height, $color = 'transparent') {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    
    $workingImage = new Imagick ();
    $workingImage->setFormat ($this->format);

    $imagick = $this->image->clone ();
    if ($this->format == 'gif') {
      $imagick->coalesceImages ();
      do {
        $temp = new Imagick ();
        $temp->newImage ($width, $height, new ImagickPixel ($color));
        $imagick->chopImage ($cropX, $cropY, 0, 0);
        $temp->compositeImage ($imagick, imagick::COMPOSITE_DEFAULT, 0, 0);
         
        $workingImage->addImage ($temp);
        $workingImage->setImageDelay ($imagick->getImageDelay ());
      } while ($imagick->nextImage ());
    } else {
      $workingImage->newImage ($width, $height, new ImagickPixel ($color));
      $imagick->chopImage ($cropX, $cropY, 0, 0);
      $workingImage->compositeImage ($imagick, imagick::COMPOSITE_DEFAULT, 0, 0 );
    }
    return $workingImage;
  }

  public function adaptiveResizePercent ($width, $height, $percent) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyDimension ($this->createDimension ($width, $height))) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");
    if (!$this->verifyPercent ($percent, 0, 100)) $this->showError ("<fr>Error!</fr> The percent of the position error.\nIt must be a numeric from 0 to 100.\nPlease confirm your program again.");
    
    if(($width == $this->dimension['width']) && ($height == $this->dimension['height'])) {
      return $this;
    } else if ($this->options['resizeUp'] === false) {
      $newDimension['height']  = (intval ($height) > $this->dimension['height']) ? $this->dimension['height'] : $height;
      $newDimension['width']   = (intval ($width) > $this->dimension['width']) ? $this->dimension['width'] : $width;
    } else {
      $newDimension['height']  = intval ($height);
      $newDimension['width']   = intval ($width);
    }

    $newDimension = $this->calcImageSizeStrict ($this->dimension, $newDimension);
    if (!$this->verifyDimension ($newDimension)) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");

    $this->resize ($newDimension['width'], $newDimension['height']);

    if ($this->options['resizeUp'] === false) {
      $newDimension['height']  = (intval ($height) > $this->dimension['height']) ? $this->dimension['height'] : $height;
      $newDimension['width']   = (intval ($width) > $this->dimension['width']) ? $this->dimension['width'] : $width;
    } else {
      $newDimension['height']  = intval ($height);
      $newDimension['width']   = intval ($width);
    }
    if (!$this->verifyDimension ($newDimension)) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");

    $cropX = 0;
    $cropY = 0;

    if ($this->dimension['width'] > $newDimension['width']) {
      $maxCropX = $this->dimension['width'] - $newDimension['width'];
      $cropX = intval (($percent / 100) * $maxCropX);
    } else if ($this->dimension['height'] > $newDimension['height']) {
      $maxCropY = $this->dimension['height'] - $newDimension['height'];
      $cropY = intval (($percent / 100) * $maxCropY);
    }

    $workingImage = $this->_machiningImageCrop ($cropX, $cropY, $newDimension['width'], $newDimension['height']);

    return $this->_updateImage ($workingImage);
  }

  private function _machiningImageResize ($newDimension) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    
    $workingImage = $this->image->clone ()->coalesceImages ();

    if ($this->format == 'gif') {
      do {
        $workingImage->resizeImage ($newDimension['width'], $newDimension['height'], Imagick::FILTER_LANCZOS, 0.8, true);
      } while ($workingImage->nextImage ());
      $workingImage = $workingImage->deconstructImages ();
    } else {
      $workingImage->resizeImage ($newDimension['width'], $newDimension['height'], Imagick::FILTER_LANCZOS, 0.8, true);
    }

    return $workingImage;
  }

  public function resize ($width, $height, $method = 'both') {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyDimension ($this->createDimension ($width, $height))) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");
    if (!$this->verifyItemInArray ($method, array ('both', 'width', 'height'))) $this->showError ("<fr>Error!</fr> The quadrant error.\nIt must be one of string of 'both', 'width' or 'height'!\nPlease confirm your program again.");
    
    if(($width == $this->dimension['width']) && ($height == $this->dimension['height'])) {
      return $this;
    } else if ($this->options['resizeUp'] === false) {
      $newDimension['height'] = (intval($height) > $this->dimension['height']) ? $this->dimension['height'] : $height;
      $newDimension['width']  = (intval($width) > $this->dimension['width']) ? $this->dimension['width'] : $width;
    } else {
      $newDimension['height'] = intval($height);
      $newDimension['width']  = intval($width);
    }

    switch ($method) {
      default: case 'both': $newDimension = $this->calcImageSize ($this->dimension, $newDimension); break;
      case 'width': $newDimension = $this->calcWidth ($this->dimension, $newDimension); break;
      case 'height': $newDimension = $this->calcHeight ($this->dimension, $newDimension); break;
    }
    if (!$this->verifyDimension ($newDimension)) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");

    $workingImage = $this->_machiningImageResize ($newDimension);
    
    return $this->_updateImage ($workingImage);
  }

  public function pad ($width, $height, $color = 'transparent') {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyDimension ($this->createDimension ($width, $height))) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");
    if (!$this->verifyColor ($color, 'String')) $this->showError ("<fr>Error!</fr> The new color format error.\nIt must be a string, which format like 'blue', '#0000ff', 'rgb(0,0,255)', 'cmyk(100,100,100,10)'.\nPlease confirm your program again.");

    if(($width == $this->dimension['width']) && ($height == $this->dimension['height'])) {
      return $this;
    } else if (($width < $this->dimension['width']) || ($height < $this->dimension['height'])) {
      return $this->resize ($width, $height);
    } else {
      $workingImage = new Imagick ();
      $workingImage->setFormat ($this->format);

      if ($this->format == 'gif') {
        $imagick = $this->image->clone ()->coalesceImages ();
        do {
          $temp = new Imagick ();
          $temp->newImage ($width, $height, new ImagickPixel ($color));
          $temp->compositeImage ($imagick, imagick::COMPOSITE_DEFAULT, intval (($width - $this->dimension['width'])/2), intval (($height - $this->dimension['height'])/2) );
           
          $workingImage->addImage ($temp);
          $workingImage->setImageDelay ($imagick->getImageDelay ());
        } while ($imagick->nextImage());
      } else {
        $workingImage->newImage ($width, $height, new ImagickPixel ($color));
        $workingImage->compositeImage ($this->image->clone (), imagick::COMPOSITE_DEFAULT, intval (($width - $this->dimension['width'])/2), intval (($height - $this->dimension['height'])/2) );
      }
      
    return $this->_updateImage ($workingImage);
    }
  }

  private function _updateImage ($workingImage) {
    $this->image = $workingImage;
    $this->dimension = $this->getDimension ($workingImage);
    return $this;
  }
  
  public function save ($fileName, $is_path = false, $rawData = true) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    
    if (!$is_path) $fileName = $this->utilitySameLevelPath ($this->options['absolute_path'] . '/' . $fileName);

    $this->image->writeImages ($fileName, $rawData);
    return $this;
  }

  private function _setBaseInfo () {
    $this->image = new Imagick ($this->getFileName());
    if (!$this->verifyBase ($this->image)) $this->showError ("<fr>Error!</fr> The image is empty!\nPlease confirm your program again.");

    // $info = $this->image->identifyImage ();
    // $this->mime = ($this->verifyArrayFormat ($info, array ('mimetype')) && $this->verifyString ($info['mimetype'])) ? $info['mimetype'] : null;
    
    $this->mime = mime_content_type ($this->getFileName());
    if (!$this->verifyString ($this->mime)) $this->showError ("<fr>Error!</fr> The file format error!\nPlease confirm your file format again.");
    
    $this->format = $this->_getFormat ($this->mime);
    if (!$this->verifyItemInArray ($this->format, $this->d4_valid_formats)) $this->showError ("<fr>Error!</fr> This file format is no support!\nPlease confirm your file format again.");
    
    $this->dimension = $this->getDimension ($this->image);
    if (!$this->verifyDimension ($this->dimension)) $this->showError ("<fr>Error!</fr> The dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");
  }

  private function _getFormat ($mime) {
    switch ($mime) {
      case 'image/gif': return 'gif'; break;
      case 'image/jpeg': case 'image/pjpeg': return 'jpg'; break;
      case 'image/png': case 'image/x-png': return 'png'; break;
      default: return null; break;
    }
  }

  public function getDimension ($image = null) {
    if (!$this->verifyBase ($image)) $image = $this->image->clone ();
    $imagePage = $this->verifyDimension ($imagePage = $image->getImagePage ()) ? $imagePage : ($imagePage = $image->getImageGeometry ());
    return $this->createDimension ($imagePage['width'], $imagePage['height']);
  }

  private function _setSavePath () {
    $this->options['save_path'] = $this->utilityPath ($this->options['save_path']);
    $this->options['save_path'] = $this->verifyString ($this->options['save_path']) ? ($this->options['save_path'] . '/') : '';
    $this->options['absolute_path'] = $this->utilitySameLevelPath ($this->options['absolute_path'] . '/' . $this->options['save_path']);
  }

  private function _setOptions ($options) {
    $this->options = array_merge ($this->d4_options, $options);
  }

  private function _initD4Variable () {
    $this->d4_options = array (
      'absolute_path'        => FCPATH,
      'save_path'            => 'temp',
      'resizeUp'             => false,
      'correctPermissions'   => false,
      'memory_limit'         => '256M'
    );

    $this->d4_valid_formats = array ('gif', 'jpg', 'png');
  }
}