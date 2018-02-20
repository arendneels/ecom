<?php

//OUTPUT BUFFERING aanzetten
// request naar php. Dit vangt redirection op.
ob_start();
//SESSIONS aanzetten.
//Een gebruiker die je website bezoekt krijgt een uniek id, nl. de session-id.
//Deze kan bewaard worden in een cookie bij de user of worden meegegeven in de url.
//Dankzij de sessie_id kunnen requests tussen je site en de user uniek blijven.
//Hiervoor gaan we later gebruik maken van de superglobal array $_SESSION.
//om te starten:
session_start();
//session_destroy();


defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT", __DIR__ . DS . "templates/front");
defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__ . DS . "templates/back");
defined("UPLOAD_DIRECTORY") ? null : define("UPLOAD_DIRECTORY", __DIR__ . DS . "uploads");

defined("DB_HOST") ? null : define("DB_HOST", "localhost");
defined("DB_USER") ? null : define("DB_USER", "root");
defined("DB_PASS") ? null : define("DB_PASS", "");
defined("DB_NAME") ? null : define("DB_NAME", "ecom_db");


$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);


require_once("functions.php");
require_once("cart.php");
?>