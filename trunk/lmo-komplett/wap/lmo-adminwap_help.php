<?php
echo("<card id=\"help\" title=\"Hilfe\">\n");
echo("<p><small>");

for($j=0;$j<$anzteams;$j++){
	$j1=$j+1;
  $teamk[$j1]=str_replace("�","&#xE4;",$teamk[$j1]);
	$teamk[$j1]=str_replace("�","&#xC4;",$teamk[$j1]);
	$teamk[$j1]=str_replace("�","&#xF6;",$teamk[$j1]);
	$teamk[$j1]=str_replace("�","&#xD6;",$teamk[$j1]);
	$teamk[$j1]=str_replace("�","&#xFC;",$teamk[$j1]);
	$teamk[$j1]=str_replace("�","&#xDC;",$teamk[$j1]);
	$teamk[$j1]=str_replace("�","&#xDF;",$teamk[$j1]);
	
	$teams[$j1]=str_replace("�","&#xE4;",$teams[$j1]);
	$teams[$j1]=str_replace("�","&#xC4;",$teams[$j1]);
	$teams[$j1]=str_replace("�","&#xF6;",$teams[$j1]);
	$teams[$j1]=str_replace("�","&#xD6;",$teams[$j1]);
	$teams[$j1]=str_replace("�","&#xFC;",$teams[$j1]);
	$teams[$j1]=str_replace("�","&#xDC;",$teams[$j1]);
	$teams[$j1]=str_replace("�","&#xDF;",$teams[$j1]);
	echo "<b>".$teamk[$j1]."</b>=<br/>".$teams[$j1]."<br/>---<br/>\n";
}?>
</small><br/><a href='<?=$_SERVER['PHP_SELF']."?wap_file=$file"?>&amp;op=nav'>zur�ck</a>