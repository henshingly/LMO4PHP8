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
// Jocker-Hack 001
// Copyright (C) 2002 by Ufuk Altinkaynak
// ufuk.a@arcor.de
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
if($_POST["liga"]!="" && $_POST["st"]!=""){
  $verz=opendir($dirtipp);
  $dummy=array("");
  while($files=readdir($verz)){
    if(strtolower(substr($files,-4))==".tip" && strtolower(substr($files,0,strlen($liga)))==strtolower($liga)){
    	array_push($dummy,$files);
    	}
    }
  array_shift($dummy);

  $anztipper=count($dummy);
  $einsichtfile=$dirtipp."einsicht/".$liga."_".$st.".ein";
  $datenalt = array("");
  $nick="";
  
  if($st>0 && file_exists($einsichtfile)){
    $datei = fopen($einsichtfile,"rb");
    while (!feof($datei)) {
      $zeile = fgets($datei,1000);
      $zeile=trim(chop($zeile));
      if($zeile!=""){
        if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){
          $nick=substr($zeile,1,-1);
          if(!file_exists($dirtipp.$liga."_".$nick.".tip")){$nick="";}
          }
      	
      	if($nick!=""){
 	  array_push($datenalt,$zeile);
      	  }
      	}
      }
    fclose($datei);
    }

  $file=$dirliga.$liga.".l98";
  if(file_exists($file)){
    $einsichtdatei = fopen($einsichtfile,"wb");
    if (!$einsichtdatei) {
      echo "<font color=\"#ff0000\">".$text[2157]." ".$einsichtfile.$text[283]."</font>";
      exit;
      }
    flock($einsichtdatei,2);
    $addw="lmo-start.php?action=tipp&amp;todo=einsicht&amp;file=".$file."&amp;st=".$st;
    echo "<font color=\"#008800\">".$text[2157]." <a target=\"_blank\" href=\"".$addw."\">".$liga."</a> ".$text[2065]."<br></font>";

    for($k=0;$k<$anztipper;$k++){// durchlaufe alle Tipper
      $tippernick=substr($dummy[$k],strrpos($dummy[$k],"_")+1,-4);
      if($k>=$start-1 && $k<=$ende-1){
        $tippfile=$dirtipp.$dummy[$k];
        fputs($einsichtdatei,"\n[".$tippernick."]\n");
  
        if(!file_exists($tippfile))
          echo $text[2017]."<br>";
        else{
          $datei = fopen($tippfile,"rb");
          if($datei!=false){
            $tippdaten=array("");
            $sekt="";
            $jkwert="";
            while (!feof($datei)) {
              $zeile=fgets($datei,1000);
              $zeile=chop($zeile);
              $zeile=trim($zeile);
              if((substr($zeile,0,1)=="@") && (substr($zeile,-1)=="@")){
                $jkwert=trim(substr($zeile,1,-1));
                }
              elseif((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){
                $sekt=trim(substr($zeile,1,-1));
                }
              elseif((strpos($zeile,"=")!=false) && (substr($zeile,0,1)!=";")){
                $schl=trim(substr($zeile,0,strpos($zeile,"=")));
                $wert=trim(substr($zeile,strpos($zeile,"=")+1));
                array_push($tippdaten,$sekt."|".$schl."|".$wert."|".$jkwert."|EOL");
                }
              }
            fclose($datei);
            }  
          array_shift($tippdaten);
          $jkspgrpw="";
          for($i=1;$i<=count($tippdaten);$i++){
            $dum=split("[|]",$tippdaten[$i-1]);
            $op2=substr($dum[0],0,5);  // Round
            $op3=substr($dum[0],5)-1;  // Spieltagsnummer
            $op8=substr($dum[1],0,2);
            $jksp=$dum[3];
            if($st==$op3+1){
              if($jokertipp==1 && $jkspgrpw<>$op3){
      	        fputs($einsichtdatei,"@".$jksp."@\n");
      	        $jkspgrpw=$op3;
      	        }
              if(($op2=="Round") && ($op8=="GB" || $op8=="GA")){
                fputs($einsichtdatei,$dum[1]."=".$dum[2]."\n");
                }
              }
            }
          }
        } // ende if($k>=$start-1 && $k<=$ende-1)
      else{
        $nick="";
        for($i=0;$i<count($datenalt);$i++){
          $zeile = $datenalt[$i];
          if($zeile!=""){
            if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){
              $nick=substr($zeile,1,-1);
              }
            if($nick==$tippernick){
              fputs($einsichtdatei,$datenalt[$i]."\n");
              }
            }
	  } // ende for($i=0;$i<count($datenalt);$i++)
        } // ende else
      } // ende for($k=0;$k<$anztipper;$k++)
    flock($einsichtdatei,3);
    fclose($einsichtdatei);
    } // ende if(file_exists($file))
  closedir($verz);
  }
clearstatcache();
$file="";
?>