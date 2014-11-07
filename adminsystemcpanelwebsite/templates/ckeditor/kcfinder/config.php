<?php

/** This file is part of KCFinder project
  *
  *      @desc Base configuration file
  *   @package KCFinder
  *   @version 2.21
  *    @author Pavel Tzonkov <pavelc@users.sourceforge.net>
  * @copyright 2010 KCFinder Project
  *   @license http://www.opensource.org/licenses/gpl-2.0.php GPLv2
  *   @license http://www.opensource.org/licenses/lgpl-2.1.php LGPLv2
  *      @link http://kcfinder.sunhater.com
  */

// IMPORTANT!!! Do not remove uncommented settings in this file even if
// you are using session configuration.
// See http://kcfinder.sunhater.com/install for setting descriptions

$_CONFIG = array(

    'disabled' => false,
    'readonly' => false,
    'denyZipDownload' => false,

    'theme' => "oxygen",

    'uploadURL' => "../../../../data",
    'uploadDir' => "",

    'dirPerms' => 0777,
    'filePerms' => 0644,

    'deniedExts' => "exe com msi bat php cgi pl",

    'types' => array(

        // CKEditor & FCKEditor types
        'files'   =>  "",
        'flash'   =>  "swf",
        'images'  =>  "*img",

        // TinyMCE types
        'file'    =>  "",
        'media'   =>  "swf flv avi mpg mpeg qt mov wmv asf rm png jpg jpeg bmp gif",
        'image'   =>  "*img",
    ),

    'mime_magic' => "",

    'maxImageWidth' => 1200,
    'maxImageHeight' => 700,

    'thumbWidth' => 80,
    'thumbHeight' => 80,

    'thumbsDir' => "thumbs_",

    'jpegQuality' => 90,

    'cookieDomain' => "",
    'cookiePath' => "",
    'cookiePrefix' => 'KCFINDER_',

    // THE FOLLOWING SETTINGS CANNOT BE OVERRIDED WITH SESSION CONFIGURATION

    '_check4htaccess' => true,
    //'_tinyMCEPath' => "/tiny_mce",

    '_sessionVar' => &$_SESSION['KCFINDER'],
    //'_sessionLifetime' => 30,
    //'_sessionDir' => "/full/directory/path",

    //'_sessionDomain' => ".mysite.com",
    //'_sessionPath' => "/my/path",
);

?>