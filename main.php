<?php
require("banco.php");
$login = isset($_POST["matricula"]) ? addslashes(trim($_POST["matricula"])) : FALSE;
$senha = isset($_POST["senha"]) ? md5(trim($_POST["senha"])) : FALSE;
session_start();

//if($login or $senha) {
	
if($sair) { session_destroy(); session_start(); }
$matricula = $_GET["matricula"];


if ($_SESSION['id']) {
//mysql_connect("localhost", "sico", "sico");
//mysql_select_db("sico"); 
$SQL = "SELECT id, nome, login, senha, departamento, permissao FROM usuarios WHERE id = '".$_SESSION['id']."'";
$result_id = @mysql_query($SQL) or die("Erro no banco de dados!2");
$total = @mysql_num_rows($result_id);
if(!$total) header("Location: index.php");  
} 
if ($login || $senha) {
// Usuário não forneceu a senha ou o login
$login = str_replace("#", "", $login);
//mysql_connect("localhost", "sico", "sico");
// Seleciona banco de dados
//mysql_select_db("sico"); 
// Conexão com o banco de dados

// Inicia sessões



/**
* Executa a consulta no banco de dados.
* Caso o número de linhas retornadas seja 1 o login é válido,
* caso 0, inválido.
*/
$SQL = "SELECT id, nome, login, senha, departamento, permissao FROM usuarios WHERE login = '$login'";
$result_id = @mysql_query($SQL) or die("Erro no banco de dados!3");
$total = @mysql_num_rows($result_id);

// Caso o usuário tenha digitado um login válido o número de linhas será 1..
if($total)
{
    // Obtém os dados do usuário, para poder verificar a senha e passar os demais dados para a sessão
    $dados = @mysql_fetch_array($result_id);

    // Agora verifica a senha
    if(!strcmp($senha, $dados["senha"]))
    {
        // TUDO OK! Agora, passa os dados para a sessão e redireciona o usuário
        $_SESSION["id"]   = $dados["id"];
        $_SESSION["nome"] = stripslashes($dados["nome"]);
		$_SESSION["matricula"] = stripslashes($dados["login"]);
				$_SESSION["email"] = $dados["email"];	
        $_SESSION["permissao"]    = $dados["permissao"];
		header("Location: consulta.php"); 
    }
    // Senha inválida
    else
    {
        echo "<script type='text/javascript'> alert('Login ou senha invalidos!'); </script>";
    }
}
// Login inválido
else
{
        echo "<script type='text/javascript'> alert('Login ou senha invalidos!'); </script>";
} 
}
//}

?>