<?php 
//armazena operação feita pelo usuário
$x = 'cadastro de usuario no bd'; 
//Chama a função que armazena a ação do usuário no sistema
include 'criarlog.php';
//função para chamar página responsável pela conecção ao banco de dados
require("main3.php");
//função para verificar se o usuário está logado 
$xx = $_SESSION['id'];
//verificar se usuário tem permissão para acessar a página
								$sql = "SELECT * from usuarios where id = '$xx'";
								$resultado = mysql_query($sql);
 								while($registros = mysql_fetch_array($resultado)){
								$permissao = $registros["permissao"];
//se o usuário não tiver permissão o seguinte código será executado
								if ($permissao == 1){ echo "<script language='javascript' type='text/javascript'>alert('P\u00e1gina indispon\u00edvel para este tipo de usu\u00e1rio');window.location.href='leitura.php'</script>";}
								
								}		
//obtem os dados enviados pela página incuser através do método post 
$cad_nome = $_POST['nome'];
$cad_login = $_POST['login'];
$cad_dep = $_POST['dep'];
$cad_senha = md5($_POST['senha']);
$cad_type = $_POST['userType'];

//verifica se no campo de login não existe nenhum caractere especial
if (!preg_match("/^([a-zA-Z0-9]+)$/", $cad_login)) {
    echo "<script language='javascript' type='text/javascript'>alert('O campo login n\u00e3o deve conter caracteres especiais');window.location.href='incuser.php';</script>";
}

//verifica se o campo nome do usuário está preenchido 
if(!$cad_nome){
	echo "<script language='javascript' type='text/javascript'>alert('O campo nome deve ser preenchido');window.location.href='incuser.php';</script>";
}

//verifica se o campo login está preenchido 
if(!$cad_login){
	echo "<script language='javascript' type='text/javascript'>alert('O campo login deve ser preenchido');window.location.href='incuser.php';</script>";
}

//verifica se o campo departamento está preenchido 
if(!$cad_dep){
	echo "<script language='javascript' type='text/javascript'>alert('O campo departamento deve ser preenchido');window.location.href='incuser.php';</script>";
}

//verifica se o campo departamento está preenchido 
if(!$cad_senha){
	echo "<script language='javascript' type='text/javascript'>alert('O campo senha deve ser preenchido');window.location.href='incuser.php';</script>";
}

// verificar se valor inserido em login já existe no banco de dados 

//extrair do banco de dados campo login onde este for igual ao login informado pelo usuário no momento do cadastro deste. 
$SQL = "SELECT * FROM usuarios WHERE login = '$login'";
// verifica se foi encontrado o valor no banco de dados
$result = mysql_query("$SQL") or die ('Erro ao retornar valores ' . mysql_error());
// Armazena tudo que foi encontrado no banco de dados em $SQL
$array = mysql_fetch_array($result);
// armazena o valor de login informado pelo usuário em $logarray
$logarray = $array['login'];

// faz a verificação se login informado pelo usuário corresponde a algum login já cadastrado 
if($login == $logarray || !preg_match("/^([a-zA-Z0-9]+)$/", $cad_login)){
echo "<script language='javascript' type='text/javascript'>alert('Este login j\u00e1 est\u00e1 cadastrado!');window.location.href='incuser.php';</script>";
} else {


// insere através do comando Insert valores no banco de dados
$SQL = "INSERT INTO usuarios VALUES ";

// caso o usuário tenha sido cadastrado como administrador o seguinte código será executado 
if (!$cad_type){
$SQL .= "('', '$cad_nome', '$cad_login', '$cad_senha', '$cad_dep', '1')";

// caso o usuário tenha sido cadastrado como usuário comum o seguinte código será executado
} else{
$SQL .= "('', '$cad_nome', '$cad_login', '$cad_senha', '$cad_dep', '$cad_type')";
}
// realiza uma consulta no banco de dados 
$result = mysql_query("$SQL");

// caso a consulta feita no banco de dados tenha retornado valor negativo então o seguinte código será executado
if (!$result){
echo "<script language='javascript' type='text/javascript'>alert('Erro ao cadastrar usu\u00e1rio');window.location.href='incuser.php';</script>";
}
// caso a consulta retorne um valor positivo o seguinte código será executado 
else{
echo "<script language='javascript' type='text/javascript'>alert('Usu\u00e1rio cadastrado com sucesso');window.location.href='incuser.php';</script>";
}

}

?>