<?
//
// Limporter Addon for LigaManager Online
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /
//
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
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

require_once(PATH_TO_LMO."/lmo-admintest.php");
require_once(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR."/limporter/lim_ini.php");
require_once(PATH_TO_ADDONDIR."/limporter/lim-classes.php");
require_once(PATH_TO_ADDONDIR."/limporter/lim-functions.php");

if(($file!="") && ($_SESSION['lmouserok']==2)){
  if(!isset($team)){$team="";}
  if(!isset($save)){$save=0;}
  $addr=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
  $addz=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=-2&amp;team=";
	$meldung = '';

 include(PATH_TO_LMO."/lmo-adminsubnavi.php"); ?>


<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">

  <tr>
    <td align="center"><h1><?=$titel?><h1></td>
  </tr>
  <tr>
    <td align="center">
      <form name="lmoedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<? echo $file; ?>">
        <input type="hidden" name="st" value="<? echo $st; ?>">
<?

  $liga1 = new liga();
	if ($liga1->loadFile(PATH_TO_LMO."/".$file)==false)
		echo "fehler beim Laden des LigaFiles";

 	if (isset($HTTP_POST_VARS)) {
   reset ($HTTP_POST_VARS);
   $changesFound = False;
   foreach ($HTTP_POST_VARS as $k=>$v) {
      $array = split('_',$k);
      if (isset($array) and count($array)==4 and ($array[0] == 'sp') and ($array[1] != $v)) {
      	$alteSpielTagNr = $array[1];
      	$neueSpielTagNr = $v;
      	$heimNr = $array[2];
      	$gastNr = $array[3];
      	$aSpielTag =$liga1->spieltagForNumber($alteSpielTagNr);
      	$newSpielTag =$liga1->spieltagForNumber($neueSpielTagNr);

      	$heim = $liga1->teamForNumber($heimNr);
      	$gast = $liga1->teamForNumber($gastNr);

       	$aPartie = $liga1->partieForTeams($heim,$gast);
      	if($aSpielTag->removePartie($aPartie)) {
      		$changesFound = True;
          $newSpielTag->addPartie(&$aPartie);
          $liga1->spieltage[$neueSpielTagNr-1] = $newSpielTag;
          $liga1->spieltage=array_values($liga1->spieltage); // Index neu erstellen
          $liga1->spieltage[$alteSpielTagNr-1] = $aSpielTag;
          $liga1->spieltage=array_values($liga1->spieltage); // Index neu erstellen
          $meldung = "Partie ".$aPartie->heim->name." - ".$aPartie->gast->name." vom $alteSpielTagNr. zum $neueSpielTagNr. Spieltag verschoben.<BR>";
        }

      }
   } // foreach

   if ($changesFound == True) {
      $liga1->writeFile(PATH_TO_LMO."/".$file,0,0);
   }
 }
  $liga = new liga();
	$liga->loadFile(PATH_TO_LMO."/".$file);

?>
        <? echo "<font color=\"#008800\">".$meldung."</font>"; ?>
        <table border= '0' cellspacing='0' align='center' class="lmoInner">
        <? foreach ($liga->spieltage as $spTag) { ?>
        <tr>
        	<th width=15 class="nobr">&nbsp;</th>
        	<th colspan=6 class="nobr" align='left'>
        		<strong><?=$spTag->nr.". Spieltag - ".$spTag->vonBisString()."</strong> / ".$spTag->partienCount()." Partien" ; ?>
        	</th>
        	<th colspan=3 class="nobr" align='left'>&nbsp;</th>
      	</tr>

<?
    $pcount = 1;
    $teamArray = array();
    foreach ($spTag->partien as $partie) {
      $hTore = $partie->hTore;
      $gTore = $partie->gTore;
      if($hTore == -1 and $gTore == -1) {
        $hTore = "__";
        $gTore = "__";
      }
      else if ($hTore < -1 or $gTore < -1) {
        $hTore = 0;
        $gTore = 0;
      }
      $teamArray[] = $partie->heim->nr;
      $teamArray[] = $partie->gast->nr;
?>
        <tr>
          <td">&nbsp</td>

          <td>&nbsp</td>
<?=$partie->datumString()." ".$partie->zeitString(); ?></td>
          <td>&nbsp</td>
<?=$partie->heim->name; ?></td>
          <td>&nbsp</td>
-</td>
          <td>&nbsp</td>
<?=$partie->gast->name; ?></td>
          <td class="lmost5" align='right' ><?=$hTore; ?></td>
          <td>&nbsp</td>
:</td>
          <td class="lmost5" align='center'><?=$gTore; ?></td>
          <td>&nbsp</td>
</td>
          <td>&nbsp</td>

<?
      echo "<select class=\"lmo-formular-input\" onChange=\"dolmoedit()\" name=\"sp_";
      echo $spTag->nr."_".$partie->heim->nr."_".$partie->gast->nr."\">\n";
      for ($sp = 1;$sp <= $liga->spieltageCount();$sp++) {
        echo "<option value=$sp";
        if($spTag->nr==$sp){echo " selected";}
        echo ">".$sp.".Spieltag</option>";
      }
      echo "</select>"
?>
					</td>
      	</tr>
<?
      $pcount++;
    }
		if ($liga->options->valueForKey("Type") == 0 ) {
    foreach ($liga->teams as $team) {
    	if (!in_array($team->nr,$teamArray)) {
?>
        <tr>
          <td">&nbsp</td>

          <td>&nbsp</td>
&nbsp;</td>
          <td>&nbsp</td>
&nbsp;</td>
          <td>&nbsp</td>
&nbsp;</td>
          <td>&nbsp</td>
<?=$team->name; ?></td>
          <td class="lmost5" align='right' colspan=3>Spielfrei</td>
        </tr>
<?
    	} // if
    } 	// foreach ($liga->teams as $team)
    }
	// teamnummern die an einem spieltag antreten. f�r eine js-Funktion, die verhindert
	// das ein team mehrmals an einem spieltag antreten muss js-funktion muss noch gebaut werden
	echo "<input type='hidden' name='sptext_".$spTag->nr."' value='".implode(",",$teamArray)."'>";
  }			// foreach ($spTag->partien as $partie)

?>
  <tr>
    <td class="lmost5" colspan="10" align="center"><? echo LIM_VERSIONS ; ?></td>
  </tr>


        <tr>
            <th colspan=10 align="middle">
              <acronym title="<? echo $text[114] ?>"><input class="lmo-formular-button" type="submit" name="spPlan" value="<? echo "&Auml;nderungen speichern"; ?>"></acronym>
            </th>
          </tr>
				</table>
        </td>
        </tr>
        </table>
      </form>
    </td>
  </tr>

<?}?>