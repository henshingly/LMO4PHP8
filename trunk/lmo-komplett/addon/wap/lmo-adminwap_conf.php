<?
// Ist der MD5-Hack aktiv?
// Voreinstellung ist ja!
// Ist wird sehr empfohlen, diesen Hack zu installieren, da ansonsten das Passwort im Klartext �bermittelt wird.
// Wenn md5 nicht aktiv ist, von TRUE auf FALSE �ndern
$lmo_md5 = FALSE;

// Pfad zu den Dateien lmo-access.txt und lmo-auth.txt
// Voreinstellung ist der lmo-Pfad, also ohne Unterverzeichnis
// Wenn dies ge�ndert werden soll, dann z.B. einfach folgendes hinschreiben:
// $lmo_auth_pfad="meinverzeichnis/";
// Also in den "" das Verzeichnis !!!mit!!! / angeben
$lmo_auth_verz="";

// Hier k�nnte man die Endung der Ligadatein �ndern, falls dies mal notwendig werden sollte.
// Aber normalerweise bzw. zur Zeit keine �nderungen vornehmen!
$ftype=".l98";
?>