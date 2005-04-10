Durch diese Erweiterung von Gowi wird:
- das Tippspiel neu ausgewertet,
- die Zusatzstatistiken aktualisiert,
- die HTML-Ausgaben und das Minitabellen-CSV im Output-Verzeichnis automatisch aktualisiert, 

sobald der Limporter ein Ligaupdate durchgef�hrt hat.

Zus�tzliche Addons k�nnen in die update_addons.php eingepflegt werden, falls eine
Aktualisierung erforderlich ist.

Install:
update_addons.php ins classlib verzeichnis kopieren

Folgende zwei Anpassungen sind an der classes.php der classlib erforderlich:

suchen nach (ca. Zeile 1200): function writeFile

nach der Zeile:
function writeFile($fileName="",$message=0,$deleteEmptyRounds=0) {

folgendes einf�gen:
include 'update_addons.php';

suchen nach (ca. Zeile 1287): flock($datei,3);


[CODE SNIP]

// fileContent schreiben
   	foreach($iniData as $sek=>$keys) {
       fputs($datei,"[$sek]\n");
       foreach($keys as $key=>$val) {
        fputs($datei,"$key=$val\n");
        }
       fputs($datei,"\n");
		}
    flock($datei,3);
    fclose($datei);

[CODE SNIP]

nach der Zeile fclose($datei); 
folgendes einf�gen:
updateAddons($fileName);

Jetzt wird bei jedem Speichern der Liga die Funktion updateAddons() aufgerufen, in der Aktualisierungsroutinen f�r
die einzelnen Addons eingebaut werden k�nnen.

Dank an Gowi


