<?
header("Content-Type: text/css");
require("init.php");
@include(PATH_TO_TEMPLATEDIR."/style.css");
echo <<< STYLE


.sort-arrow {
	width:					11px;
	height:					11px;
	background-position:	center center;
	background-repeat:		no-repeat;
	margin:					0 2px;
}

.sort-arrow.descending {
	background-image:		url("img/downsimple.png");

}

.sort-arrow.ascending {
	background-image:		url("img/upsimple.png");
}
a span.popup, a:link span.popup{
	display: none;
}
a:hover span.popup{
  display: inline;
	font-size:80%;
  position: absolute;
  background-color: $tabbback; 
  color: $tabbcolo;
  border: $tabbbord;
  max-width: 15em;
	margin: 1.5em 0 0 -4em;  
  padding: 0.2em;
	z-index: 999;
  white-space:normal;
  text-decoration:none !important;
  text-align:left;
  \-moz-border-radius: 8px;
}
.message{margin:0;color:#080;background-color:transparent;}
.error{margin:0;color:#a00;background-color:transparent;}
.nobr {white-space:nowrap;}
FORM { padding: 0; margin: 0; }
acronym {cursor:help;border-bottom:1px dotted $tabccolo;}
TABLE { padding: 0; margin: 0; }
.lmomaina { background: $tababack; border: $tababord; margin:auto;font-size:90%;font-family:sans-serif;}
.lmosta { background: $tabbback; border: $tabbbord; margin:auto; white-space:normal;}
.lmostb {  background: $tabcback; border: $tabcbord; margin:auto; }

.lmomain0 { padding: 2px; background: $tababack; color: $tabacoti; font-family: $tabafont; font-size: $tabatite; font-weight: bold; }
  
.lmomain1 { padding: 2px; font-weight: bold; font-size: $tabasize; white-space:nowrap}
.lmomain1, .lmomain1 a { background: $tababack; color: $tabacolo; font-family: $tabafont; }
  .lmomain1 a:link, .lmomain1 a:visited { font-weight: normal; text-decoration: none; }
  .lmomain1 a:hover, .lmomain1 a:active { background: $tabacolo; color: $tababack; font-weight: normal; text-decoration: none; border:0;}

.lmomain2 { padding: 2px; background: $tababack; color: $tabacolo; font-family: $tabafont; font-size: $tabaupda; font-weight: normal; }

.lmost0, lmost0a { padding: 2px; font-weight: normal;font-size: $tabbsize; }
.lmost0, .lmost0 a, .lmost0a, .lmost0a a {  background: $tabbback; color: $tabccolo; font-family: $tabbfont; }
  .lmost0 a:link, .lmost0 a:visited, .lmost0a a:link, .lmost0a a:visited { text-decoration: none; }
  .lmost0 a:hover, .lmost0 a:active, .lmost0a a:hover, .lmost0a a:active { background: $tabbcolo; color: $tabbback; text-decoration: none; border:0;}

.lmost1 { padding: 2px; background: $tabbback; color: $tabbcolo; font-family: $tabbfont; font-size: $tabbsize; font-weight: bold; }

.lmost2 { padding: 2px; font-weight: normal;font-size: $tabbsize;}
.lmost2, .lmost2 a { background: $tabbback; color: $tabbcolo; font-family: $tabbfont;  }
  .lmost2 a:link, .lmost2 a:visited { text-decoration: none; }
  .lmost2 a:hover, .lmost2 a:active { background: $tabbcolo; color: $tabbback; text-decoration: none; border:0;}

.lmost3 { padding: 2px; background: $tabbback; color: $tabbcolo;}

.lmost4 { padding: 2px; font-weight: bold; font-size: $tabcsize;background-color: $tabcgrey; color: $tabccolo; font-family: $tabcfont;}
.lmost4 a { background-color: $tabcgrey; color: $tabccolo; }
  .lmost4 a:link, .lmost4 a:visited { text-decoration: none; background-color: $tabcgrey; color: $tabccolo;}
  .lmost4 a:hover, .lmost4 a:active { text-decoration: underline; border:0; background-color $tabcgrey; color: $tabccolo;}

.lmost5 { padding: 2px; font-weight: normal; font-size: $tabcsize;}
.lmost5, .lmost5 a { background: $tabcback; color: $tabccolo; font-family: $tabcfont; }
  .lmost5 a:link {  background: $tabcback; color: $tabclin1; text-decoration: none; }
  .lmost5 a:hover, .lmost5 a:active {  background: $tabcback; color: $tabclin2; text-decoration: underline;}

.lmost7 { padding: 2px; font-weight: normal; font-size: $tabcsize;}
.lmost7, .lmost7 a { background: $tabftur1; color: $tabccolo; font-family: $tabcfont; }
  .lmost7 a:link, .lmost7 a:visited { background: $tabftur1; color: $tabclin1; text-decoration: none; }
  .lmost7 a:hover, .lmost7 a:active { background: $tabftur1; color: $tabclin2; text-decoration: underline; border:0;}

.lmost8 { padding: 2px; background: $tabcback; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: bold; }

.lmost9a { padding: 2px; font-weight: normal; font-size: $tabcsize;}
.lmost9a, .lmost9a a { background: $tabftur2; color: $tabccolo; font-family: $tabcfont; }
  .lmost9a a:link, .lmost9a a:visited { background: $tabftur2; color: $tabclin1; text-decoration: none; }
  .lmost9a a:hover, .lmost9a a:active { background: $tabftur2; color: $tabclin2; text-decoration: underline; border:0;}

.lmost9b { padding: 2px; font-weight: normal; font-size: $tabcsize;}
.lmost9b, .lmost9b a { background: $tabftur3; color: $tabccolo; font-family: $tabcfont; }
  .lmost9b a:link, .lmost9b a:visited { background: $tabftur3; color: $tabclin1; text-decoration: none; }
  .lmost9b a:hover, .lmost9b a:active { background: $tabftur3; color: $tabclin2; text-decoration: underline; border:0;}

.lmost9c { padding: 2px; font-weight: normal; font-size: $tabcsize;}
.lmost9c, .lmost9c a { background: $tabftur4; color: $tabccolo; font-family: $tabcfont; }
  .lmost9c a:link, .lmost9c a:visited { background: $tabftur4; color: $tabclin1; text-decoration: none; }
  .lmost9c a:hover, .lmost9c a:active { background: $tabftur4; color: $tabclin2; text-decoration: underline; border:0;}

.lmotab1 { padding: 2px; font-weight: normal; font-size: $tabcsize;}
.lmotab1, .lmotab1 a { background: $tabftab1; color: $tabccolo; font-family: $tabcfont; }
  .lmotab1 a:link, .lmotab1 a:visited { background: $tabftab1; color: $tabclin1; text-decoration: none; }
  .lmotab1 a:hover, .lmotab1 a:active { background: $tabftab1; color: $tabclin2; text-decoration: underline; border:0;}

.lmotab2 { padding: 2px; font-weight: normal; font-size: $tabcsize;}
.lmotab2, .lmotab2 a { background: $tabftab2; color: $tabccolo; font-family: $tabcfont; }
  .lmotab2 a:link, .lmotab2 a:visited { background: $tabftab2; color: $tabclin1; text-decoration: none; }
  .lmotab2 a:hover, .lmotab2 a:active { background: $tabftab2; color: $tabclin2; text-decoration: underline; border:0;}

.lmotab3 { padding: 2px; font-weight: normal; font-size: $tabcsize;}
.lmotab3, .lmotab3 a { background: $tabftab3; color: $tabccolo; font-family: $tabcfont; }
  .lmotab3 a:link, .lmotab3 a:visited { background: $tabftab3; color: $tabclin1; text-decoration: none; }
  .lmotab3 a:hover, .lmotab3 a:active { background: $tabftab3; color: $tabclin2; text-decoration: underline; border:0;}

.lmotab4 { padding: 2px; font-weight: normal; font-size: $tabcsize;}
.lmotab4, .lmotab4 a { background: $tabftab4; color: $tabccolo; font-family: $tabcfont; }
  .lmotab4 a:link, .lmotab4 a:visited { background: $tabftab4; color: $tabclin1; text-decoration: none; }
  .lmotab4 a:hover, .lmotab4 a:active { background: $tabftab4; color: $tabclin2; text-decoration: underline; border:0;}

.lmotab5 { padding: 2px; font-weight: normal; font-size: $tabcsize;}
.lmotab5, .lmotab5 a { background: $tabftab6; color: $tabccolo; font-family: $tabcfont; }
  .lmotab5 a:link, .lmotab5 a:visited { background: $tabftab6; color: $tabclin1; text-decoration: none; }
  .lmotab5 a:hover, .lmotab5 a:active { background: $tabftab6; color: $tabclin2; text-decoration: underline; border:0;}

.lmotab8 { padding: 2px; font-weight: normal; font-size: $tabcsize;}
.lmotab8, .lmotab8 a { background: $tabftab5; color: $tabccolo; font-family: $tabcfont; }
  .lmotab8 a:link, .lmotab8 a:visited { background: $tabftab5; color: $tabclin1; text-decoration: none; }
  .lmotab8 a:hover, .lmotab8 a:active { background: $tabftab5; color: $tabclin2; text-decoration: underline; border:0;}

.lmotab6 { padding: 2px; background: $tabftab7; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }

.lmotab7 { padding: 2px; background: $tabftab8; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }

.lmocross1 { padding: 1px; background: $tabbback; color: $tabbcolo; font-family: $tabcfont; font-size: $tabdsize; font-weight: bold; }

.lmocross2{ padding: 1px; font-weight: normal; font-size: $tabdsize;}
.lmocross2, .lmocross2 a { background: $tabbback; color: $tabccolo; font-family: $tabcfont; }
  .lmocross2 a:link, .lmocross2 a:visited { text-decoration: none; }
  .lmocross2 a:hover, .lmocross2 a:active { background: $tabbcolo; color: $tabbback; font-weight: normal; text-decoration: none; border:0;}

.lmocross4 { padding: 1px; background: $tabcgrey; color: $tabccolo; font-family: $tabcfont; font-size: $tabdsize; font-weight: bold; }

.lmocross5 { padding: 1px; font-weight: normal; font-size: $tabdsize;}
.lmocross5, .lmocross5 a { background: $tabcback; color: $tabccolo; font-family: $tabcfont; }
  .lmocross5 a:link, .lmocross5 a:visited { background: $tabcback; color: $tabclin1; text-decoration: none; }
  .lmocross5 a:hover, .lmocross5 a:active { background: $tabcback; color: $tabclin2; text-decoration: underline; border:0;}

.lmocross6 { padding: 1px; font-weight: normal; font-size: $tabdsize;}
.lmocross6, .lmocross6 a { background: $tabftur1; color: $tabccolo; font-family: $tabcfont; }
  .lmocross6 a:link, .lmocross6 a:visited { background: $tabftur1; color: $tabclin1; text-decoration: none; }
  .lmocross6 a:hover, .lmocross6 a:active { background: $tabftur1; color: $tabclin2; text-decoration: underline; border:0;}

.lmocalni { padding: 2px; background: $tabcgrey; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: bold; }

.lmocalat { padding: 2px; border: 1px solid $tabcgrey;  background: $tabcback; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: bold; }
  .lmocalat a:link, .lmocalat a:visited { background: $tabcback; color: $tabclin1; font-weight: normal; text-decoration: none; }
  .lmocalat a:hover, .lmocalat a:active { background: $tabcback; color: $tabclin2; font-weight: normal; text-decoration: underline; border:0;}

.lmocalht { padding: 2px; border: 1px solid $tabcgrey;  background: $tabhback; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: bold; }
  .lmocalht a:link, .lmocalht a:visited { background: $tabhback; color: $tabclin1; font-weight: normal; text-decoration: none; }
  .lmocalht a:hover, .lmocalht a:active { background: $tabhback; color: $tabclin2; font-weight: normal; text-decoration: underline; border:0;}

.lmocalwe { padding: 2px; border: 1px solid $tabcgrey;  background: $tabcback; color: $tabwcolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: bold; }
  .lmocalwe a:link, .lmocalwe a:visited { background: $tabcback; color: $tabclin1; font-weight: normal; text-decoration: none; }
  .lmocalwe a:hover, .lmocalwe a:active { background: $tabcback; color: $tabclin2; font-weight: normal; text-decoration: underline; border:0;}

.lmocalhe { padding: 2px; border: 1px solid $tabcgrey;  background: $tabhback; color: $tabwcolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: bold; }
  .lmocalhe a:link, .lmocalhe a:visited  { background: $tabhback; color: $tabclin1; font-weight: normal; text-decoration: none; }
  .lmocalhe a:hover, .lmocalhe a:active { background: $tabhback; color: $tabclin2; font-weight: normal; text-decoration: underline; border:0;}

.lmotext { padding: 6px; background: $tabcback; color: $tabccolo; text-align: justify; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }

.lmofett { background: $tabcback; color: $tabccolo; text-align: justify; font-family: $tabcfont; font-size:85%; font-weight: bold; }

.lmoadminli { padding-bottom: 4px; }

.lmoadminein { background: $tabeback; color: $tabecolo; border: 1px solid $tabecolo; font-family: $tabcfont; font-size: $tabcsize; }
.lmoadminbut { background: $tabkback; color: $tabkcolo; border-left: 1px solid $tabkcolo; border-top: 1px solid $tabkcolo; border-right: 2px solid $tabkcolo; border-bottom: 2px solid $tabkcolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: bold; }
STYLE;
?>