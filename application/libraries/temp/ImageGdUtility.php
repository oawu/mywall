<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'ImageBaseUtility.php';

class ImageGdUtility extends ImageBaseUtility {
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

  private function _copyReSampled ($n_img, $o_img, $n_x, $n_y, $o_x, $o_y, $n_w, $n_h, $o_w, $o_h) {
    imagecopyresampled ($n_img, $o_img, $n_x, $n_y, $o_x, $o_y, $n_w, $n_h, $o_w, $o_h);
    $this->_updateImage ($n_img);
    return $this;
  }

  public function imageFilter ($filter, $arg1 = null, $arg2 = null, $arg3 = null, $arg4 = null) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    
    $items = array (IMG_FILTER_NEGATE,         IMG_FILTER_GRAYSCALE,    IMG_FILTER_BRIGHTNESS, IMG_FILTER_CONTRAST,
                    IMG_FILTER_COLORIZE,       IMG_FILTER_EDGEDETECT,   IMG_FILTER_EMBOSS,     IMG_FILTER_GAUSSIAN_BLUR,
                    IMG_FILTER_SELECTIVE_BLUR, IMG_FILTER_MEAN_REMOVAL, IMG_FILTER_SMOOTH,     IMG_FILTER_PIXELATE);

    if (!$this->verifyItemInArray ($filter, $items)) $this->showError ("<fr>Error!</fr> The filter error.\nIt must be one of uppercase uppercase of 'IMG_FILTER_NEGATE', 'IMG_FILTER_GRAYSCALE', 'IMG_FILTER_BRIGHTNESS', 'IMG_FILTER_CONTRAST', 'IMG_FILTER_COLORIZE', 'IMG_FILTER_EDGEDETECT', 'IMG_FILTER_EMBOSS', 'IMG_FILTER_GAUSSIAN_BLUR', 'IMG_FILTER_SELECTIVE_BLUR', 'IMG_FILTER_MEAN_REMOVAL', 'IMG_FILTER_SMOOTH' or 'IMG_FILTER_PIXELATE'!\nPlease confirm your program again.");
    if (!function_exists ('imagefilter')) $this->showError ("<fr>Error!</fr> Your version of GD does not support image filters.\nPlease confirm your program again.");
    
    try {
      switch ($filter) {
        case IMG_FILTER_BRIGHTNESS: case IMG_FILTER_CONTRAST: case IMG_FILTER_SMOOTH:
          // 1 parameter
          if (isset ($arg1) && ($arg1 !== null))
            $result = imagefilter ($this->image, $filter, $arg1);
          else
            $this->showError ("Error! The parameter error, The filter - " . $filter . " need one parameter!\nPlease confirm your program again.");
          break;

        case IMG_FILTER_PIXELATE:
          // 2 parameters
          if (isset ($arg1) && ($arg1 !== null) && isset ($arg2) && ($arg2 !== null))
            $result = imagefilter ($this->image, $filter, $arg1, $arg2);
          else
            $this->showError ("Error! The parameter error, The filter - " . $filter . " need two parameters!\nPlease confirm your program again.");
          break;

        case IMG_FILTER_COLORIZE:
          // 4 parameters
          if (isset ($arg1) && ($arg1 !== null) && isset ($arg2) && ($arg2 !== null) && isset ($arg3) && ($arg3 !== null) && isset ($arg4) && ($arg4 !== null))
            $result = imagefilter ($this->image, $filter, $arg1, $arg2, $arg3, $arg4);
          else
            $this->showError ("Error! The parameter error, The filter - " . $filter . " need four parameters!\nPlease confirm your program again.");
          break;

        default:
          // 0 parameter
          $result = imagefilter ($this->image, $filter);
          break;
      }
    } catch (Exception $e) { $this->showError ("<fr>Error!</fr> The imageFilter happen unknown reasons error!\nThe message : " . $e . "\nPlease confirm your program again."); }

    if (!$result) $this->showError ("<fr>Error!</fr> GD imagefilter failed.\nPlease confirm your program again.");
    
    return $this;
  }

  public function rotateCW ($direction = 'CW', $color = array (255, 255, 255)) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyItemInArray ($direction, array ('CW', 'CCW'))) $this->showError ("<fr>Error!</fr> The direction error.\nIt must be one of uppercase string of 'CW' or 'CCW'!\nPlease confirm your program again.");
    if (!$this->verifyColor ($color, 'Array')) $this->showError ("<fr>Error!</fr> The new color format error.\nIt must be an array which has three integer element 0 to 255.\nPlease confirm your program again.");
    return $this->rotate ($direction == 'CW' ? 90: -90);
  }

  public function rotate ($degree, $color = array (255, 255, 255)) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyDegree ($degree)) $this->showError ("<fr>Error!</fr> The degree format error.\nIt must be a numeric.\nPlease confirm your program again.");
    if (!function_exists ('imagerotate')) $this->showError ("<fr>Error!</fr> Your version of GD does not support image rotation.\nPlease confirm your program again.");
    if (!$this->verifyColor ($color, 'Array')) $this->showError ("<fr>Error!</fr> The new color format error.\nIt must be an array which has three integer element 0 to 255.\nPlease confirm your program again.");
    if (($degree % 360) == 0) return $this;
    
    if (function_exists ('imagecreatetruecolor')) {
      $temp = imagecreatetruecolor (1, 1);
    } else {
      $temp = imagecreate (1, 1);
    }

    $fillColor = imagecolorallocate ( $temp, $color[0], $color[1], $color[2]);
    $workingImage = imagerotate ($this->image, 0 - $degree, $fillColor);

    $this->_updateImage ($workingImage);
    return $this;
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
    
    if (function_exists ('imagecreatetruecolor')) {
      $workingImage = imagecreatetruecolor ($width, $height);
    } else {
      $workingImage = imagecreate ($width, $height);
    }
    
    $workingImage = $this->_preserveAlpha ($workingImage);   
    
    return $this->_copyReSampled (
      $workingImage, $this->image,
      0, 0,
      $startX, $startY,
      $width, $height,
      $width, $height
    );
  }

  public function pad ($width, $height, $color = array (255, 255, 255)) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyDimension ($this->createDimension ($width, $height))) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");
    if (!$this->verifyColor ($color, 'Array')) $this->showError ("<fr>Error!</fr> The new color format error.\nIt must be an array which has three integer element 0 to 255.\nPlease confirm your program again.");

    if(($width == $this->dimension['width']) && ($height == $this->dimension['height'])) {
      return $this;
    } else if (($width < $this->dimension['width']) || ($height < $this->dimension['height'])) {
      return $this->resize ($width, $height);
    } else {

      if (function_exists ('imagecreatetruecolor')) {
        $workingImage = imagecreatetruecolor ($width, $height);
      } else {
        $workingImage = imagecreate ($width, $height);
      }
      
      $fillColor = imagecolorallocate ($workingImage, $color[0], $color[1], $color[2]);
      imagefill ($workingImage, 0, 0, $fillColor);
      
      return $this->_copyReSampled (
        $workingImage, $this->image,
        intval (($width - $this->dimension['width']) / 2), intval (($height - $this->dimension['height']) / 2),
        0, 0,
        $this->dimension['width'], $this->dimension['height'],
        $this->dimension['width'], $this->dimension['height']
      );
    }
  }

  public function adaptiveResizeQuadrant ($width, $height, $item) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyDimension ($this->createDimension ($width, $height))) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");
    if (!$this->verifyItemInArray ($item, array ('C', 'R', 'L', 'T', 'B'))) $this->showError ("<fr>Error!</fr> The quadrant error.\nIt must be one of uppercase characters of 'C', 'T', 'B', 'L' or 'R'!\nPlease confirm your program again.");
    
    if(($width == $this->dimension['width']) && ($height == $this->dimension['height'])) {
      return $this;
    } else if ($this->options['resizeUp'] === false) {
      $newDimension['height'] = (intval ($height) > $this->dimension['height']) ? $this->dimension['height'] : $height;
      $newDimension['width']  = (intval ($width) > $this->dimension['width']) ? $this->dimension['width'] : $width;
    } else {
      $newDimension['height'] = intval ($height);
      $newDimension['width']  = intval ($width);
    }
    $newDimension = $this->calcImageSizeStrict ($this->dimension, $newDimension);
    if (!$this->verifyDimension ($newDimension)) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");

    $this->resize ($newDimension['width'], $newDimension['height']);

    if ($this->options['resizeUp'] === false) {
      $newDimension['height'] = (intval ($height) > $this->dimension['height']) ? $this->dimension['height'] : $height;
      $newDimension['width']  = (intval ($width) > $this->dimension['width']) ? $this->dimension['width'] : $width;
    } else {
      $newDimension['height'] = intval ($height);
      $newDimension['width']  = intval ($width);
    }
    if (!$this->verifyDimension ($newDimension)) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");

    if (function_exists ('imagecreatetruecolor')) {
      $workingImage = imagecreatetruecolor ($newDimension['width'], $newDimension['height']);
    } else {
      $workingImage = imagecreate ($newDimension['width'], $newDimension['height']);
    }

    $workingImage = $this->_preserveAlpha ($workingImage);  

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

    return $this->_copyReSampled (
      $workingImage, $this->image,
      0, 0,
      $cropX, $cropY,
      $newDimension['width'], $newDimension['height'],
      $newDimension['width'], $newDimension['height']
    );
  }

  public function resizePercent ($percent = 0) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyPercent ($percent, 1, null)) $this->showError ("<fr>Error!</fr> The percent of the position error.\nIt must be a numeric bigger or equal than one.\nPlease confirm your program again.");
    if ($percent == 100) return $this;

    $newDimension = $this->calcImageSizePercent ($percent, $this->dimension);
    if (!$this->verifyDimension ($newDimension)) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");

    return $this->resize ($newDimension['width'], $newDimension['height']);
  }

  public function adaptiveResizePercent ($width, $height, $percent) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyDimension ($this->createDimension ($width, $height))) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");
    if (!$this->verifyPercent ($percent, 0, 100)) $this->showError ("<fr>Error!</fr> The percent of the position error.\nIt must be a numeric from 0 to 100.\nPlease confirm your program again.");
    
    if(($width == $this->dimension['width']) && ($height == $this->dimension['height'])) {
      return $this;
    } else if ($this->options['resizeUp'] === false) {
      $newDimension['height'] = (intval ($height) > $this->dimension['height']) ? $this->dimension['height'] : $height;
      $newDimension['width']  = (intval ($width) > $this->dimension['width']) ? $this->dimension['width'] : $width;
    } else {
      $newDimension['height'] = intval ($height);
      $newDimension['width']  = intval ($width);
    }

    $newDimension = $this->calcImageSizeStrict ($this->dimension, $newDimension);
    if (!$this->verifyDimension ($newDimension)) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");

    $this->resize ($newDimension['width'], $newDimension['height']);

    if ($this->options['resizeUp'] === false) {
      $newDimension['height'] = (intval ($height) > $this->dimension['height']) ? $this->dimension['height'] : $height;
      $newDimension['width']  = (intval ($width) > $this->dimension['width']) ? $this->dimension['width'] : $width;
    } else {
      $newDimension['height'] = intval ($height);
      $newDimension['width']  = intval ($width);
    }
    if (!$this->verifyDimension ($newDimension)) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");

    if (function_exists ('imagecreatetruecolor')) {
      $workingImage = imagecreatetruecolor ($newDimension['width'], $newDimension['height']);
    } else {
      $workingImage = imagecreate ($newDimension['width'], $newDimension['height']);
    }

    $workingImage = $this->_preserveAlpha ($workingImage);  

    $cropX = 0;
    $cropY = 0;

    if ($this->dimension['width'] > $newDimension['width']) {
      $maxCropX = $this->dimension['width'] - $newDimension['width'];
      $cropX = intval (($percent / 100) * $maxCropX);
    } else if ($this->dimension['height'] > $newDimension['height']) {
      $maxCropY = $this->dimension['height'] - $newDimension['height'];
      $cropY = intval (($percent / 100) * $maxCropY);
    }

    return $this->_copyReSampled (
      $workingImage, $this->image,
      0, 0,
      $cropX, $cropY,
      $newDimension['width'], $newDimension['height'],
      $newDimension['width'], $newDimension['height']
    );
  }

  public function adaptiveResize ($width, $height) {
    return $this->adaptiveResizePercent ($width, $height, 50);
  }

  public function resize ($width, $height, $method = 'both') {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyDimension ($this->createDimension ($width, $height))) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");
    if (!$this->verifyItemInArray ($method, array ('both', 'width', 'height'))) $this->showError ("<fr>Error!</fr> The quadrant error.\nIt must be one of string of 'both', 'width' or 'height'!\nPlease confirm your program again.");
    
    if(($width == $this->dimension['width']) && ($height == $this->dimension['height'])) {
      return $this;
    } else if ($this->options['resizeUp'] === false) {
      $newDimension['height'] = (intval ($height) > $this->dimension['height']) ? $this->dimension['height'] : $height;
      $newDimension['width']  = (intval ($width) > $this->dimension['width']) ? $this->dimension['width'] : $width;
    } else {
      $newDimension['height'] = intval ($height);
      $newDimension['width']  = intval ($width);
    }

    switch ($method) {
      default: case 'both': $newDimension = $this->calcImageSize ($this->dimension, $newDimension); break;
      case 'width': $newDimension = $this->calcWidth ($this->dimension, $newDimension); break;
      case 'height': $newDimension = $this->calcHeight ($this->dimension, $newDimension); break;
    }
    
    if (!$this->verifyDimension ($newDimension)) $this->showError ("<fr>Error!</fr> The new dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");
  
    if (function_exists ('imagecreatetruecolor')) {
      $workingImage = imagecreatetruecolor ($newDimension['width'], $newDimension['height']);
    } else {
      $workingImage = imagecreate ($newDimension['width'], $newDimension['height']);
    }
    
    $workingImage = $this->_preserveAlpha ($workingImage);   
    
    return $this->_copyReSampled (
      $workingImage, $this->image,
      0, 0,
      0, 0,
      $newDimension['width'], $newDimension['height'],
      $this->dimension['width'], $this->dimension['height']
    );
  }

  private function _updateImage ($workingImage) {
    $this->image = $workingImage;
    $this->dimension = $this->getDimension ($this->image);
  }

  private function _preserveAlpha ($workingImage) {
    if (($this->format == 'png') && ($this->options['preserveAlpha'] === true)) {
      imagealphablending ($workingImage, false);

      $colorTransparent = imagecolorallocatealpha (
        $workingImage, 
        $this->options['alphaMaskColor'][0], 
        $this->options['alphaMaskColor'][1], 
        $this->options['alphaMaskColor'][2], 
        0
      );
      
      imagefill ($workingImage, 0, 0, $colorTransparent);
      imagesavealpha ($workingImage, true);
    }

    if (($this->format == 'gif') && ($this->options['preserveTransparency'] === true)) {
      $colorTransparent = imagecolorallocate (
        $workingImage, 
        $this->options['transparencyMaskColor'][0], 
        $this->options['transparencyMaskColor'][1], 
        $this->options['transparencyMaskColor'][2] 
      );
      
      imagecolortransparent ($workingImage, $colorTransparent);
      imagetruecolortopalette ($workingImage, true, 256);
    }

    return $workingImage;
  }

  public function save ($fileName, $is_path = false) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    
    if ($this->options['interlace'] === true) {
      imageinterlace ($this->image, 1);
    } else if ($this->options['interlace'] === false) {
      imageinterlace ($this->image, 0);
    }
    
    if (!$is_path) $fileName = $this->utilitySameLevelPath ($this->options['absolute_path'] . '/' . $fileName);

    switch ($this->format) {
      case 'gif': imagegif ($this->image, $fileName); break;
      case 'jpg': imagejpeg ($this->image, $fileName, $this->options['jpegQuality']); break;
      case 'png': imagepng ($this->image, $fileName); break;
    }

    return $this;
  }

  private function _setBaseInfo () {
    $this->mime = mime_content_type ($this->getFileName());
    if (!$this->verifyString ($this->mime)) $this->showError ("<fr>Error!</fr> The file format error!\nPlease confirm your file format again.");
    
    $this->format = $this->_getFormat ($this->mime);
    if (!$this->verifyItemInArray ($this->format, $this->d4_valid_formats)) $this->showError ("<fr>Error!</fr> This file format is no support!\nPlease confirm your file format again.");
    
    $this->image = $this->_getOldImage ($this->format);
    if (!$this->verifyBase ($this->image)) $this->showError ("<fr>Error!</fr> The image is empty!\nPlease confirm your program again.");

    $this->dimension = $this->getDimension ($this->image);
    if (!$this->verifyDimension ($this->dimension)) $this->showError ("<fr>Error!</fr> The dimension format error.\nIt must be a number greater or equal than one.\nPlease confirm your program again.");
  }
  
  private function _getOldImage ($format) {
    switch ($format) {
      case 'gif': return imagecreatefromgif ($this->getFileName()); break;
      case 'jpg': return imagecreatefromjpeg ($this->getFileName()); break;
      case 'png': return imagecreatefrompng ($this->getFileName()); break;
    }
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
    if (!$this->verifyBase ($image)) $image = $this->_getOldImage ($this->format);
    return $this->createDimension (imagesx ($image), imagesy ($image));
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
      'absolute_path'         => FCPATH,
      'save_path'             => 'temp',
      'resizeUp'              => false,
      'interlace'             => null,
      'jpegQuality'           => 100,
      'preserveAlpha'         => true,
      'alphaMaskColor'        => array (255, 255, 255),
      'preserveTransparency'  => true,
      'memory_limit'          => '256M',
      'transparencyMaskColor' => array (0, 0, 0)
    );

    $this->d4_valid_formats = array ('gif', 'jpg', 'png');
  }
}