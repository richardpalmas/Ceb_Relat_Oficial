<?php
//realiza a conexão com banco de dados
	require("main3.php");
	$vvv = $_POST["relatorio"];
	if ( strlen($_POST['ano']) == 4 && strlen($_POST['ano_conc']) == 4) $anoox = $_POST['ano_uc']; 
	if ( strlen($_POST['ano']) == 4 &&  strlen($_POST['ano_uc']) == 4) $anoox = $_POST['ano_conc']; 
	if ( strlen($_POST['ano_uc']) == 4 && strlen($_POST['ano_conc']) == 4) $anoox = $_POST['ano']; 

//(strlen($_POST['ano']) == 4)
$mees = substr($anoox, 0, -5);
$anoo = substr($anoox, -4);
$anoo_pen = $anoo - 1;
$ihh = date('t', mktime(0, 0, 0, $mees, '01', $anoo)); 
$diaa = date('d');
$data_i = "$anoo/$mees/$diaa";
$data_f = date('Y/m/d', strtotime('-3 months', strtotime("$anoo/$mees/$diaa")));

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

	<title>CEB RELAT - SISTEMA DE RELATÓRIOS DA CEB</title>
	<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'">
  <title>SICOB</title>
	   <link href="css/bootstrap.min.css" rel="stylesheet">
     <link href="_css/estilo01.css" rel="stylesheet">
     <link href="_css/estilo_relat.css" rel="stylesheet">
     <link href="_css/footerallpages.css" rel="stylesheet">
     <link href="https://playground.anychart.com/gallery/Column_Charts/Stick_Chart/iframe" rel="canonical">

</head><body>

<?php 	if(empty($_POST["relatorio"])){
echo "<script language='javascript' type='text/javascript'>alert('Data de referência não definida');window.location.href='relatorios.php'</script>";} ?>
<script src="jquery.js" type="text/javascript"></script>
<script src="jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


 <script type="text/javascript">
	
	<?php if ($_POST["relatorio"]=="m_abertura"){ ?>
		google.charts.load('current', {'packages':['bar']});  	
	  	 //aqui faz-se conexão e carrega os parâmetros que darão origem a tabela do Google Table 
		  	 google.charts.load('current', {'packages':['table']});
		google.charts.setOnLoadCallback(drawChart);
		google.charts.setOnLoadCallback(drawChart5);
		  google.charts.setOnLoadCallback(drawTable4);
		  google.charts.setOnLoadCallback(drawTable6);
		  google.charts.setOnLoadCallback(drawTable7);		  
	<?php } ?>

	<?php if ($_POST["relatorio"]=="m_deslig"){ ?>
	  google.charts.load('current', {'packages':['bar']});
		  google.charts.load('current', {'packages':['corechart']});
	  	 //aqui faz-se conexão e carrega os parâmetros que darão origem a tabela do Google Table 
		   google.charts.load('current', {'packages':['table']});
          google.charts.setOnLoadCallback(drawChart);    
	  	google.charts.setOnLoadCallback(drawChart2);	  	
      google.charts.setOnLoadCallback(drawTable);	  
      google.charts.setOnLoadCallback(drawTable2);    
      google.charts.setOnLoadCallback(drawTable3); 
       google.charts.setOnLoadCallback(drawTable8); 
       google.charts.setOnLoadCallback(drawTable9); 
       google.charts.setOnLoadCallback(drawTable5); 

       google.charts.setOnLoadCallback(drawTableRelig); 
       google.charts.setOnLoadCallback(drawTableRelig2); 
       google.charts.setOnLoadCallback(drawChart3);          
    <?php } ?>
	<?php if ($_POST["relatorio"]=="relat_uc_s_med"){ ?>
		google.charts.load('current', {'packages':['bar']});
		  google.charts.load('current', {'packages':['corechart']});
   google.charts.load('current', {'packages':['table']});
google.charts.setOnLoadCallback(drawChart0);
google.charts.setOnLoadCallback(drawChart1);
google.charts.setOnLoadCallback(drawChart3);
google.charts.setOnLoadCallback(drawChart2);
	google.charts.setOnLoadCallback(drawChart4);
   google.charts.setOnLoadCallback(drawTable);	  
      google.charts.setOnLoadCallback(drawTable2);    
   
      <?php } 
	  
	$contador = array();

$contador[dj][total]=0;

$contador[cv][total]=0;

$contador[at][total]=0;

$dj = array();
$cv = array();
$at = array();

$dj_cv_at = array();

$conta_paga = array();

$semana_mes_atual = array();

$semana_mes_pen = array();

$classe = array();

$mes_abert = array();
$ano_abert = array();

$mes_uc = array();
$ano_uc = array();
$situacao = array();
$tipo_ligacao = array();

/***

***/

if ($_POST["relatorio"]=="m_abertura"){
	
$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and MOT IN ('EXISTE DEBITO CLIENTE - INICIATIVA CEB', 'EXISTÊNCIA DE DEBITO DO CLIENTE', 'FIM PRAZO SUSPENSÃO', 'DETERMINACAO JUDICIAL', 'FIM DO PRAZO SUSPENSAO - INICIATIVA CEB', 'INICIATIVA DA CEB', 'FALTA ACESSO MEDIÇÃO', 'FIM DO PRAZO DA LIGAÇÃO TEMPORARIA', 'DESOBEDIENCIA AS NORMAS', 'FRAUDE', 'FIM DO PRAZO FIXADO PELO CLIENTE') and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR'";
$resultado = mysql_query($sql);
$contador[dj][total] = mysql_result($resultado, 0);	
$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and MOT IN ('EXISTE DEBITO CLIENTE - INICIATIVA CEB', 'EXISTÊNCIA DE DEBITO DO CLIENTE', 'FIM PRAZO SUSPENSÃO', 'DETERMINACAO JUDICIAL', 'FIM DO PRAZO SUSPENSAO - INICIATIVA CEB', 'INICIATIVA DA CEB', 'FALTA ACESSO MEDIÇÃO', 'FIM DO PRAZO DA LIGAÇÃO TEMPORARIA', 'DESOBEDIENCIA AS NORMAS', 'FRAUDE', 'FIM DO PRAZO FIXADO PELO CLIENTE') and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO')";
$resultado = mysql_query($sql);
$contador[cv][total] = mysql_result($resultado, 0);	
$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and MOT IN ('EXISTE DEBITO CLIENTE - INICIATIVA CEB', 'EXISTÊNCIA DE DEBITO DO CLIENTE', 'FIM PRAZO SUSPENSÃO', 'DETERMINACAO JUDICIAL', 'FIM DO PRAZO SUSPENSAO - INICIATIVA CEB', 'INICIATIVA DA CEB', 'FALTA ACESSO MEDIÇÃO', 'FIM DO PRAZO DA LIGAÇÃO TEMPORARIA', 'DESOBEDIENCIA AS NORMAS', 'FRAUDE', 'FIM DO PRAZO FIXADO PELO CLIENTE') and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES')";
$resultado = mysql_query($sql);
$contador[at][total] = mysql_result($resultado, 0);	

$sql = "SELECT DISTINCT month(dataconc) AS mes, year(dataconc) AS ano FROM `corte` WHERE month(dataconc) < $mees AND year(dataconc) = $anoo OR month(dataconc) > $mees AND year(dataconc) < $anoo  GROUP BY dataconc ORDER BY dataconc DESC LIMIT 1";
    	$resultado = mysql_query($sql);
    	while ($registro = mysql_fetch_array($resultado)){
    	$mes_abert[] = $registro['mes'];
    	$ano_abert[] = $registro['ano'];
    	}
    	
      $mes_abert_pen = $mes_abert[0];
      $ano_abert_pen = $ano_abert[0];

      $ijj = date('t', mktime(0, 0, 0, $mes_abert_pen, '01', $ano_abert_pen)); 	


/* Buscando resultados semanais de valores de cortes gerados referentes ao mês atual */

$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataconc) BETWEEN 1 and 8 and MOT IN ('EXISTE DEBITO CLIENTE - INICIATIVA CEB', 'EXISTÊNCIA DE DEBITO DO CLIENTE', 'FIM PRAZO SUSPENSÃO', 'DETERMINACAO JUDICIAL', 'FIM DO PRAZO SUSPENSAO - INICIATIVA CEB', 'INICIATIVA DA CEB', 'FALTA ACESSO MEDIÇÃO', 'FIM DO PRAZO DA LIGAÇÃO TEMPORARIA', 'DESOBEDIENCIA AS NORMAS', 'FRAUDE', 'FIM DO PRAZO FIXADO PELO CLIENTE')";
$resultado = mysql_query($sql);
	$semana_mes_atual1 = mysql_result($resultado, 0); 
	$semana_mes_atual[1] = number_format($semana_mes_atual1, 0, ',','.');	

$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataconc) BETWEEN 9 and 16 and MOT IN ('EXISTE DEBITO CLIENTE - INICIATIVA CEB', 'EXISTÊNCIA DE DEBITO DO CLIENTE', 'FIM PRAZO SUSPENSÃO', 'DETERMINACAO JUDICIAL', 'FIM DO PRAZO SUSPENSAO - INICIATIVA CEB', 'INICIATIVA DA CEB', 'FALTA ACESSO MEDIÇÃO', 'FIM DO PRAZO DA LIGAÇÃO TEMPORARIA', 'DESOBEDIENCIA AS NORMAS', 'FRAUDE', 'FIM DO PRAZO FIXADO PELO CLIENTE')";
$resultado = mysql_query($sql);
	$semana_mes_atual2 = mysql_result($resultado, 0); 
	$semana_mes_atual[2] = number_format($semana_mes_atual2, 0, ',','.');

$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataconc) BETWEEN 17 and 24 and MOT IN ('EXISTE DEBITO CLIENTE - INICIATIVA CEB', 'EXISTÊNCIA DE DEBITO DO CLIENTE', 'FIM PRAZO SUSPENSÃO', 'DETERMINACAO JUDICIAL', 'FIM DO PRAZO SUSPENSAO - INICIATIVA CEB', 'INICIATIVA DA CEB', 'FALTA ACESSO MEDIÇÃO', 'FIM DO PRAZO DA LIGAÇÃO TEMPORARIA', 'DESOBEDIENCIA AS NORMAS', 'FRAUDE', 'FIM DO PRAZO FIXADO PELO CLIENTE')";
$resultado = mysql_query($sql);
	$semana_mes_atual3 = mysql_result($resultado, 0); 
	$semana_mes_atual[3] = number_format($semana_mes_atual3, 0, ',','.');


$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataconc) BETWEEN 25 and 31 and MOT IN ('EXISTE DEBITO CLIENTE - INICIATIVA CEB', 'EXISTÊNCIA DE DEBITO DO CLIENTE', 'FIM PRAZO SUSPENSÃO', 'DETERMINACAO JUDICIAL', 'FIM DO PRAZO SUSPENSAO - INICIATIVA CEB', 'INICIATIVA DA CEB', 'FALTA ACESSO MEDIÇÃO', 'FIM DO PRAZO DA LIGAÇÃO TEMPORARIA', 'DESOBEDIENCIA AS NORMAS', 'FRAUDE', 'FIM DO PRAZO FIXADO PELO CLIENTE')";
$resultado = mysql_query($sql);
	$semana_mes_atual4 = mysql_result($resultado, 0); 
	$semana_mes_atual[4] = number_format($semana_mes_atual4, 0, ',','.');

/** Calculando as porcentagens relativas as semanas do mês atual **/

$qtd_semana_atual_1 = $semana_mes_atual1 + $semana_mes_atual2 + $semana_mes_atual3 + $semana_mes_atual4;
$qtd_semana_atual = number_format($qtd_semana_atual_1, 0, ',','.');

$porcentagem_semana1_1 = ($semana_mes_atual1 / $qtd_semana_atual_1) * 100; 
$porcentagem_semana1 = number_format($porcentagem_semana1_1, 2);

$porcentagem_semana2_1 = ($semana_mes_atual2 / $qtd_semana_atual_1) * 100; 
$porcentagem_semana2 = number_format($porcentagem_semana2_1, 2);

$porcentagem_semana3_1 = ($semana_mes_atual3 / $qtd_semana_atual_1) * 100; 
$porcentagem_semana3 = number_format($porcentagem_semana3_1, 2);

$porcentagem_semana4_1 = ($semana_mes_atual4 / $qtd_semana_atual_1) * 100; 
$porcentagem_semana4 = number_format($porcentagem_semana4_1, 2);

$porcentagem_total_atual_1 = $porcentagem_semana1 + $porcentagem_semana2 + $porcentagem_semana3 + $porcentagem_semana4;
$porcentagem_total_atual = number_format($porcentagem_total_atual_1, 0, ',','.');


/* Buscando resultados semanais de valores de cortes gerados referentes ao mês anterior */

if (!empty($mes_abert_pen)){

$sql = "SELECT count(*) from corte where year(dataabert) = $ano_abert_pen and month(dataabert) = $mes_abert_pen and day(dataconc) BETWEEN 1 and 8 and MOT IN ('EXISTE DEBITO CLIENTE - INICIATIVA CEB', 'EXISTÊNCIA DE DEBITO DO CLIENTE', 'FIM PRAZO SUSPENSÃO', 'DETERMINACAO JUDICIAL', 'FIM DO PRAZO SUSPENSAO - INICIATIVA CEB', 'INICIATIVA DA CEB', 'FALTA ACESSO MEDIÇÃO', 'FIM DO PRAZO DA LIGAÇÃO TEMPORARIA', 'DESOBEDIENCIA AS NORMAS', 'FRAUDE', 'FIM DO PRAZO FIXADO PELO CLIENTE')";
$resultado = mysql_query($sql);
	$semana_mes_pen1 = mysql_result($resultado, 0); 
	$semana_mes_pen[1] = number_format($semana_mes_pen1, 0, ',','.');	

$sql = "SELECT count(*) from corte where year(dataabert) = $ano_abert_pen and month(dataabert) = $mes_abert_pen and day(dataconc) BETWEEN 9 and 16 and MOT IN ('EXISTE DEBITO CLIENTE - INICIATIVA CEB', 'EXISTÊNCIA DE DEBITO DO CLIENTE', 'FIM PRAZO SUSPENSÃO', 'DETERMINACAO JUDICIAL', 'FIM DO PRAZO SUSPENSAO - INICIATIVA CEB', 'INICIATIVA DA CEB', 'FALTA ACESSO MEDIÇÃO', 'FIM DO PRAZO DA LIGAÇÃO TEMPORARIA', 'DESOBEDIENCIA AS NORMAS', 'FRAUDE', 'FIM DO PRAZO FIXADO PELO CLIENTE')";
$resultado = mysql_query($sql);
	$semana_mes_pen2 = mysql_result($resultado, 0); 
	$semana_mes_pen[2] = number_format($semana_mes_pen2, 0, ',','.');

$sql = "SELECT count(*) from corte where year(dataabert) = $ano_abert_pen and month(dataabert) = $mes_abert_pen and day(dataconc) BETWEEN 17 and 24 and MOT IN ('EXISTE DEBITO CLIENTE - INICIATIVA CEB', 'EXISTÊNCIA DE DEBITO DO CLIENTE', 'FIM PRAZO SUSPENSÃO', 'DETERMINACAO JUDICIAL', 'FIM DO PRAZO SUSPENSAO - INICIATIVA CEB', 'INICIATIVA DA CEB', 'FALTA ACESSO MEDIÇÃO', 'FIM DO PRAZO DA LIGAÇÃO TEMPORARIA', 'DESOBEDIENCIA AS NORMAS', 'FRAUDE', 'FIM DO PRAZO FIXADO PELO CLIENTE')";
$resultado = mysql_query($sql);
	$semana_mes_pen3 = mysql_result($resultado, 0); 
	$semana_mes_pen[3] = number_format($semana_mes_pen3, 0, ',','.');


$sql = "SELECT count(*) from corte where year(dataabert) = $ano_abert_pen and month(dataabert) = $mes_abert_pen and day(dataconc) BETWEEN 25 and 31 and MOT IN ('EXISTE DEBITO CLIENTE - INICIATIVA CEB', 'EXISTÊNCIA DE DEBITO DO CLIENTE', 'FIM PRAZO SUSPENSÃO', 'DETERMINACAO JUDICIAL', 'FIM DO PRAZO SUSPENSAO - INICIATIVA CEB', 'INICIATIVA DA CEB', 'FALTA ACESSO MEDIÇÃO', 'FIM DO PRAZO DA LIGAÇÃO TEMPORARIA', 'DESOBEDIENCIA AS NORMAS', 'FRAUDE', 'FIM DO PRAZO FIXADO PELO CLIENTE')";
$resultado = mysql_query($sql);
	$semana_mes_pen4 = mysql_result($resultado, 0); 
	$semana_mes_pen[4] = number_format($semana_mes_pen4, 0, ',','.');


/** Calculando as porcentagens relativas as semanas do mês anterior**/

$qtd_semanas_mes_anterior_1 = $semana_mes_pen1 + $semana_mes_pen2 + $semana_mes_pen3 + $semana_mes_pen4;
$qtd_semanas_mes_anterior = number_format($qtd_semanas_mes_anterior_1, 0, ',','.');

$porcentagem_pen_semana1_1 = ($semana_mes_pen1 / $qtd_semanas_mes_anterior_1) * 100; 
$porcentagem_pen_semana1 = number_format($porcentagem_pen_semana1_1, 2);

$porcentagem_pen_semana2_1 = ($semana_mes_pen2 / $qtd_semanas_mes_anterior_1) * 100; 
$porcentagem_pen_semana2 = number_format($porcentagem_pen_semana2_1, 2);

$porcentagem_pen_semana3_1 = ($semana_mes_pen3 / $qtd_semanas_mes_anterior_1) * 100; 
$porcentagem_pen_semana3 = number_format($porcentagem_pen_semana3_1, 2);

$porcentagem_pen_semana4_1 = ($semana_mes_pen4 / $qtd_semanas_mes_anterior_1) * 100; 
$porcentagem_pen_semana4 = number_format($porcentagem_pen_semana4_1, 2);

$porcentagem_total_pen_1 = $porcentagem_pen_semana1 + $porcentagem_pen_semana2 + $porcentagem_pen_semana3 + $porcentagem_pen_semana4;
$porcentagem_total_pen = number_format($porcentagem_total_pen_1, 0, ',','.');


/*Calculando a diferença percentual entre o mês atual e o anterior */

$diff_percent1_1 = (($semana_mes_atual1 - $semana_mes_pen1) / $semana_mes_pen1) * 100;
$diff_percent1 = number_format($diff_percent1_1, 2, '.','');

$diff_percent2_1 = (($semana_mes_atual2 - $semana_mes_pen2) / $semana_mes_pen2) * 100;
$diff_percent2 = number_format($diff_percent2_1, 2);

$diff_percent3_1 = (($semana_mes_atual3 - $semana_mes_pen3) / $semana_mes_pen3) * 100;
$diff_percent3 = number_format($diff_percent3_1, 2);

$diff_percent4_1 = (($semana_mes_atual4 - $semana_mes_pen4) / $semana_mes_pen4) * 100;
$diff_percent4 = number_format($diff_percent4_1, 2);

$diff_percent_total_1 = (($qtd_semana_atual_1 - $qtd_semanas_mes_anterior_1) / $qtd_semanas_mes_anterior_1) * 100;
$diff_percent_total = number_format($diff_percent_total_1, 2);

}

/* Consultando mês anterior nos cortes gerados */

if (!empty($mes_abert_pen)){

/* Total mensal de geração de cortes no disjuntor */

$sql = "SELECT count(*) from corte where year(dataabert) = $ano_abert_pen and month(dataabert) = $mes_abert_pen and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR'";
$resultado = mysql_query($sql);
$contador[dj][total_pen] = mysql_result($resultado, 0);	

/* Total mensal de geração de cortes convencionais */

$sql = "SELECT count(*) from corte where year(dataabert) = $ano_abert_pen and month(dataabert) = $mes_abert_pen and  TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO')";
$resultado = mysql_query($sql);
$contador[cv][total_pen] = mysql_result($resultado, 0);	

/* Total mensal de geração de cortes de alta tensão */

$sql = "SELECT count(*) from corte where year(dataabert) = $ano_abert_pen and month(dataabert) = $mes_abert_pen and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES')";
$resultado = mysql_query($sql);
$contador[at][total_pen] = mysql_result($resultado, 0);	

}



/***
 31 dias de levantamento para as concluidas no DJ - BT 
 ***/
$i=1;
while ($i <=$ihh) {
			
$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and MOT IN ('EXISTE DEBITO CLIENTE - INICIATIVA CEB', 'EXISTÊNCIA DE DEBITO DO CLIENTE', 'FIM PRAZO SUSPENSÃO', 'DETERMINACAO JUDICIAL', 'FIM DO PRAZO SUSPENSAO - INICIATIVA CEB', 'INICIATIVA DA CEB', 'FALTA ACESSO MEDIÇÃO', 'FIM DO PRAZO DA LIGAÇÃO TEMPORARIA', 'DESOBEDIENCIA AS NORMAS', 'FRAUDE', 'FIM DO PRAZO FIXADO PELO CLIENTE') and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR'";
$resultado = mysql_query($sql);
$dj[gerada][$i] = mysql_result($resultado, 0);	


	$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and MOT IN ('EXISTE DEBITO CLIENTE - INICIATIVA CEB', 'EXISTÊNCIA DE DEBITO DO CLIENTE', 'FIM PRAZO SUSPENSÃO', 'DETERMINACAO JUDICIAL', 'FIM DO PRAZO SUSPENSAO - INICIATIVA CEB', 'INICIATIVA DA CEB', 'FALTA ACESSO MEDIÇÃO', 'FIM DO PRAZO DA LIGAÇÃO TEMPORARIA', 'DESOBEDIENCIA AS NORMAS', 'FRAUDE', 'FIM DO PRAZO FIXADO PELO CLIENTE') and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO')";
$resultado = mysql_query($sql);
$cv[gerada][$i] = mysql_result($resultado, 0);



$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and MOT IN ('EXISTE DEBITO CLIENTE - INICIATIVA CEB', 'EXISTÊNCIA DE DEBITO DO CLIENTE', 'FIM PRAZO SUSPENSÃO', 'DETERMINACAO JUDICIAL', 'FIM DO PRAZO SUSPENSAO - INICIATIVA CEB', 'INICIATIVA DA CEB', 'FALTA ACESSO MEDIÇÃO', 'FIM DO PRAZO DA LIGAÇÃO TEMPORARIA', 'DESOBEDIENCIA AS NORMAS', 'FRAUDE', 'FIM DO PRAZO FIXADO PELO CLIENTE') and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES')";
$resultado = mysql_query($sql);
$at[gerada][$i] = mysql_result($resultado, 0);
	$i++;	
}

} if ($_POST['relatorio']=="m_deslig") {	


//QUANTIDADE DE OS COCLUÍDAS SEM IMPEDIMENTO
$sql = "SELECT count('qtd') as qtdConc FROM corte WHERE sit IN('Concluída') AND year(dataconc) = '$anoo' and month(dataconc) = '$mees'";
			$resultado = mysql_query($sql);
			$qtd_conc = mysql_result($resultado, 0);


//QUANTIDADE DE RELIGAÇÕES CONCLUÍDAS NO MÊS
$sql = "SELECT count('qtd') FROM corte as C INNER JOIN religacao as R ON C.ncli = R.ncli and R.dataabert >= C.dataconc WHERE R.sit IN('Concluída') and C.sit in ('Concluída') AND year(C.dataconc) = '$anoo' and month(C.dataconc) = '$mees' ";
$resultado0101 = mysql_query($sql);	
$resultado0102 = mysql_result($resultado0101, 0);

$religafazerOrig = $qtd_conc - $resultado0102;

if (!empty($qtd_conc)) {
$porcentagem_corte_relig2 = ($religafazerOrig / $qtd_conc) * 100;
} else $porcentagem_corte_relig2 = 0;
$porcentagem_corte_relig2 = number_format($porcentagem_corte_relig2, 2);

if (!empty($resultado0102)) {
$porcentagem_corte_relig1 = ($resultado0102 / $qtd_conc) * 100;
} else $porcentagem_corte_relig1 = 0;
$porcentagem_corte_relig = number_format($porcentagem_corte_relig1, 2);


$sql = "SELECT count('qtd') FROM corte as C INNER JOIN religacao as R ON C.ncli = R.ncli and R.dataabert >= C.dataconc WHERE R.sit IN('Gerada') and C.sit in ('Concluída') AND year(C.dataconc) = '$anoo' and month(C.dataconc) = '$mees' ";
$relgerada01 = mysql_query($sql);	
$relgerada02 = mysql_result($relgerada01, 0);

if (!empty($relgerada02)) {
$porcentagem_relgerada = ($relgerada02 / $religafazerOrig) * 100;
} else $porcentagem_relgerada = 0;
$porcentagem_relgerada = number_format($porcentagem_relgerada, 2);

$sql = "SELECT count('qtd') FROM corte as C INNER JOIN religacao as R ON C.ncli = R.ncli and R.dataabert >= C.dataconc WHERE R.sit IN('Aguardando Despacho') and C.sit in ('Concluída') AND year(C.dataconc) = '$anoo' and month(C.dataconc) = '$mees' ";
$relagdespacho01 = mysql_query($sql);	
$relagdespacho02 = mysql_result($relagdespacho01, 0);

if (!empty($relagdespacho02)) {
$porcentagem_relagdespacho = ($relagdespacho02 / $religafazerOrig) * 100;
} else $porcentagem_relagdespacho = 0;
$porcentagem_relagdespacho = number_format($porcentagem_relagdespacho, 2);

$sql = "SELECT count('qtd') FROM corte as C INNER JOIN religacao as R ON C.ncli = R.ncli and R.dataabert >= C.dataconc WHERE R.sit IN('Cancelada') and C.sit in ('Concluída') AND year(C.dataconc) = '$anoo' and month(C.dataconc) = '$mees' ";
$relcancelada01 = mysql_query($sql);	
$relcancelada02 = mysql_result($relcancelada01, 0);

if (!empty($relcancelada02)) {
$porcentagem_relcancelada = ($relcancelada02 / $religafazerOrig) * 100;
} else $porcentagem_relcancelada = 0;
$porcentagem_relcancelada = number_format($porcentagem_relcancelada, 2);

$sql = "SELECT count('qtd') FROM corte as C INNER JOIN religacao as R ON C.ncli = R.ncli and R.dataabert >= C.dataconc WHERE R.sit IN('Aceita') and C.sit in ('Concluída') AND year(C.dataconc) = '$anoo' and month(C.dataconc) = '$mees' ";
$relaceita01 = mysql_query($sql);	
$relaceita02 = mysql_result($relaceita01, 0);

if (!empty($relaceita02)) {
$porcentagem_relaceita = ($relaceita02 / $religafazerOrig) * 100;
} else $porcentagem_relaceita = 0;
$porcentagem_relaceita = number_format($porcentagem_relaceita, 2);

$sql = "SELECT count('qtd') FROM corte as C INNER JOIN religacao as R ON C.ncli = R.ncli and R.dataabert >= C.dataconc WHERE R.sit IN('Concluída com Impedimento') and C.sit in ('Concluída') AND year(C.dataconc) = '$anoo' and month(C.dataconc) = '$mees' ";
$relconcimp01 = mysql_query($sql);	
$relconcimp02 = mysql_result($relconcimp01, 0);

if (!empty($relconcimp02)) {
$porcentagem_relconcimp = ($relconcimp02 / $religafazerOrig) * 100;
} else $porcentagem_relconcimp = 0;
$porcentagem_relconcimp = number_format($porcentagem_relconcimp, 2);

$sql = "SELECT count('qtd') FROM corte as C INNER JOIN religacao as R ON C.ncli = R.ncli and R.dataabert >= C.dataconc WHERE R.sit IN('Concluída com Inconsistência') and C.sit in ('Concluída') AND year(C.dataconc) = '$anoo' and month(C.dataconc) = '$mees' ";
$relconcinc01 = mysql_query($sql);	
$relconcinc02 = mysql_result($relconcinc01, 0);

if (!empty($relconcinc02)) {
$porcentagem_relconcinc = ($relconcinc02 / $religafazerOrig) * 100;
} else $porcentagem_relconcinc = 0;
$porcentagem_relconcinc = number_format($porcentagem_relconcinc, 2);

$sql = "SELECT count('qtd') FROM corte as C INNER JOIN religacao as R ON C.ncli = R.ncli and R.dataabert >= C.dataconc WHERE R.sit IN('Concluída por Tempo') and C.sit in ('Concluída') AND year(C.dataconc) = '$anoo' and month(C.dataconc) = '$mees' ";
$relconctemp01 = mysql_query($sql);	
$relconctemp02 = mysql_result($relconctemp01, 0);

if (!empty($relconctemp02)) {
$porcentagem_relconctemp = ($relconctemp02 / $religafazerOrig) * 100;
} else $porcentagem_relconctemp = 0;
$porcentagem_relconctemp = number_format($porcentagem_relconctemp, 2);

$sql = "SELECT count('qtd') FROM corte as C INNER JOIN religacao as R ON C.ncli = R.ncli and R.dataabert >= C.dataconc WHERE R.sit IN('Despachada') and C.sit in ('Concluída') AND year(C.dataconc) = '$anoo' and month(C.dataconc) = '$mees' ";
$reldespachada01 = mysql_query($sql);	
$reldespachada02 = mysql_result($reldespachada01, 0);

if (!empty($reldespachada02)) {
$porcentagem_reldespachada = ($reldespachada02 / $religafazerOrig) * 100;
} else $porcentagem_reldespachada = 0;
$porcentagem_reldespachada = number_format($porcentagem_reldespachada, 2);

$sql = "SELECT count('qtd') FROM corte as C INNER JOIN religacao as R ON C.ncli = R.ncli and R.dataabert >= C.dataconc WHERE R.sit IN('Em Execução') and C.sit in ('Concluída') AND year(C.dataconc) = '$anoo' and month(C.dataconc) = '$mees' ";
$relexec01 = mysql_query($sql);	
$relexec02 = mysql_result($relexec01, 0);

if (!empty($relexec02)) {
$porcentagem_relexec = ($relexec02 / $religafazerOrig) * 100;
} else $porcentagem_relexec = 0;
$porcentagem_relexec = number_format($porcentagem_relexec, 2);

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and SIT IN ('Concluída', 'Concluída com Impedimento')";
$resultado = mysql_query($sql);
$resultado01 = mysql_result($resultado, 0);

if (is_null($resultado01)){
	$contador[dj][total] = 0;
} else { $contador[dj][total] = mysql_result($resultado, 0);}

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and SIT IN ('Concluída', 'Concluída com Impedimento')";
$resultado = mysql_query($sql);
$resultado01 = mysql_result($resultado, 0);

if (is_null($resultado01)){
	$contador[cv][total] = 0;
} else {$contador[cv][total] = mysql_result($resultado, 0);}

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and SIT IN ('Concluída', 'Concluída com Impedimento')";
$resultado = mysql_query($sql);
$resultado01 = mysql_result($resultado, 0);

if(is_null($resultado01)){
	$contador[at][total] = 0;
} else { $contador[at][total] = mysql_result($resultado, 0);}




$i=1;
while ($i <=$ihh) {



$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and `sit` in ('Concluída com Impedimento') and `orgexecutor` in ('GROS', 'PSTEL') and `orggerador` in ('SFG', 'GRCO', 'GRSE')";
$resultado = mysql_query($sql);
$dj[concluida_c_imp_total][$i] = mysql_result($resultado, 0);	

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and `sit` in ('Concluída com Impedimento') and `orgexecutor` IN ('GROS', 'PSTEL') and `orggerador` in ('SFG', 'GRCO', 'GRSE')";
$resultado = mysql_query($sql);
$cv[concluida_c_imp_total][$i] = mysql_result($resultado, 0);	


$sql = "SELECT count(*) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and `sit` in ('Concluída com Impedimento') and `orgexecutor` IN ('GROS', 'PSTEL') and `orggerador` in ('SFG', 'GRCO', 'GRSE')";
$resultado = mysql_query($sql);
$at[concluida_c_imp_total][$i] = mysql_result($resultado, 0);	

//Levantamento dos cortes concluídos com impedimento em que o cliente apresentou conta paga

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and TIPOSERV in  ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO', 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR', 'DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and `sit` in ('Concluída com Impedimento') and cod_imp = '8410' and `orgexecutor` in ('GROS', 'PSTEL') and `orggerador` in ('SFG', 'GRCO')";
$resultadocp = mysql_query($sql);
$conta_paga[total][$i] = mysql_result($resultadocp, 0);	
if (empty($conta_paga[total][$i])){
	$conta_paga[total][$i] = 0;
}

//Somatório diário de cortes concluídos com impedimento 
$dj_cv_at[concluida_c_imp_total][$i] = $dj[concluida_c_imp_total][$i] + $cv[concluida_c_imp_total][$i] + $at[concluida_c_imp_total][$i] - $conta_paga[total][$i];

//Levantamento diário dos cortes concluídos sem impedimento

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and `sit` in ('Concluída') and `orgexecutor` in ('GROS', 'PSTEL') and `orggerador` in ('SFG', 'GRCO', 'GRSE')";
$resultado = mysql_query($sql);
$dj[concluida][$i] = mysql_result($resultado, 0);	

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and `sit` in ('Concluída') and `orgexecutor` in ('GROS', 'PSTEL') and `orggerador` in ('SFG', 'GRCO', 'GRSE')";
$resultado = mysql_query($sql);
$cv[concluida][$i] = mysql_result($resultado, 0);	


$sql = "SELECT count(*) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and `sit` in ('Concluída') and `orgexecutor` in ('GROS', 'PSTEL') and `orggerador` in ('SFG', 'GRCO', 'GRSE')";
$resultado = mysql_query($sql);
$at[concluida][$i] = mysql_result($resultado, 0);	

//Somatório diário de cortes concluídos s impedimento 

$dj_cv_at[concluida][$i] = $dj[concluida][$i] + $cv[concluida][$i] + $at[concluida][$i];

//Somatório diário dos cortes concluídos com impedimento e sem impedimento 

$dj_cv_at[concluida_total][$i] = $dj_cv_at[concluida][$i] + $conta_paga[total][$i] + $dj_cv_at[concluida_c_imp_total][$i];

// calculando percentual de impedimentos por total de cortes concluídos

if ($dj_cv_at[concluida_c_imp_total][$i] == 0){
$dj_cv_at[percentual][$i] =	0;
} else {$dj_cv_at[percentual][$i] =($dj_cv_at[concluida_c_imp_total][$i] / $dj_cv_at[concluida_total][$i]) * 100;}


$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and `sit` in ('Concluída', 'Concluída com Impedimento')";
$resultado = mysql_query($sql);
$dj[concluida_total][$i] = mysql_result($resultado, 0);	

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and `sit` in ('Concluída', 'Concluída com Impedimento')";
$resultado = mysql_query($sql);
$cv[concluida_total][$i] = mysql_result($resultado, 0);	


$sql = "SELECT count(*) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and `sit` in ('Concluída', 'Concluída com Impedimento')";
$resultado = mysql_query($sql);
$at[concluida_total][$i] = mysql_result($resultado, 0);	

	$i++;
}

/* Buscando resultados semanais de valores de cortes concluídos sem impedimento referentes ao mês atual */

$sql = "SELECT sum(qtd) as quantidade from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) BETWEEN 1 and 8 and `sit` = 'Concluída'";
$resultado = mysql_query($sql);
	$semana_mes_atual1 = mysql_result($resultado, 0); 
	$semana_mes_atual[1] = number_format($semana_mes_atual1, 0, ',','.');	

$sql = "SELECT sum(qtd) as quantidade from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) BETWEEN 9 and 16 and `sit` = 'Concluída'";
$resultado = mysql_query($sql);
	$semana_mes_atual2 = mysql_result($resultado, 0); 
	$semana_mes_atual[2] = number_format($semana_mes_atual2, 0, ',','.');

$sql = "SELECT sum(qtd) as quantidade from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) BETWEEN 17 and 24 and `sit` = 'Concluída'";
$resultado = mysql_query($sql);
	$semana_mes_atual3 = mysql_result($resultado, 0); 
	$semana_mes_atual[3] = number_format($semana_mes_atual3, 0, ',','.');


$sql = "SELECT sum(qtd) as quantidade from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) BETWEEN 25 and 31 and `sit` = 'Concluída'";
$resultado = mysql_query($sql);
	$semana_mes_atual4 = mysql_result($resultado, 0); 
	$semana_mes_atual[4] = number_format($semana_mes_atual4, 0, ',','.');

/** Calculando as porcentagens relativas as semanas do mês atual **/

$qtd_semana_atual_1 = $semana_mes_atual1 + $semana_mes_atual2 + $semana_mes_atual3 + $semana_mes_atual4;
$qtd_semana_atual = number_format($qtd_semana_atual_1, 0, ',','.');

$porcentagem_semana1_1 = ($semana_mes_atual1 / $qtd_semana_atual_1) * 100; 
$porcentagem_semana1 = number_format($porcentagem_semana1_1, 2);

$porcentagem_semana2_1 = ($semana_mes_atual2 / $qtd_semana_atual_1) * 100; 
$porcentagem_semana2 = number_format($porcentagem_semana2_1, 2);

$porcentagem_semana3_1 = ($semana_mes_atual3 / $qtd_semana_atual_1) * 100; 
$porcentagem_semana3 = number_format($porcentagem_semana3_1, 2);

$porcentagem_semana4_1 = ($semana_mes_atual4 / $qtd_semana_atual_1) * 100; 
$porcentagem_semana4 = number_format($porcentagem_semana4_1, 2);

$porcentagem_total_atual_1 = $porcentagem_semana1 + $porcentagem_semana2 + $porcentagem_semana3 + $porcentagem_semana4;
$porcentagem_total_atual = number_format($porcentagem_total_atual_1, 0, ',','.');


/* Buscando resultados semanais de valores de cortes concluídos sem impedimento referentes ao mês anterior */


$sql = "SELECT DISTINCT month(dataconc) AS mes, year(dataconc) AS ano FROM `corte` WHERE month(dataconc) < $mees AND year(dataconc) = $anoo OR month(dataconc) > $mees AND year(dataconc) < $anoo  GROUP BY dataconc ORDER BY dataconc DESC LIMIT 1";
    	$resultado = mysql_query($sql);
    	while ($registro = mysql_fetch_array($resultado)){
    	$mes_cort[] = $registro['mes'];
    	$ano_cort[] = $registro['ano'];
    	}
    	
      $mes_cort_pen = $mes_cort[0];
      $ano_cort_pen = $ano_cort[0];

$ijj = date('t', mktime(0, 0, 0, $mes_cort_pen, '01', $ano_cort_pen)); 

if (!empty($mes_cort_pen)){

$sql = "SELECT sum(qtd) as quantidade from corte where year(dataconc) = $ano_cort_pen and month(dataconc) = $mes_cort_pen and day(dataconc) BETWEEN 1 and 8 and `sit` = 'Concluída'";
$resultado = mysql_query($sql);
	$semana_mes_pen1 = mysql_result($resultado, 0); 
	$semana_mes_pen[1] = number_format($semana_mes_pen1, 0, ',','.');	

$sql = "SELECT sum(qtd) as quantidade from corte where year(dataconc) = $ano_cort_pen and month(dataconc) = $mes_cort_pen and day(dataconc) BETWEEN 9 and 16 and `sit` = 'Concluída'";
$resultado = mysql_query($sql);
	$semana_mes_pen2 = mysql_result($resultado, 0); 
	$semana_mes_pen[2] = number_format($semana_mes_pen2, 0, ',','.');

$sql = "SELECT sum(qtd) as quantidade from corte where year(dataconc) = $ano_cort_pen and month(dataconc) = $mes_cort_pen and day(dataconc) BETWEEN 17 and 24 and `sit` = 'Concluída'";
$resultado = mysql_query($sql);
	$semana_mes_pen3 = mysql_result($resultado, 0); 
	$semana_mes_pen[3] = number_format($semana_mes_pen3, 0, ',','.');


$sql = "SELECT sum(qtd) as quantidade from corte where year(dataconc) = $ano_cort_pen and month(dataconc) = $mes_cort_pen and day(dataconc) BETWEEN 25 and 31 and `sit` = 'Concluída'";
$resultado = mysql_query($sql);
	$semana_mes_pen4 = mysql_result($resultado, 0); 
	$semana_mes_pen[4] = number_format($semana_mes_pen4, 0, ',','.');


/** Calculando as porcentagens relativas as semanas do mês anterior**/

$qtd_semanas_mes_anterior_1 = $semana_mes_pen1 + $semana_mes_pen2 + $semana_mes_pen3 + $semana_mes_pen4;
$qtd_semanas_mes_anterior = number_format($qtd_semanas_mes_anterior_1, 0, ',','.');

$porcentagem_pen_semana1_1 = ($semana_mes_pen1 / $qtd_semanas_mes_anterior_1) * 100; 
$porcentagem_pen_semana1 = number_format($porcentagem_pen_semana1_1, 2);

$porcentagem_pen_semana2_1 = ($semana_mes_pen2 / $qtd_semanas_mes_anterior_1) * 100; 
$porcentagem_pen_semana2 = number_format($porcentagem_pen_semana2_1, 2);

$porcentagem_pen_semana3_1 = ($semana_mes_pen3 / $qtd_semanas_mes_anterior_1) * 100; 
$porcentagem_pen_semana3 = number_format($porcentagem_pen_semana3_1, 2);

$porcentagem_pen_semana4_1 = ($semana_mes_pen4 / $qtd_semanas_mes_anterior_1) * 100; 
$porcentagem_pen_semana4 = number_format($porcentagem_pen_semana4_1, 2);

$porcentagem_total_pen_1 = $porcentagem_pen_semana1 + $porcentagem_pen_semana2 + $porcentagem_pen_semana3 + $porcentagem_pen_semana4;
$porcentagem_total_pen = number_format($porcentagem_total_pen_1, 0, ',','.');


/*Calculando a diferença percentual entre o mês atual e o anterior */

$diff_percent1_1 = (($semana_mes_atual1 - $semana_mes_pen1) / $semana_mes_pen1) * 100;
$diff_percent1 = number_format($diff_percent1_1, 2, '.','');

$diff_percent2_1 = (($semana_mes_atual2 - $semana_mes_pen2) / $semana_mes_pen2) * 100;
$diff_percent2 = number_format($diff_percent2_1, 2);

$diff_percent3_1 = (($semana_mes_atual3 - $semana_mes_pen3) / $semana_mes_pen3) * 100;
$diff_percent3 = number_format($diff_percent3_1, 2);

$diff_percent4_1 = (($semana_mes_atual4 - $semana_mes_pen4) / $semana_mes_pen4) * 100;
$diff_percent4 = number_format($diff_percent4_1, 2);

$diff_percent_total_1 = (($qtd_semana_atual_1 - $qtd_semanas_mes_anterior_1) / $qtd_semanas_mes_anterior_1) * 100;
$diff_percent_total = number_format($diff_percent_total_1, 2);

}




}



if ($_POST['relatorio']=="relat_uc_s_med") {



$sql = "SELECT DISTINCT month(data_insercao) AS mes, year(data_insercao) AS ano FROM `uc_sem_med_oficial` WHERE month(data_insercao) <= $mees AND year(data_insercao) = $anoo OR month(data_insercao) > $mees AND year(data_insercao) < $anoo  GROUP BY data_insercao ORDER BY data_insercao DESC LIMIT 3";
    	$resultado = mysql_query($sql);
    	while ($registro = mysql_fetch_array($resultado)){
    	$mes_uc[] = $registro['mes'];
    	$ano_uc[] = $registro['ano'];
    	}

      $mes_uc_ult = $mes_uc[0];
      $ano_uc_ult = $ano_uc[0];      
      $mes_uc_pen = $mes_uc[1];
      $ano_uc_pen = $ano_uc[1];
      $mes_uc_ant = $mes_uc[2];
      $ano_uc_ant = $ano_uc[2];



if(isset($mes_uc_ult)){

$sql = "SELECT sum(qtd) as quantidade, classe FROM `uc_sem_med_oficial` WHERE year(data_insercao) = $ano_uc_ult AND month(data_insercao) = $mes_uc_ult GROUP BY classe ORDER BY quantidade desc";
	$resultado = mysql_query($sql);
	while ($registro = mysql_fetch_array($resultado)){
		$nome_classe_1 = $registro['classe'];
		$qtd_classe = $registro['quantidade'];
		$nome_classe = trim($nome_classe_1);
		switch ($nome_classe) {
			case 'RESIDENCIAL':
			$classe[RESIDENCIAL][0] = $qtd_classe;
				break;
			case 'COMERCIAL':
			$classe[COMERCIAL][0] = $qtd_classe;
				break;
			case 'RURAL':
			$classe[RURAL][0] = $qtd_classe;
				break;
			case 'P. PUBLICO':
			$classe[PPUBLICO][0] = $qtd_classe;
				break;
			case 'C. PROPRIO':
			$classe[CPROPRIO][0] = $qtd_classe;
				break;
			case 'S. PUBLICO':
			$classe[SPUBLICO][0] = $qtd_classe;
				break;
			case 'INDUSTRIAL':
			$classe[INDUSTRIAL][0] = $qtd_classe;
				break;
			case 'CONCESSIO.':
			$classe[CONCESSIO][0] = $qtd_classe;
				break;			
		}	
}


$sql = "SELECT situacao, sum(qtd) as quantidade FROM `uc_sem_med_oficial` WHERE year(data_insercao) = $ano_uc_ult AND month(data_insercao) = $mes_uc_ult GROUP BY situacao ORDER BY quantidade desc";
        	$result_sit_uc = mysql_query($sql);
        	while ($registro = mysql_fetch_array($result_sit_uc)){
        		$nome_situacao_1 = $registro['situacao'];
        		$qtd_situacao = $registro['quantidade'];
        		$nome_situacao = trim($nome_situacao_1);
        		switch ($nome_situacao) {
        			case 'LIGADA':
        			$situacao[LIGADA][0] = $qtd_situacao;
        				break;
        			case 'SUSPENSA':
        			$situacao[SUSPENSA][0] = $qtd_situacao;
        				break;        			
        		}       		
}


$sql = "SELECT tipo_ligacao, sum(qtd) as quantidade FROM `uc_sem_med_oficial` WHERE year(data_insercao) = $ano_uc_ult AND month(data_insercao) = $mes_uc_ult GROUP BY tipo_ligacao ORDER BY quantidade desc";
        	$resultado = mysql_query($sql);
        	while ($registro = mysql_fetch_array($resultado)){
        	$tipo_ligacao_1 = $registro['tipo_ligacao'];
        	$qtd_tipo_ligacao = $registro['quantidade'];
        		switch ($tipo_ligacao_1) {
        			case '1':
        			$tipo_ligacao[MONOFASICO][0] = $qtd_tipo_ligacao;
        				break;
        			case '2':
        			$tipo_ligacao[BIFASICO][0] = $qtd_tipo_ligacao;
        				break;   
        			case '3':
        			$tipo_ligacao[TRIFASICO][0] = $qtd_tipo_ligacao;
        				break;       			
        		}       		
}

}

if (isset($mes_uc_pen)) {

/* Consulta ao banco de dados para se buscar e armazenar em variáveis os 3 últimos meses de ocorrência de uc sem medição discriminado por classe*/

$sql = "SELECT sum(qtd) as quantidade, classe FROM `uc_sem_med_oficial` WHERE year(data_insercao) = $ano_uc_pen AND month(data_insercao) = $mes_uc_pen GROUP BY classe ORDER BY quantidade desc";
	$resultado = mysql_query($sql);
	while ($registro = mysql_fetch_array($resultado)){
		$nome_classe_1 = $registro['classe'];
		$qtd_classe = $registro['quantidade'];
		$nome_classe = trim($nome_classe_1);
		switch ($nome_classe) {
			case 'RESIDENCIAL':
			$classe[RESIDENCIAL][1] = $qtd_classe;
				break;
			case 'COMERCIAL':
			$classe[COMERCIAL][1] = $qtd_classe;
				break;
			case 'RURAL':
			$classe[RURAL][1] = $qtd_classe;
				break;
			case 'P. PUBLICO':
			$classe[PPUBLICO][1] = $qtd_classe;
				break;
			case 'C. PROPRIO':
			$classe[CPROPRIO][1] = $qtd_classe;
				break;
			case 'S. PUBLICO':
			$classe[SPUBLICO][1] = $qtd_classe;
				break;
			case 'INDUSTRIAL':
			$classe[INDUSTRIAL][1] = $qtd_classe;
				break;
			case 'CONCESSIO.':
			$classe[CONCESSIO][1] = $qtd_classe;
				break;			
		}	
}


$sql = "SELECT situacao, sum(qtd) as quantidade FROM `uc_sem_med_oficial` WHERE year(data_insercao) = $ano_uc_pen AND month(data_insercao) = $mes_uc_pen GROUP BY situacao ORDER BY quantidade desc";
        	$result_sit_uc = mysql_query($sql);
        	while ($registro = mysql_fetch_array($result_sit_uc)){
        		$nome_situacao_1 = $registro['situacao'];
        		$qtd_situacao = $registro['quantidade'];
        		$nome_situacao = trim($nome_situacao_1);
        		switch ($nome_situacao) {
        			case 'LIGADA':
        			$situacao[LIGADA][1] = $qtd_situacao;
        				break;
        			case 'SUSPENSA':
        			$situacao[SUSPENSA][1] = $qtd_situacao;
        				break;        			
        		}       		
}


$sql = "SELECT tipo_ligacao, sum(qtd) as quantidade FROM `uc_sem_med_oficial` WHERE year(data_insercao) = $ano_uc_pen AND month(data_insercao) = $mes_uc_pen GROUP BY tipo_ligacao ORDER BY quantidade desc";
        	$resultado = mysql_query($sql);
        	while ($registro = mysql_fetch_array($resultado)){
        		$tipo_ligacao_1 = $registro['tipo_ligacao'];
        		$qtd_tipo_ligacao = $registro['quantidade'];
        		switch ($tipo_ligacao_1) {
        			case '1':
        			$tipo_ligacao[MONOFASICO][1] = $qtd_tipo_ligacao;
        				break;
        			case '2':
        			$tipo_ligacao[BIFASICO][1] = $qtd_tipo_ligacao;
        				break;   
        			case '3':
        			$tipo_ligacao[TRIFASICO][1] = $qtd_tipo_ligacao;
        				break;       			
        		}       		
}

}

if (isset($mes_uc_ant)) {

$sql = "SELECT sum(qtd) as quantidade, classe FROM `uc_sem_med_oficial` WHERE year(data_insercao) = $ano_uc_ant AND month(data_insercao) = $mes_uc_ant GROUP BY classe ORDER BY quantidade desc";
	$resultado = mysql_query($sql);
	while ($registro = mysql_fetch_array($resultado)){
		$nome_classe_1 = $registro['classe'];
		$qtd_classe = $registro['quantidade'];
		$nome_classe = trim($nome_classe_1);
		switch ($nome_classe) {
			case 'RESIDENCIAL':
			$classe[RESIDENCIAL][2] = $qtd_classe;
				break;
			case 'COMERCIAL':
			$classe[COMERCIAL][2] = $qtd_classe;
				break;
			case 'RURAL':
			$classe[RURAL][2] = $qtd_classe;
				break;
			case 'P. PUBLICO':
			$classe[PPUBLICO][2] = $qtd_classe;
				break;
			case 'C. PROPRIO':
			$classe[CPROPRIO][2] = $qtd_classe;
				break;
			case 'S. PUBLICO':
			$classe[SPUBLICO][2] = $qtd_classe;
				break;
			case 'INDUSTRIAL':
			$classe[INDUSTRIAL][2] = $qtd_classe;
				break;
			case 'CONCESSIO.':
			$classe[CONCESSIO][2] = $qtd_classe;
				break;			
		}	
}


$sql = "SELECT situacao, sum(qtd) as quantidade FROM `uc_sem_med_oficial` WHERE year(data_insercao) = $ano_uc_ant AND month(data_insercao) = $mes_uc_ant GROUP BY situacao ORDER BY quantidade desc";
        	$result_sit_uc = mysql_query($sql);
        	while ($registro = mysql_fetch_array($result_sit_uc)){
        		$nome_situacao_1 = $registro['situacao'];
        		$qtd_situacao = $registro['quantidade'];
        		$nome_situacao = trim($nome_situacao_1);
        		switch ($nome_situacao) {
        			case 'LIGADA':
        			$situacao[LIGADA][2] = $qtd_situacao;
        				break;
        			case 'SUSPENSA':
        			$situacao[SUSPENSA][2] = $qtd_situacao;
        				break;        			
        		}       		
}


$sql = "SELECT tipo_ligacao, sum(qtd) as quantidade FROM `uc_sem_med_oficial` WHERE year(data_insercao) = $ano_uc_ant AND month(data_insercao) = $mes_uc_ant GROUP BY tipo_ligacao ORDER BY quantidade desc";
        	$resultado = mysql_query($sql);
        	while ($registro = mysql_fetch_array($resultado)){
        		$tipo_ligacao_1 = $registro['tipo_ligacao'];
                $qtd_tipo_ligacao = $registro['quantidade'];
        		switch ($tipo_ligacao_1) {
        			case '1':
        			$tipo_ligacao[MONOFASICO][2] = $qtd_tipo_ligacao;
        				break;
        			case '2':
        			$tipo_ligacao[BIFASICO][2] = $qtd_tipo_ligacao;
        				break;   
        			case '3':
        			$tipo_ligacao[TRIFASICO][2] = $qtd_tipo_ligacao;
        				break;       			
        		}       		
}

}
/*Consulta ao banco de dados para se obter valores referentes a cada situação das uc sem medidores do ultimo mes */




}

$soma_tot = $contador[dj][total]+$contador[cv][total]+$contador[at][total];

?>  	

   function drawChart() {

    var data = google.visualization.arrayToDataTable([
	   <?php if ($_POST["relatorio"]=="m_abertura") echo "['Dia', 'Geracao DJ', 'Geracao CV', 'Geracao AT'],"; 

	   if ($_POST["relatorio"]=="m_deslig") echo "['Dia', 'Corte DJ', 'Corte CV', 'Corte AT'],"; 

/*
	   if ($_POST["relatorio"]=="relat_uc_s_med") { echo "['Data de Referência', 'BRASÍLIA-DF', 'TAGUATINGA-DF', 'CRUZEIRO-DF', 'GUARA-DF', 'SOBRADINHO-DF', 'CEILÂNDIA-DF', 'SAMAMBAIA-DF', 'PARANOÁ-DF', 'GAMA-DF', 'SÃO SEBASTIÃO-DF', 'PLANALTINA-DF', 'LAGO NORTE-DF', 'SANTA MARIA-DF', 'RIACHO FUNDO-DF', 'LAGO SUL-DF', 'RECANDO DAS EMAS-DF', 'BRAZLANDIA-DF', 'NUCLEO BANDEIRANTE-DF', 'CANDANGOLANDIA-NB-DF'],";

        echo " ['$mees/$anoo', $regiao01, $regiao02, $regiao03, $regiao04, $regiao05, $regiao06, $regiao07, $regiao08, $regiao09, $regiao10, $regiao11, $regiao12, $regiao13, $regiao14, $regiao15, $regiao16, $regiao17, $regiao18, $regiao19]";
        	}
*/

$i=1;
/*** 
Totaliza as OSES concluídas por meio do while 
contando dia, após dia em relação ao mês selecionado
disponível na variável $ihh
***/
		  
 
/***
declara as variaveis e as setam iguais a 1 para a ixab (já que não existe dia 0)
a variável em questão serve de comparação para a quantidade de dias do mês 
selecionado na variável $ihh, já as demais variáveis são setadas como zero
para ser utilizado na contagem no quantitativo de ordem de serviço
***/

	$ixb=1;
	
/***
viariáveis que servem para contagem dos valores do quantitativo
de ordens de serviço
***/
	
	$calcular_total = 0;
	$dj_concluidas_s_imp = 0;
	$cv_concluidas_s_imp = 0;
	$at_concluidas_s_imp = 0;
		
/*** 
inicia o while para contar cada dia até o último dia do mês selecionado pela variável $ihh 
***/
				  
				  
		  while($i <= $ihh){
			 
if ($_POST["relatorio"]=="m_abertura"){
			  $dj_concluidas = $dj[gerada][$i];
			  $cv_concluidas = $cv[gerada][$i];
			  $at_concluidas = $at[gerada][$i];
			  if($i==$ihh) {
				  echo "['$i', $dj_concluidas, $cv_concluidas, $at_concluidas]";
			  } else echo "['$i', $dj_concluidas, $cv_concluidas, $at_concluidas],";
			  
} if ($_POST["relatorio"]=="m_deslig") {	

	
			  $dj_concluidas = $dj[concluida_total][$i];
			  $cv_concluidas = $cv[concluida_total][$i];
			  $at_concluidas = $at[concluida_total][$i];

	
			  if($i==$ihh) {
				  echo "['$i', $dj_concluidas, $cv_concluidas, $at_concluidas]";
			  } else echo "['$i', $dj_concluidas, $cv_concluidas, $at_concluidas],";
			 
		  }

		  
/**** teste ****/
/***
contagem do corte no disjuntor
***/	

/*$dj_concluidas_s_imp_v = $dj[concluida][$ixb];
$dj_concluidas_s_imp = $dj_concluidas_s_imp + $dj_concluidas_s_imp_v;
	*/
/*** 
contagem do corte convencional 
***/
/*

$cv_concluidas_s_imp_v = $cv[concluida][$ixb];
$cv_concluidas_s_imp = $cv_concluidas_s_imp + $cv_concluidas_s_imp_v;
	
	*/
/***
contagem do corte AT
***/
	/*
$at_concluidas_s_imp_v = $at[concluida][$ixb];
$at_concluidas_s_imp = $at_concluidas_s_imp + $at_concluidas_s_imp_v;
	*/
	/* adiciona +1 na variável */
	$ixb++;

		  
		  
		  
		  $i++;
		  }

       ?>
         
        ]);

        var options = {
				<?php if ($_POST["relatorio"]=="m_abertura") echo "title: 'Relatorio de Geracao de Cortes',"; if ($_POST["relatorio"]=="m_deslig") echo "title: 'Relatorio de Cortes Concluidos - CEB',"; /*if ($_POST["relatorio"]=="relat_uc_s_med") echo "title: 'Relatório de UC sem Medidor - CEB',"; */
            
          echo "subtitle: 'Mes de Referencia $mees/$anoo',"; ?>
			is3D: true,
		  backgroundColor: 'transparent',
          
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
	
 function drawChart0() {

        var data = google.visualization.arrayToDataTable([
       <?php  echo "['Regiões', 'Qtd'],";
       /*Realiza consultas ao banco de dados para armazenar quantas regiões distintas existem no banco de dados ocorrências de uc sem medição por região */

   $sql = "SELECT count(DISTINCT regiao) as count_regiao FROM `uc_sem_med_oficial` WHERE year(data_insercao) = $anoo AND month(data_insercao) = $mees";
   $resultado = mysql_query($sql);
   $count_regiao = mysql_result($resultado, 0); 

/*Realiza consultas ao banco de dados para armazenar dados relativos ao nome e quantidade de ucs sem medição por região */

  $sql = "SELECT regiao, sum(qtd) as quantidade FROM `uc_sem_med_oficial` WHERE year(data_insercao) = $anoo AND month(data_insercao) = $mees GROUP BY regiao ORDER BY quantidade asc";
       $resultado_regiao = mysql_query($sql);
		$i_regiao = 1;
       while ($registro = mysql_fetch_array($resultado_regiao)){
       	$regiao = $registro['regiao'];
       	$qtd_regiao = $registro['quantidade'];       	
       	if ($i_regiao < $count_regiao){       
        echo " ['$regiao', $qtd_regiao],";}
    	else { echo " ['$regiao', $qtd_regiao]";
    	}
        $i_regiao++;
    }
         ?>
        ]);

        var options = {
        	legend: { position: 'none' },
            <?php echo "title: 'Relatório de UC sem Medidor Por Região - CEB',";
          echo "subtitle: 'Mes de Referencia $mees/$anoo',"; ?>
            is3D: true,
		  backgroundColor: 'transparent',		 
		  vAxis: {format: '#,###'},		  
          bars: 'horizontal' // Required for Material Bar Charts.
     
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }


      function drawChart1() {
        var data = google.visualization.arrayToDataTable([
         <?php 
         	if (isset($mes_uc_ult) && empty($mes_uc_pen)){ echo "['Classes', '$mes_uc_ult/$ano_uc_ult'],";
          echo  "['RESIDENCIAL', ".$classe[RESIDENCIAL][0]."], ['COMERCIAL', ".$classe[COMERCIAL][0]."], ['RURAL', ".$classe[RURAL][0]."], ['P. PUBLICO', ".$classe[PPUBLICO][0]."], ['C. PROPRIO', ".$classe[CPROPRIO][0]."], ['S. PUBLICO', ".$classe[SPUBLICO][0]."], ['INDUSTRIAL', ".$classe[INDUSTRIAL][0]."], ['CONCESSIO', ".$classe[CONCESSIO][0]."]";} 

         	if (isset($mes_uc_pen) && empty($mes_uc_ant)){ echo "['Classes', '$mes_uc_pen/$ano_uc_pen', '$mes_uc_ult/$ano_uc_ult'],";
          echo  "['RESIDENCIAL', ".$classe[RESIDENCIAL][1].", ".$classe[RESIDENCIAL][0]."], ['COMERCIAL', ".$classe[COMERCIAL][1].", ".$classe[COMERCIAL][0]."], ['RURAL', ".$classe[RURAL][1].", ".$classe[RURAL][0]."], ['P. PUBLICO', ".$classe[PPUBLICO][1].", ".$classe[PPUBLICO][0]."], ['C. PROPRIO', ".$classe[CPROPRIO][1].", ".$classe[CPROPRIO][0]."], ['S. PUBLICO', ".$classe[SPUBLICO][1].", ".$classe[SPUBLICO][0]."], ['INDUSTRIAL', ".$classe[INDUSTRIAL][1].", ".$classe[INDUSTRIAL][0]."], ['CONCESSIO', ".$classe[CONCESSIO][1].", ".$classe[CONCESSIO][0]."]";}
          
          if (isset($mes_uc_ant)) {echo "['Classes', '$mes_uc_ant/$ano_uc_ant', '$mes_uc_pen/$ano_uc_pen', '$mes_uc_ult/$ano_uc_ult'],";          
          echo  "['RESIDENCIAL', ".$classe[RESIDENCIAL][2].", ".$classe[RESIDENCIAL][1].", ".$classe[RESIDENCIAL][0]."], ['COMERCIAL', ".$classe[COMERCIAL][2].", ".$classe[COMERCIAL][1].", ".$classe[COMERCIAL][0]."], ['RURAL', ".$classe[RURAL][2].", ".$classe[RURAL][1].", ".$classe[RURAL][0]."], ['P. PUBLICO', ".$classe[PPUBLICO][2].", ".$classe[PPUBLICO][1].", ".$classe[PPUBLICO][0]."], ['C. PROPRIO', ".$classe[CPROPRIO][2].", ".$classe[CPROPRIO][1].", ".$classe[CPROPRIO][0]."], ['S. PUBLICO', ".$classe[SPUBLICO][2].", ".$classe[SPUBLICO][1].", ".$classe[SPUBLICO][0]."], ['INDUSTRIAL', ".$classe[INDUSTRIAL][2].", ".$classe[INDUSTRIAL][1].", ".$classe[INDUSTRIAL][0]."], ['CONCESSIO', ".$classe[CONCESSIO][2].", ".$classe[CONCESSIO][1].", ".$classe[CONCESSIO][0]."]";}
	
          ?>          
        ]);

        var options = {
        		legend: { textStyle: {fontSize: 12}},
				<?php echo "title: 'Relatório de UC sem Medidor Por Classes - CEB',"; 
            if (isset($mes_uc_ant)){
          echo "subtitle: 'Referente aos meses $mes_uc_ant/$mes_uc_pen/$mes_uc_ult',"; 
      }		
      		if (isset($mes_uc_pen) && empty($mes_uc_ant)){
          echo "subtitle: 'Referente aos meses $mes_uc_pen/$mes_uc_ult',"; 
      }
      		if (empty($mes_uc_pen)){
      			 echo "subtitle: 'Referente ao mês $mes_uc_ult',";
      			}
      		?>
			is3D: true,
		  backgroundColor: 'transparent',
          colors: ['#452800', '#C8050B', '#FE2E9A'],        
          vAxis: {format: '#,###', title: 'Quantidade'}
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material_2'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }

        function drawChart3() {
        var data = google.visualization.arrayToDataTable([
         <?php 
         	if (isset($mes_uc_ult) && empty($mes_uc_pen)){ echo "['Situação', '$mes_uc_ult/$ano_uc_ult'],";
          echo  "['LIGADA', ".$situacao[LIGADA][0]."], ['SUSPENSA', ".$situacao[SUSPENSA][0]."]";}

         	if (isset($mes_uc_pen) && empty($mes_uc_ant)){ echo "['Situação', '$mes_uc_pen/$ano_uc_pen', '$mes_uc_ult/$ano_uc_ult'],";
          echo  "['LIGADA', ".$situacao[LIGADA][1].", ".$situacao[LIGADA][0]."], ['SUSPENSA', ".$situacao[SUSPENSA][1].", ".$situacao[SUSPENSA][0]."]";}

          if (isset($mes_uc_ant)) {echo "['Situação', '$mes_uc_ant/$ano_uc_ant', '$mes_uc_pen/$ano_uc_pen', '$mes_uc_ult/$ano_uc_ult'],";          
          echo  "['LIGADA', ".$situacao[LIGADA][2].", ".$situacao[LIGADA][1].", ".$situacao[LIGADA][0]."], ['SUSPENSA', ".$situacao[SUSPENSA][2].", ".$situacao[SUSPENSA][1].", ".$situacao[SUSPENSA][0]."]";}

          ?>          
        ]);

        var options = {
       			 legend: { textStyle: {fontSize: 10}},
				<?php echo "title: 'Relatório de UC sem Medidor Por Situação - CEB',"; 
          if (isset($mes_uc_ant)){
          echo "subtitle: 'Referente aos meses $mes_uc_ant/$mes_uc_pen/$mes_uc_ult',"; 
      }		
      		if (isset($mes_uc_pen) && empty($mes_uc_ant)){
          echo "subtitle: 'Referente aos meses $mes_uc_pen/$mes_uc_ult',"; 
      }
      		if (empty($mes_uc_pen)){
      			 echo "subtitle: 'Referente aos mes $mes_uc_ult',";
      			}
      		?>
			is3D: true,
		  backgroundColor: 'transparent',
          colors: ['#02A9B5', '#FC9300', '#FACC2E'],
          vAxis: {format: '#,###', title: 'Quantidade'}
         
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material_3'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }



             function drawChart4() {
        var data = google.visualization.arrayToDataTable([
         <?php 
         	if (isset($mes_uc_ult) && empty($mes_uc_pen)){ echo "['Tipo de Fornecimento', '$mes_uc_ult/$ano_uc_ult'],";
          echo  "['MONOFÁSICO', ".$tipo_ligacao[MONOFASICO][0]."], ['BIFÁSICO', ".$tipo_ligacao[BIFASICO][0]."], ['TRIFÁSICO', ".$tipo_ligacao[TRIFASICO][0]."]";}

         	if (isset($mes_uc_pen) && empty($mes_uc_ant)){ echo "['Tipologia', '$mes_uc_pen/$ano_uc_pen', '$mes_uc_ult/$ano_uc_ult'],";
          echo  "['MONOFÁSICO', ".$tipo_ligacao[MONOFASICO][1].", ".$tipo_ligacao[MONOFASICO][0]."], ['BIFÁSICO', ".$tipo_ligacao[BIFASICO][1].", ".$tipo_ligacao[BIFASICO][0]."], ['TRIFÁSICO', ".$tipo_ligacao[TRIFASICO][1].", ".$tipo_ligacao[TRIFASICO][0]."]";}

          if (isset($mes_uc_ant)) {echo "['Tipologia', '$mes_uc_ant/$ano_uc_ant', '$mes_uc_pen/$ano_uc_pen', '$mes_uc_ult/$ano_uc_ult'],";          
          echo  "['MONOFÁSICO', ".$tipo_ligacao[MONOFASICO][2].", ".$tipo_ligacao[MONOFASICO][1].", ".$tipo_ligacao[MONOFASICO][0]."], ['BIFÁSICO', ".$tipo_ligacao[BIFASICO][2].", ".$tipo_ligacao[BIFASICO][1].", ".$tipo_ligacao[BIFASICO][0]."], ['TRIFÁSICO', ".$tipo_ligacao[TRIFASICO][2].", ".$tipo_ligacao[TRIFASICO][1].", ".$tipo_ligacao[TRIFASICO][0]."]";}

          ?>          
        ]);

        var options = {        	
        	legend: { textStyle: {fontSize: 10}},

				<?php echo "title: 'Relatório de UC sem Medidor Por Tipo de Fornecimento - CEB',"; 
          if (isset($mes_uc_ant)){
          echo "subtitle: 'Referente aos meses $mes_uc_ant/$mes_uc_pen/$mes_uc_ult',"; 
      }		
      		if (isset($mes_uc_pen) && empty($mes_uc_ant)){
          echo "subtitle: 'Referente aos meses $mes_uc_pen/$mes_uc_ult',"; 
      }
      		if (empty($mes_uc_pen)){
      			 echo "subtitle: 'Referente aos mes $mes_uc_ult',";
      			}
      		?>
			is3D: true,
		  backgroundColor: 'transparent', 
		  colors: ['#550276', '#07B527', '#FF00FF'],
		  vAxis: {format: '#,###', title: 'Quantidade'}	  
				  
        };


        var chart = new google.charts.Bar(document.getElementById('columnchart_material_4'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }


       function drawChart5() {
        var data = google.visualization.arrayToDataTable([
         <?php 
         	if (empty($mes_abert_pen)){ echo "['Tipo de Corte', '$mees/$anoo'],";
          echo  "['DISJUNTOR', ".$contador[dj][total]."], ['CONVENCIONAL', ".$contador[cv][total]."], ['ALTA TENSÃO', ".$contador[at][total]."]";}

         	if (isset($mes_abert_pen)){ echo "['Tipo de Corte', '$mes_abert_pen/$ano_abert_pen', '$mees/$anoo'],";
          echo  "['DISJUNTOR', ".$contador[dj][total_pen].", ".$contador[dj][total]."], ['CONVENCIONAL', ".$contador[cv][total_pen].", ".$contador[cv][total]."], ['ALTA TENSÃO', ".$contador[at][total_pen].", ".$contador[at][total]."]";}

          ?>          
        ]);

        var options = {
        	legend: { position: 'none' },
				<?php echo "title: 'Relatório Compartivo de Geração de Cortes - CEB',"; 

        if (isset($mes_abert_pen)){
          echo "subtitle: 'Referente aos meses $mes_abert_pen/$mees',"; 
      }
      		if (empty($mes_abert_pen)){
      			 echo "subtitle: 'Referente aos mes $mees',";
      			}
      		?>
			is3D: true,
		  backgroundColor: 'transparent', 
		  colors: ['#550276', '#07B527'],
		  vAxis: {format: '#,###', title: 'Quantidade'}	  
				  
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material_5'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }



      function drawChart2() {
	        //   var data = new google.visualization.DataTable();

       var data = google.visualization.arrayToDataTable([
		['Desligamentos', 'Qtde por mes'],
		<?php
if ($_POST["relatorio"]=="m_abertura") {
	 echo "['Geracao no DJ', ".$contador[dj][total]."],";
          echo "['Geracao CV', ".$contador[cv][total]."],";
		  echo "['Geracao AT', ".$contador[at][total]."]"; 
} if ($_POST["relatorio"]=="m_deslig") {
				  echo "['Corte no DJ', ".$contador[dj][total]."],";
          echo "['Corte CV', ".$contador[cv][total]."],";
		  echo "['Corte AT', ".$contador[at][total]."]";    
} if ($_POST["relatorio"]=="relat_uc_s_med") {	
			  echo "['RESIDENCIAL', ".$classe[RESIDENCIAL][0]."],"; 
			  echo "['COMERCIAL', ".$classe[COMERCIAL][0]."],"; 
			  echo "['RURAL', ".$classe[RURAL][0]."],"; 
			  echo "['P. PÚBLICO', ".$classe[PPUBLICO][0]."],"; 
			  echo "['C. PRÓPRIO', ".$classe[CPROPRIO][0]."],"; 
			  echo "['S. PUBLICO', ".$classe[SPUBLICO][0]."],"; 
			  echo "['INDUSTRIAL', ".$classe[INDUSTRIAL][0]."],"; 
			  echo "['CONCESSIO.', ".$classe[CONCESSIO][0]."]"; 

}

       ?>
 ]);
        var options = {
			<?php if ($_POST["relatorio"]=="m_abertura") echo "title: 'Qtde de OS Geradas',"; if ($_POST["relatorio"]=="m_deslig") echo "title: 'Qtde de cortes', ";
			if ($_POST["relatorio"]=="relat_uc_s_med") echo "title: 'Qtde de UC Sem Medição Por Classe Referente ao Mês $mees', "; 
			
         ?>
         pieResidueSliceLabel: 'OUTROS',
		  is3D: true,
		  backgroundColor: 'transparent',	
		  legend: {'position': 'bottom'}  
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
	


<?php if ($_POST["relatorio"] == "m_abertura") { ?>

function drawTable4() { 
        var data = new google.visualization.DataTable();
       	data.addColumn('string', 'Dias');
        data.addColumn('number', 'Quantidade');
        data.addColumn('number', 'Porcentagem');
        data.addRows([
       	<?php echo "['Dias 1 a 8', {v: $semana_mes_atual[1], f: '$semana_mes_atual[1]'}, {v: $porcentagem_semana1, f: '$porcentagem_semana1%'}],

          ['Dias 9 a 16',  {v: $semana_mes_atual[2], f: '$semana_mes_atual[2]'},  {v: $porcentagem_semana2, f: '$porcentagem_semana2%'}],

          ['Dias 17 a 24',  {v: $semana_mes_atual[3], f: '$semana_mes_atual[3]'}, {v: $porcentagem_semana3, f: '$porcentagem_semana3%'}],

          ['Dias 25 a 30/31',  {v: $semana_mes_atual[4], f: '$semana_mes_atual[4]'},  {v: $porcentagem_semana4, f: '$porcentagem_semana4%'}],

          ['<div style=\"font-weight:bold\">Total</div>',  {v: $qtd_semana_atual, f: '<div style=\"font-weight:bold\">$qtd_semana_atual</div>'}, {v: $porcentagem_total_atual, f: '<div style=\"font-weight:bold\">$porcentagem_total_atual%</div>'}]" ?>
        ]);

       
        var table = new google.visualization.Table(document.getElementById('table_div6'));

        
        table.draw(data, {showRowNumber: false, width: '300px', height: '100%', allowHtml: true});
	

		 var tablehead ='<tr class="google-visualization-table-tr-head"><th class="google-visualization-table-th gradient unsorted" colspan="1"></th><th class="google-visualization-table-th gradient unsorted" colspan="2"><?php echo"Mês $mees/$anoo"?></th></tr>';
          var stuff = jQuery('#table_div6').find('thead').prepend(tablehead);

      }

<?php if (isset($mes_abert_pen)) { ?>

function drawTable6() { 
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Dias');
        data.addColumn('number', 'Quantidade');
        data.addColumn('number', 'Porcentagem');
        data.addRows([
       	<?php echo "['Dias 1 a 8', {v: $semana_mes_pen[1], f: ' $semana_mes_pen[1] '}, {v: $porcentagem_pen_semana1, f: '$porcentagem_pen_semana1%'}],

          ['Dias 9 a 16', {v: $semana_mes_pen[2], f: '$semana_mes_pen[2]'}, {v: $porcentagem_pen_semana2, f: '$porcentagem_pen_semana2%'}],

          ['Dias 17 a 24',  {v: $semana_mes_pen[3], f: '$semana_mes_pen[3]'}, {v: $porcentagem_pen_semana3, f: '$porcentagem_pen_semana3%'}],

          ['Dias 25 a $ijj',  {v: $semana_mes_pen[4], f: '$semana_mes_pen[4]'}, {v: $porcentagem_pen_semana4, f: '$porcentagem_pen_semana4%'}],

          ['<div style=\"font-weight:bold\">Total</div>',  {v: $qtd_semanas_mes_anterior, f: '<div style=\"font-weight:bold\">$qtd_semanas_mes_anterior</div>'}, {v: $porcentagem_total_pen, f: '<div style=\"font-weight:bold\">$porcentagem_total_pen%</div>'}]" ?>
        ]);
  
        var table = new google.visualization.Table(document.getElementById('table_div7'));

        table.draw(data, {showRowNumber: false, width: '300px', height: '100%', allowHtml: true});
	
         var tablehead ='<tr class="google-visualization-table-tr-head"><th class="google-visualization-table-th gradient unsorted" colspan="1"></th><th class="google-visualization-table-th gradient unsorted" colspan="2"><?php echo"Mês $mes_abert_pen/$ano_abert_pen"?></th></tr>';
          var stuff = jQuery('#table_div7').find('thead').prepend(tablehead);
 	
      }

function drawTable7() { 
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Dias');
        data.addColumn('number', 'Diferença Percentual');
        data.addRows([
       	<?php echo "['Dias 1 a 8', {v: $diff_percent1, f: '<div style=\"font-weight:bold\">$diff_percent1%</div>'}],

          ['Dias 9 a 16', {v: $diff_percent2, f: '<div style=\"font-weight:bold\">$diff_percent2%</div>'}],

          ['Dias 17 a 24', {v: $diff_percent3, f: '<div style=\"font-weight:bold\">$diff_percent3%</div>'}],

          ['Dias 25 a 30/31', {v: $diff_percent4, f: '<div style=\"font-weight:bold\">$diff_percent4%</div>'}],

          ['<div style=\"font-weight:bold\">Total</div>', {v: $diff_percent_total, f: '<div style=\"font-weight:bold\">$diff_percent_total%</div>'}]" ?>
        ]);

          var table = new google.visualization.Table(document.getElementById('table_div8'));

        table.draw(data, {showRowNumber: false, width: '300px', height: '100%', allowHtml: true});


         var tablehead ='<tr class="google-visualization-table-tr-head"><th class="google-visualization-table-th gradient unsorted" colspan="1"></th><th class="google-visualization-table-th gradient unsorted" colspan="1"><?php echo"Mês $mees/$anoo x $mes_abert_pen/$ano_abert_pen"?></th></tr>';
          var stuff = jQuery('#table_div8').find('thead').prepend(tablehead);

      }

<?php } } ?>


//criação da função que define as configurações da tabela de acordo com o Google Table Charts

<?php 
if ($_POST["relatorio"] == "m_deslig") {
?>


      function drawTableRelig() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Tipo');
        data.addColumn('number', 'Qtd'); 
        data.addColumn('number', 'Porcentagem');     
        data.addRows([

        	<?php 
			 $religconc01 = number_format($resultado0102, 0, ',','.');	
        	 $religafazer = number_format($religafazerOrig, 0, ',','.');
        	 $qtd_conc02 = number_format($qtd_conc, 0, ',','.');		
        	 $relgerada03 = number_format($relgerada02, 0, ',','.');	
        	 $relcancelada03 = number_format($relcancelada02, 0, ',','.');	
        	 $relagdespacho03 = number_format($relagdespacho02, 0, ',','.');	


			echo "['Religações Concluídas',   {v:$religconc01,   f: '$religconc01'}, {v:$porcentagem_corte_relig,   f: '$porcentagem_corte_relig%'}],				
			['Religações Pendentes',   {v:$religafazer,   f: '$religafazer'}, {v:$porcentagem_corte_relig2,   f: '$porcentagem_corte_relig2%'}],

			['<div style=\"font-weight:bold\">Cortes Concluídos</div>',  {v: $qtd_conc02, f: '<div style=\"font-weight:bold\">$qtd_conc02</div>'}, {v:100,   f: '<div style=\"font-weight:bold\">100%</div>'}],"; ?> ]);

        var table = new google.visualization.Table(document.getElementById('table_div77'));

        table.draw(data, {showRowNumber: false, width: '100%', height: '100%', allowHtml: true});
      }
  
  function drawTableRelig2() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Tipo');
        data.addColumn('number', 'Qtd'); 
        data.addColumn('number', 'Porcentagem');     
        data.addRows([

        	<?php 
			// $religconc01 = number_format($resultado0102, 0, ',','.');	
        	 $religNaoSolGeral = $religafazerOrig;
        	 $religNaoSolGeral2 = number_format($religNaoSolGeral, 0, ',','.');
        	// $qtd_conc02 = number_format($qtd_conc, 0, ',','.');		
        	 $relgerada03 = number_format($relgerada02, 0, ',','.');	
        	 $relcancelada03 = number_format($relcancelada02, 0, ',','.');	
        	 $relagdespacho03 = number_format($relagdespacho02, 0, ',','.');	
        	 $relaceita03 = number_format($relaceita02, 0, ',','.');	
        	 $reldespachada03 = number_format($reldespachada02, 0, ',','.');	
        	 $relexec03 = number_format($relexec02, 0, ',','.');	
        	 $relconcimp03 = number_format($relconcimp02, 0, ',','.');	
        	 $relconcincp03 = number_format($relconcincp02, 0, ',','.');	
 		     $relconctemp03 = number_format($relconctemp02, 0, ',','.');

        	 $soma1 = $relcancelada03 + $relagdespacho03 + $relgerada03 + $relaceita03 + $reldespachada03 + $relexec03 + $relconcimp03 + $relconcinc03 + $relconctemp03;
        	 $religNaoSol = $religNaoSolGeral - $soma1;
    		 $religNaoSol2 = number_format($religNaoSol, 0, ',','.');
			if (!empty($religNaoSolGeral)) {
			 $porcentagem_religNaoSol = ($religNaoSol / $religNaoSolGeral) * 100;
			} else $porcentagem_religNaoSol = 0;
			$porcentagem_religNaoSol = number_format($porcentagem_religNaoSol, 2);
		 
        	

			echo "['Aceitas',   {v:$relaceita02,   f: '$relaceita02'}, {v:$porcentagem_relaceita,   f: '$porcentagem_relaceita%'}],
				  ['Geradas',   {v:$relgerada03,   f: '$relgerada03'}, {v:$porcentagem_relgerada,   f: '$porcentagem_relgerada%'}],
				  ['Canceladas',   {v:$relcancelada03,   f: '$relcancelada03'}, {v:$porcentagem_relcancelada,   f: '$porcentagem_relcancelada%'}],
				  ['Despachadas',   {v:$reldespachada02,   f: '$reldespachada02'}, {v:$porcentagem_reldespachada,   f: '$porcentagem_reldespachada%'}],
				  ['Ag. Despacho',   {v:$relagdespacho03,   f: '$relagdespacho03'}, {v:$porcentagem_relagdespacho,   f: '$porcentagem_relagdespacho%'}],	
				  ['Em Execução',   {v:$relexec02,   f: '$relexec02'}, {v:$porcentagem_relexec,   f: '$porcentagem_relexec%'}],				  			 
				  ['Concluídas C/ Imp',   {v:$relconcimp02,   f: '$relconcimp02'}, {v:$porcentagem_relconcimp,   f: '$porcentagem_relconcimp%'}],
				  ['Concluídas C/ Inc',   {v:$relconcinc02,   f: '$relconcinc02'}, {v:$porcentagem_relconcinc,   f: '$porcentagem_relconcinc%'}],
				  ['Concluídas Por Tempo',   {v:$relconctemp02,   f: '$relconctemp02'}, {v:$porcentagem_relconctemp,   f: '$porcentagem_relconctemp%'}],
				  ['Não Solicitadas',   {v:$religNaoSol2,   f: '$religNaoSol2'}, {v:$porcentagem_religNaoSol,   f: '$porcentagem_religNaoSol%'}],

			['<div style=\"font-weight:bold\">Total</div>',  {v: $religNaoSolGeral2, f: '<div style=\"font-weight:bold\">$religNaoSolGeral2</div>'}, {v:100,   f: '<div style=\"font-weight:bold\">100%</div>'}],"; ?> ]);

        var table = new google.visualization.Table(document.getElementById('table_div88'));

        table.draw(data, {showRowNumber: false, width: '100%', height: '100%', allowHtml: true});
      }


function drawChart3() {
        var data = google.visualization.arrayToDataTable([

        	<?php         
        	$religconc02 = $resultado0102;
        	//$religafazer02 = $religNaoSol2;

        	echo "['Tipo', 'Quantidade'],          
          ['Geradas',    $relgerada02],   
          ['Canceladas',    $relcancelada02],
          ['Ag. Despacho',    $relagdespacho02],
          ['Despachadas', $reldespachada02], 
          ['Aceitas', $relaceita02],
          ['Em Execução', $relexec02],
          ['Concluídas C/ Imp', $relconcimp02],
          ['Concluídas C/ Inc', $relconcinc02],
          ['Concluídas Por Tempo', $relconctemp02],  
          ['Concluídas',    $religconc02],              
          ['Não Solicitadas',    $religNaoSol]"
          ; ?>
        ]);

        var options = {
          title: 'Religações',
          titlePosition: 'none',
          pieResidueSliceLabel: 'OUTROS',
          is3D: true,
          backgroundColor: 'transparent',	
		  legend: {'position': 'right'},  
		  chartArea: {'width': '100px', 'height': '80%'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_cort_relig'));
        chart.draw(data, options);
      }


   			function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Tipos');
        data.addColumn('number', 'Corte Dj');
        data.addColumn('number', 'Corte Cv');
        data.addColumn('number', 'Corte AT');
        data.addColumn('number', 'Total');
        data.addRows([
  
			  <?php 
			  
			  
/*** 
Totaliza as OSES concluídas por meio do while 
contando dia, após dia em relação ao mês selecionado
disponível na variável $ihh
***/
		  
 
/***
declara as variaveis e as setam iguais a 1 para a ixab (já que não existe dia 0)
a variável em questão serve de comparação para a quantidade de dias do mês 
selecionado na variável $ihh, já as demais variáveis são setadas como zero
para ser utilizado na contagem no quantitativo de ordem de serviço
***/

//	$ixb=1;
	
/***
viariáveis que servem para contagem dos valores do quantitativo
de ordens de serviço
***/
	
/*	$calcular_total = 0;
	$dj_concluidas_s_imp = 0;
	$cv_concluidas_s_imp = 0;
	$at_concluidas_s_imp = 0;*/
		
/*** 
inicia o while para contar cada dia até o último dia do mês selecionado pela variável $ihh 
***/

//while($ixb <= $ihh){  
	
/***
contagem do corte no disjuntor
***/	

/*$dj_concluidas_s_imp_v = $dj[concluida][$ixb];
$dj_concluidas_s_imp = $dj_concluidas_s_imp + $dj_concluidas_s_imp_v;*/
	
/*** 
contagem do corte convencional 
***/

/*$cv_concluidas_s_imp_v = $cv[concluida][$ixb];
$cv_concluidas_s_imp = $cv_concluidas_s_imp + $cv_concluidas_s_imp_v;
	*/
/***
contagem do corte AT
***/
	
/*$at_concluidas_s_imp_v = $at[concluida][$ixb];
$at_concluidas_s_imp = $at_concluidas_s_imp + $at_concluidas_s_imp_v;
	*/
	/* adiciona +1 na variável */
//	$ixb++;
	//		}
			/* realiza consulta ao banco de dados para extrair dados relativos a cada tipo de corte  */

//Corte DJ

		$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and `sit` = 'Concluída com Impedimento'";
		$resultado_dj_c_imp = mysql_query($sql);
		$dj_contador_concluida_1 = mysql_result($resultado_dj_c_imp, 0);	

		$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and `sit` = 'Concluída'";
		$resultado_dj_s_imp = mysql_query($sql);
		$dj_concluidas_s_imp = mysql_result($resultado_dj_s_imp, 0);

		$dj_total_1 = $contador[dj][total];

//Corte CV

		$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and `sit` = 'Concluída com Impedimento'";
		$resultado_cv_c_imp = mysql_query($sql);
		$cv_contador_concluida_1 = mysql_result($resultado_cv_c_imp, 0);

		$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and `sit` = 'Concluída'";
			$resultado_cv_s_imp = mysql_query($sql);
		$cv_concluidas_s_imp = mysql_result($resultado_cv_s_imp, 0);	


		$cv_total_1	= $contador[cv][total];

//Corte AT

		$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and `sit` = 'Concluída com Impedimento'";
		$resultado_at_c_imp = mysql_query($sql);
		$at_contador_concluida_1 = mysql_result($resultado_at_c_imp, 0);

		$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and `sit` = 'Concluída'";
		$resultado_at_s_imp = mysql_query($sql);
		$at_concluidas_s_imp = mysql_result($resultado_at_s_imp, 0);

		$at_total_1 = $contador[at][total];

	
	
/*** aqui está sendo contabilizado o quantitativo
total de ordens de serviço com e sem impedimento
***/	
		
		$dj_at_cv_com_impedimento_1 = $dj_contador_concluida_1 + $cv_contador_concluida_1 + $at_contador_concluida_1;


		$dj_at_cv_sem_impedimento_1 = $dj_concluidas_s_imp + $cv_concluidas_s_imp + $at_concluidas_s_imp;



		$total_dj_cv_at_1 = $dj_total_1 + $cv_total_1 + $at_total_1;
		  
/*** 
Conversão para milhar dos quantitavos 
calculados.
***/

				  $dj_contador_concluida = number_format($dj_contador_concluida_1, 0, ',','.');
				  $dj_concluidas_s_imp = number_format($dj_concluidas_s_imp, 0, ',','.');
				  $dj_total = number_format($dj_total_1, 0, ',','.');
				  $cv_contador_concluida = number_format($cv_contador_concluida_1, 0, ',','.');	
				  $cv_concluidas_s_imp = number_format($cv_concluidas_s_imp, 0, ',','.');
				  $cv_total = number_format($cv_total_1, 0, ',','.');
				  $at_contador_concluida = number_format($at_contador_concluida_1, 0, ',','.');
				  $at_concluidas_s_imp = number_format($at_concluidas_s_imp, 0, ',','.');
				  $at_total = number_format($at_total_1, 0, ',','.');
				  $dj_at_cv_com_impedimento = number_format($dj_at_cv_com_impedimento_1, 0, ',','.');
				  $dj_at_cv_sem_impedimento = number_format($dj_at_cv_sem_impedimento_1, 0, ',','.');
  				  $total_dj_cv_at = number_format($total_dj_cv_at_1, 0, ',','.');
				  
			  echo "
		  ['Com impedimento',  {v: $dj_contador_concluida, f: '$dj_contador_concluida'}, {v: $cv_contador_concluida, f: '$cv_contador_concluida'}, {v: $at_contador_concluida, f: '$at_contador_concluida'}, {v: $dj_at_cv_com_impedimento, f: '$dj_at_cv_com_impedimento'}],

          ['Sem Impedimento',  {v: $dj_concluidas_s_imp, f: '$dj_concluidas_s_imp'}, {v: $cv_concluidas_s_imp, f: '$cv_concluidas_s_imp'}, {v: $at_concluidas_s_imp, f: '$at_concluidas_s_imp'}, {v: $dj_at_cv_sem_impedimento, f: '$dj_at_cv_sem_impedimento'} ],

          ['<div style=\"font-weight:bold\">Total</div>',    {v: $dj_total, f: '<div style=\"font-weight:bold\">$dj_total</div>'}, {v: $cv_total, f: '<div style=\"font-weight:bold\">$cv_total</div>'}, {v: $at_total, f: '<div style=\"font-weight:bold\">$at_total</div>'}, {v: $total_dj_cv_at, f: '<div style=\"font-weight:bold\">$total_dj_cv_at</div>'} ],
		  "; 
		  ?>
         ]);

        var table = new google.visualization.Table(document.getElementById('table_div'));

        table.draw(data, {showRowNumber: false, width: '100%', height: '100%', allowHtml: true});
      }


function drawTable5() {
        var data = new google.visualization.DataTable();
         data.addColumn('string', 'Data');
        data.addColumn('number', 'Com Impedimento');
        data.addColumn('number', 'C. Imp. Conta Paga');
        data.addColumn('number', 'Sem Impedimento');
        data.addColumn('number', 'Total');
        data.addColumn('number', 'Percentual Conc. C. Imp.');
        data.addRows([
       	<?php 
$i=1;
       	 while($i <= $ihh){     
		$dj_cv_at_c_imp = $dj_cv_at[concluida_c_imp_total][$i];
		$conta_paga_total = $conta_paga[total][$i];
		$dj_cv_at_s_imp = $dj_cv_at[concluida][$i];
		$dj_cv_at_total = $dj_cv_at[concluida_total][$i];
		$corte_conc_c_imp_percent_1 = $dj_cv_at[percentual][$i];
		$corte_conc_c_imp_percent = number_format($corte_conc_c_imp_percent_1, 2);
		//$corte_conc_c_imp_percent = number_format($corte_conc_c_imp_percent_1, 2);
					  if($i==$ihh) {
				  echo "['$i/$mees/$anoo', {v: $dj_cv_at_c_imp, f: '$dj_cv_at_c_imp'}, {v: $conta_paga_total, f: '$conta_paga_total'}, {v: $dj_cv_at_s_imp, f: '$dj_cv_at_s_imp'}, {v: $dj_cv_at_total, f: '$dj_cv_at_total'}, {v: $corte_conc_c_imp_percent, f: '$corte_conc_c_imp_percent%'}]";
			  } else { echo "['$i/$mees/$anoo', {v: $dj_cv_at_c_imp, f: '$dj_cv_at_c_imp'}, {v: $conta_paga_total, f: '$conta_paga_total'}, {v: $dj_cv_at_s_imp, f: '$dj_cv_at_s_imp'}, {v: $dj_cv_at_total, f: '$dj_cv_at_total'}, {v: $corte_conc_c_imp_percent, f: '$corte_conc_c_imp_percent%'}],";}

			  $i++; 
			}
			?>
        ]);
        
        var table = new google.visualization.Table(document.getElementById('table_div7'));


    	 table.draw(data, {showRowNumber: false, width: '100%', height: '100%', allowHtml: true});


      }



//função para criar tabela com detalhessemanais sobre cortes sem impedimento do mês atual      

function drawTable3() {
        var data = new google.visualization.DataTable();
       	data.addColumn('string', 'Dias');
        data.addColumn('number', 'Quantidade');
        data.addColumn('number', 'Porcentagem');
        data.addRows([
       	<?php echo "['Dias 1 a 8', {v: $semana_mes_atual[1], f: '$semana_mes_atual[1]'}, {v: $porcentagem_semana1, f: '$porcentagem_semana1%'}],

          ['Dias 9 a 16',  {v: $semana_mes_atual[2], f: '$semana_mes_atual[2]'},  {v: $porcentagem_semana2, f: '$porcentagem_semana2%'}],

          ['Dias 17 a 24',  {v: $semana_mes_atual[3], f: '$semana_mes_atual[3]'}, {v: $porcentagem_semana3, f: '$porcentagem_semana3%'}],

          ['Dias 25 a $ihh',  {v: $semana_mes_atual[4], f: '$semana_mes_atual[4]'},  {v: $porcentagem_semana4, f: '$porcentagem_semana4%'}],

          ['<div style=\"font-weight:bold\">Total</div>',  {v: $qtd_semana_atual, f: '<div style=\"font-weight:bold\">$qtd_semana_atual</div>'}, {v: $porcentagem_total_atual, f: '<div style=\"font-weight:bold\">$porcentagem_total_atual%</div>'}]" ?>
        ]);

       
        var table = new google.visualization.Table(document.getElementById('table_div9'));

        
        table.draw(data, {showRowNumber: false, width: '300px', height: '100%', allowHtml: true});
	

		 var tablehead ='<tr class="google-visualization-table-tr-head"><th class="google-visualization-table-th gradient unsorted" colspan="1"></th><th class="google-visualization-table-th gradient unsorted" colspan="2"><?php echo"Mês $mees/$anoo"?></th></tr>';
          var stuff = jQuery('#table_div9').find('thead').prepend(tablehead);

      }

<?php if (isset($mes_cort_pen)) { ?>

	function drawTable8() { 
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Dias');
        data.addColumn('number', 'Quantidade');
        data.addColumn('number', 'Porcentagem');
        data.addRows([
       	<?php echo "['Dias 1 a 8', {v: $semana_mes_pen[1], f: ' $semana_mes_pen[1] '}, {v: $porcentagem_pen_semana1, f: '$porcentagem_pen_semana1%'}],

          ['Dias 9 a 16', {v: $semana_mes_pen[2], f: '$semana_mes_pen[2]'}, {v: $porcentagem_pen_semana2, f: '$porcentagem_pen_semana2%'}],

          ['Dias 17 a 24',  {v: $semana_mes_pen[3], f: '$semana_mes_pen[3]'}, {v: $porcentagem_pen_semana3, f: '$porcentagem_pen_semana3%'}],

          ['Dias 25 a $ijj',  {v: $semana_mes_pen[4], f: '$semana_mes_pen[4]'}, {v: $porcentagem_pen_semana4, f: '$porcentagem_pen_semana4%'}],

          ['<div style=\"font-weight:bold\">Total</div>',  {v: $qtd_semanas_mes_anterior, f: '<div style=\"font-weight:bold\">$qtd_semanas_mes_anterior</div>'}, {v: $porcentagem_total_pen, f: '<div style=\"font-weight:bold\">$porcentagem_total_pen%</div>'}]" ?>
        ]);
  
        var table = new google.visualization.Table(document.getElementById('table_div10'));

        table.draw(data, {showRowNumber: false, width: '300px', height: '100%', allowHtml: true});
	
         var tablehead ='<tr class="google-visualization-table-tr-head"><th class="google-visualization-table-th gradient unsorted" colspan="1"></th><th class="google-visualization-table-th gradient unsorted" colspan="2"><?php echo"Mês $mes_cort_pen /$ano_cort_pen"?></th></tr>';
          var stuff = jQuery('#table_div10').find('thead').prepend(tablehead);
 	
      }

      <?php 
      if ($ijj > $ihh){
      	$ill = $ijj;
      	} else {
      		$ill = $ihh;
      	}

      ?>

function drawTable9() { 
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Dias');
        data.addColumn('number', 'Diferença Percentual');
        data.addRows([
       	<?php echo "['Dias 1 a 8', {v: $diff_percent1, f: '<div style=\"font-weight:bold\">$diff_percent1%</div>'}],

          ['Dias 9 a 16', {v: $diff_percent2, f: '<div style=\"font-weight:bold\">$diff_percent2%</div>'}],

          ['Dias 17 a 24', {v: $diff_percent3, f: '<div style=\"font-weight:bold\">$diff_percent3%</div>'}],

          ['Dias 25 a $ill', {v: $diff_percent4, f: '<div style=\"font-weight:bold\">$diff_percent4%</div>'}],

          ['<div style=\"font-weight:bold\">Total</div>', {v: $diff_percent_total, f: '<div style=\"font-weight:bold\">$diff_percent_total%</div>'}]" ?>
        ]);

          var table = new google.visualization.Table(document.getElementById('table_div11'));

        table.draw(data, {showRowNumber: false, width: '300px', height: '100%', allowHtml: true});


         var tablehead ='<tr class="google-visualization-table-tr-head"><th class="google-visualization-table-th gradient unsorted" colspan="1"></th><th class="google-visualization-table-th gradient unsorted" colspan="1"><?php echo"Mês $mees/$anoo x $mes_cort_pen/$ano_cort_pen"?></th></tr>';
          var stuff = jQuery('#table_div11').find('thead').prepend(tablehead);

      }

<?php } ?>

//criação de uma segunda função que define as configurações da tabela de acordo com o Google Table Charts

      function drawTable2() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Cód. Impedimento');
        data.addColumn('number', 'Quantidade');
        data.addRows([

        	<?php
//consulta ao banco de dados para buscar top 5 impedimentos 
        	$sql = "SELECT cod_imp, sum(qtd) as quantidade FROM corte WHERE year(dataconc) = $anoo AND month(dataconc) = $mees AND cod_imp !='' GROUP BY cod_imp ORDER BY sum(qtd) DESC LIMIT 5";
			$resultado_cod_imp = mysql_query($sql);
		//$total = mysql_num_rows($resultado_cod_imp);
		//echo $total;

			
	//imprimir principais causas de impedimento em ordem decrescente
			while ($registro = mysql_fetch_array($resultado_cod_imp)) {
				$nome_imp = $registro["cod_imp"];
				switch ($nome_imp) {
					case '115':
						$nome1 = "UC FECHADA OU SEM ACESSO AO PADRÃO";
						break;
					case '8900':
						$nome1 = "OUTROS IMPEDIMENTOS";
						break;
					case '8410':
						$nome1 = "APRESENTOU CONTA PAGA";
						break;
					case '8004':
						$nome1 = "PROIBIDA ENTRADA DO EXECUTOR DO SERVIÇO";
						break;
					case '8018':
						$nome1 = "UNIDADE CONSUMIDORA NÃO LOCALIZADA";
						break;
					case '8000':
						$nome1 = "FALTA/DIFICULDADE DE ACESSO";
						break;
					case '116':
						$nome1 = "CLIENTE AUSENTE";
						break;
					case '111':
						$nome1 = "FAZER CORREÇÕES NO ENDEREÇO DA UC";
						break;
					case '8001':
						$nome1 = "PORTA/PORTÃO FECHADO";
						break;
					case '8006':
						$nome1 = "DIFICIL ACESSO AO MEDIDOR";
						break;				
					case '9934':
						$nome1 = "SERVICO ENCONTRADO EXECUTADO";
						break;	
					case '0113':
						$nome1 = "INDICAR PONTO DE REFERENCIA DA UC";
						break;
					case '7051':
						$nome1 = "EXISTENCIA DE FRAUDE";
						break;
					case '8005':
						$nome1 = "PREDIO DESOCUPADO";
						break;
					case '8008':
						$nome1 = "FALTA PLACA DE IDENTIFICACAO";
						break;
					case '8100':
						$nome1 = "DECISAO GERENCIAL";
						break;
					case '8800':
						$nome1 = "CLIENTE ORIENTADO CONF. CROQUIS";
						break;
					case '8007':
						$nome1 = "NINGUEM PARA AVISAR - CORTE NAO REALIZADO";
						break;
					case '8012':
						$nome1 = "CORTE NAO REALIZ.DEVIDO AFETAR OUTRAS UCS";
						break;
					case '8016':
						$nome1 = "RUA/ESTRADA INTRANSITAVEL";
						break;
					case '8023':
						$nome1 = "UC INEXISTENTE FISICAMENTE";
						break;
					case '8404':
						$nome1 = "QUITACAO DO DEBITO";
						break;
					case '8002':
						$nome1 = "CAO BRAVO SOLTO";
						break;
					case '5301':
						$nome1 = "ENDERECO INCOMPLETO (NAO LOCALIZADO)";
						break;
					case '0411':
						$nome1 = "FAZER ACABAMENTO ELETROD.()ENTRADA ( )SAIDA C/ARR";
						break;
					case '0115':
						$nome1 = "UC FECHADA OU SEM ACESSO AO PADRAO";
						break;		
					case '9966':
						$nome1 = "UC JA SE ENCONTRA SUSPENSA";
						break;	
					case '8420':
						$nome1 = "APRESENTOU CONTA PAGA APÓS O CORTE";
						break;	
					case '8902':
						$nome1 = "NECESSIDADE DE EQUIPE COM ESCADA";
						break;									
					default:
						$nome1 = "OUTROS";
						break;
				}
				$quantidade1 = $registro["quantidade"];
				$quantidade = number_format($quantidade1, 0, ',','.');
				echo  "['$nome1', {v: $quantidade, f: '$quantidade'} ],";
				}	
				
              ?>
        ]);

        var table = new google.visualization.Table(document.getElementById('table_div2'));
        table.draw(data, {showRowNumber: false, width: '100%', height: '100%'});
		}

<?php
	}
?>

<?php

if ($_POST["relatorio"] == "relat_uc_s_med") {

?>

function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Situação');
        data.addColumn('number', 'Quantidade');
        data.addRows([
  
			  <?php 
        		$sql = "SELECT situacao, sum(qtd) as quantidade FROM `uc_sem_med_oficial` WHERE year(data_insercao) = $anoo AND month(data_insercao) = $mees GROUP BY situacao ORDER BY quantidade desc";
        	$result_sit_uc = mysql_query($sql);
          $cont_sit = 1;
          while ($registro = mysql_fetch_array($result_sit_uc)){
            $nome_sit_uc_1 = $registro["situacao"];
            $nome_sit_uc = trim($nome_sit_uc_1);
            $qtd_sit_uc_1 = $registro["quantidade"];
            $qtd_sit_uc = number_format($qtd_sit_uc_1, 0,',','.');
            if ($cont_sit < 2){
            echo "['$nome_sit_uc',  {v: $qtd_sit_uc, f: '$qtd_sit_uc'}],";}
            else{ echo "['$nome_sit_uc',  {v: $qtd_sit_uc, f: '$qtd_sit_uc'}],";
            			$sql = "SELECT sum(qtd) as quantidade  FROM `uc_sem_med_oficial` WHERE year(data_insercao) = $anoo AND month(data_insercao) = $mees";
			$resultado = mysql_query($sql) or die ("Erro");
			$registro = mysql_fetch_array($resultado);
			$qtd_total_result_1 = $registro['quantidade'];
			$qtd_total_result = number_format($qtd_total_result_1, 0, ',','.');
        	echo "['<div style=\"font-weight:bold\">TOTAL</div>', {v:$qtd_total_result, f: '<div style=\"font-weight:bold\">$qtd_total_result</div>'}]";}
            $cont_sit++;
          }
                  	mysql_free_result($result_sit_uc);
        	?>
       ]);
        
        
        var table = new google.visualization.Table(document.getElementById('table_div3'));

        table.draw(data, {showRowNumber: false, width: '100%', height: '100%', allowHtml: true});
		}

function drawTable2() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Tipologia');
        data.addColumn('number', 'Quantidade');
        data.addRows([
  
			  <?php 
        		$sql = "SELECT tipo_ligacao, sum(qtd) as quantidade FROM `uc_sem_med_oficial` WHERE year(data_insercao) = $anoo AND month(data_insercao) = $mees GROUP BY tipo_ligacao ORDER BY tipo_ligacao asc";
        	$result_tipo_uc = mysql_query($sql);
        	$cont_tipo = 1;
        	while ($registro2 = mysql_fetch_array($result_tipo_uc)){
        		$nome_tipo_uc_1 = $registro2["tipo_ligacao"];
        		switch ($nome_tipo_uc_1) {
        			case '1':
        				$nome_tipo_uc = "MONOFÁSICO";
        				break;
        			case '2':
        				$nome_tipo_uc = "BIFÁSICO";
        				break;
        			case '3':
        				$nome_tipo_uc = "TRIFÁSICO";
        				break;
        			default:
        				$nome_tipo_uc = "???";
        				break;
        		}
        		$qtd_tipo_uc_1 = $registro2["quantidade"];
        		$qtd_tipo_uc = number_format($qtd_tipo_uc_1, 0, ',','.');
        		if ($cont_tipo < 3){ 
        			echo "['$nome_tipo_uc',  {v: $qtd_tipo_uc, f: '$qtd_tipo_uc'}],";}		
        		elseif ($cont_tipo <= 3) { echo "['$nome_tipo_uc',  {v: $qtd_tipo_uc, f: '$qtd_tipo_uc'}],";
        		$sql = "SELECT sum(qtd) as quantidade  FROM `uc_sem_med_oficial` WHERE year(data_insercao) = $anoo AND month(data_insercao) = $mees";
			$resultado = mysql_query($sql) or die ("Erro");
			$registro = mysql_fetch_array($resultado);
			$tipo_result_1 = $registro['quantidade'];
			$tipo_result = number_format($tipo_result_1, 0, ',','.');
        	echo "['<div style=\"font-weight:bold\">TOTAL</div>', {v:$tipo_result, f: '<div style=\"font-weight:bold\">$tipo_result</div>'}]";}
        		$cont_tipo++;
        	}
        	

        	?>
       ]);

        var table = new google.visualization.Table(document.getElementById('table_div4'));

        table.draw(data, {showRowNumber: false, width: '100%', height: '100%', allowHtml: true});
		}

<?php
	}
?>

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
function submete() {
if ( document.formulario.relatorio.value == "NULL" ) {
		alert( 'Selecione o tipo de relatorio!' );
		document.formulario.relatorio.focus();
    } else if ( document.formulario.ano.value == "NULL" ) {
		alert( 'Selecione o ano do relatorio!' );
		document.formulario.ano.focus();
    }  else {
        	document.formulario.submit();	
		 $("#botao").css("display", "none");
		 		 $("#carregando").css("display", "block");
}
}


function optionCheck1(){
			document.getElementById("button_class2").focus();
            document.getElementById("columnchart_material_2").style.visibility ="hidden";
            document.getElementById("columnchart_material_2").style.position ="absolute";
            document.getElementById("piechart").style.visibility ="visible"; 
           document.getElementById("piechart").style.position ="relative";   
            document.getElementById("relat_class_det1").style.display ="none";
             document.getElementById("relat_class_det2").style.display ="block";
       		}

function optionCheck2(){
			document.getElementById("button_class1").focus();
            document.getElementById("columnchart_material_2").style.visibility ="visible";
            document.getElementById("columnchart_material_2").style.position ="relative";
            document.getElementById("piechart").style.visibility ="hidden";    
            document.getElementById("piechart").style.position ="absolute";  
            document.getElementById("relat_class_det1").style.display ="block";
            document.getElementById("relat_class_det2").style.display ="none";
             }

function optionCheck3(){
	document.getElementById("button_sit2").focus();
	        document.getElementById("columnchart_material_3").style.display ="none";
            document.getElementById("relat_sit_table").style.display ="block";    
            document.getElementById("relat_sit_det1").style.display ="none";
             document.getElementById("relat_sit_det2").style.display ="block";
     if (document.getElementById("columnchart_material_4").style.display == 'block'){
             document.getElementById("columnchart_material_4").style.marginTop ="-50px";
             document.getElementById("relat_tipo_det1").style.marginTop ="-50px";
        }
     if (document.getElementById("relat_tipo_table").style.display == 'block'){
         document.getElementById("tab_title_dir").style.marginTop ="-55px"; 
      	 document.getElementById("tab_title_dir").style.marginLeft ="60px"; 
      	 document.getElementById("table_div_estilo3").style.marginTop ="-40px";
             document.getElementById("relat_tipo_det2").style.marginTop ="-30px";           
         } 
       		}

function optionCheck4(){
	document.getElementById("button_sit1").focus();
            document.getElementById("columnchart_material_3").style.display ="block";
            document.getElementById("relat_sit_table").style.display ="none";    
            document.getElementById("relat_sit_det1").style.display ="block";
             document.getElementById("relat_sit_det2").style.display ="none";
        document.getElementById("columnchart_material_4").style.marginTop ="3px";   
        document.getElementById("columnchart_material_4").style.marginRight ="5px";   
             document.getElementById("relat_tipo_det1").style.marginTop ="5px";
            if (document.getElementById("relat_tipo_table").style.display == 'block'){
      document.getElementById("tab_title_dir").style.marginTop ="0px"; 
      	 document.getElementById("tab_title_dir").style.marginLeft ="60px"; 
      	 document.getElementById("table_div_estilo3").style.marginTop ="-40px";
             document.getElementById("relat_tipo_det2").style.marginTop ="15px";               
         }   
       		}

function optionCheck5(){
	document.getElementById("button_tipo2").focus();
            document.getElementById("columnchart_material_4").style.display ="none";
            document.getElementById("relat_tipo_table").style.display ="block";    
            document.getElementById("relat_tipo_det1").style.display ="none";
             document.getElementById("relat_tipo_det2").style.display ="block";              
      if (document.getElementById("relat_sit_table").style.display == 'block'){  
      	 document.getElementById("tab_title_dir").style.marginTop ="-55px"; 
      	 document.getElementById("tab_title_dir").style.marginLeft ="60px"; 
      	 document.getElementById("table_div_estilo3").style.marginTop ="-100px";
             document.getElementById("relat_tipo_det2").style.marginTop ="-30px"; 
       } else document.getElementById("relat_tipo_det2").style.marginTop ="15px"; 
       document.getElementById("table_div_estilo3").style.marginTop ="-40px";
        document.getElementById("tab_title_dir").style.marginBottom ="50px"; 
         document.getElementById("tab_title_dir").style.marginLeft ="60px";  		
       		}

function optionCheck6(){
	document.getElementById("button_tipo1").focus();
            document.getElementById("columnchart_material_4").style.display ="block";
            document.getElementById("relat_tipo_table").style.display ="none";    
            document.getElementById("relat_tipo_det1").style.display ="block";
             document.getElementById("relat_tipo_det2").style.display ="none";     
        if (document.getElementById("relat_sit_table").style.display == 'block'){
             document.getElementById("columnchart_material_4").style.marginTop ="-50px";
             document.getElementById("relat_tipo_det1").style.marginTop ="-50px";
         }       
       		}

function optionCheck7(){
	document.getElementById("button_cort2").focus();
            document.getElementById("relat_cort_s_imp_table_1").style.display ="none";
            document.getElementById("relat_cort_s_imp_table_2").style.display ="block";       
            document.getElementById("relat_cort_det1").style.display ="none";
            document.getElementById("relat_cort_det2").style.display ="block"; 
             document.getElementById("meio_esq").style.height = "100%";
            document.getElementById("meio_dir").style.height = "100%";
            if (document.getElementById("relat_cort_daily_table").style.display == 'block'){              
                 document.getElementById("table_div_estilo13").style.marginRight = "100px";   	
                 document.getElementById("tab_title13").style.marginRight = "0px";
                 document.getElementById("table_div_estilo14").style.marginRight = "330px";
            
            } else {
                document.getElementById("table_div_estilo13").style.marginRight = "100px"; 
                document.getElementById("tab_title13").style.marginRight = "0px";
                 document.getElementById("table_div_estilo14").style.marginRight = "330px";           
            }

        	}

function optionCheck8(){
	document.getElementById("button_cort1").focus();
            document.getElementById("relat_cort_s_imp_table_1").style.display ="block";            
            document.getElementById("relat_cort_s_imp_table_2").style.display ="none";    
            document.getElementById("relat_cort_det1").style.display ="block";
            document.getElementById("relat_cort_det2").style.display ="none"; 
             document.getElementById("meio_esq").style.height = "100%";
            document.getElementById("meio_dir").style.height = "100%";           
         }       
       		
function optionCheck9(){

	document.getElementById("button_cort4").focus();
            document.getElementById("relat_cort_daily_table").style.display ="block";
            document.getElementById("columnchart_material").style.display ="none";    
            document.getElementById("relat_cort_daily_table_det2").style.display ="block";
            document.getElementById("relat_cort_daily_table_det1").style.display ="none";  
             document.getElementById("meio_esq").style.height = "100%";
            document.getElementById("meio_dir").style.height = "100%";
            if (document.getElementById("relat_cort_s_imp_table_1").style.display == 'block'){
            	document.getElementById("tab_title13").style.marginRight = "-100px";
                 document.getElementById("table_div_estilo14").style.marginRight = "195px";
    }
            else {
            	document.getElementById("table_div_estilo13").style.marginRight = "100px";
            	  document.getElementById("tab_title13").style.marginRight = "0px";
                 document.getElementById("table_div_estilo14").style.marginRight = "330px";  	
       }
           }     

function optionCheck10(){
document.getElementById("button_cort3").focus();
            document.getElementById("relat_cort_daily_table").style.display ="none";
            document.getElementById("columnchart_material").style.display ="block";       
            document.getElementById("relat_cort_daily_table_det2").style.display ="none";
            document.getElementById("relat_cort_daily_table_det1").style.display ="block"; 
               document.getElementById("meio_esq").style.height = "100%";
            document.getElementById("meio_dir").style.height = "100%";
            if (document.getElementById("relat_cort_s_imp_table_1").style.display == 'none'){
	document.getElementById("table_div_estilo13").style.marginRight = "100px"; 
            	document.getElementById("tab_title13").style.marginRight = "0px";
                 document.getElementById("table_div_estilo14").style.marginRight = "330px";
    }
        	}


function optionCheck11(){
document.getElementById("button_relig2").focus();
            document.getElementById("relat_relig_1").style.display ="none";
            document.getElementById("relat_relig_2").style.display ="block";       
            document.getElementById("relat_relig_det1").style.display ="none";
            document.getElementById("relat_relig_det2").style.display ="block";   
            document.getElementById("meio_esq").style.height = "100%";
            document.getElementById("meio_dir").style.height = "100%";
        	}


function optionCheck12(){
document.getElementById("button_relig1").focus();
             document.getElementById("relat_relig_1").style.display ="block";
            document.getElementById("relat_relig_2").style.display ="none";       
            document.getElementById("relat_relig_det1").style.display ="block";
            document.getElementById("relat_relig_det2").style.display ="none";    
            document.getElementById("meio_esq").style.height = "100%";
            document.getElementById("meio_dir").style.height = "100%";     
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
          <li class="nav-item"><a class="nav-link" id="font_config" href="http://10.68.14.67/novosicob/consulta.php">Pág. Inicial<span class="sr-only">(current)</span></a></li>   
           <li class="nav-item"><a class="nav-link" id="font_config" href="http://10.68.14.67/novosicob/anexoIII_leitura.php" tabindex="-1">Enviar Arquivo</a></li>
           <li class="nav-item"><a class="nav-link" id="font_config" href="http://10.68.14.67/novosicob/gerar_relat.php">Gerar Arquivo</a></li>
           <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-toggle="dropdown" id="link_ativo" href="#" role="button" aria-haspopup="true" aria-expanded="false">Relatórios</a>
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

 

  <section class="corpo_meio_relat_abert">
            <nav class="navbar navbar-dark" style="background-color: #B43104;">
  <a class="navbar-brand" id="title01" href="http://10.68.14.67/novosicob/tratrec_load.php">
    <div class="h4"> Relatórios </div>
  </a>
</nav>
      <div class="container-fluid">


        <div class="row">
<?php

if ($_POST["relatorio"]=="m_abertura"){ echo "<div id=\"columnchart_material\" style=\"width: 900; height: 400px;\"></div><br/>"; ?>


<div id="columnchart_material_5" style="width: 400px; height: 300px; margin-top: 0px;"><br/><br/><r/></div>
	
	<?php if (empty($mes_abert_pen)){ ?>

				<div class='tab_title' style="text-align: center; margin-top: 25px;">Quantidade e Percentual de Cortes Gerados</div><br/>
				<div class='table_div_estilo6' style="margin: 0px auto 0px auto;">
				<div id='table_div6'></div><br/>
				</div>				

	<?php } else {?>

	<div class='tab_title'>Quantidade e Percentual de Cortes Gerados</div><br/>
	<div class='table_div_estilo5' style="margin-left: 100px;">
	<div id='table_div7'></div><br/>
	</div>
	<div class='table_div_estilo5' style="margin-left: 90px;">
	<div id='table_div6'></div><br/>
	</div>
	<div class='tab_title' style="clear: both; text-align: center; margin-top: 170px;">Diferença percentual entre Cortes Gerados</div><br/>
	<div class='table_div_estilo6' style="margin: 0px auto 0px auto;">
	<div id='table_div8'></div>
	<br/>
	</div>
<?php } $soma_totx = number_format($soma_tot, 0, ',','.');
}

if ($_POST["relatorio"]=="m_deslig") { echo "<div id=\"columnchart_material\" style=\"width: 900; height: 400px; display:block;\"></div>";
$soma_totx = number_format($soma_tot, 0, ',','.'); ?>

<div id="relat_cort_daily_table_det1" style="display:block;"><p align="left"> Veja relatório detalhado <button type="button" id="button_cort3" onClick="optionCheck9()">aqui</button></p></div>

<div id="relat_cort_daily_table" style="display:none;">
<div class='tab_title'>Relatório de Cortes Concluídos - CEB <?php echo "$mees/$anoo" ?></div><br/>
<div id='table_div_estilo4'><br/>
		<div id='table_div7'></div></div><br/>
</div>

<!-- Legenda para voltar à tabela de cortes diário concluídos (dj, cv, at) -->
<div id="relat_cort_daily_table_det2" style="display:none;"><p align="left"> Veja gráfico de cortes concluídos (DJ, CV e AT) <button type="button" id="button_cort4" onClick="optionCheck10()">aqui</button></p></div>

<?php 
}

if ($_POST["relatorio"]=="relat_uc_s_med"){ 
	echo "<div id=\"barchart_material\" style=\"width: 900px; height: 400px;\"></div><br/><br/><br/>";
	echo "<div id='resultado_total'>Total $qtd_total_result</div>";
}

// aqui cria-se as divs que irão dar forma às tabelas
if ($_POST["relatorio"]=="m_abertura"){
	echo "<p align=\"left\">Total de OS Geradas: <b>$soma_totx</b></p>"; 
}


 if ($_POST["relatorio"]=="m_deslig") {
	?>
	<!-- Gráfico Pizza com cortes realizados no cv, dj e at-->
<div id="piechart" style="width: 800px; height: 300px;"></div>

	<!-- Tabela com relatório de cortes com e sem impedimento -->

<div id="relat_cort_s_imp_table_1" style="display:block;">
<div class='tab_title'>Resumo de cortes (com e sem impedimento):</div><br/>
	<div id='table_div_estilo'><br/>
		<div id='table_div'></div></div><br/>
</div>
<div id="relat_cort_det1" style="display:block;"><p align="left"> Veja tabela semanal dos cortes concluídos s/ impedimento <button type="button" id="button_cort1" onClick="optionCheck7()">aqui</button></p></div>

<?php if (empty($mes_cort_pen)){ ?>
<!-- tabela com detalhes de corte s impedimento refente ao mês anterior, atual e diferença percentual entre os meses -->
<div id="relat_cort_s_imp_table_2" style="display:none;">
	<div class='tab_title'>Cortes Concluídos S/ Impedimento</div><br/>
		<div id='table_div10'></div></div><br/>
</div>

<?php } else { ?>

	<div id="relat_cort_s_imp_table_2" style="display:none;">
	<div id='tab_title14'>Cortes Concluídos S/ Impedimento</div><br/>
		<div class='table_div_estilo6' style="float: left; margin-left: 100px;">
		<div id='table_div10'></div></div><br/>
		<div id='table_div_estilo13' style="float: right;  margin-top: -18px;">
		<div id='table_div9'></div></div><br/>	
		<div id='tab_title13'>Diferença percentual entre Cortes Concluídos</div><br/>
		<div id='table_div_estilo14'>
		<div id='table_div11'></div></div>  </div><br/>

<?php } ?>




<!-- Legenda para voltar à tabela de cortes concluídos com e sem impedimento -->
<div id="relat_cort_det2" style="display:none;"><p align="left"> Veja cortes concluídos com e sem impedimento <button type="button" id="button_cort2" onClick="optionCheck8()">aqui</button></p></div>



<!-- Tabela com top 5 impedimentos -->
	<div class='tab_title'>Top 5 impedimentos:</div><br/>
		<div id='table_div_estilo'><br/>
			<div id='table_div2'></div></div>

<p style="clear: both;" align="left"> <?php echo "<br/>Total de cortes conclu&iacute;dos: <b>$soma_totx</b>"; ?> baixar a planilha detalhada <b>
<a id="myLink" target="_blank" href="<? echo "baixa_relat2.php?relatorio=$vvv&ano=$mees/$anoo";?>">aqui</a></b></p>

<div id="relat_relig_1" style="display:block;">
			<div class='tab_title77'>Cortes X Religação: </div><br/>
<div id='table_div_estilo77' style="text-align: left; display:block;"><br/>
<div id="table_div77" style="text-align: left; "></div></div>
<div id="relat_relig_det1" style="display:block; position:absolute; margin-top: 230px;"><p align="left"> Veja Mais Detalhes Sobre as Religações Pendentes <button type="button" id="button_relig1" onClick="optionCheck11()">aqui</button></p></div>
</div>

<div id="relat_relig_2" style="display:none;">
<div class='tab_title88'>Religações Pendentes: </div><br/>
<div id='table_div_estilo88' style="text-align: left;"><br/>
<div id="table_div88" style="text-align: left;"></div></div>
<div id="relat_relig_det2" style="display:block; position:absolute; margin-top: 320px;"><p align="left"> Veja cortes concluídos com e sem impedimento <button type="button" id="button_relig2" onClick="optionCheck12()">aqui</button></p></div>
</div>
<div class='tab_title99'>Religações </div><br/>
 <div id="piechart_cort_relig"></div>




<?php
}
if ($_POST["relatorio"]=="relat_uc_s_med"){
?>
<!-- Gráfico em colunas referente as classes de UC Sem Medidor -->

<div id="columnchart_material_2" style="width: 800px; height: 300px; visibility: visible; position: relative;"><br/><br/><r/></div>
<div id="relat_class_det1" style="display:block;"><p align="left"> Veja detalhes do mês atual <button type="button" id="button_class1" onClick="optionCheck1()">aqui</button>
</p></div>
<!-- Gráfico em pizza referente as classes de UC Sem Medidor -->
<div id="piechart" style="width: 800px; height: 300px;  visibility: hidden; position: absolute;"><br/><br/><r/></div>
<div id="relat_class_det2" tabindex="0" style="display:none; "><p align="left"> Veja comparação entre os últimos meses <button type="button" id="button_class2" onClick="optionCheck2()">aqui</button>
</p></div>
<br/><br/>
<!-- Gráfico em colunas referente a situacão UC Sem Medidor -->
<div id="columnchart_material_3" style="width: 350px; height: 300px; float: left; margin-left: 70px; display:block;"><br/><br/><r/></div>
<div id="relat_sit_det1" style="display:block"><p class="relat_sit_det1"> Veja detalhes do mês atual <button type="button" id="button_sit1" onClick="optionCheck3()">aqui</button>
</p></div>
<div id="relat_sit_table" style="display:none;">
	<div class='tab_title'>Situa&ccedil;&atilde;o UC Sem Medidor <?php echo "($mees/$anoo)"; ?></div><br/>
		<div id='table_div_estilo2'><br/>
			<div id='table_div3'></div></div><br/>
</div>
<div id="relat_sit_det2" style="display:none"><p class="relat_sit_det2"> Veja comparação entre os últimos meses <button type="button" id="button_sit2" onClick="optionCheck4()">aqui</button>
</p></div>

<!-- Gráfico em colunas referente a tipo medição UC Sem Medidor -->
<div id="columnchart_material_4" style="width: 385px; height: 300px; float: left; margin-left: 90px; margin-top: 0px; display:block;"><br/><br/><r/></div>
<div id="relat_tipo_det1" style="display:block"><p class="relat_tipo_det1"> Veja detalhes do mês atual <button type="button" id="button_tipo1" onClick="optionCheck5()">aqui</button></p></div>
<div id="relat_tipo_table" style="display:none;">
<div id="tab_title_dir" style="margin-right: 0px; float: left ">Tipo de Medição UC Sem Medidor <?php echo "($mees/$anoo)"; ?></div><br/>
		<div id='table_div_estilo3'><br/>
			<div id='table_div4'></div></div>
</div>
<div id="relat_tipo_det2" style="display:none"><p class="relat_tipo_det2"> Veja comparação entre os últimos meses <button type="button" id="button_tipo2" onClick="optionCheck6()">aqui</button>
</p></div>


<br/><br/>


<?php
}
?>
        
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
<li class=""><a title="youtube" target="_blank" href="https://www.youtube.com/"><img alt="youtube" width="30" height="30" src="data:image/png;base64,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"></a></li>
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