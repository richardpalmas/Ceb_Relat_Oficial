<?php 
//função para chamar página responsável pela conexao ao banco de dados
$x = 'Enviar anexo III'; 
include 'criarlog.php';
require_once("diautil.php");
require_once("ferteste01.php");

require("main3.php"); 

//verifica se o usuário efetuou o primeiro passo 
//se o usuário tiver realizado o passo 1 estproces retornara verdadeiro caso não 0 retornará falso
date_default_timezone_set('America/Belem');

$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$urlref = 'http://localhost/novosicob/anexo_load2.php?upload=1';
$urlref2 = 'http://10.68.14.67/novosicob/anexo_load2.php?upload=1';


if($url == $urlref || $url == $urlref2){ 

$sql = "SELECT estproceseusd as processo FROM eusd WHERE estproceseusd = 0";
$result = mysql_query($sql);
$registro = mysql_fetch_array($result);
$estproces = $registro['processo'];
/*
if (is_null($estproces)){
  echo "<script language='javascript' type='text/javascript'>alert('Voc\u00ea ainda n\u00e3o fez o upload da EUSD. Para prosseguir com o procedimento por favor complete o passo 1');window.location.href='eusd_load.php?upload=1'</script>";
} */

}

//verifica se ele passou a variavel de download, caso sim, executa a funcao para fazer download do arquivo    

//caso seja o upload do arquivo executa essa parte  
// se o  tamanho do arquivo for maior q 0 bytes ai ele passa a copiar o mesmo           
if ($_FILES[csv][size] > 0) { 

//obtém o número da matrícula atravé da variável armazenada em session
$matricula = $_SESSION['matricula'];

$sql = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(nome, ' ', 1), ' ', -1) as primeiroNome FROM usuarios WHERE login = '$matricula'";
$result = mysql_query($sql);
$registro = mysql_fetch_array($result);
$usuario = $registro['primeiroNome'];

//nome do arquivo 
$filename1 = "relatorio_anexo_iii\\anexo_iii_original\\temp.csv";

//se existir um arquivo com o nome da variável $filename então o procedimento será interrompido
if (file_exists($filename1)){
    echo "<script language='javascript' type='text/javascript'>alert('Apague o arquivo cujo nome \u00e9 temp do diretorio anexo_iii_original e tente fazer o upload novamente. Caso o problema persista, por favor, contate o administrador do sistema. ');window.location.href='anexo_load2.php?upload=1'</script>";
  exit();} 

//move o arquivo do tmp para a pasta que queremos trabalhar e o renomeia para temp
if(is_uploaded_file($_FILES['csv']['tmp_name'])) move_uploaded_file($_FILES['csv']['tmp_name'], "$filename1");

//abre o arquivo cujo o nome é temp (temporario) para efetuar leitura (r). 
//Este é o arquivo original do processo
$arquivo1 = fopen ("$filename1", 'r');


$ib = 1;
  $arqc = array();
 // Lê o conteúdo do arquivo 
  while(!feof($arquivo1))
  {
    $arqc[$ib] = fgets($arquivo1, 999000);
    $ib++;
    
  }
  
  $ii=1;

while ($ii <= count($arqc)-1 ) {
//while ($ii <= count($arqc)-1) { 
  
 if ($ii > 1 && $ii < 3) {

//define que cada variável será separada por ;
$converte_array = explode(";",$arqc[$ii]);

//extrao do arquivo original (temp) a data de conclusão 
$data_conc = $converte_array[16];
//inverte data para o formato americano padrão
$data_conc_invert = implode("-",array_reverse(explode("/",$data_conc)));
$arq_mes = substr($data_conc_invert, 5, 2);
$arq_ano =  substr($data_conc_invert, 0, 4);

switch ($arq_mes) {
  case '01':
    $arq_mes = "Jan";
    break;
  case '02':
    $arq_mes = "Fev";
    break;
  case '03':
    $arq_mes = "Mar";
    break;
  case '04':
    $arq_mes = "Abr";
    break;
  case '05':
    $arq_mes = "Mai";
    break;
  case '06':
    $arq_mes = "Jun";
    break;
  case '07':
    $arq_mes = "Jul";
    break;
  case '08':
    $arq_mes = "Ago";
    break;
  case '09':
    $arq_mes = "Set";
    break;
  case '10':
    $arq_mes = "Out";
    break;
  case '11':
    $arq_mes = "Nov";
    break;
  case '12':
    $arq_mes = "Dez";
    break;  
  default:
    $arq_mes = "00";
    break;
}

}
  $ii++;
}

fclose($arquivo1); 

//faz o controle do nome do arquivo e se o numero de arquivos criados
//respectivos ao mes já foi alcançado

$arqi = 1;
while($arqi <= 6){  
  if ($arqi == 6){
  //caso tenha alcançado o limite máximo de arquivos 
  //exclui o arquivo provisório "temp" e emite mensagem 
  //de limite alcançado
  unlink( "relatorio_anexo_iii\\anexo_iii_original\\temp.csv" );
  echo "<script language='javascript' type='text/javascript'>alert('N\u00famero m\u00e1ximo de arquivos deste m\u00eas alcan\u00e7ado. Se voc\u00ea gostaria de fazer o upload de mais um arquivo, por favor v\u00e1 at\u00e9 o diret\u00f3rio e apague um dos arquivos referentes a este m\u00eas ou entre em contato com o servi\u00e7o de administra\u00e7\u00e3o do sistema');window.location.href='anexo_load2.php?upload=1'</script>";
  exit();} 
  $filename2 = "relatorio_anexo_iii\\anexo_iii_original\\Relatorio Anexo_iii Original - $usuario $arq_mes-$arq_ano edicao $arqi.csv";
  $filename2_2 = "Relatorio Anexo_iii Original - $usuario $arq_mes-$arq_ano edicao $arqi.csv";
  //caso o arquivo com o nome $filename não exista
  //o arquivo temp é renomeado para $filename
  if (!file_exists($filename2)){
  rename( "$filename1", "$filename2" ); // && unlink( "anexoIII_original\\temp.csv" );
  //rename("anexoIII_original\\temp.csv", "$filename"); 
  break; } 
  //caso contrário o loop continua
  else $arqi++;
}

//verifica se já há registro no banco de dados referentes ao mês 
//que se pretende inserir
/*
$sql = "SELECT month(dataconc) AS mes, year(dataconc) AS ano FROM `anexo_iii` WHERE month(dataconc) = $arq_mes AND year(dataconc) = $arq_ano GROUP BY month(dataconc)";
$result = mysql_query($sql);
$registro = (mysql_fetch_array($result));
$arq_mes_bd = $registro['mes'];
$arq_ano_bd = $registro['ano'];
if (!empty($arq_mes_bd)){

  //se for encontrado algum registro no banco de dados referente ao mes é mostrada a seginte mensagem
echo "<script language='javascript' type='text/javascript'>alert('J\u00e1 existe um arquivo referente a data $arq_mes/$arq_ano em nosso banco de dados. Por favor, confira o arquivo que voc\u00ea est\u00e1 enviando ou contate o administrador do sistema');window.location.href='anexo_load2.php?upload=1'</script>";
  exit();} 
*/

//verifica se já existe um arquivo igual no diretório ao que se quer enviar
//if (file_exists())


    /*


if(file_exists("../blog/imagem.jpg")){
  
}

  $data = date('d-m-Y');
    $data .= ' '.date('H:i:s');

  */
//abre arquivo original 
$arquivo1 = fopen ("$filename2", 'r');

//faz o controle do nome do arquivo e se o numero de arquivos criados
//respectivos ao mes já foi alcançado
$arqi = 1;
while($arqi <= 6){  
  if ($arqi == 6){
  //caso tenha alcançado o limite máximo de arquivos 
  //exclui o arquivo provisório "temp" e emite mensagem 
  //de limite alcançado
  echo "<script language='javascript' type='text/javascript'>alert('N\u00famero m\u00e1ximo de arquivos deste m\u00eas alcan\u00e7ado. Se voc\u00ea gostaria de fazer o upload de mais um arquivo, por favor v\u00e1 at\u00e9 o diret\u00f3rio e apague um dos arquivos referentes a este m\u00eas ou entre em contato com o servi\u00e7o de administra\u00e7\u00e3o do sistema');window.location.href='anexo_load2.php?upload=1'</script>";

  exit();} 
  $filename3 = "relatorio_anexo_iii\\anexo_iii_modificado\\Relatorio Anexo iii Modificado $usuario $arq_mes-$arq_ano edicao $arqi.csv";
  $filename3_3 = "Relatorio Anexo iii Modificado $usuario $arq_mes-$arq_ano edicao $arqi.csv";
  //caso o arquivo com o nome $filename não exista
  //o arquivo temp é renomeado para $filename
  if (!file_exists($filename3)){
  //criar arquivo cópia com o nome de $filename
  $arquivo2 = fopen ("$filename3", 'a');
  //rename( "anexoIII_original\\temp.csv", "$filename" ); // && unlink( "anexoIII_original\\temp.csv" );
  //rename("anexoIII_original\\temp.csv", "$filename"); 
  break; } 
  //caso contrário o loop continua
  else $arqi++;
}

$ib = 1;
  $arqc = array();
 // Lê o conteúdo do arquivo 
  while(!feof($arquivo1))
  {
    $arqc[$ib] = fgets($arquivo1, 999000);
    $ib++;
    
  }

 $ii=1;

    while ($ii <= count($arqc)-1) {

//while ($ii <= count($arqc)-1) { 
  //obtem somente a linha nº1 da planilha
   //respectiva ao nome de cada coluna

if ($ii > 0 && $ii < 2) {

  $converte_array = explode(";",$arqc[$ii]);
 
//separa as colunas da planilha excel
//identidade de cada coluna 
$text = "id;".$converte_array[1].";".$converte_array[2].";".$converte_array[3].";".$converte_array[4].";".$converte_array[5].";".$converte_array[6].";".$converte_array[7].";".$converte_array[8].";".$converte_array[9].";".$converte_array[10].";".$converte_array[11].";".$converte_array[12].";".$converte_array[13].";".$converte_array[14].";".$converte_array[15].";".$converte_array[16].";".$converte_array[17].";".$converte_array[18].";".$converte_array[19].";".$converte_array[20].";".$converte_array[21].";".$converte_array[22].";"."IMPEDIMENTO;"."ST_monit;"."Vlr_EUSD;"."Mes_EUSD;"."NO_PRAZO;"."ST_Ver_Prz;"."PV_CALC;"."ST_PV;"."PP;"."DU/DC/HS;"."N/U;"."U/R;"."Vlr_Comp;"."Dt_Ini_Cor;"."DT_LIM_CORR;"."Aux_DT_LIM_GS;"."ST_DT_LIMIT;"."Dt_Fin_Cor;"."Data_insercao".";\n";
//$text = "$entrada;$entradab;$entradac;$entradad;$entradae;$entradaf;$entradag.$entradah;$entradai;$entradaj;$entradal;$entraday;$testx;\n";
fwrite($arquivo2, $text);
}
  $ii++;
}

$ii=1;

while ($ii <= count($arqc)-1 ) {
//while ($ii <= count($arqc)-1) { 
  
 if ($ii > 1) {

//separa as colunas da planilha excel
$converte_array = explode(";",$arqc[$ii]);

 $tipo2 = $converte_array[4];
 $tipo2 = str_replace("?", "A", $tipo2);
 $tipo2 = str_replace("1A", "1o", $tipo2);
 $tipo2 = str_replace("1?", "1o", $tipo2);
 $tipo2 = str_replace("2A", "2o", $tipo2);
 $tipo2 = str_replace("2?", "2o", $tipo2);



 $motivo1 = $converte_array[5];
 $motivo2 = str_replace("?", "A", $motivo1);

 //realiza a checagem para conferir se a ocorrência está
 //presente em um dos tipos de serviço da tabela tipo
 $sql = "SELECT tipo FROM tipos WHERE `tipo` = '$tipo2'" or die(mysql_error());
 $result = mysql_query($sql);
 $registro = mysql_fetch_array($result);
 $tipo = $registro['tipo'];

//se for localizado na tabela tipos 
//a variavel $tipo2 significa que $tipo2 é
//um tipo válido 
//caso não localize $tipo2 é um tipo inválido
if (!empty($tipo) || $tipo2 == 'ORIENT./VIST. LIGACAO NOVA-AREA  URBANA' || $tipo2 == 'PEDIDO DE FORN. DE BAIXA TENSAO  URBANA' ){ 


/* -------- IDENTIFICANDO TIPO DE PRIORIDADE ------------- */

$prioridade = $converte_array[7];

if (($prioridade == "Prioritaria") || ($prioridade == "Emergencial")){
    $nu = "Urg";
} else{
  $nu = "Nor";
}

/* -------- IDENTIFICANDO TIPO DE LIGAÇÃO URBANA E RURAL ------------- */

//função stristr busca em um conjunto de palavras
//o parâmetro dado pelo usuário 
//ex: "rural"
if (stristr($tipo2, "rural")){
  $ur = "Ru";
} else {
  $ur = "Urb";
}


/* -------- SETANDO DATA ATUAL AAAA/MM/DD H:i:s ------------- */

    $data = date('Y-m-d H:i:s');

/* --------- OBTEM PRAZO LEGAL E TIPO DE PRAZO DE RELIGAÇÃO ---------- */

//realiza uma consulta ao banco de dados para 
//buscar o prazo e o tipo (DC, DU, etc) de cada tipo de serv.
$sql = "SELECT prz, tipo_prz FROM tipos WHERE tipo = '$tipo2'";
$result = mysql_query($sql);
$registro = mysql_fetch_array($result);
$prz = $registro['prz'];
$tipo_prz = $registro ['tipo_prz'];

/* --------- EXTRAÇÃO DE COLUNAS MONIT E NO_PRZ ---------- */

//extraindo coluna monitora
$monit = $converte_array[22];

if ($monit == "S"){
  $st_monit = "Ok";
} else $st_monit = "Fail";


//extraindo dados da coluna Duração Dias
$dur_dias = $converte_array[18];


/* --------- VARIÁVEIS GLOBAIS --------- */

/* -------- DATA DE ABERTURA --------- */

$data_abert_orig = $converte_array[12];


$data_abert_invert = implode("-",array_reverse(explode("/",$data_abert_orig)));

//a data de abertura corrigida leva em conta 
//se a data de abertura (original) está associada 
//a um dia não útil (sábado, domingo e feriados). 
//Se estiver será acrescentado 1 dia útil 

$data_abert_corr = proximoDiaUtil($data_abert_invert); 


//$data_abert_corr = proximoDiaUtil($data_abert_invert); 
$sql = "SELECT dat_ini FROM feriados WHERE dat_ini = '$data_abert_corr'";
$result = mysql_query($sql);
$registro = mysql_fetch_array($result);
$ferdat = $registro['dat_ini'];

// verifica se a data de abertura 
// foi registrada em um feriado  

if (!empty($ferdat)){

$data_abert_corr = proximoDiaUtilPr($data_abert_corr); 

}




$hora_abert = $converte_array[13];



/* -------- DATA LIMITE ------------- */

//extrai data limite original da planilha
$data_limit = $converte_array[14];

//converte data limite para formato americano padrao 
$data_limit_invert = implode("-",array_reverse(explode("/",$data_limit)));

//extrai hora data_limit da 
//planilha original 
$hora_limit = $converte_array[15];


/* -------- DATA CONCLUSÃO ------------- */

//extrai data_conc da planilha original 
$data_conc_orig = $converte_array[16];

//coverte data conc para o formato americano padrao
$data_conc_invert = implode("-",array_reverse(explode("/",$data_conc_orig)));


//extrai hora data de conclusão da planilha 
$hora_conc_orig = $converte_array[17];

// realiza a correção caso a data conc 
//não caia em dia útil
 //proximoDiaUtil (conferir arquivo diautil)
$data_conc_corr = proximoDiaUtil($data_conc_invert);

$sql = "SELECT dat_ini FROM feriados WHERE dat_ini = '$data_conc_corr'";
$result = mysql_query($sql);
$registro = mysql_fetch_array($result);
$ferdat = $registro['dat_ini'];

// verifica se a data de abertura 
// foi registrada em um feriado  
if (!empty($ferdat)){
$data_conc_corr = proximoDiaUtilPr($data_conc_corr);
}






/* --------- INICIO CÁLCULO PRAZO DE VERIFICAÇÃO DIAS UTEIS ----------- */

//caso seja DU realiza a adição dos dias uteis 
// a partir da data $data_limit_pr
if ($tipo_prz == 'DU'){

$data_limit_corr = $data_abert_corr;

  //Aqui assume-se que a data em que se inicia a contagem
  //corresponde a um dia útil 
$prdia = 0;
  //A função que acrescenta um dia a mais na data
  //será executada enquanto os dias úteis forem menores que o prazo
  //lembrando qua ao final deste loop a quantidade de dias úteis 
  //irá corresponder ao prazo DU por isso deixará de ser executado
  while ($prdia < $prz){
    $data_limit_corr = proximoDiaUtilPr($data_limit_corr);      

$sql = "SELECT dat_ini FROM feriados WHERE dat_ini = '$data_limit_corr'";
$result = mysql_query($sql);
$registro = mysql_fetch_array($result);
$ferdat = $registro['dat_ini'];

// verifica se a data de abertura 
// foi registrada em um feriado  
if (!empty($ferdat)){
$data_limit_corr = proximoDiaUtilPr($data_limit_corr);

}

$prdia++;
 }




  
 //calcular o prazo de cumprimento da solicitação 

 $hora_limit = "23:59";


/* ------------ CALCULANDO PV_CALC ---------------- */

//extraindo data de conclusão da planilha
//$data_conc03 = $converte_array[16];
//convertendo data para padrão americano
//$conc_calc_corr = implode("-",array_reverse(explode("/",$data_conc03)));

$conc_calc_corr = $data_conc_corr;

//extraindo data de abertura da planilha
//obs criar variáveis globais da data de abertura e conclusão 
//porque elas são usadas no decorrer de todo o código
//$data_abert03 = $converte_array[12];
//convertendo data para padrão americano
//$data_abert_calc_du = implode("-",array_reverse(explode("/",$data_abert03)));

$data_abert_calc_du = $data_abert_corr;

//$protocolo = $converte_array[2];


$dataConc = date_create($conc_calc_corr);
$dataLimit = date_create($data_limit_corr);
$intervalo = date_diff($dataLimit, $dataConc);
$diff_conc_limit_du = $intervalo->format('%R%a');



/*
//diferença entre data de conclusão e data limite em dias corridos
$diff_conc_limit_du = strtotime($conc_calc_corr) - strtotime($data_limit_corr);
//conbverter resultado em dias
$diff_conc_limit_du = round($diferenca / (60 * 60 * 24));
*/



//executar caso a diferença entre data de conclusão e limite 
//em dias corridos seja inferior ou igual a zero 
//síntese: data de conclusão for menor que a data de abertura
if ($diff_conc_limit_du <= 0){

//calcular a difença entre data de abertura e data de conclusão em dias úteis 
$diff_conc_abert_du = diasUteis($data_abert_calc_du, $conc_calc_corr);


  //executar caso a diferença em dias úteis entre a data de conclusão e 
  //abertura for maior ou igual a dois 
  if ($diff_conc_abert_du >= 2){
    $intervalo_pv = $diff_conc_abert_du - 1;
    } else { $intervalo_pv = $diff_conc_abert_du; }

} 
//se a diferença entre data de conclusão e limite 
//em dias corridos não for inferior ou igual a zero
else{ 

  //acrescentar um dia útil à data de conclusão 
  $data_conc_pv = proximoDiaUtilPr($conc_calc_corr);

  //consultar tabela feriados no bd e trazer resultado(s)
  $sql = "SELECT dat_ini FROM feriados WHERE dat_ini = '$data_conc_pv'";
  $result = mysql_query($sql);
  $registro = mysql_fetch_array($result);
  $ferdat = $registro['dat_ini'];


// verifica se a data de abertura 
// foi registrada em um feriado  
if (!empty($ferdat)){
$data_conc_pv = proximoDiaUtilPr($data_conc_pv);
}


$diferenca = (strtotime($data_conc_pv) - strtotime($data_limit_corr));
$diff_conc_limit = round($diferenca / (60 * 60 * 24)) - 1;

/*
$dataConc = date_create($data_conc_pv);
$intervalo = date_diff($dataLimit, $dataConc);
$diff_conc_limit_du = $intervalo->format('%R%a');
*/

$intervalo_pv = $diff_conc_limit + $prz;



}
//$intervalo_pv = $intervalo_pv.",00";

$intervalo_pv = number_format($intervalo_pv, 2, ',', '.');  


$intervalo_int = round($intervalo_pv);

if ($intervalo_int == $dur_dias){
  $st_pv = "Ok";
} else $st_pv = "Fail"; 


}


/* --------------- INICIO PV_CALC DIAS CORRIDOS ------------------ */


//caso seja DC realiza a adição dos dias corridos 
// a partir da data $data_limit_pr
if ($tipo_prz == 'DC'){

$data_limit_corr = $data_abert_corr;

$prdia = 0;
  //A função que acrescenta um dia a mais na data
  //será executada enquanto os dias corridos forem menores que o prazo
  //lembrando qua ao final deste loop a quantidade de dias corridos 
  //irá corresponder ao prazo DC por isso deixará de ser executado
  while ($prdia < $prz){
    $data_limit_corr = proximoDiaCorridoPr($data_limit_corr);
    $prdia++;
 }

$data_limit_corr = proximoDiaUtil($data_limit_corr);

  $sql = "SELECT dat_ini FROM feriados WHERE dat_ini = '$data_limit_corr'";
$result = mysql_query($sql);
$registro = mysql_fetch_array($result);
$ferdat = $registro['dat_ini'];

// verifica se a data de abertura 
// foi registrada em um feriado  
if (!empty($ferdat)){
$data_limit_corr = proximoDiaUtilPr($data_limit_corr);
}

$hora_limit = "23:59";


/* ------- PV_CALC DC -------- */

$data_conc02 = $converte_array[16];
$data_conc_calc_dc = implode("-",array_reverse(explode("/",$data_conc02)));

$data_conc_calc_dc = $data_conc_corr;

$data_abert_calc_dc = $data_abert_corr;

$diff_conc_abert_dc = strtotime($data_conc_calc_dc) - strtotime($data_abert_calc_dc);

$intervalo_pv = round($diff_conc_abert_dc / (60 * 60 * 24));

if ($intervalo_pv < 0){
  $intervalo_pv = '0,00'; 
} else $intervalo_pv = number_format($intervalo_pv, 2, ',', '.');
//$intervalo_pv = $intervalo_pv.",00";

//$intervalo_pv = number_format($intervalo_pv, 2, ',', '.');  

$intervalo_pv_format = str_replace(".", "", "$intervalo_pv");

$intervalo_pv_format = str_replace(",", ".", "$intervalo_pv_format");

$intervalo_int = round($intervalo_pv_format);



if ($intervalo_int == $dur_dias){
  $st_pv = "Ok";
} else $st_pv = "Fail"; 

}

/* ------------------ INICIO PV_CALC HORAS ------------------------- */


if ($tipo_prz == 'HS'){

  $prior = $nu.".".$ur;




  if ($motivo2 == "ALEGACAO DO CLI DE SUSP INDEVIDA-ANALISE"){
    $prz = 4;
  } else {

    switch ($prior) {

      case 'Nor.Urb':
        $prz = 24;
        break;
      case 'Nor.Ru':
        $prz = 48;
        break;
      case 'Urg.Urb':
        $prz = 4;
        break;
      default:
        $prz = 8;
      break;
  }
  }

$protocolo = $converte_array[2];

$data_abert_corr2 = $data_abert_invert;

$hora_abert_corr = $hora_abert;

$data_abert_corr3 = proximoDiaUtil($data_abert_corr2);

$sql = "SELECT dat_ini FROM feriados WHERE dat_ini = '$data_abert_corr3'";
$result = mysql_query($sql);
$registro = mysql_fetch_array($result);
$ferdat = $registro['dat_ini'];

// verifica se a data de abertura 
// foi registrada em um feriado  
if (!empty($ferdat)){
$data_abert_corr3 = proximoDiaUtilPr($data_abert_corr3);
}

if($data_abert_corr3 != $data_abert_corr2){
    $hora_abert_corr = "08:00";
}


if ($hora_abert_corr >= "18:00"){


    $data_abert_corr3 = proximoDiaUtilPr($data_abert_corr2); 
    $hora_abert_corr = "08:00";

$sql = "SELECT dat_ini FROM feriados WHERE dat_ini = '$data_abert_corr3'";
$result = mysql_query($sql);
$registro = mysql_fetch_array($result);
$ferdat = $registro['dat_ini'];

// verifica se a data de abertura 
// foi registrada em um feriado 
 if (!empty($ferdat)){
$data_abert_corr3 = proximoDiaUtilPr($data_abert_corr3); 

}


  }



    if ($prz == 24) {
      $data_limit_corr = date('Y-m-d', strtotime("+1 day",strtotime($data_abert_corr3))); 
  

    }

    elseif ($prz == 48) {
    $data_limit_corr = date('Y-m-d', strtotime("+2 days",strtotime($data_abert_corr3)));  
  
    } 

    else {
      $data_limit_corr = $data_abert_corr3;
      
    }


    $timestamp = strtotime($hora_abert_corr) + 60*60*$prz;
    $hora_limit = strftime('%H:%M', $timestamp); 


$data_conc_calc = $data_conc_corr;
$hora_conc01 = $hora_conc_orig;

$hora_abert_calc = $hora_abert_corr;

$data_hora_conc_calc = "$data_conc_calc $hora_conc01";

$data_hora_abert_calc = "$data_abert_corr3 $hora_abert_calc";



$str1 = $data_hora_abert_calc; 
$str2 = $data_hora_conc_calc;
$tz1 = new DateTimeZone('America/Belem');
$tz2 = $tz1;
$d1 = new DateTime($str1, $tz1); // tz is optional,
$d2 = new DateTime($str2, $tz2); // and ignored if str contains tz offset
$delta_h = ($d2->getTimestamp() - $d1->getTimestamp()) / 3600;


if ($delta_h <= 0){
  $intervalo_pv = '0,00'; 
} else {

$intervalo_pv = number_format($delta_h, 2, ',', '.'); 

}

$intervalo_pv_format = str_replace(".", "", "$intervalo_pv");

$intervalo_pv_format = str_replace(",", ".", "$intervalo_pv_format");

$intervalo_int = round($intervalo_pv_format);

$dur_dias = number_format($dur_dias, 2, ',', '.');  

if ($intervalo_pv == $dur_dias){
  $st_pv = "Ok";
} else $st_pv = "Fail"; 


}

//extrair Data Limite Original
$data_limit_aux = $converte_array[14];
//coverte data conc para o formato americano padrao

$data_limit_aux_invert = implode("-",array_reverse(explode("/",$data_limit_aux)));

//extrair Hora Limite Original 
$hora_limit_aux = $converte_array[15];



/* --------- CONCATAR DATA E HORA LIMITE CORRIGIDA ----------- */

$dt_hr_limit_corr = "$data_limit_corr $hora_limit";



/* --------- CONCATAR DATA E HORA LIMITE AUX CORRIGIDA ----------- */

$dt_hr_limit_aux_corr = "$data_limit_aux_invert $hora_limit_aux";


/* --------- CONCATAR DATA E HORA CONCLUSÃO CORRIGIDA ----------- */

$dt_hr_conc_corr = "$data_conc_corr $hora_conc_orig";

/* --------- CONCATAR DATA E HORA ABERTURA CORRIGIDA ----------- */

$dt_hr_abert_corr = "$data_abert_corr $hora_abert";

//obter identificação do cliente através do seu número de registro 
$cliente = $converte_array[1];


/* --------- OBTER DADOS EUSD ----------- */

$sql = "SELECT eusd, data_ref FROM eusd WHERE cliente = '$cliente' and estproceseusd = 0";
$result = mysql_query($sql);
$registro = mysql_fetch_array($result);
$num_eusd = $registro['eusd'];
$data_eusd = $registro['data_ref'];



/* --------- FORMATAR NÚMERO EUSD ----------- */

//Formatar eusd para formato americano 
//padrao para que os cálculos possam ser 
//efetuados corretamente

//$num_eusd =  number_format($num_eusd, 2, '.', '');



/* --------- FORMATAR NÚMERO INTERVALO_PV ----------- */

//Formatar intervalo_pv para formato americano 
//padrao para que os cálculos possam ser 
//efetuados corretamente

$intervalo_pv_format = str_replace(".", "", "$intervalo_pv");

$intervalo_pv_format = str_replace(",", ".", "$intervalo_pv_format");


/* --------- CALCULANDO VLR_COMP ----------- */

$protocolo = $converte_array[2];

if ($num_eusd > 0){

$variavel1 = ($num_eusd / 730);

} else {$variavel1 = $num_eusd;}

if (($intervalo_pv_format > 0) && ($prz > 0)) {

$variavel2 = ($intervalo_pv_format / $prz);

} else $variavel2 = 0;

$condicao1 = ($variavel1 * $variavel2) * 100;

$condicao2 = $num_eusd * 10;

if (($intervalo_pv_format > $prz) && ($num_eusd != "SemEusd")){
if ($condicao1 <= $condicao2){
    $vlr_comp = $condicao1;

  } else{
$vlr_comp = $condicao2;
}

} else {$vlr_comp = 0;}

$vlr_comp = number_format($vlr_comp, 2, ',', '.');  



$vlr_comp = "R$ ".$vlr_comp;


/* --------- ACRESCENTAR R$ NO NÚMERO EUSD ----------- */

$num_eusd =  "R$ " . number_format($num_eusd, 2, ',', '.');


/* --------- NF_PRAZO (NO PRAZO / FORA DO PRAZO) ----------- */

if ($intervalo_pv_format > $prz){
  $nf_prazo = "ForaPrz";
} else { $nf_prazo = "NoPrz";}


/* ---------  ST_VER_PRZ  ----------- */
$protocolo = $converte_array[2];


//extraindo dados da coluna NO PRAZO
$no_prz = $converte_array[19];


//$no_prz = str_replace("?", "a", $no_prz);

//echo "No prazo2 -> $no_prz<br/>";

$no_prz22 = utf8_decode($no_prz);

//$no_prz2 = removeAcento($no_prz22);

$no_prz = str_replace("?", "a", $no_prz22);




//condição para encontrar a definição de ST_Ver_Prz

if (($no_prz == "Nao") && ($nf_prazo == "ForaPrz") || ($no_prz == "Sim") && ($nf_prazo == "NoPrz")) {
$st_ver_prz = "Ok";
} else {$st_ver_prz = "Fail";}


/* --------- ST_DT_LIMIT ----------- */

//Verificar se data limite prevista pelo sistema é a mesma 
//que a corrigida 
/*
echo "-------------- INICIO ------------<BR/>";
echo "TIPO PRZ --> $tipo_prz<br/>";
echo "Data Hora Limite --> $data_limit_corr  $hora_limit<br/>";
echo "Data Hora Aux --> $data_limit_aux_invert  $hora_limit_aux<br/>";

*/
if (($data_limit_corr == $data_limit_aux_invert) && ($hora_limit == $hora_limit_aux)) {
$st_dt_limit = "Ok";  
} else {$st_dt_limit = "Fail";}

//echo "ST-DT_LIMIT --> $st_dt_limit<br/><br/>";

/* --------- FATOR_A3 ----------- */

/*
if (($intervalo_pv_format == 0) || ($prz == 0)){
  $condicao1 = $intervalo_pv_format;
} else $condicao1 = ($intervalo_pv_format / $prz);

$condicao2 = ($condicao1) * (100/730);

if ($condicao1 <= 1){
  $fator_a3 = "SemComp";
} else {
  if($condicao2 > 10){
  $fator_a3 = "Lim_10EUSD";
} else $fator_a3 = $condicao2;

}

if (is_float($fator_a3)){
$fator_a3 = number_format($fator_a3, 9, ',', '.');  
}

*/

$impedimento = trim($converte_array[23]);

/* --------- ESCREVER DADOS EM PLANILHA ----------- */

$text = "".$converte_array[0].";".$converte_array[1].";".$converte_array[2].";".$converte_array[3].";".$tipo2.";".$motivo2.";".$converte_array[6].";".$converte_array[7].";".$converte_array[8].";".$converte_array[9].";".$converte_array[10].";".$converte_array[11].";".$data_abert_invert.";".$converte_array[13].";".$data_limit_invert.";".$converte_array[15].";".$data_conc_invert.";".$converte_array[17].";".$converte_array[18].";".$converte_array[19].";".$converte_array[20].";".$converte_array[21].";".$converte_array[22].";".$impedimento.";".$st_monit.";".$num_eusd.";".$data_eusd.";".$nf_prazo.";".$st_ver_prz.";".$intervalo_pv.";".$st_pv.";".$prz.";".$tipo_prz.";".$nu.";".$ur.";".$vlr_comp.";".$dt_hr_abert_corr.";".$dt_hr_limit_corr.";".$dt_hr_limit_aux_corr.";".$st_dt_limit.";".$dt_hr_conc_corr.";".$data.";\n";
//$text = "$entrada;$entradab;$entradac;$entradad;$entradae;$entradaf;$entradag.$entradah;$entradai;$entradaj;$entradal;$entraday;$testx;\n";
fwrite($arquivo2, $text);
}
}
//acrescenta + uma linha a variavel $ii 
// e volta para o  loop de contagem de linhas
  $ii++;
}

fclose($arquivo1); 
fclose($arquivo2); 



$nomeArquivo = "AnexoIII $arq_mes/$arq_ano";

$sql = "SELECT nome FROM usuarios WHERE login = '$matricula'";
$resultado = mysql_query($sql);
while($registro = mysql_fetch_array($resultado)){
      $nomeUsuario = $registro['nome'];
      } 

$dataInsert = $data;

$query = "LOAD DATA LOCAL INFILE 'relatorio_anexo_iii\\\\anexo_iii_original\\\\$filename2_2' INTO TABLE anexo_iii_orig FIELDS TERMINATED BY ';' ESCAPED BY '\\\\' LINES TERMINATED BY '\\n' IGNORE 1 LINES (`id`,`cliente`,`protocolo`,`matabertura`,`tiposerv`,`mot`,`numfase`,`prioridade`,`sit`,`orggerador`,`orgexecutivo`,`desc`,`dataabert`,`horaabert`,`datalimit`,`horalimit`,`dataconc`,`horaconc`,`duracaodias`,`noprazo`,`diasatraso`,`horas`,`monit`,`imp`)";
$result = mysql_query($query) or die(mysql_error());
$query = "DELETE FROM anexo_iii WHERE cliente = '0'";
$result = mysql_query($query) or die(mysql_error());

$query = "LOAD DATA LOCAL INFILE 'relatorio_anexo_iii\\\\anexo_iii_modificado\\\\$filename3_3' INTO TABLE anexo_iii FIELDS TERMINATED BY ';' ESCAPED BY '\\\\' LINES TERMINATED BY '\\n' IGNORE 1 LINES (`id`,`cliente`,`protocolo`,`matabertura`,`tiposerv`,`mot`,`numfase`,`prioridade`,`sit`,`orggerador`,`orgexecutivo`,`desc`,`dataabert`,`horaabert`,`datalimit`,`horalimit`,`dataconc`,`horaconc`,`duracaodias`,`noprazo`,`diasatraso`,`horas`,`monit`,`imp`,`st_monit`,`eusd`,`data_ref_eusd`,`nf_prazo`,`st_ver_prz`,`intervalo_pv`,`st_pv`,`prz`,`tipo_prz`,`nu`,`ur`,`vlr_comp`,`dt_hr_abert_corr`,`dt_hr_limit_corr`,`dt_hr_limit_aux`,`st_dt_limit`,`dt_hr_conc_corr`,`data_insercao`)";
$result = mysql_query($query) or die(mysql_error());
$query = "DELETE FROM anexo_iii WHERE cliente = '0'";
$result = mysql_query($query) or die(mysql_error());

$sql = "INSERT INTO uploads(id, nomeArquivo, NomeUsuario, dataInsert) VALUES ('', '$nomeArquivo', '$nomeUsuario', '$dataInsert')";
$result = mysql_query($sql) or die(mysql_error());


$sql = "UPDATE eusd SET estproceseusd = 1 WHERE estproceseusd = 0";
$result = mysql_query($sql) or die(mysql_error());


header('Location: anexo_load2.php?success=1'); die;
}

?>


<html lang="pt-br">
<head>

	<title>SICOB - SISTEMA DE COBRANCA</title>
	<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'">
  <title>SICOB</title>
	   <link href="css/bootstrap.min.css" rel="stylesheet">
     <link href="_css/estilo01.css" rel="stylesheet">
     <link href="_css/footerallpages.css" rel="stylesheet">




<style type="text/css">

progress {
    -webkit-appearance: none;
    height: 20px;
    width: 450px;
    text-align: center;
}

progress::-webkit-progress-bar {

   background: black;
    border-radius: 50px;
    padding: 2px;    
}
progress::-moz-progress-bar {  
    background: black;
    border-radius: 50px;
    padding: 2px;
}

progress::-webkit-progress-value {

   background-image:
     -webkit-linear-gradient(-45deg, 
                             transparent 33%, rgba(0, 0, 0, .1) 33%, 
                             rgba(0,0, 0, .1) 66%, transparent 66%),
     -webkit-linear-gradient(top, 
                             rgba(255, 255, 255, .25), 
                             rgba(0, 0, 0, .25)),
     -webkit-linear-gradient(left, #09c, #f44);

    border-radius: 50px; 
    background-size: 35px 20px, 100% 100%, 100% 100%;
}

#progConfig {
  margin-top: 25px;
  margin-right: 100px;  
}

progress#pg:before {
    content: attr(value) "%" ;
}

#fcarrega {
  margin-left: 67px;
  padding-bottom: 30px;
  color: #1C4977;
  font-weight: bolder;
  font-family: Times, Times New Roman, serif;
  font-size: 20px;
}

#multiple_upload {
      position:relative;
}
#uploadChange {
      position:absolute;
      top:2px;
      left:0;
      opacity:0.01;
      border:none;
      width:355px;
      padding:10px;
      z-index:1;
      cursor:pointer
}

#message {
      border:2px solid #ccc;
      background:#fff;
      padding:10px;
      width:250px;
      float:left;
      margin:4px;
      overflow:hidden;
      color: #333     
}

#Enviar {
  clear: both;
  float: left;
     border:1px solid #2E9AFE;
      background:#2E9AFE;
      color:#ffffff;
      font-family:'Open Sans';
      font-size:15px;
      font-weight:bold;
      padding:6px 18px;
      margin:0px 0px;
      border-radius: 10px;
}

#botao {
      border:1px solid #ff7b00;
      background:#ff7b00;
      color:#ffffff;
      font-family:'Open Sans';
      font-size:15px;
      font-weight:bold;
      padding:8px 28px;
      margin:4px 8px;
      border-radius: 10px;
}

#multiple_upload:hover > #botao {
      background:#662f00;
      border-color:#662f00;
} 

#lista ol {
      margin-left: -16px; 
}
#lista ol li {
     border-bottom:1px solid #eee;
     padding:10px;
    display:block;
    clear:left;
    margin-bottom:2px;
}
#lista ol li.item_grey{
     background:#f9f9f9;
}

img.item {
    max-width: 100%;
    max-height: 100%;
}

.box-images {
    height: 30px;
    width: 30px;
    background-color: #eee;
    border:1px solid #eee;
    margin-bottom:15px;
    /* Centralizando imagens */
    display: flex;
    align-items: center;
    justify-content: center;
    float:left;
    margin:0 10px 20px 0;
}


</style>


<script src="jquery.js" type="text/javascript"></script>  

<script>

$(document).ready(function(){

$(function(){
    $('#uploadChange').on('change',function() {
         var id = $(this).attr('id');
        var totalFiles = $(this).get(0).files.length;
         $('#message').text( totalFiles+' arquivo selecionado' );
           var htm='<ol>';             
             for (var i=0; i < totalFiles; i++) {
             var c = (i % 2 == 0) ? 'item_white' : 'item_grey';
             var arquivo = $(this).get(0).files[i];
             var fileV = new readFileView(arquivo, i);
             htm += '<li class="'+c+'"><div class="box-images"><img class="item" src="imagens/icone_excel.png" data-id="'+id+'" border="0"></div><span>'+arquivo.name+'</span><a href="" id="remove" class="remove">&nbsp;&nbsp;&nbsp;x</a></li>'+"\n";
         }
        htm += '</ol>';
           $('#lista').html(htm);    
    });
  
});

function readFileView(file, i) {

    var reader = new FileReader();
     reader.onload = function (e) {
       $('[data-img="'+i+'"]').attr('src', e.target.result);
  }
     reader.readAsDataURL(file);
}



});


  var maximo = new Number();  
  var maximo = 60;
  var progresso = new Number();
  var progresso = 0;
  function startProgres(){
    //if ($('#uploadChange').files.length === 0) {
 //  alert("Você ainda não selecionou um arquivo para upload!" )
//} else{
    document.getElementById("form1").style.display ="none";
    document.getElementById("uploadingStatus").style.display ="block";     
    if((progresso + 1) < maximo){
      progresso = progresso + 1;
      document.getElementById("pg").value = progresso;
      setTimeout("startProgres();", 450);
    }
  }

</script>
  
</head><body>

<script language="Javascript">

function somente_numero(campo){
        var digits="0123456789X"
        var campo_temp 
        for (var i=0;i<campo.value.length;i++){
          campo_temp=campo.value.substring(i,i+1)       
          if (digits.indexOf(campo_temp)==-1){
                        campo.value = campo.value.substring(0,i);
                        break;
           }
        }
}

<?php
$sql = "SELECT month(dataconc) as mes, year(dataconc) as ano FROM anexo_iii ORDER BY MAX(dataconc) LIMIT 1";
  $result = mysql_query($sql);
  $registro = mysql_fetch_array($result);
  $mesref = $registro['mes'];
  if ($mesref == 12){
    $mesref = 01;
  } else { 
  $mesref = $mesref + 1;} 
  $anoref = $registro['ano'];
  if ($mesref == 01){
    $anoref = $anoref + 1;
  }
?>

function optionCheck(){

 alert("Selecione o AnexoIII correspondente a data <?php echo "$mesref/$anoref" ?> ");

          }

function optionCheck2(){

a = confirm("Voc\u00ea est\u00e1 certo que o arquivo selcionado corresponde a data: <?php echo "$mesref/$anoref" ?> ");

if (a) {
  alert ("O arquivo ser\u00e1 armazenado no banco de dados");
} else {
  alert ("Operacao cancelada!");
  document.getElementById('Enviar').type = 'reset';
}
          }


</script>
  


<script language="Javascript">

function somente_numero(campo){
        var digits="0123456789X"
        var campo_temp 
        for (var i=0;i<campo.value.length;i++){
          campo_temp=campo.value.substring(i,i+1)       
          if (digits.indexOf(campo_temp)==-1){
                        campo.value = campo.value.substring(0,i);
                        break;
           }

     }


}

  var maximo = new Number();  
  var maximo = 100;
  var progresso = new Number();
  var progresso = 0;
  function startProgres(){
    //if ($('#uploadChange').files.length === 0) {
 //  alert("Você ainda não selecionou um arquivo para upload!" )
//} else{
    document.getElementById("form1").style.display ="none";
    document.getElementById("uploadingStatus").style.display ="block";     
    if((progresso + 1) < maximo){
      progresso = progresso + 1;
      document.getElementById("pg").value = progresso;
      setTimeout("startProgres();", 450);
    }
  }



</script>


   <!--::Inicio do Header::-->
    <header class="main_menu home_menu">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg fixed-top navbar-light">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
   

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
           <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item"><a class="nav-link" id="font_config"  href="http://10.68.14.67/novosicob/consulta.php">Pág. Inicial<span class="sr-only">(current)</span></a></li>   
           <li class="nav-item"><a class="nav-link" id="link_ativo"  href="http://10.68.14.67/novosicob/anexoIII_leitura.php" tabindex="-1">Enviar Arquivo</a></li>
           <li class="nav-item"><a class="nav-link" id="font_config" href="http://10.68.14.67/novosicob/gerar_relat.php">Gerar Arquivo</a></li>
           <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-toggle="dropdown" id="font_config" href="#" role="button" aria-haspopup="true" aria-expanded="false">Relatórios</a>
           <div class="dropdown-menu">
              <a class="dropdown-item" href="http://10.68.14.67/novosicob/enviar_relat.php" >Enviar Relatórios</a>
              <a class="dropdown-item" href="http://10.68.14.67/novosicob/relatorios.php" >Gerar Relatórios</a>            
            </div>
           </li>
           <li class="nav-item"><a class="nav-link" id="font_config" href="http://10.68.14.67/novosicob/admuser.php">Adm. Sistema</a></li>
           </ul>

<a class="navbar-brand" id="img_logo_main" href="consulta.php"><img id="img_logo" src="imagens/logo_ceb.png"></a>

              <span class="border border-secondary rounded-circle" id="border_icon"><img src="imagens/icon2.png" id="icon" alt="User Icon"/></span>
             <div class="h4"><?php echo "".$_SESSION['nome']; ?></div>
             <ul class="navbar-nav mr-auto " id="sair">
             <li class="nav-item"><a class="nav-link" href="http://10.68.14.67/novosicob/index.php?sair=1.php">Sair</a></li>
             </ul>
            </div>
          </div>
        </nav>
      </header>

 

  <section class="corpo_meio_marg">
          <nav class="navbar navbar-dark" style="background-color: #6A0888;">
  <a class="navbar-brand" id="title01" href="http://10.68.14.67/novosicob/">
    <div class="h4"> Anexo III </div>
  </a>
</nav>
      <div class="container-fluid">


        <div class="row">

           <div id="table04"> 
          

<?php
                    if ($_GET['upload'] && empty($_GET[success])){ ?> <form action="" onsubmit="startProgres();" style="display:block;" method="post" enctype="multipart/form-data" name="form1" id="form1" > 
                     <p style="font-size:16px;"> O arquivo deve estar no formato .csv </p>  
                   <div id="multiple_upload">     
                   <input name="csv" onClick="optionCheck()" accept=".csv" type="file"id="uploadChange" required />
                  <div id="message" style="font-size:14px; font-family:'Open Sans';" >Selecione o arquivo Anexo III:</div>
                  <input type="button" id="botao" value="Pesquisar" required />
                   <div id="lista">
   </div>                  
                   </div>
                <input type="submit" name="Submit" id="Enviar"  value="Enviar"/>  
                  </form> <div id="uploadingStatus" style="display:none;"> 
                    <font id="fcarrega"> AGUARDE ENQUANTO CARREGA </font> <div name="progConfig" id="progConfig" > <progress max="100" id="pg">
                  </progress></div></div>
                   
                                    
                    <?php
                  }
                   else if (!empty($_GET[success])){  ?>                  
                    <a href="eusd_load.php?upload=1">+ Carregar os arquivos EUSD para o banco de dados! [Passo 1]</a><br/>
                      <br/><b>Seu arquivo foi carregado com sucesso!</b> <? }  ?>        
                       </div>
        </div>
      </div>
  </section>

   <font style="font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif;">
<footer id="footer" class="footer-1">

<div class="main-footer widgets-dark typo-light">

<div class="container">

<div class="row">
  
<div class="col-xs-12 col-sm-6 col-md-3">
<div class="widget subscribe no-box">
<h5 class="widget-title">CEB RELAT<span></span></h5>
<p>Sistema desenvolvido com o intuito de automatizar os processos internos dos setores da CEB - Distribuição por meio da análise e tratamento de dados.</p></div>
</div>

<div class="col-xs-12 col-sm-6 col-md-3">
<div class="widget no-box">
<h5 class="widget-title">Mais Acessados<span></span></h5>
<ul class="thumbnail-widget">
<li>
<div class="thumb-content"><a href="http://10.68.14.67/novosicob/tratrec_load.php">Trat. Rec. Anexo III</a></div> 
</li>
<li>
<div class="thumb-content"><a href="http://10.68.14.67/novosicob/tratrec_load_anexo_i.php">Trat. Rec. Anexo I</a></div> 
</li>
<li>
<div class="thumb-content"><a href="http://10.68.14.67/novosicob/relat_gs.php">Anexo III Art. 32</a></div> 
</li>
<li>
<div class="thumb-content"><a href="http://10.68.14.67/novosicob/incuser.php">Incluir Usuário</a></div> 
</li>
<li>
<div class="thumb-content"><a href="http://10.68.14.67/novosicob/condeluser.php">Consultar Usuários</a></div>  
</li>
<li>
<div class="thumb-content"><a href="http://10.68.14.67/novosicob/consulta.php">Histórico</a></div> 
</li>
</ul>
</div>
</div>

<div class="col-xs-12 col-sm-6 col-md-3">
<div class="widget no-box">
<h5 class="widget-title">Incluir Usuário<span></span></h5>
<p>Função disponível apenas para administradores</p>
<a class="btn" href="http://10.68.14.67/novosicob/incuser.php" target="_blank">Cadastrar</a>
</div>
</div>

<div class="col-xs-12 col-sm-6 col-md-3">

<div class="widget no-box">
<h5 class="widget-title">Contato<span></span></h5>

<p><a href="mailto:richard.silva@ceb.com" title="glorythemes">richard.silva@ceb.com</a></p>
<ul class="social-footer2">
<li class=""><a title="youtube" target="_blank" href="https://www.youtube.com/"><img alt="youtube" width="30" height="30" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAAKT2lDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVNnVFPpFj333vRCS4iAlEtvUhUIIFJCi4AUkSYqIQkQSoghodkVUcERRUUEG8igiAOOjoCMFVEsDIoK2AfkIaKOg6OIisr74Xuja9a89+bN/rXXPues852zzwfACAyWSDNRNYAMqUIeEeCDx8TG4eQuQIEKJHAAEAizZCFz/SMBAPh+PDwrIsAHvgABeNMLCADATZvAMByH/w/qQplcAYCEAcB0kThLCIAUAEB6jkKmAEBGAYCdmCZTAKAEAGDLY2LjAFAtAGAnf+bTAICd+Jl7AQBblCEVAaCRACATZYhEAGg7AKzPVopFAFgwABRmS8Q5ANgtADBJV2ZIALC3AMDOEAuyAAgMADBRiIUpAAR7AGDIIyN4AISZABRG8lc88SuuEOcqAAB4mbI8uSQ5RYFbCC1xB1dXLh4ozkkXKxQ2YQJhmkAuwnmZGTKBNA/g88wAAKCRFRHgg/P9eM4Ors7ONo62Dl8t6r8G/yJiYuP+5c+rcEAAAOF0ftH+LC+zGoA7BoBt/qIl7gRoXgugdfeLZrIPQLUAoOnaV/Nw+H48PEWhkLnZ2eXk5NhKxEJbYcpXff5nwl/AV/1s+X48/Pf14L7iJIEyXYFHBPjgwsz0TKUcz5IJhGLc5o9H/LcL//wd0yLESWK5WCoU41EScY5EmozzMqUiiUKSKcUl0v9k4t8s+wM+3zUAsGo+AXuRLahdYwP2SycQWHTA4vcAAPK7b8HUKAgDgGiD4c93/+8//UegJQCAZkmScQAAXkQkLlTKsz/HCAAARKCBKrBBG/TBGCzABhzBBdzBC/xgNoRCJMTCQhBCCmSAHHJgKayCQiiGzbAdKmAv1EAdNMBRaIaTcA4uwlW4Dj1wD/phCJ7BKLyBCQRByAgTYSHaiAFiilgjjggXmYX4IcFIBBKLJCDJiBRRIkuRNUgxUopUIFVIHfI9cgI5h1xGupE7yAAygvyGvEcxlIGyUT3UDLVDuag3GoRGogvQZHQxmo8WoJvQcrQaPYw2oefQq2gP2o8+Q8cwwOgYBzPEbDAuxsNCsTgsCZNjy7EirAyrxhqwVqwDu4n1Y8+xdwQSgUXACTYEd0IgYR5BSFhMWE7YSKggHCQ0EdoJNwkDhFHCJyKTqEu0JroR+cQYYjIxh1hILCPWEo8TLxB7iEPENyQSiUMyJ7mQAkmxpFTSEtJG0m5SI+ksqZs0SBojk8naZGuyBzmULCAryIXkneTD5DPkG+Qh8lsKnWJAcaT4U+IoUspqShnlEOU05QZlmDJBVaOaUt2ooVQRNY9aQq2htlKvUYeoEzR1mjnNgxZJS6WtopXTGmgXaPdpr+h0uhHdlR5Ol9BX0svpR+iX6AP0dwwNhhWDx4hnKBmbGAcYZxl3GK+YTKYZ04sZx1QwNzHrmOeZD5lvVVgqtip8FZHKCpVKlSaVGyovVKmqpqreqgtV81XLVI+pXlN9rkZVM1PjqQnUlqtVqp1Q61MbU2epO6iHqmeob1Q/pH5Z/YkGWcNMw09DpFGgsV/jvMYgC2MZs3gsIWsNq4Z1gTXEJrHN2Xx2KruY/R27iz2qqaE5QzNKM1ezUvOUZj8H45hx+Jx0TgnnKKeX836K3hTvKeIpG6Y0TLkxZVxrqpaXllirSKtRq0frvTau7aedpr1Fu1n7gQ5Bx0onXCdHZ4/OBZ3nU9lT3acKpxZNPTr1ri6qa6UbobtEd79up+6Ynr5egJ5Mb6feeb3n+hx9L/1U/W36p/VHDFgGswwkBtsMzhg8xTVxbzwdL8fb8VFDXcNAQ6VhlWGX4YSRudE8o9VGjUYPjGnGXOMk423GbcajJgYmISZLTepN7ppSTbmmKaY7TDtMx83MzaLN1pk1mz0x1zLnm+eb15vft2BaeFostqi2uGVJsuRaplnutrxuhVo5WaVYVVpds0atna0l1rutu6cRp7lOk06rntZnw7Dxtsm2qbcZsOXYBtuutm22fWFnYhdnt8Wuw+6TvZN9un2N/T0HDYfZDqsdWh1+c7RyFDpWOt6azpzuP33F9JbpL2dYzxDP2DPjthPLKcRpnVOb00dnF2e5c4PziIuJS4LLLpc+Lpsbxt3IveRKdPVxXeF60vWdm7Obwu2o26/uNu5p7ofcn8w0nymeWTNz0MPIQ+BR5dE/C5+VMGvfrH5PQ0+BZ7XnIy9jL5FXrdewt6V3qvdh7xc+9j5yn+M+4zw33jLeWV/MN8C3yLfLT8Nvnl+F30N/I/9k/3r/0QCngCUBZwOJgUGBWwL7+Hp8Ib+OPzrbZfay2e1BjKC5QRVBj4KtguXBrSFoyOyQrSH355jOkc5pDoVQfujW0Adh5mGLw34MJ4WHhVeGP45wiFga0TGXNXfR3ENz30T6RJZE3ptnMU85ry1KNSo+qi5qPNo3ujS6P8YuZlnM1VidWElsSxw5LiquNm5svt/87fOH4p3iC+N7F5gvyF1weaHOwvSFpxapLhIsOpZATIhOOJTwQRAqqBaMJfITdyWOCnnCHcJnIi/RNtGI2ENcKh5O8kgqTXqS7JG8NXkkxTOlLOW5hCepkLxMDUzdmzqeFpp2IG0yPTq9MYOSkZBxQqohTZO2Z+pn5mZ2y6xlhbL+xW6Lty8elQfJa7OQrAVZLQq2QqboVFoo1yoHsmdlV2a/zYnKOZarnivN7cyzytuQN5zvn//tEsIS4ZK2pYZLVy0dWOa9rGo5sjxxedsK4xUFK4ZWBqw8uIq2Km3VT6vtV5eufr0mek1rgV7ByoLBtQFr6wtVCuWFfevc1+1dT1gvWd+1YfqGnRs+FYmKrhTbF5cVf9go3HjlG4dvyr+Z3JS0qavEuWTPZtJm6ebeLZ5bDpaql+aXDm4N2dq0Dd9WtO319kXbL5fNKNu7g7ZDuaO/PLi8ZafJzs07P1SkVPRU+lQ27tLdtWHX+G7R7ht7vPY07NXbW7z3/T7JvttVAVVN1WbVZftJ+7P3P66Jqun4lvttXa1ObXHtxwPSA/0HIw6217nU1R3SPVRSj9Yr60cOxx++/p3vdy0NNg1VjZzG4iNwRHnk6fcJ3/ceDTradox7rOEH0x92HWcdL2pCmvKaRptTmvtbYlu6T8w+0dbq3nr8R9sfD5w0PFl5SvNUyWna6YLTk2fyz4ydlZ19fi753GDborZ752PO32oPb++6EHTh0kX/i+c7vDvOXPK4dPKy2+UTV7hXmq86X23qdOo8/pPTT8e7nLuarrlca7nuer21e2b36RueN87d9L158Rb/1tWeOT3dvfN6b/fF9/XfFt1+cif9zsu72Xcn7q28T7xf9EDtQdlD3YfVP1v+3Njv3H9qwHeg89HcR/cGhYPP/pH1jw9DBY+Zj8uGDYbrnjg+OTniP3L96fynQ89kzyaeF/6i/suuFxYvfvjV69fO0ZjRoZfyl5O/bXyl/erA6xmv28bCxh6+yXgzMV70VvvtwXfcdx3vo98PT+R8IH8o/2j5sfVT0Kf7kxmTk/8EA5jz/GMzLdsAAAAgY0hSTQAAeiUAAICDAAD5/wAAgOkAAHUwAADqYAAAOpgAABdvkl/FRgAAAY1JREFUeNrs1j9rFVEQBfDfe74UFgpaKBoh2PkFLIL4AfwOChaCRQpttFBILdiInZAmQWIp/sFCsNQUVjYigkUQTECw0EZJ8sZmHjyXXffug5BmD9xi7x3O2Zk5O3cHEeEgMHRA6IV74X3DqGH/CK7jAiJXKQYY4znWsVsbVPMdn8Az/MQqfneszB6OYwmfcblWPCKm13xErEfEo8r+LGsuIt5ExJ2IOF09rwYvRcSHiDjVQDbsKH4xIjaS95+zagnP4Dt+NJTxFq5lH0uwmWVeaHP1hLDJTOfwEK+xWCA86e1cm6ujwLE38CeN9xZ38e0/8bW8wxm++12s4Ty28R63u3J1FR5Ushjn83C/J9ceDuFKZjqfmd/Ll5h5crW5NfAA73AVGwXxtbyj0sDEJ9zESuEYnfDvtAlv4hKOpXGquN+xpAvZzi9tPX6Bj1huIBp39M8yXuFlySVxEk9zgj3B1pR7FfR0hLM54b7mJbFTIgxHp67Fwx3cP0jn/8osH3e5Fvtfn164F54JfwcAPgUNoNdO9QgAAAAASUVORK5CYII="></a></li>
<li class=""><a href="https://www.facebook.com/richard.palmas" target="_blank" title="Facebook"><img alt="Facebook" width="30" height="30" src="data:image/png;base64,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"></a></li>
<li class=""><a href="https://twitter.com" target="_blank" title="Twitter"><img alt="Twitter" width="30" height="30" src="data:image/png;base64,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"></a></li>
<li class=""><a title="instagram" target="_blank" href="https://www.instagram.com/"><img alt="instagram" width="30" height="30" src="data:image/png;base64,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"></a></li>
</ul>
</div>
</div>

</div>
</div>
</div>
  
<div class="footer-copyright">
<div class="container">
<div class="row">
<div class="col-md-12 text-center">
<p>Copyright Richard Palmas © 2019. Todos os direitos reservados.</p>
</div>
</div>
</div>
</div>
</footer>
</font>
          <script src="jquery.js" type="text/javascript"></script>
          <script src="js/bootstrap.min.js"></script>




  </body></html>