<?PHP
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
if(($file!="") && ($_SESSION['lmouserok']==2)){
  require_once(PATH_TO_LMO."/lmo-openfile.php");
  if(isset ($save) && $save==1){
    for($i=0;$i<$anzst;$i++){
      for($j=$anzsp;$j<40;$j++){
        $teama[$i][$j]=0;
        $teamb[$i][$j]=0;
        $goala[$i][$j]=-1;
        $goalb[$i][$j]=-1;
        $msieg[$i][$j]=0;
        $mterm[$i][$j]="";
        $mnote[$i][$j]="";
        $mberi[$i][$j]="";
        $mspez[$i][$j]="_";
        }
      }
    for($i=$anzst;$i<116;$i++){
      for($j=0;$j<40;$j++){
        $teama[$i][$j]=0;
        $teamb[$i][$j]=0;
        $goala[$i][$j]=-1;
        $goalb[$i][$j]=-1;
        $msieg[$i][$j]=0;
        $mterm[$i][$j]="";
        $mnote[$i][$j]="";
        $mberi[$i][$j]="";
        $mspez[$i][$j]="_";
        }
      }
    $anzst=trim($_POST["xanzst"]);
    $anzsp=trim($_POST["xanzsp"]);
    if($stx>$anzst){$stx=$anzst;}
    require(PATH_TO_LMO."/lmo-savefile.php");
    }
  $addr=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" class="lmost3">
      <form name="lmoedit" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?PHP echo $file; ?>">
        <input type="hidden" name="st" value="<?PHP echo $st; ?>">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td class="lmost4" colspan="3"><?PHP echo $text[340]; ?></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><acronym title="<?PHP echo $text[275] ?>"><?PHP echo $text[274]; ?></acronym></td>
            <td class="lmost5">
              <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xanzst" size="3" maxlength="3" value="<?=$anzst?>" onChange="lmoanzstauf('xanzst',0)" onKeyDown="lmoanzstclk('xanzst',event.keyCode)"></td>
                  <td class="lmost5" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmoanzstauf(\'xanzst\',1);" title="<?PHP echo $text[276]; ?>" onMouseOver="lmoimg(\'sa\',img1)" onMouseOut="lmoimg(\'sa\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximgsa" width="7" height="7" border="0"></a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmoanzstauf(\'xanzst\',-1);" title="<?PHP echo $text[276]; ?>" onMouseOver="lmoimg(\'sb\',img3)" onMouseOut="lmoimg(\'sb\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximgsb" width="7" height="7" border="0"></a>')</script></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><acronym title="<?PHP echo $text[278] ?>"><?PHP echo $text[277]; ?></acronym></td>
            <td class="lmost5">
              <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xanzsp" size="2" maxlength="2" value="<?=$anzsp?>" onChange="lmoanzspauf('xanzsp',0)" onKeyDown="lmoanzspclk('xanzsp',event.keyCode)"></td>
                  <td class="lmost5" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmoanzspauf(\'xanzsp\',1);" title="<?PHP echo $text[279]; ?>" onMouseOver="lmoimg(\'pa\',img1)" onMouseOut="lmoimg(\'pa\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximgpa" width="7" height="7" border="0"></a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmoanzspauf(\'xanzsp\',-1);" title="<?PHP echo $text[279]; ?>" onMouseOver="lmoimg(\'pb\',img3)" onMouseOut="lmoimg(\'pb\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximgpb" width="7" height="7" border="0"></a>')</script></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td class="lmost4" colspan="3" align="right">
              <acronym title="<?PHP echo $text[114] ?>"><input class="lmoadminbut" type="submit" name="best" value="<?PHP echo $text[188]; ?>"></acronym>
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td><? include(PATH_TO_LMO."/lmo-adminnaviunten.php"); ?></td>
  </tr>
</table>

<?PHP } ?>