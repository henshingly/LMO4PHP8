<?PHP
//
// LigaManager Online 3.02
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
// Erweiterung f�r Archiv Funktion durch Georg Strey


  if(isset($_REQUEST["action"]) && $_REQUEST["action"]=="tipp")
  {
    session_start();
  }
?>

<SCRIPT Language="JavaScript">
<!--
 NS4 = (document.layers);
 if (NS4) { document.write('<link rel="stylesheet" href="nc.css" type="text/css">'); }
  else { document.write('<link rel="stylesheet" href="lmo-style.css" type="text/css">'); }
//-->
</script>
<noscript>
<link rel="stylesheet" href="lmo-style.css" type="text/css">
</noscript>

<?php
ob_start();
setlocale(LC_TIME, "de_DE");
$array = array("");

require_once("lmo-cfgload.php");
require_once("lmo-langload.php");
require_once("lmo-archiv.php");
require_once("lmo-showdir.php");

if (file_exists("lmo-tippcfgload.php"))
  {require_once("lmo-tippcfgload.php");}

if(!isset($_REQUEST["action"])){$_REQUEST["action"]="";}
if(!isset($_REQUEST["file"])){$_REQUEST["file"]="";}

if($_REQUEST["action"]=="admin"){$_REQUEST["action"]="";}

echo "<link rel=stylesheet type=\"text/css\" href=\"lmo-style.css\">";

if($_REQUEST["action"]=="")
{
  if($_REQUEST["file"]=="")
  {
    if(isset($_REQUEST["archiv"]))
    {
      if($_REQUEST["archiv"]=="dir")
        {AuswahlArchiv();}
      else
        {WechselLigaVerzeichnis();}
    }
    else
      {AuswahlLiga();}
  }
  else
  {
    require("lmo-openfile.php");
    if($onrun==0){$action="results";}else{$action="table";}
    require("lmo-showmain.php");
  }
}
elseif ($_REQUEST["action"] == "tipp")
{
  define('LMO_TIPPAUTH', 1);
  require("lmo-tippstart.php");
}
else
{
  if($file=="")
    {AuswahlLiga();}
  else
  {
    require("lmo-openfile.php");
    require("lmo-showmain.php");
  }
}
ob_end_flush();
?>