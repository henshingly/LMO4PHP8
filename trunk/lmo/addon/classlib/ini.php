<?php 
/**
 *
 * classlib Addon for LigaManager Online
 * Copyright (C) 2003 by Tim Schumacher
 * timme@uni.de /
 *
 *      27.10.05 2.8� diverse �nderungen an den functionen loadFile() und writeFile() um auch KO Runden speichern zu k�nnen.
 *                    gameSorted() und gamesortedforTeam() in die Klasse liga aufgenommen, neue Klasse Stats f�r Auswertung
 *                    der Statistiken.
 *      05.11.05 2.8RC1 Bugfixes
 *      13.11.05 2.8RC2 Bugfixes  getLigaObject() aus functions.php rausgenommen und als factory pattern in die Klasse liga
 *                                eingef�gt. Eine neue Liga sollte nun mit dem Befehl "liga::factory(PATH_TO_LIGAFILE);"  erstellt werden.
 *
 * @author  LMO Group Tim Schumacher <webobjects@gmx.net>
 * @package classLib
 * @access public
 * @version 2.8 RC1
 */



require_once(dirname(__FILE__).'/../../init.php');

// classlib Dateien

require_once(PATH_TO_ADDONDIR."/classlib/classes.php");
require_once(PATH_TO_ADDONDIR."/classlib/functions.php");
require_once(PATH_TO_ADDONDIR."/classlib/html_output.php");


// Weitere Klassen einbinden
// class iniFile
require_once(PATH_TO_ADDONDIR."/classlib/classes/ini/cIniFileReader.inc");
// class pdf
require_once(PATH_TO_ADDONDIR."/classlib/classes/pdf/class.ezpdf.php");
// classes for image manipulation
if (file_exists(PATH_TO_ADDONDIR."/classlib/classes/phpthumb/phpthumb.class.php") ){
	require_once(PATH_TO_ADDONDIR."/classlib/classes/phpthumb/phpthumb.class.php");
}
if (!defined('CLASSLIB_VERSION_NR')) {
  define('CLASSLIB_VERSION_NR','2.8');
}
if (!defined('CLASSLIB_VERSION')) {
  define('CLASSLIB_VERSION',' (classlib&nbsp;'.CLASSLIB_VERSION_NR.')');
}
if (!defined('CLASSLIB_IMG_TYPES')) {
  define('CLASSLIB_IMG_TYPES',$classlib_img_types);
}
if (!defined('CLASSLIB_INFO')) {
  define('CLASSLIB_INFO',"Classlib ".CLASSLIB_VERSION_NR." &#169; <a href=\"mailto:webobjects@gmx.net?subject=LMO-KLASSENBIBLIOTHEK\" title=\"Send mail\">Timme</a>");
}

?>