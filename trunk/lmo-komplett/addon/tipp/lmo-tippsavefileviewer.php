<?PHP
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
if($tippfile!=""){
  //if(decoct(fileperms($tippfile))!=100777){chmod ($tippfile, 0777);}
  if(substr($tippfile,-4)==".tip"){
    $daten = array("");
    if(file_exists($tippfile)){
      $datei = fopen($tippfile,"rb");
      while (!feof($datei)) {
        $zeile = fgets($datei,1000);
        $zeile=trim(chop($zeile));
        if($zeile!=""){array_push($daten,$zeile);}
        }
      fclose($datei);
      }

    $datei = fopen($tippfile,"wb");
    if (!$datei) {
      echo "<p class='error'>".$text[283]."</p>";
      exit;
      }elseif($start1==0){echo "<p class='message'>".$text['tipp'][41]."<br></p>";}
    flock($datei,2);

    $stsave=array_pad($array,116,"0");
    $round=0;
    for($l=0;$l<count($daten);$l++){
      if(substr($daten[$l],0,6)=="[Round"){
        fputs($datei,$daten[$l]."\n");
        $round=substr($daten[$l],6,-1);
        $jksave=0;
        $stsave[$round]=1;
        for($k=$start1;$k<=$i;$k++){
          if($round==$spieltag[$k]){ // getippte dazu schreiben
            if($jksave==0){
              if($jksp[$k]>0){
                fputs($datei,"@".$jksp[$k]."@\n");
                $jksave=1;
                }
              elseif(substr($daten[$l+1],0,1)=="@"){
                $l++;
                fputs($datei,$daten[$l]."\n");
                $jksave=1;
                }
              }
            if($tippa[$k]=="_"){fputs($datei,"GA".$spiel[$k]."=-1\n");}
              elseif($tippa[$k]==""){fputs($datei,"GA".$spiel[$k]."=-1\n");}
              else{fputs($datei,"GA".$spiel[$k]."=".$tippa[$k]."\n");}
            if($tippb[$k]=="_"){fputs($datei,"GB".$spiel[$k]."=-1\n");}
              elseif($tippb[$k]==""){fputs($datei,"GB".$spiel[$k]."=-1\n");}
              else{fputs($datei,"GB".$spiel[$k]."=".$tippb[$k]."\n");}
            }
          }
        if($k==($i+1) && $jksave==0 && substr($daten[$l+1],0,1)=="@"){ // Joker von nicht getippten Spieltag zurückschreiben
          $l++;
          fputs($datei,$daten[$l]."\n");
          $jksave=1;
          }
        }
      elseif($daten[$l]!="" && substr($daten[$l],0,1)!="@"){
        for($k=$start1;$k<=$i;$k++){
          $sp=substr($daten[$l],2,strpos($daten[$l],"=")-2);
          if($sp==$spiel[$k] && $round==$spieltag[$k]){
            break; // nicht zurückschreiben
            }
          }
        if($k==($i+1)){fputs($datei,$daten[$l]."\n");}
        }
      }

    for($k=$start1;$k<=$i;$k++){
      if($spieltag[$k]>0 && $stsave[$spieltag[$k]]==0){ // vorher nicht getippte st dazu schreiben
        if($k==$start1 || $spieltag[$k]!=$spieltag[$k-1]){
          fputs($datei,"[Round".$spieltag[$k]."]\n");
          if($jksp[$k]>0){fputs($datei,"@".$jksp[$k]."@\n");}
          }
        if($tippa[$k]=="_"){fputs($datei,"GA".$spiel[$k]."=-1\n");}
          elseif($tippa[$k]==""){fputs($datei,"GA".$spiel[$k]."=-1\n");}
          else{fputs($datei,"GA".$spiel[$k]."=".$tippa[$k]."\n");}
        if($tippb[$k]=="_"){fputs($datei,"GB".$spiel[$k]."=-1\n");}
          elseif($tippb[$k]==""){fputs($datei,"GB".$spiel[$k]."=-1\n");}
          else{fputs($datei,"GB".$spiel[$k]."=".$tippb[$k]."\n");}
        }
      }

    flock($datei,3);
    fclose($datei);
    }

  clearstatcache();
  }
?>