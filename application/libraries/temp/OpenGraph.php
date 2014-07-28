<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'TypeVerify.php';
require_once 'WebStreamUtility.php';

class OpenGraph extends TypeVerify {
  private $urlRegex = null;
  private $url = null;
  private $imageCount = null;
  private $isError = true;
  private $openGraph = null;

  public function __construct ($config = array ()) {
    if ($this->verifyArrayFormat ($config, array ('url', 'imageCount', 'time_limit'))) {
      $urlOpen = false;
      if (!ini_get('allow_url_fopen')) {
        $urlOpen = true;
        ini_set('allow_url_fopen', 1);
      }

      $this->_initD4Variable ($config);
      $this->_init ();
      $this->isError = false;

      if ($urlOpen == true) {
        ini_set('allow_url_fopen', 0);
      }
    } 
  }

  private function _isImage ($url) {
    if (preg_match ("/\.(jpg|png|gif|bmp)$/i", $url)) return true;
    else return false;
  }

  private function _getPage ($url, $referer = null, $timeout = null, $header = "") {
    $res = array ();
    $options = array (
      CURLOPT_RETURNTRANSFER => true, // return web page
      CURLOPT_HEADER => false, // do not return headers
      CURLOPT_FOLLOWLOCATION => true, // follow redirects
      CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)", // who am i
      CURLOPT_AUTOREFERER => true, // set referer on redirect
      CURLOPT_CONNECTTIMEOUT => $this->time_limit, // timeout on connect
      CURLOPT_TIMEOUT => 120, // timeout on response
      CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
    );
    $ch = curl_init ($url);
    curl_setopt_array ($ch, $options);
    $content = curl_exec ($ch);
    $err = curl_errno ($ch);
    $errmsg = curl_error ($ch);
    $header = curl_getinfo ($ch);
    curl_close ($ch);

    $hrd = $header["content_type"];
    header ("Content-Type: ".$hrd, true);

    $res['content'] = $content;
    $res['url'] = $header['url'];
    $res['header'] = $hrd;

    return $res;
  }

  private function _separeMetaTagsContent($raw) {
    preg_match ('/content="(.*?)"/i', $raw, $match);
    if(count ($match) == 0) preg_match ("/content='(.*?)'/i", $raw, $match);
    return $match[1];
  }

  private function _getMetaTags ($contents) {
    $result = false;
    $metaTags = array ("url" => "", "title" => "", "description" => "", "image" => "");

    if (isset ($contents)) {
      preg_match_all ('/<meta(.*?)>/i', $contents, $match);

      foreach ($match[1] as $value) {
        if (((strpos ($value, 'property="og:url"') !== false) || strpos ($value, "property='og:url'") !== false) || ((strpos ($value, 'name="url"') !== false) || (strpos ($value, "name='url'") !== false)) || ((strpos ($value, 'name="og:url"') !== false) || (strpos ($value, "name='og:url'") !== false))) $metaTags["url"] = $this->_separeMetaTagsContent ($value);
        else if (((strpos ($value, 'property="og:title"') !== false) || (strpos ($value, "property='og:title'") !== false)) || ((strpos ($value, 'name="title"') !== false) || (strpos ($value, "name='title'") !== false)) || ((strpos ($value, 'name="og:title"') !== false) || (strpos ($value, "name='og:title'") !== false))) $metaTags["title"] = $this->_separeMetaTagsContent ($value);
        else if (((strpos ($value, 'property="og:description"') !== false) || (strpos ($value, "property='og:description'") !== false)) || ((strpos ($value, 'name="description"') !== false) || (strpos ($value, "name='description'") !== false)) || ((strpos ($value, 'name="og:description"') !== false) || (strpos ($value, "name='og:description'") !== false))) $metaTags["description"] = $this->_separeMetaTagsContent ($value);
        else if (((strpos ($value, 'property="og:image"') !== false) || (strpos ($value, "property='og:image'") !== false)) || ((strpos ($value, 'name="image"') !== false) || (strpos ($value, "name='image'") !== false)) || ((strpos ($value, 'name="og:image"') !== false) || (strpos ($value, "name='og:image'") !== false))) $metaTags["image"] .= $this->_separeMetaTagsContent ($value) . '|';
      }

      $result = $metaTags;
    }
    return $result;
  }

  private function _extendedTrim ($content) { return trim (str_replace ("\n", " ", str_replace ("\t", " ", preg_replace ("/\s+/", " ", $content)))); }

  private function _getTagContent ($tag, $string) {
    $pattern = "/<$tag(.*?)>(.*?)<\/$tag>/i";
    $content = "";

    preg_match_all ($pattern, $string, $matches);
    for ($i = 0; $i < count ($matches[0]); $i++) {
      $currentMatch = strip_tags ($matches[0][$i]);
      if (strlen ($currentMatch) >= 120) { $content = $currentMatch; break; }
    }
    if ($content == "") { preg_match ($pattern, $string, $matches); $content = isset ($matches[0]) ? $matches[0] : ''; }
    return str_replace ("&nbsp;", "", $content);
  }

  private function _crawlCode ($text) {
    $content = ""; $contentSpan = ""; $contentParagraph = "";

    $contentSpan = $this->_getTagContent ("span", $text);
    $contentParagraph = $this->_getTagContent ("p", $text);
    $contentDiv = $this->_getTagContent ("div", $text);
    $content = $contentSpan;
    if ((strlen ($contentParagraph) > strlen ($contentSpan)) && (strlen ($contentParagraph) >= strlen ($contentDiv))) $content = $contentParagraph;
    else if ((strlen ($contentParagraph) > strlen ($contentSpan)) && (strlen ($contentParagraph) < strlen ($contentDiv))) $content = $contentDiv;
    else $content = $contentParagraph;
    return $content;
  }

  private function _mediaYoutube ($url) {
    $media = array ();
    if (preg_match ("/(.*?)v=(.*?)($|&)/i", $url, $matching)) {
      $vid = $matching[2];
      array_push ($media, "http://i2.ytimg.com/vi/$vid/hqdefault.jpg");
      array_push ($media, '<iframe id="' . date("YmdHis") . $vid . '" style="display: none; margin-bottom: 5px;" width="499" height="368" src="http://www.youtube.com/embed/' . $vid . '" frameborder="0" allowfullscreen></iframe>');
    } else { array_push ($media, "", ""); }
    return $media;
  }

  private function _mediaVimeo ($url) {
    $url = str_replace ("https://", "", $url);
    $url = str_replace ("http://", "", $url);
    $breakUrl = explode ("/", $url);
    $media = array ();
    if ($breakUrl[1] != "") {
      $imgId = $breakUrl[1];
      $hash = unserialize (file_get_contents ("http://vimeo.com/api/v2/video/$imgId.php"));
      array_push ($media, $hash[0]['thumbnail_large']);
      array_push ($media, '<iframe id="' . date ("YmdHis") . $imgId . '" style="display: none; margin-bottom: 5px;" width="500" height="281" src="http://player.vimeo.com/video/' . $imgId . '" width="654" height="368" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen ></iframe>');
    } else { array_push ($media, "", ""); }
    return $media;
  }

  private function _mediaMetacafe ($url) {
    $media = array ();
      preg_match ('|metacafe\.com/watch/([\w\-\_]+)(.*)|', $url, $matching);
      if($matching[1] != "") {
      $vid = $matching[1];
      $vtitle = trim ($matching[2], "/");
      array_push ($media, "http://s4.mcstatic.com/thumb/{$vid}/0/6/videos/0/6/{$vtitle}.jpg");
      array_push ($media, '<iframe id="' . date ("YmdHis") . $vid . '" style="display: none; margin-bottom: 5px;" width="499" height="368" src="http://www.metacafe.com/embed/' . $vid . '" allowFullScreen frameborder=0></iframe>');
    } else { array_push ($media, "", ""); }
    return $media;
  }

  private function _mediaDailymotion ($url) {
    $media = array ();
    $id = strtok (basename ($url), '_');
    if($id != "") {
      array_push ($media, "http://www.dailymotion.com/thumbnail/160x120/video/$id");
      array_push ($media, '<iframe id="' . date ("YmdHis") . $id . '" style="display: none; margin-bottom: 5px;" width="499" height="368" src="http://www.dailymotion.com/embed/video/' . $id . '" allowFullScreen frameborder=0></iframe>');
    } else { array_push ($media, "", ""); }
    return $media;
  }

  private function _mediaCollegehumor ($url) {
    $media = array ();
    preg_match ('#(?<=video/).*?(?=/)#', $url, $matching);
    $id = $matching[0];
    if($id != "") {
      $hash = file_get_contents ("http://www.collegehumor.com/oembed.json?url=http://www.dailymotion.com/embed/video/$id");
      $hash=json_decode ($hash, true);
      array_push ($media, $hash['thumbnail_url']);
      array_push ($media, '<iframe id="' . date("YmdHis") . $id . '" style="display: none; margin-bottom: 5px;" width="499" height="368" src="http://www.collegehumor.com/e/' . $id . '" allowFullScreen frameborder=0></iframe>');
    } else { array_push ($media, "", ""); }
    return $media;
  }

  private function _mediaBlip ($url) {
    $media = array ();
    if($url != "")  {
      $hash = file_get_contents ("http://blip.tv/oembed?url=$url");
      $hash = json_decode ($hash,true);
      preg_match ('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $hash['html'], $matching);
      $src = $matching[1];
      array_push ($media, $hash['thumbnail_url']);
      array_push ($media, '<iframe id="' . date("YmdHis") . 'blip" style="display: none; margin-bottom: 5px;" width="499" height="368" src="' . $src . '" allowFullScreen frameborder=0></iframe>');
    } else { array_push ($media, "", ""); }
    return $media;
  }

  private function _mediaFunnyordie ($url) {
    $media = array ();
    if($url != "")  {   
      $hash = file_get_contents ("http://www.funnyordie.com/oembed.json?url=$url");
      $hash = json_decode ($hash,true);
      preg_match ('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $hash['html'], $matching);
      $src = $matching[1];
      array_push ($media, $hash['thumbnail_url']);
      array_push ($media, '<iframe id="' . date("YmdHis") . 'funnyordie" style="display: none; margin-bottom: 5px;" width="499" height="368" src="' . $src . '" allowFullScreen frameborder=0></iframe>');
    } else { array_push ($media, "", ""); }
    return $media;
  }

  private function _cannonicalImgSrc ($imgSrc) {
    $imgSrc = str_replace ("../", "", $imgSrc);
    $imgSrc = str_replace ("./", "", $imgSrc);
    $imgSrc = str_replace (" ", "%20", $imgSrc);
    return $imgSrc;
  }

  private function _getImageUrl ($pathCounter, $url) {
    $src = "";
    if ($pathCounter > 0) {
      $urlBreaker = explode ('/', $url);
      for ($j = 0; $j < ($pathCounter + 1); $j++) $src .= ($urlBreaker[$j] . '/');
    } else { $src = $url; }
    return $src;
  }

  private function _cannonicalPage ($url) {
    $cannonical = "";
    if ((substr_count ($url, 'http://') > 1) || (substr_count ($url, 'https://') > 1) || ((strpos ($url, 'http://') !== false) && (strpos ($url, 'https://') !== false))) return $url;
    if (strpos ($url, "http://") !== false) $url = substr ($url, 7);
    else if (strpos ($url, "https://") !== false) $url = substr ($url, 8);
    for ($i = 0; $i < strlen ($url); $i++) { if ($url[$i] != "/") $cannonical .= $url[$i]; else break; }
    return $cannonical;
  }

  private function _cannonicalLink ($imgSrc, $referer) {
    if (strpos ($imgSrc, "//") === 0) $imgSrc = "http:" . $imgSrc;
    else if (strpos ($imgSrc, "/") === 0) $imgSrc = "http://" . $this->_cannonicalPage ($referer) . $imgSrc;
    else $imgSrc = "http://" . $this->_cannonicalPage ($referer) . '/' . $imgSrc;
    return $imgSrc;
  }

  private function _getImages ($text, $url, $imageQuantity) {
    $content = array ();
    if (preg_match_all ("/<img(.*?)src=(\"|\')(.+?)(gif|jpg|png|bmp)(\"|\')(.*?)(\/)?>(<\/img>)?/", $text, $matching)) {

      for ($i = 0; $i < count ($matching[0]); $i++) {
        $src = "";
        $pathCounter = substr_count ($matching[0][$i], "../");
        preg_match ('/src=(\"|\')(.+?)(\"|\')/i', $matching[0][$i], $imgSrc);
        $imgSrc = $this->_cannonicalImgSrc ($imgSrc[2]);
        if (!preg_match ("/https?\:\/\//i", $imgSrc)) {
          $src = $this->_getImageUrl ($pathCounter, $this->_cannonicalLink ($imgSrc, $url));
        }
        if (($src . $imgSrc) != $url) { if ($src == "") array_push ($content, $src . $imgSrc); else array_push ($content, $src); }
      }
    }

    $content = array_unique ($content);
    $content = array_values ($content);
    $maxImages = (($imageQuantity != -1) && ($imageQuantity < count ($content))) ? $imageQuantity : count ($content);

    $images = "";
    for ($i = 0; $i < count ($content); $i++) {
      $img = WebStreamUtility::create ($content[$i]);
      if ($img->isExist ()) {
        $images .= ($content[$i] . "|");
        $maxImages--;
        if ($maxImages == 0) break;
      }
    }
    return substr ($images, 0, -1);
  }

  private function _init () {
    if (preg_match ($this->urlRegex, $this->url, $match)) {
      
      $raw   = ""; $video  = "no"; $finalUrl = ""; $description = "";
      $title = ""; $images = ""; $finalLink  = ""; $videoIframe = "";
      
      if (strpos($match[0], " ") === 0) $match[0] = "http://" . substr($match[0], 1);
      $finalUrl = $match[0];
      $pageUrl  = str_replace("https://", "http://", $finalUrl);

      if ($this->_isImage ($pageUrl)) {
        $images = $pageUrl;
      } else {
        $urlData = $this->_getPage ($pageUrl);
        if (!$urlData["content"] && (strpos ($pageUrl, "//www.") === false)) {
          if (strpos ($pageUrl, "http://") !== false) $pageUrl = str_replace ("http://", "http://www.", $pageUrl);
          elseif (strpos ($pageUrl, "https://") !== false) $pageUrl = str_replace ("https://", "https://www.", $pageUrl);
          $urlData = $this->_getPage ($pageUrl);
        }

        $pageUrl = $finalUrl = $urlData["url"];
        $raw = $urlData["content"];

        $metaTags = $this->_getMetaTags ($raw);
        $tempTitle = $this->_extendedTrim ($metaTags["title"]);

        if ($tempTitle != "") $title = $tempTitle;
        if ($title == "") if (preg_match ("/<title(.*?)>(.*?)<\/title>/i", str_replace ("\n", " ", $raw), $matching)) $title = $matching[2];

        $tempDescription = $this->_extendedTrim ($metaTags["description"]);

        if ($tempDescription != "") $description = $tempDescription;
        else $description = $this->_crawlCode ($raw);

        if ($description != "") $descriptionUnderstood = true; else $descriptionUnderstood = false;
        if ((($descriptionUnderstood == false) && (strlen($title) > strlen($description)) && !preg_match($this->urlRegex, $description) && ($description != "") && !preg_match('/[A-Z]/', $description)) || ($title == $description)) {
          $title = $description;
          $description = $this->_crawlCode ($raw);
        }

        $images = $this->_extendedTrim ($metaTags["image"]);
        $media  = array ();

        if (strpos ($pageUrl, "youtube.com") !== false) {
          $media = $this->_mediaYoutube ($pageUrl); $images = $media[0]; $videoIframe = $media[1];
        } else if (strpos ($pageUrl, "vimeo.com") !== false) {
          $media = $this->_mediaVimeo ($pageUrl); $images = $media[0]; $videoIframe = $media[1];
        } else if (strpos ($pageUrl, "metacafe.com") !== false) {
          $media = $this->_mediaMetacafe ($pageUrl); $images = $media[0]; $videoIframe = $media[1];
        } else if (strpos ($pageUrl, "dailymotion.com") !== false) {
          $media = $this->_mediaDailymotion ($pageUrl); $images = $media[0]; $videoIframe = $media[1];
        } else if (strpos ($pageUrl, "collegehumor.com") !== false) {
          $media = $this->_mediaCollegehumor ($pageUrl); $images = $media[0]; $videoIframe = $media[1];
        } else if (strpos ($pageUrl, "blip.tv") !== false) {
          $media =  $this->_mediaBlip ($pageUrl); $images = $media[0]; $videoIframe = $media[1];
        } else if (strpos($pageUrl, "funnyordie.com") !== false) {
          $media =  $this->_mediaFunnyordie ($pageUrl); $images = $media[0]; $videoIframe = $media[1];
        }

        if ($images == "") $images = $this->_getImages ($raw, $pageUrl, $this->imageCount);
        if (($media != null) && ($media[0] != "") && ($media[1] != "")) $video = "yes";

        $title = $this->_extendedTrim ($title);
        $pageUrl = $this->_extendedTrim ($pageUrl);
        $description = $this->_extendedTrim ($description);
        $description = preg_replace ("/<script(.*?)>(.*?)<\/script>/i", "", $description);
      }

      $finalLink = explode ("&", $finalUrl);
      $finalLink = $finalLink[0];

      $image_list = array ();
      if (count ($images = explode ('|', $images))) foreach ($images as $image) if ($this->verifyString ($image)) $image_list[] = $image;
      $this->openGraph = array ("title" => $title, "titleEsc" => $title, "url" => $finalLink, "pageUrl" => $finalUrl, "cannonicalUrl" => $this->_cannonicalPage ($pageUrl), "description" => strip_tags ($description), "descriptionEsc" => strip_tags ($description), "images" => $image_list, "video" => $video, "videoIframe" => $videoIframe);
    }
  }

  private function _initD4Variable ($config) {
    $this->urlRegex = "/(https?:\/\/)[~\S]+/i";
    
    $this->url = str_replace("\n", " ", $config['url']);
    if (!$this->verifyString ($this->url)) $this->showError ("<fr>Error!</fr> The url format is error!\nIt must be string!\nPlease confirm your program again.");
    
    $this->imageCount = $config['imageCount'];
    if (!$this->verifyNumber ($this->imageCount, -1)) $this->showError ("<fr>Error!</fr> The imageCount format is error!\nIt must be numeric and bigger than -1!\nPlease confirm your program again.");

    $this->time_limit = $config['time_limit'];
    if (!$this->verifyNumber ($this->time_limit, 1)) $this->showError ("<fr>Error!</fr> The time_limit format is error!\nIt must be numeric and bigger than 1!\nPlease confirm your program again.");
  }

  public static function create ($url, $imageCount = -1, $time_limit = 30) {
    return TypeVerify::verifyObject ($self = new self (array ('url' => $url, 'imageCount' => $imageCount, 'time_limit' => $time_limit))) ? $self : TypeVerify::showError ("<fr>Error!</fr> The create object happen unknown error...\nPlease confirm your program again.");
  }

  public function getOpenGraph () {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    return $this->verifyArray ($this->openGraph) ? $this->openGraph : null;
  }
}