<?php 
//armazena operação feita pelo usuário
$x = 'Atualização de usuario no bd'; 
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
$at_nome = $_POST['name'];
$at_login = $_POST['login'];
$at_dep = $_POST['depto'];
$at_senha = md5($_POST['senha']);
$perm = $_POST['permissao'];
$idd = $_POST['ident'];

//Compara o valor obtido com o valor hash equivalente a NULL
//caso seja diferente houve alteração da senha
if(($at_senha) != "6c3e226b4d4795d518ab341b0824ec29"){
// insere através do comando Insert valores no banco de dados
$SQL = "UPDATE `usuarios` SET nome = '$at_nome', login= '$at_login', senha = '$at_senha', departamento = '$at_dep', permissao = '$perm' WHERE id='$idd'";
} 
//caso seja igual não atualiza-se a senha
else {
// insere através do comando Insert valores no banco de dados
$SQL = "UPDATE `usuarios` SET nome = '$at_nome', login= '$at_login', departamento = '$at_dep', permissao = '$perm' WHERE id='$idd'";
}

// realiza uma consulta no banco de dados 
$result = mysql_query($SQL) or die ("Erro ao retornar dados " . mysql_error());

// caso a consulta feita no banco de dados tenha retornado valor negativo então o seguinte código será executado
if (!$result){
echo "<script language='javascript' type='text/javascript'>alert('Erro ao atualizar cadastro de usu\u00e1rio');window.location.href='condeluser.php';</script>";
}
// caso a consulta retorne um valor positivo o seguinte código será executado 
else{
echo "<script language='javascript' type='text/javascript'>alert('Usu\u00e1rio atualizado com sucesso');window.location.href='condeluser.php';</script>";
}


?>