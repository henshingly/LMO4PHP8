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
if(isset($file) && $file!=""){
  $me=array("0","January","February","March","April","May","June","July","August","September","October","November","December");
  if(substr($file,-4)==".l98"){
    $daten=array("");
    $sekt="";
    $stand=gmdate("d.m.Y H:i",filectime(PATH_TO_LMO.'/'.$file));
    $datei = fopen(PATH_TO_LMO.'/'.$file,"rb");
    while (!feof($datei)) {
      $zeile = fgets($datei,1000);
      $zeile=chop($zeile);
      $zeile=trim($zeile);
      if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){
        $sekt=trim(substr($zeile,1,-1));
        }
      elseif((strpos($zeile,"=")!=false) && (substr($zeile,0,1)!=";")){
        $schl=trim(substr($zeile,0,strpos($zeile,"=")));
        $wert=trim(substr($zeile,strpos($zeile,"=")+1));
        if($sekt=="Options"){
          if($schl=="Title"){$lmvers=$wert;}
          if($schl=="Name"){$titel=stripslashes($wert);}
          if($schl=="mittore"){$mittore=stripslashes($wert);}
          if($schl=="Type"){$lmtype=stripslashes($wert);}
          if(!isset($lmtype)){$lmtype=0;}
          if($schl=="Teams"){$anzteams=$wert;}
          if($lmtype==0){
            if($schl=="Rounds"){$anzst=$wert;}
            if($schl=="Matches"){$anzsp=$wert;}
            }
          if(!isset($st)){if($schl=="Actual"){$st=$wert;}}
          if($schl=="Actual"){$stx=$wert;}
          if($lmtype==0){
            if($schl=="Kegel"){$kegel=$wert;}
            if($schl=="HandS"){$hands=$wert;}
            if($schl=="PointsForWin"){$pns=$wert;}
            if($schl=="PointsForDraw"){$pnu=$wert;}
            if($schl=="PointsForLost"){$pnn=$wert;}
            if($schl=="MinusPoints"){$minus=$wert;}
            if($schl=="Direct"){$direkt=$wert;}
            if($schl=="Spez"){$spez=$wert;}
            if($schl=="HideDraw"){$hidr=$wert;}
            if($schl=="OnRun"){$onrun=$wert;}
            if($schl=="XtraS"){$pxs=$wert;}
            if($schl=="XtraU"){$pxu=$wert;}
            if($schl=="XtraV"){$pxn=$wert;}
            if($schl=="SpezS"){$pps=$wert;}
            if($schl=="SpezU"){$ppu=$wert;}
            if($schl=="SpezV"){$ppn=$wert;}
            if($schl=="Champ"){$champ=$wert;}
            if($schl=="CL"){$anzcl=$wert;}
            if($schl=="CK"){$anzck=$wert;}
            if($schl=="UC"){$anzuc=$wert;}
            if($schl=="AR"){$anzar=$wert;}
            if($schl=="AB"){$anzab=$wert;}
            if($schl=="namePkt"){$namepkt=$wert;}
            if($schl=="nameTor"){$nametor=$wert;}
            }
          else{
            if($schl=="KlFin"){$klfin=$wert;}
            }
          if($schl=="DatC"){$datc=$wert;}
          if($schl=="DatS"){$dats=$wert;}
          if($schl=="DatM"){$datm=$wert;}
          if($schl=="DatF"){$datf=$wert;}
          if($schl=="urlT"){$urlt=$wert;}
          if($schl=="urlB"){$urlb=$wert;}
          if($schl=="Graph"){$kurve=$wert;}
          if($schl=="Kreuz"){$kreuz=$wert;}
          if($schl=="favTeam"){$favteam=$wert;}
          if(!isset($selteam)){if($schl=="selTeam"){$selteam=$wert;}}
          if($lmtype==0){
            if(!isset($stat1)){if($schl=="kurve1"){$stat1=$wert;}}
            if(!isset($stat2)){if($schl=="kurve2"){$stat2=$wert;}}
            }
          if($schl=="ticker"){$nticker=$wert;}
          }
        array_push($daten,$sekt."|".$schl."|".$wert."|EOL");
        }
      }
    fclose($datei);
    if(!isset($st)){$st=1;}
    if(!isset($stx)){$stx=1;}
    if(!isset($kurve)){$kurve=1;}
    if(!isset($kreuz)){$kreuz=1;}
    if(!isset($favteam)){$favteam=0;}
    if(!isset($selteam)){$selteam=0;}
    if(!isset($stat1)){$stat1=0;}
    if(!isset($stat2)){$stat2=0;}
    if(($stat1>0) && ($stat1==$stat2)){$stat2=0;}
    if(($stat1==0) && ($stat2>0)){$stat1=$stat2;$stat2=0;}
    array_shift($daten);
    if(!isset($lmvers)){$lmvers="k.A.";}
    if(!isset($titel)){$titel="No Name";}
    if($lmtype==0){
      if(!isset($anzteams)){$anzteams=18;}
      if(!isset($anzsp)){$anzsp=floor($anzteams/2);}
      if(!isset($anzst)){$anzst=floor($anzteams*($anzteams-1)/$anzsp);}
      if(!isset($hands)){$hands=0;}
      }
    else{
      if(!isset($anzteams)){$anzteams=16;}
      $anzsp=floor($anzteams/2);
      $anzst=strlen(decbin($anzteams-1));
      $spez=1;
      $hands=0;
      }
    if($lmtype==0){
      if(!isset($hidr)){$hidr=0;}
      if(!isset($onrun)){$onrun=0;}
      if(!isset($kegel)){$kegel=0;}
      if(!isset($minus)){$minus=1;}
      if(!isset($pns)){$pns=3;}
      if(!isset($pnu)){$pnu=1;}
      if(!isset($pnn)){$pnn=0;}
      if(!isset($pxs)){$pxs=0;}
      if(!isset($pxu)){$pxu=0;}
      if(!isset($pxn)){$pxn=0;}
      if(!isset($pps)){$pps=0;}
      if(!isset($ppu)){$ppu=0;}
      if(!isset($ppn)){$ppn=0;}
      if(!isset($champ)){$champ=1;}
      if(!isset($anzcl)){$anzcl=1;}
      if(!isset($anzck)){$anzck=0;}
      if(!isset($anzuc)){$anzuc=3;}
      if(!isset($anzar)){$anzar=0;}
      if(!isset($anzab)){$anzab=3;}
      if(!isset($namepkt)){$namepkt="";}
      if(!isset($nametor)){$nametor="";}
      if($namepkt!=""){$text[37]=$namepkt;}else{$namepkt=$text[37];}
      if($nametor!=""){$text[38]=$nametor;}else{$nametor=$text[38];}
      }
    else{
      if(!isset($klfin)){$klfin=0;}
      }
    if(!isset($dats)){$dats=1;}
    if(!isset($datm)){$datm=0;}
    if(!isset($datc)){if((isset($dats)) || (isset($datm))){$datc=1;}else{$datc=0;}}
    if((!isset($dats)) || (!isset($datm))){$datc=0;}
    if(!isset($datf)){$datf="%d.%m. %H:%M";}
    if(!isset($urlt)){$urlt=1;}
    if(!isset($urlb)){$urlb=0;}
    $teams = array_pad($array,$anzteams+2,"");
    $teamk = array_pad($array,$anzteams+2,"");
    $teamu = array_pad($array,$anzteams+2,"");
    $teamn = array_pad($array,$anzteams+2,"");
    if(!isset($nticker)){$nticker=0;}
    if($nticker==1){
      $nlines = array();
      }
    if($lmtype==0){
      $strafp = array_pad(array("0"),116,"0");
      $strafm = array_pad(array("0"),116,"0");
      $handp = array_pad(array("0"),116,"0");
      $datum1 = array_pad($array,116,"");
      $datum2 = array_pad($array,116,"");
      $teama = array_pad($array,116,"");
      $teamb = array_pad($array,116,"");
      $goala = array_pad($array,116,"");
      $goalb = array_pad($array,116,"");
      $mspez = array_pad($array,116,"");
      $mberi = array_pad($array,116,"");
      $mtipp = array_pad($array,116,"");
      $mnote = array_pad($array,116,"");
      $msieg = array_pad($array,116,"");
      $mterm = array_pad($array,116,"");
      for($i=0;$i<116;$i++){
        $teama[$i] = array_pad(array("0"),40,"0");
        $teamb[$i] = array_pad(array("0"),40,"0");
        $goala[$i] = array_pad(array("_"),40,"_");
        $goalb[$i] = array_pad(array("_"),40,"_");
        $mspez[$i] = array_pad($array,40,"");
        $mnote[$i] = array_pad($array,40,"");
        $mberi[$i] = array_pad($array,40,"");
        $mtipp[$i] = array_pad($array,40,"");
        $msieg[$i] = array_pad(array("0"),40,"0");
        $mterm[$i] = array_pad(array("0"),40,"0");
        }
      }
    else{
      $datum1 = array_pad($array,7,"");
      $datum2 = array_pad($array,7,"");
      $modus = array_pad(array("1"),7,"1");
      $teama = array_pad($array,7,"");
      $teamb = array_pad($array,7,"");
      $goala = array_pad($array,7,"");
      $goalb = array_pad($array,7,"");
      $mspez = array_pad($array,7,"");
      $mberi = array_pad($array,7,"");
      $mtipp = array_pad($array,7,"");
      $mnote = array_pad($array,7,"");
      $mterm = array_pad($array,7,"");
      for($i=0;$i<7;$i++){
        $teama[$i] = array_pad(array("0"),64,"0");
        $teamb[$i] = array_pad(array("0"),64,"0");
        $goala[$i] = array_pad($array,64,"");
        $goalb[$i] = array_pad($array,64,"");
        $mspez[$i] = array_pad($array,64,"");
        $mnote[$i] = array_pad($array,64,"");
        $mberi[$i] = array_pad($array,64,"");
        $mtipp[$i] = array_pad($array,64,"");
        $mterm[$i] = array_pad($array,64,"");
        for($j=0;$j<64;$j++){
          $goala[$i][$j] = array_pad(array("_"),7,"_");
          $goalb[$i][$j] = array_pad(array("_"),7,"_");
          $mspez[$i][$j] = array_pad($array,7,"");
          $mnote[$i][$j] = array_pad($array,7,"");
          $mberi[$i][$j] = array_pad($array,7,"");
          $mtipp[$i][$j] = array_pad($array,7,"");
          $mterm[$i][$j] = array_pad(array("0"),7,"0");
          }
        }
      }
    $teams[0]="___";
    $teamk[0]="___";
    for($i=1;$i<=count($daten);$i++){
      $dum=split("[|]",$daten[$i-1]);
      if($nticker==1){
        if(($dum[0]=="News") && ($dum[1]!="NC")){$nlines[]=stripslashes($dum[2]);print_r($nlines);}
        }
      if($dum[0]=="Teams"){$teams[$dum[1]]=stripslashes($dum[2]);}
      if($dum[0]=="Teamk"){$teamk[$dum[1]]=stripslashes($dum[2]);}
      $op1=substr($dum[0],0,4);
      $op2=substr($dum[0],0,5);
      $op3=substr($dum[0],5)-1;
      $op4=substr($dum[1],2)-1;
      $op5=substr($dum[0],4);
      $op6=substr($dum[1],2,-1)-1;
      $op7=substr($dum[1],-1)-1;
      $op8=substr($dum[1],0,2);
      for($j=0;$j<$anzteams;$j++){if($teamk[$j]==""){$teamk[$j]=substr($teams[$j],0,5);}}
      if($lmtype==0){
        if(($op1=="Team") && ($dum[0]!="Teams") && ($dum[0]!="Teamk") && ($dum[1]=="SP")){$strafp[$op5]=$dum[2];}
        if(($op1=="Team") && ($dum[0]!="Teams") && ($dum[0]!="Teamk") && ($dum[1]=="SM")){$strafm[$op5]=$dum[2];}
        }
      if(($op1=="Team") && ($dum[0]!="Teams") && ($dum[0]!="Teamk") && ($dum[1]=="URL")){$teamu[$op5]=$dum[2];}
      if(($op1=="Team") && ($dum[0]!="Teams") && ($dum[0]!="Teamk") && ($dum[1]=="NOT")){$teamn[$op5]=$dum[2];}
      if(($op2=="Round") && ($dum[1]=="HS")){$handp[$op3]=$dum[2];}
      if(!isset($handp[$op3])){$handp[$op3]="0";}
      if(($op2=="Round") && ($dum[1]=="D1")){$datum1[$op3]=$dum[2];}
      if(isset($datum1[$op3])){
        if($datum1[$op3]!=""){
          $dummy=strtotime(substr($datum1[$op3],0,2)." ".$me[intval(substr($datum1[$op3],3,2))]." ".substr($datum1[$op3],6,4));
          if($dummy>-1){$datum1[$op3]=strftime("%d.%m.%Y",$dummy);}else{$datum1[$op3]="";}
          }
        }
      if(($op2=="Round") && ($dum[1]=="D2")){$datum2[$op3]=$dum[2];}
      if(isset($datum2[$op3])){
        if($datum2[$op3]!=""){
          $dummy=strtotime(substr($datum2[$op3],0,2)." ".$me[intval(substr($datum2[$op3],3,2))]." ".substr($datum2[$op3],6,4));
          if($dummy>-1){$datum2[$op3]=strftime("%d.%m.%Y",$dummy);}else{$datum2[$op3]="";}
          }
        }
      if($lmtype!=0){
        if(($op2=="Round") && ($dum[1]=="MO")){$modus[$op3]=$dum[2];}
        }
      if(($op2=="Round") && ($op8=="TA")){$teama[$op3][$op4]=$dum[2];}
      if(($op2=="Round") && ($op8=="TB")){$teamb[$op3][$op4]=$dum[2];}
      if($lmtype==0){
        if(($op2=="Round") && ($op8=="GA")){
          $goala[$op3][$op4]=$dum[2];
          if($goala[$op3][$op4]==""){$goala[$op3][$op4]=-1;}
          if($goala[$op3][$op4]=="-1"){$goala[$op3][$op4]="_";}
          if($goala[$op3][$op4]=="-2"){$msieg[$op3][$op4]=1;$goala[$op3][$op4]="0";}
          }
        if(($op2=="Round") && ($op8=="GB")){
          $goalb[$op3][$op4]=$dum[2];
          if($goalb[$op3][$op4]==""){$goalb[$op3][$op4]=-1;}
          if($goalb[$op3][$op4]=="-1"){$goalb[$op3][$op4]="_";}
          if($goalb[$op3][$op4]=="-2"){$msieg[$op3][$op4]=2;$goalb[$op3][$op4]="0";}
          }
        if($spez==1){
          if(($op2=="Round") && ($op8=="SP")){
            $mspez[$op3][$op4]=$dum[2];
            if($mspez[$op3][$op4]==0){$mspez[$op3][$op4]="&nbsp;";}
            if($mspez[$op3][$op4]==2){$mspez[$op3][$op4]=$text[0];}
            if($mspez[$op3][$op4]==1){$mspez[$op3][$op4]=$text[1];}
            }
          }
        if(($op2=="Round") && ($op8=="ET") && ($dum[2]==3)){$msieg[$op3][$op4]=3;}
        if(($op2=="Round") && ($op8=="NT")){$mnote[$op3][$op4]=addslashes($dum[2]);}
        if(($op2=="Round") && ($op8=="BE")){$mberi[$op3][$op4]=$dum[2];}
        if(($op2=="Round") && ($op8=="TI")){$mtipp[$op3][$op4]=$dum[2];}
        if(($op2=="Round") && ($op8=="AT")){$mterm[$op3][$op4]=$dum[2];}
        }
      else{
        if(($op2=="Round") && ($op8=="GA")){
          $goala[$op3][$op6][$op7]=$dum[2];
          if($goala[$op3][$op6][$op7]==""){$goala[$op3][$op6][$op7]=-1;}
          if($goala[$op3][$op6][$op7]=="-1"){$goala[$op3][$op6][$op7]="_";}
          }
        if(($op2=="Round") && ($op8=="GB")){
          $goalb[$op3][$op6][$op7]=$dum[2];
          if($goalb[$op3][$op6][$op7]==""){$goalb[$op3][$op6][$op7]=-1;}
          if($goalb[$op3][$op6][$op7]=="-1"){$goalb[$op3][$op6][$op7]="_";}
          }
        if(($op2=="Round") && ($op8=="SP")){
          $mspez[$op3][$op6][$op7]=$dum[2];
          if($mspez[$op3][$op6][$op7]==0){$mspez[$op3][$op6][$op7]="&nbsp;";}
          if($mspez[$op3][$op6][$op7]==2){$mspez[$op3][$op6][$op7]=$text[0];}
          if($mspez[$op3][$op6][$op7]==1){$mspez[$op3][$op6][$op7]=$text[1];}
          }
        if(($op2=="Round") && ($op8=="NT")){$mnote[$op3][$op6][$op7]=addslashes($dum[2]);}
        if(($op2=="Round") && ($op8=="BE")){$mberi[$op3][$op6][$op7]=$dum[2];}
        if(($op2=="Round") && ($op8=="TI")){$mtipp[$op3][$op6][$op7]=$dum[2];}
        if(($op2=="Round") && ($op8=="AT")){$mterm[$op3][$op6][$op7]=$dum[2];}
        }
      }
    if(!isset($nlines)){$nticker=0;}
    }
  }
?>