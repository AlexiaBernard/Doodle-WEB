<?php
if(!isset($_SESSION['login']) || $_SESSION['login']==1){
	die('Vous n êtes pas autoriser à être ici');
}
?>