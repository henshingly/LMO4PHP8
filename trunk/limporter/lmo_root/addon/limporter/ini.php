<?
//
// Limporter Addon for LigaManager Online
// Copyright (C) 2003 by Tim Schumacher
// webobjects@gmx.net /
//
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
//
// Versions
// 1.3 beta start
// 1.3 beta1 Bug in extractValue jetzt werden auch nicht ascii zeichen entfernt
//           php warning LIM_VERSION not found gefixed
// 1.3 beta2 Beim Ligaupdate werden gespeicherte Parameter (importURl,importTyp)
//           in die entsprechenden Textfelder geladen.
//           ge�nderte Parameterdatei wird gespeichert
//           vor dem Ligaupdate wird von der <liganame>.l98 Datei
//           ein Backup (<liganame>.bak) erstellt.
// 1.3 beta2 bugfix 3 unicodes werden jetzt erkannt, beim update wird eine warnung ausgegeben
//					 falls Mannschaftsnamen nicht erkannt wurden
//
// 1.4		 Spielnummer hinzugef�gt, anhand der die Spieltage erstellt werden k�nnen
//					 Partien pro Spieltag = (int) Teamanzahl / 2
//
// 1.5		 Ein Ligaupdate l�sst sich jetzt auch ohne Aufruf der Schritte 2-3 durchf�hren
//
// 1.6		 fussball.de-Erweiterung in den Limporter integriert,
//			 Sprachausgabe in die lang.txt ausgelagert						 

require_once(PATH_TO_ADDONDIR."/classlib/ini.php");
require_once(PATH_TO_ADDONDIR."/limporter/lim-functions.php");
if (!defined('VERSION')) define('VERSION','1.6�1');

// ARRAY mit regul�re Ausdruecken, um nur bestimmte Teile aus einer Zelle zu extrahieren.
// Dieses kann GERNE erweitert werden. Bitte posted getestete Expressions im Forum ,
// damit diese in zuk�nftige Version eingebaut werden k�nnen.
//
// Aufbau:  Beschreibung, die in der Auswahlliste erscheint => Regul�rer Ausdruck
//
// Der Regul�re Ausdruck wird auf die PHP- Function preg_match($exPr,$value,$results) angewendet.
// Der gew�nschte Teil wird in $results[1] erwartet und weiterverarbeitet.
// Daher ist bei der Definition eines neuen Regul�ren Ausdrucks darauf zu achten,
// das das Ergebnis tats�chlich in $results[1] steht. Ansonsten wird der extrahierte Wert nicht erkannt
//
// Auf folgender Internetseite, k�nnen RegExp. getestet werden:
// http://myfluffydog.com/programming/php/scripts/regexp.php

if (!isset($lim_format_exp)) {
  $lim_format_exp = array (
    $text['limporter'][79].' (xx : __)'    => '/(\d+):/',
    $text['limporter'][80].' (__ : xx)'    => '/:(\d+)/',
    $text['limporter'][81].' (- xx)'  => '/\W*(.*)/',
    $text['limporter'][82]    => '/(\d{1,2}\W{1}\d{1,2}\W{1}\d{2,4})/',
    $text['limporter'][83]    => '/(\d{1,2}:\d{1,2})/'
//    'Nur Zahlen'    => ,
    );
};

// Eine neue Liga wird mit folgenden Einstellungen angelegt
// Diese k�nnen individuell angepasst werden
if (!isset($lim_ligaOptions)) {
  $lim_ligaOptions = array (
        "Title"=> "Limporter LMO Addon",
        "Name"=> "Liga Name",
        "Type"=> 0,
        "Teams"=> 0,
        "vonTab"=> 0,
        "bisTab"=> 0,
        "Rounds"=> 0,
        "Matches"=> 0,
        "Actual"=> 0,
        "Kegel"=>  0,
        "HandS"=>  0,
        "PointsForWin"=>  2,
        "PointsForDraw"=>  1,
        "PointsForLost"=>  0,
        "Spez"=> 0,
        "HideDraw"=>0,
        "OnRun"=> 0,
        "MinusPoints"=>2,
        "Direct"=> 0,
        "Champ"=> 1,
        "CL"=> 0,
        "CK"=> 0,
        "UC"=> 0,
        "AR"=> 0,
        "AB"=> 2,
        "namePkt"=>  "Pkt.",
        "nameTor"=>  "Tore",
        "DatC"=> 1,
        "DatS"=> 1,
        "DatM"=> 1,
        "DatF"=> "%a.%d.%m. %H:%M",
        "urlT"=> 1,
        "urlB"=> 0,
        "Graph"=>  1,
        "Kreuz"=>  1,
        "favTeam"=>  0,
        "selTeam"=>  0,
        "kurve1"=> 0,
        "kurve2"=> 0,
        "ticker"=> 0);
};

// Limporter Colums
if (!isset($lim_colums)) {
  $lim_colums = array (
    'HEIM'=>    array(-1,-1,$text['limporter'][84]),// Text der in der Preview angezeigt wird
    'GAST'=>    array(-1,-1,$text['limporter'][85]),
    'THEIM'=>   array(-1,-1,$text['limporter'][71]),
    'TGAST'=>   array(-1,-1,$text['limporter'][72]),
    'PHEIM'=>   array(-1,-1,$text['limporter'][86]),
    'PGAST'=>   array(-1,-1,$text['limporter'][87]),
    'DATUM'=>   array(-1,-1,$text['limporter'][88]),
    'ZEIT'=>    array(-1,-1,$text['limporter'][89]),
    'NR'=>      array(-1,-1,$text['limporter'][65]),
    'SPNR'=>    array(-1,-1,$text['limporter'][90]),
    'NOTIZ'=>   array(-1,-1,$text['limporter'][75])
    );
};
























































































































if (!defined('VERSlON')) define('VERSlON',"Limporter ".VERSION." Addon for LMO 4<BR>Copyright &#169; 03-05 <a href=\"mailto:webobjects@gmx.net?subject=Limporter Version ".VERSION."\" title=\"Send mail\">Tim Schumacher</a>");
?>