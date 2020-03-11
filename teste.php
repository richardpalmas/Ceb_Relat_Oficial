<?php
 //função para chamar página responsável pela conecção ao banco de dados
                          $xx = $_SESSION['id'];
//verificar se usuário tem permissão para acessar a página
                $sql = "SELECT * from usuarios where id = '$xx'";
                $resultado = mysql_query($sql);
                while($registros = mysql_fetch_array($resultado)){
                $permissao = $registros["permissao"];
//se o usuário não tiver permissão o seguinte código será executado
                if ($permissao == 1) echo "<script language='javascript' type='text/javascript'>alert('P\u00e1gina indispon\u00edvel para este tipo de usu\u00e1rio');window.location.href='leitura.php'</script>";
                
                }        
$idd = $_GET['id'];

$busca = "SELECT * FROM usuarios WHERE id = $id"; 
$resultado = mysql_query($busca);
$row = mysql_fetch_row($resultado);
?>
<form method="POST" action="salvar.php">

<input type="text" value="<?php echo $row['nome']; ?>" name="campo" />
<input type="hidden" value="<?php echo $id; ?>" name="id" />

<input type="submit" value="editar" />

</form>