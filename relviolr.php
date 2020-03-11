<?php

require("main3.php");
$x = 'Relviolr'; 
include 'criarlog.php';


/*
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");
header("Expires: 0");
*/
/*
$path = "\\\\ntbkp01\Privado3\GPGC\Desligamentos\\";
$diretorio = dir($path);
 
echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";
while($arquivo = $diretorio -> read()){
echo "$path$arquivo<br>";
}
$diretorio -> close();
exit;
*/
ob_start();
echo ('Atualizando a base...aguarde!<br>');
ob_flush();
$test = array();

$arquivoi = fopen ("\\\\ntbkp01\Privado3\GPGC\RelviolrMod\\Relat_mod.csv", 'w');
fclose($arquivoi);

error_reporting(0);
ini_set(“display_errors”, 0 );



$conexao = mysql_connect("localhost", "sico", "sico");
if($conexao){
	mysql_select_db("geq", $conexao) or die("O banco solicitado não pode ser utilizado :  . mysql_error()");
}
else{echo "não foi possivel estabelecer uma conecção";}


//$abner = array();	
$i=1;
$files = new FilesystemIterator('\\\\ntbkp01\Privado3\GPGC\Relviolr\\\\');


foreach($files as $file)
{
	$test[$i++] = $file->getFilename();
	
} 
//var_dump($test);
$data = array();
//echo count($test);

$ii=1;
/*while ($ii <= count($test)) {
$data[$ii] = "".substr($test[$ii], 14, 2)."/".substr($test[$ii], 12, 2)."/".substr($test[$ii], 10, 2)."";
	$ii++;s
}
*/
// Abre o Arquvio no Modo r (para leitura)
$ob=1;
//echo "CODIGO; NOME; ENDERECO; LOCALIDADE; TELEFONE; DATA; VALOR; SEQ; NF; CLIENTE; MES REFERENCIA; \n";
while ($ob <= count($test)) {
	
$arquivos = $test[$ob];



//var_dump($test);

$arquivo = fopen ("\\\\ntbkp01\Privado3\GPGC\Relviolr\\$arquivos", 'r');
$arquivoi = fopen ("\\\\ntbkp01\Privado3\GPGC\RelviolrMod\\Relat_mod.csv", 'a');


$ib = 1;
	$arqc = array();
 // Lê o conteúdo do arquivo 
  while(!feof($arquivo))
  {
		$arqc[$ib] = fgets($arquivo, 2018);
	  $ib++;
	  
  }
  
  // Fecha arquivo aberto
//  fclose($arquivo);
//echo "Data do arquivo: $data e $testar e caminho completo $cmp<br>";
//echo "$arquivos <br>";

$ii=1;

while ($ii <= count($arqc)-1) {
//while ($ii <= count($arqc)-1) {	
	
 if ($ii > 1) {
/*	$entrada = substr($arqc[$ii], 0, 2);
	$entradab = substr($arqc[$ii], 105, 50);
		$entradac = substr($arqc[$ii], 323, 40);
		$entradad = substr($arqc[$ii], 368, 20);
		$entradae = substr($arqc[$ii], 488, 13);
	 	//$entradaf = substr($arqc[$ii], 501, 8);
		$entradag = substr($arqc[$ii], 509, 13);
		$entradah = substr($arqc[$ii], 522, 2);
$entradaff = "".substr($arqc[$ii], 507, 2)."/".substr($arqc[$ii], 505, 2)."/".substr($arqc[$ii], 501, 4)."";
$entradaf = "".substr($arqc[$ii], 501, 4)."-".substr($arqc[$ii], 505, 2)."-".substr($arqc[$ii], 507, 2)."";
$entradai = substr($arqc[$ii], 593, 7);
$entradaj = substr($arqc[$ii], 413, 25);
$entradal = substr($arqc[$ii], 438, 7);
$entraday = "".substr($arqc[$ii], 445, 4)."-".substr($arqc[$ii], 449, 2)."-01";
$entradayy = "".substr($arqc[$ii], 449, 2)."/".substr($arqc[$ii], 445, 4)."";
$testx = "".substr($test[$ob], 10, 2)."-".substr($test[$ob], 12, 2)."-".substr($test[$ob], 14, 2)."";
*/
$converte_array = explode(";",$arqc[$ii]);

$protocolo = $converte_array[1];

$mesano1 = $converte_array[0];

$ano1 = substr($mesano1, 0, 4);

$mes1 = substr($mesano1, -2);

$mesano2 = $converte_array[4];

$ano2 = substr($mesano2, 0, 4);

$mes2 = substr($mesano2, -2);


$eusd = $converte_array[5];
$eusd = str_replace(",", ".", "$eusd");

$valcalc = $converte_array[6];
$valcalc = str_replace(",", ".", "$valcalc");

$valacred = $converte_array[7];
$valacred = str_replace(",", ".", "$valacred");


$text = "".$ano1.";".$mes1.";".$converte_array[1].";".$converte_array[2].";".$converte_array[3].";".$ano2.";".$mes2.";".$eusd.";".$valcalc.";".$valacred.";".$converte_array[8];
//$text = "$entrada;$entradab;$entradac;$entradad;$entradae;$entradaf;$entradag.$entradah;$entradai;$entradaj;$entradal;$entraday;$testx;\n";
fwrite($arquivoi, $text);


//	$sql = "INSERT INTO $tabela (ID, COD, NOM, END, LOC, TEL, DAT, VAL, SEQ, NF, CLI, MES, ARQ ) VALUES (DEFAULT, '$entrada', '$entradab', '$entradac', '$entradad', '$entradae', '$entradaf', '$entradag.$entradah', '$entradai', '$entradaj', '$entradal', '$entraday', '$test[$ob]')";
		
	//	$result = mysql_query($sql) or die(mysql_error());
//echo "$ii ";
		
//		echo "linha $ii: $entrada e $entradab e $entradac e $entradad";
// echo "<br>";

}
	$ii++;
}

		$ob++;
}
fclose($arquivoi);



//$query = "TRUNCATE TABLE corte";
$query = "DELETE FROM relviolr WHERE ano1 IN ('2016', '2017', '2018', '2019', '2020', '2021', '2022')";
	$result = mysql_query($query) or die(mysql_error());
//$query = "LOAD DATA LOCAL INFILE 'C:\\Users\\#49158\\Desktop\\Backup_Augusto_Gerencia_Disco_D\\new_xampp\\htdocs\\sicob\\serasa\\102017\\csv.csv' INTO TABLE serasa FIELDS TERMINATED BY ';' ESCAPED BY  '\\' LINES TERMINATED BY '\n' ('cod','nom','end','loc','tel','dat','val','seq','nf','cli','mes','arq')";
$query = "LOAD DATA LOCAL INFILE '\\\\\\\\ntbkp01\\\\Privado3\\\\GPGC\\\\RelviolrMod\\\\Relat_mod.csv' INTO TABLE relviolr FIELDS TERMINATED BY ';' ESCAPED BY '\\\\' LINES TERMINATED BY '\\n'(`ano1`,`mes1`,`cliente`,`os`,`desc`,`ano2`,`mes2`,`eusd`,`valcalc`,`valacred`,`sit`)";
//sc_exec_sql($query);
	$result = mysql_query($query) or die(mysql_error());
	$query = "DELETE FROM relviolr WHERE cliente = '0'";
	$result = mysql_query($query) or die(mysql_error());
//	echo $av;

echo "<b>Base atualizada com sucesso!</b> para acessar o sistema clique <a href=\"index.php\">aqui</a>";
ob_end_flush(); 