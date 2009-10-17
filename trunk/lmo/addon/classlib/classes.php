<?PHP
/**
 * LMO Class Library Version (01/2004)
 *
 * Die LMO Class Library (classlib) bildet ein Ligadatei (.l98) des LMO
 * in Form eines Objektbaums ab und erm�glicht so die Entwicklung von
 * objektorientierten Erweiterung in Form von sog. Addons f�r den Liga Manager Online.
 *
 * �nderungen:
 *  20.07.04 2.0 Start
 *  22.07.04 2.1 Pdf Class hinzugef�gt.
 *  23.07.04 2.1 Bugfix in methode $liga->writeFile teamdetails gingen verloren
 *  31.07.04     relative Pfadangabe in class.ezpdf.php ersetzt
 *  01.08.04 2.2 Spielbericht (reportURL) zur class Partie hinzugef�gt
 *               Beim Einlesen der Runden wird jetzt der Pokalmodus ber�cksichtigt
 *  20.09.04 2.3 Class iniFile function getIniFile
 *               Beim Auslesen einer URL, die keyValues enth�lt
 *               fehlten die Gleichheitszeichen
 *  22.09.04 2.3 Pokalmodus in loadLiga implementiert
 *  22.11.04 2.4 Mal wieder keyValue gefunden und in keyValues ge�ndert
 *               classes.php Ist der aktuelle Spieltag nicht gesetzt wird $aktSpTag = 1
 *  02.12.04 2.5 writeFile / loadFile ge�ndert
 *               Das komplette File wird zun�chst in ein array geladen und zwischengespeichert.
 *               Beim Speichern wird dieses zun�chst mit den Werten der Objekte abgeglichen und
 *               dann im Anschluss komplett ins file geschrieben. Dadurch gehen keine Informationen verloren
 *               Auch Erweiterungen des LigaFiles (z.B, zus�tzliche Sektionen wie beim MittellangTeamName
 *               Addon werden erkannt und geschrieben.
 *  20.12.04 2.6 neue Fktion gamesSorted hinzugef�gt (Sortierung der Partien)
 *  14.01.05 2.6 SP1 Klasse Partie function valuateGame() Ermittelt die Wertung einer Partie (beta Status)
 *  16.02.05 2.7 Klasse Partie fkt. gToreString() und hToreString() �berarbeitet. Bei greenTable wird 0 bzw. 0*
 *									 zur�ckgegeben.
 *  10.04.05 2.7 (Dank an Gowi) update Funktionen f�r addons implementiert
 * @author    Tim Schumacher <webobjects@gmx.net>
 * @version   2.7
 * @package   classLib
*/

//Team
require(PATH_TO_ADDONDIR."/classlib/classes/team.class.php");

//Spieltag
require(PATH_TO_ADDONDIR."/classlib/classes/spieltag.class.php");

//Partie
require(PATH_TO_ADDONDIR."/classlib/classes/partie.class.php");

//Sektion (Ligafile Inhalt)
require(PATH_TO_ADDONDIR."/classlib/classes/sektion.class.php");

//optionsSektion (Ligafile Optionen)
require(PATH_TO_ADDONDIR."/classlib/classes/optionsSektion.class.php");

//Liga
require(PATH_TO_ADDONDIR."/classlib/classes/liga.class.php");



?>