<?php
session_start();
if ($_SESSION['id']) {
mysql_connect("localhost", "sico", "sico");
mysql_select_db("sico"); 
$SQL = "SELECT id, nome, login, senha, departamento, permissao FROM usuarios WHERE id = '".$_SESSION['id']."'";
$result_id = @mysql_query($SQL) or die("Erro no banco de dados!");
$total = @mysql_num_rows($result_id);
} 

?>