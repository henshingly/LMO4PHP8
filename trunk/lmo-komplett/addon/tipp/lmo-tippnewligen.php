<?
// 
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
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
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if (($action == "tipp") && ($todo == "newligen")) {
  if ($newpage == 1) {
    $users = array("");
    $pswfile = PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
    $datei = fopen($pswfile, "rb");
    while (!feof($datei)) {
      $zeile = fgets($datei, 1000);
      $zeile = trim(chop($zeile));
      if ($zeile != "") {
        if ($zeile != "") {
          array_push($users, $zeile);
        }
      }
    }
    fclose($datei);
    $gef = 0;
    for($i = 1; $i < count($users) && $gef == 0; $i++) {
      $dummb = split("[|]", $users[$i]);
      if ($lmotippername == $dummb[0]) {
        // Nick gefunden
        $gef = 1;
      }
    }
    if ($gef == 0) {
      exit;
    }
     
    if ($xtipperligen != "") {
      foreach($xtipperligen as $key => $value) {
        $tippfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$value."_".$lmotippername.".tip";
        $st = -1;
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippsavefile.php"); // Tipp-Datei erstellen
        $auswertdatei = fopen(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/".$value.".aus", "ab");
        flock($auswertdatei, 2);
        fputs($auswertdatei, "\n[".$lmotippername."]\n");
        fputs($auswertdatei, "Team=".$dummb[5]."\n");
        fputs($auswertdatei, "Name=".$dummb[3]."\n");
        flock($auswertdatei, 3);
        fclose($auswertdatei);
      }
    }
  } // end ($newpage==1)
?>
<table class="lmoInner" width="100%" cellspacing="0" cellpadding="0" border="0">
  <caption><?=$lmotippername;if($lmotipperverein!=""){echo " - ".$lmotipperverein;} ?></caption>
  <tr>
    <th align="center"><?=$text['tipp'][135]; ?></th>
  </tr>
  <tr>
    <td align="left"><? 
  if($newpage!=1){ ?>
      <form name="lmotippedit" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="newligen">
        <input type="hidden" name="newpage" value="1"><? 
  $ftype=".l98"; 
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php"); 
    if($i!=0){ ?>
        <input class="lmo-formular-button" type="submit" name="xtippersub" value="<?=$text['tipp'][11]; ?>"><? 
    } ?>
      </form><? 
  }?>
    </td>
  </tr><?
  
  if($newpage==1){ /* Anmeldung erfolgreich */?>
  <tr>
    <td class="message" align="center"><img src="<?=URL_TO_IMGDIR?>/right.gif" border="0" width="12" height="12" alt="">  <?=$text['tipp'][20]; ?></td>
  </tr><? 
  }
  
  if($newpage==1 || $i==0){ /* zur�ck zur �bersicht */?>
  <tr>
    <td class="lmoFooter" align="right"><a href="<?=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=" ?>"><?=$text[5]." ".$text['tipp'][1]; ?></a></td>
  </tr><? 
  }?>    
</table><? 
} 
$file=""; ?>