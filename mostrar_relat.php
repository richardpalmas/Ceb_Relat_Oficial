<?php 

require("main3.php"); 
$x = 'Mostrar Relatório'; 
include 'criarlog.php';

 
	if ( strlen($_POST['ano_uc']) == 4 && strlen($_POST['ano_conc']) == 4) { include 'relat_abert.php';} 
	if ( strlen($_POST['ano']) == 4 &&  strlen($_POST['ano_uc']) == 4) { include 'relat_cort.php';}  
	if ( strlen($_POST['ano']) == 4 && strlen($_POST['ano_conc']) == 4) { include 'relat_uc_s_med.php';}



?>