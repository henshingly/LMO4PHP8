<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					"http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
<head>
<title>Tippspielregeln</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
<?PHP
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  * 
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  */
  
  
require(dirname(__FILE__)."/../../init.php");
?>
<style type="text/css">
  body { background: #fff; color: #000; font-family: sans-serif; font-size: 91%; }
  a {font-size:91%;}
  a:active {text-decoration: overline underline;}
  a:hover {text-decoration: overline underline;}
  h1 { color:#ddf; Background:#006;margin: 10px auto 4px auto; font-size: 115%; font-weight: bold; text-align: center; }
  h2 { font-size: 105%; font-weight: bold; color:#009;}
  h3 { margin-bottom: 4px; font-size: 100%; font-weight: bold; }
  ul {list-style-type:none;}
  ul ul {list-style-type:disc;}
  ul#rechtliches {color:#900;}
  strong{color:#060;}
</style>
</head>
<body>
<script type="text/javascript">document.write('<a href="#" onclick="self.close();">Fenster schlie�en</a>')</script>
<h1>Anleitung f�r das Tippspiel</h1>
<p>Nach der  Anmeldung zum Tippspiel hat der Tipper die M�glichkeit, eine <strong>oder</strong> mehrere Tippspiele 
zu abonnieren.</p>
<ol>
  <li><h2>Verfahren zum Abonnieren und Spielen einzelner Ligen</h2>
    <ul>
      <li><h3>Anmelden und Verwalten</h3>
        <ol>
          <li>Im Login-Bereich auf "<strong>anmelden</strong>" klicken .</li>
          <li>Alle Anmeldedaten eintragen und ausw�hlen, welche Liga Sie abonnieren m�chten.<br>
            <strong>Hinweis</strong>: Weitere Ligen k�nnen Sie jederzeit nach der Erstanmeldung unter 
            Ihrem Usernamen nachtr�glich abonnieren!</li>
          <li>Nach der Anmeldung sind Sie eingeloggt bzw. Sie k�nnen sich jetzt jederzeit 
            mit Ihrem Nickname einloggen.</li>
          <li>Im User-Bereich des Tippspiels k�nnen Sie:
            <ul>
              <li>Eine abonnierte <strong>Liga tippen</strong></li>
              <li><strong>Punktst�nde anschauen</strong></li>
              <li><strong>Ihre Daten �ndern</strong></li>
              <li><strong>andere bzw. neue Ligen in Ihren Tippschein aufnehmen </strong></li>
              <li><strong>Passwort �ndern </strong></li>
              <li><strong>Tipp-Account l�schen</strong> (<strong>Achtung</strong>: Alle abonnierten Tippspiele 
              Ihres Nicknames werden gel�scht!)</li>
              <li><strong>Aus dem Tippspiel ausloggen </strong></li>
            </ul>
          </li>
        </ol>
      </li>
      <li><h3>Liga tippen</h3>
        <ol>
          <li>Nach dem Einloggen im Tippspielbereich eine abonnierte Liga zum Tippen ausw�hlen.</li>
          <li>Im Ansetzungsbereich k�nnen Sie nun Ihre Tipps f�r die einzelnen Spieltage 
          abgeben.</li>
          <li>Nach Eingabe der Tipps <strong>eines Spieltages</strong> klicken Sie auf - <strong>Tipps 
          speichern</strong><br>
          Sie k�nnen jetzt auf einen anderen Spieltag wechseln und weitere Tipps abgeben.</li>
        </ol>
      </li>
      <li><h3>Hinweise zur Tippabgabe:</h3>
        <ul>
          <li>Die Tippzeit l�uft f�r jedes Spiel einzeln ab. </li>
          <li>Ablauf der Tippzeit ist jeweils <?PHP echo $tipp_tippBis;?> Minuten vor Anpfiff.</li>
          <li>Sollten <strong>ohne</strong> unsere Kenntnis einzelne Spiele vorgezogen werden, bitten 
          wir das zu entschuldigen.<br>
          Wir versuchen jedoch immer <strong>vor</strong> einem Spieltag alle ver�nderten Ansto�zeiten 
          zu aktualisieren.</li>
        </ul>
      </li>
    </ul>
  </li>
  <li><h2>Spielwertung und Ligawertung</h2>
    <ul>
      <li><h3>Die Spielwertung (Punktverteilung)</h3>
        <ul>
          <li>Ergebnis richtig: <strong><?PHP echo $tipp_rergebnis;?> Punkte</strong></li>
          <li>nur Tendenz und Tordifferenz richtig: <strong><?PHP echo $tipp_rtendenzdiff;?> Punkte</strong></li>
          <li>nur Tendenz richtig: <strong><?PHP echo $tipp_rtendenz;?> Punkte</strong></li>
          <li>nur eine Toranzahl richtig: <strong><?PHP echo $tipp_rtor;?> Punkt</strong></li>
        </ul>
      </li>
      <li><h3>Die Liga- und Spieltagswertung</h3>
        <ul>
          <li>Die Gesamtligawertung erhalten Sie, wenn Sie in der Tippspiel-�bersicht eine 
          abonnierte Liga unter dem Punkt: <strong>Punktest�nde anschauen</strong> ausw�hlen.</li>
          <li>Sie erreichen die Gesamtligawertung auch, wenn Sie im Tippbereich auf - <strong>
          Ligawertung</strong> wechseln</li>
          <li>Die erzielten Punkte Ihrer <strong>einzelnen</strong> Spiele k�nnen Sie einsehen, wenn 
          Sie im Tippbereich einer Liga einen <strong>absolvierten Spieltag</strong> aufrufen.</li>
          <li><strong>Gesamtsieger</strong> ist, wer nach einer Spielsaison die meisten Punkte auf 
          seinem Spielkonto verbuchen kann.</li>
          <li>Zus�tzlich k�nnen unter <strong>Tippeinsicht</strong> die Tipps der Mitspieler eingesehen 
          werden</li>
          <li>Die <strong>Tipp-Tabelle</strong> ist eine Zusatzanzeige, also eine Tabelle erzeugt 
          nach Ihren abgegebenen Tipps</li>
        </ul>
      </li>
      <li><h3>Hinweise zum Zeitpunkt der Tippauswertung</h3>
        <ul>
          <li>Die technische Auswertung der Spieltipps erfolgt in der Regel nach jedem absolvierten 
          Spieltag.</li>
          <li>Bitte beachten Sie, dass sich aus organisatorischen Gr�nden die Tippauswertung auch 
          einmal um <strong>1 bis 2 Tage</strong> verz�gern kann.</li>
        </ul>
      </li>
    </ul>
  </li>
  <li><h3>Haftungsausschlu�</h3>  
    <ul id="rechtliches">
      <li>F�r etwaige �bertragungsfehler und sonstige technische Schwierigkeiten ist der 
      Veranstalter in keiner Weise verantwortlich zu machen.</li>
      <li>Mit der Anmeldung zum Spiel akzeptieren Sie die Bedingungen. Dieses Spiel dient 
      dem reinen Unterhaltungszweck. Wer hackt, verf�lscht, oder sich
      mehrmals unter verschiedenen Namen anmeldet, wird mit Spielsperre bestraft.</li>
      <li><strong>Der Rechtsweg ist ausgeschlossen.</strong></li>
    </ul>  
  </li>
</ol>
<script type="text/javascript">document.write('<a href="#" onclick="self.close();">Fenster schlie�en</a>')</script>
</body>
</html>