<?php
//realiza a conexão com banco de dados
	require("main3.php");
//armazena o tipo de relatorio obtido em select	
	$vvv = $_POST["relatorio"];
//obtém o mês e o ano do relatório desejado
	$anoox = $_POST['ano'];
//obtém o mês separadamente 
	$mees = substr($anoox, 0, -5);
//obtém o ano separadamente 
	$anoo = substr($anoox, -4);
//obtém o penúltimo ano 
	$anoo_pen = $anoo - 1;
//obtém a quantidade de dias do mês em questão 
	$ihh = date('t', mktime(0, 0, 0, $mees, '01', $anoo)); 
//obtém o dia atual 
	$diaa = date('d');

	$data_i = "$anoo/$mees/$diaa";
//Obtém o mês antepenúltimo relativo a data do relatório	
	$data_f = date('Y/m/d', strtotime('-3 months', strtotime("$anoo/$mees/$diaa")));



 ?>


 <!DOCTYPE html>
<html lang="pt-br">
<head>

	<title>CEB RELAT - SISTEMA DE RELATÓRIOS DA CEB</title>
	<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'">
	   <link href="css/bootstrap.min.css" rel="stylesheet">
     <link href="_css/estilo01.css" rel="stylesheet">
     <link href="_css/footerallpages.css" rel="stylesheet">
     <link href="https://playground.anychart.com/gallery/Column_Charts/Stick_Chart/iframe" rel="canonical">



  
</head><body>
<script src="jquery.js" type="text/javascript"></script>  
<script src="jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script language="Javascript"> 


google.charts.load('current', {'packages':['bar']});    
       //aqui faz-se conexão e carrega os parâmetros que darão origem a tabela do Google Table 
         google.charts.load('current', {'packages':['table']});
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawChart5);
      google.charts.setOnLoadCallback(drawTable4);
      google.charts.setOnLoadCallback(drawTable6);
      google.charts.setOnLoadCallback(drawTable7); 
       google.charts.setOnLoadCallback(drawTable5); 
         


<?php

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


$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and  `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR'";
$resultado = mysql_query($sql);
$contador[dj][total] = mysql_result($resultado, 0); 

$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and `tiposerv` IN ('DESLIGAMENTO DE UC BAIXA TENSAO', 'DESLIGAMENTO UC RURAL BAIXA TENSAO')";
$resultado = mysql_query($sql);
$contador[cv][total] = mysql_result($resultado, 0); 

$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and  `tiposerv` IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES')";
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

$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) BETWEEN 1 and 8";
$resultado = mysql_query($sql);
  $semana_mes_atual1 = mysql_result($resultado, 0); 
  $semana_mes_atual[1] = number_format($semana_mes_atual1, 0, ',','.'); 

$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) BETWEEN 9 and 16";
$resultado = mysql_query($sql);
  $semana_mes_atual2 = mysql_result($resultado, 0); 
  $semana_mes_atual[2] = number_format($semana_mes_atual2, 0, ',','.');

$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) BETWEEN 17 and 24";
$resultado = mysql_query($sql);
  $semana_mes_atual3 = mysql_result($resultado, 0); 
  $semana_mes_atual[3] = number_format($semana_mes_atual3, 0, ',','.');


$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) BETWEEN 25 and 31";
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

$sql = "SELECT count(*) from corte where year(dataabert) = $ano_abert_pen and month(dataabert) = $mes_abert_pen and day(dataabert) BETWEEN 1 and 8";
$resultado = mysql_query($sql);
  $semana_mes_pen1 = mysql_result($resultado, 0); 
  $semana_mes_pen[1] = number_format($semana_mes_pen1, 0, ',','.'); 

$sql = "SELECT count(*) from corte where year(dataabert) = $ano_abert_pen and month(dataabert) = $mes_abert_pen and day(dataabert) BETWEEN 9 and 16";
$resultado = mysql_query($sql);
  $semana_mes_pen2 = mysql_result($resultado, 0); 
  $semana_mes_pen[2] = number_format($semana_mes_pen2, 0, ',','.');

$sql = "SELECT count(*) from corte where year(dataabert) = $ano_abert_pen and month(dataabert) = $mes_abert_pen and day(dataabert) BETWEEN 17 and 24";
$resultado = mysql_query($sql);
  $semana_mes_pen3 = mysql_result($resultado, 0); 
  $semana_mes_pen[3] = number_format($semana_mes_pen3, 0, ',','.');


$sql = "SELECT count(*) from corte where year(dataabert) = $ano_abert_pen and month(dataabert) = $mes_abert_pen and day(dataabert) BETWEEN 25 and 31";
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
$diff_percent2 = number_format($diff_percent2_1, 2, '.','');

$diff_percent3_1 = (($semana_mes_atual3 - $semana_mes_pen3) / $semana_mes_pen3) * 100;
$diff_percent3 = number_format($diff_percent3_1, 2, '.','');

$diff_percent4_1 = (($semana_mes_atual4 - $semana_mes_pen4) / $semana_mes_pen4) * 100;
$diff_percent4 = number_format($diff_percent4_1, 2, '.','');

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

$sql = "SELECT count(*) from corte where year(dataabert) = $ano_abert_pen and month(dataabert) = $mes_abert_pen and  TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSAO', 'DESLIGAMENTO UC RURAL BAIXA TENSAO')";
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
while ($i <= $ihh) {
      
$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR'";
$resultado = mysql_query($sql);
$dj[gerada][$i] = mysql_result($resultado, 0);


  $sql = "SELECT count('prot') from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSAO', 'DESLIGAMENTO UC RURAL BAIXA TENSAO')";
$resultado = mysql_query($sql) or die(mysql_error());
$cv[gerada][$i] = mysql_result($resultado, 0);


$sql = "SELECT count(*) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES')";
$resultado = mysql_query($sql);
$at[gerada][$i] = mysql_result($resultado, 0);


  $i++; 
}


$soma_tot = $contador[dj][total]+$contador[cv][total]+$contador[at][total];

?>


 function drawChart() {

    var data = google.visualization.arrayToDataTable([
     <?php echo "['Dia', 'Geracao DJ', 'Geracao CV', 'Geracao AT'],"; 

     


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
       
        $dj_concluidas = $dj[gerada][$i];
        $cv_concluidas = $cv[gerada][$i];
        $at_concluidas = $at[gerada][$i];
        if($i==$ihh) {
          echo "['$i', $dj_concluidas, $cv_concluidas, $at_concluidas]";
        } else echo "['$i', $dj_concluidas, $cv_concluidas, $at_concluidas],";
       

  /* adiciona +1 na variável */
  $ixb++;           
      
      $i++;
      }

       ?>
         
        ]);

        var options = {
        <?php echo "title: 'Relatorio de Geracao de Cortes',"; 
            
          echo "subtitle: 'Mes de Referencia $mees/$anoo',"; ?>
      is3D: true,
      backgroundColor: 'transparent',
          
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }


      function drawTable5() {
        var data = new google.visualization.DataTable();
         data.addColumn('string', 'Data');        
        data.addColumn('number', 'Total');        
        data.addRows([
        <?php 
$i=1;
         while($i <= $ihh){ 
        $dj_cv_at_total = $dj[gerada][$i] + $cv[gerada][$i]; + $at[gerada][$i];
            if($i==$ihh) {
          echo "['$i/$mees/$anoo', {v: $dj_cv_at_total, f: '$dj_cv_at_total'}]";
        } else { echo "['$i/$mees/$anoo', {v: $dj_cv_at_total, f: '$dj_cv_at_total'}],";}

        $i++; 
      }
      ?>
        ]);
        
        var table = new google.visualization.Table(document.getElementById('table_div_daily'));


       table.draw(data, {showRowNumber: false, width: '100%', height: '100%', allowHtml: true});


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

      <?php } ?>

//Parâmetro para configuração de botões
       function optionCheck9(){
            document.getElementById("relat_cort_daily_table").style.display ="block";    
            document.getElementById("columnchart_material").style.display ="none";     
            document.getElementById("D2").style.display ="block";   
            document.getElementById("D1").style.display ="none";              
              document.getElementById("corpo_meio_relat_abert").style.height = "127em";      
           
       }


     function optionCheck10(){ 
            document.getElementById("relat_cort_daily_table").style.display ="none";
            document.getElementById("columnchart_material").style.display ="block";       
            document.getElementById("D2").style.display ="none";
            document.getElementById("D1").style.display ="block"; 
      document.getElementById("corpo_meio_relat_abert").style.height = "97em";  
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

 

  <section id="corpo_meio_relat_abert">
            <nav class="navbar navbar-dark" style="background-color: #B43104;">
  <a class="navbar-brand" id="title01" href="http://10.68.14.67/novosicob/tratrec_load.php">
    <div class="h4"> Relatório de Geração de Cortes </div>
  </a>
</nav>
      <div class="container-fluid">


        <div class="row">

<?php echo "<div id=\"columnchart_material\" style=\"width: 80%; height: 400px; float: left; margin-left: 8.5%; margin-top: 2%;\"></div><br/>"; ?>

<div id="D1" style="display:block; margin-left: 8%;"><p align="left">  <button type="button" class="btn btn-primary" id="button_cort3" onClick="optionCheck9()">Veja relatório detalhado</button></p></div>

<div id="relat_cort_daily_table" style="display:none; margin-left: 38%; margin-top: 2%;">
<div class='tab_title'>Relatório de Cortes Concluídos - CEB <?php echo "$mees/$anoo" ?></div>
<div id='table_div_estilo4'><br/>
    <div id='table_div_daily'></div></div><br/>
</div>

<!-- Legenda para voltar à tabela de cortes diário concluídos (dj, cv, at) -->
<div id="D2" style="display:none; margin-top: 56%; margin-left: -23%;"> <p align="left"> <button type="button" id="button_cort4" class="btn btn-primary" onClick="optionCheck10()"> Veja gráfico de cortes concluídos (DJ, CV e AT) </button></p></div>
        
        </div>

        <div class="row">

 <div id="columnchart_material_5" style="width: 35%; height: 22.3em; margin-top: 0px; margin-left: 32.5%; margin-top: 3%;"><br/><br/><r/></div>
        
        </div>

        

  <?php if (empty($mes_abert_pen)){ ?> 
        <div class="row">
        <div class='tab_title' style="text-align: center; margin-top: 25px; margin-left: 100px;">Quantidade e Percentual de Cortes Gerados</div><br/></div>
        <div class="row">
        <div class='table_div_estilo6' style="margin: 0px auto 0px auto;">
        <div id='table_div6'>  </div><br/>
        </div>        
      </div> 

  <?php } else {?>  
<div class="row_tab_abert">
  <div class="row">
  <div class='tab_title' style="text-align: center; margin-top: 2%; margin-left: 24%; margin-bottom: 2%;">Quantidade e Percentual de Cortes Gerados</div><br/></div>
  <div class="row">
  <div class='table_div_estilo5' style="margin-left: 100px;">
  <div id='table_div7'></div><br/>
  </div> 
  <div class='table_div_estilo5' style="margin-left: 90px;">
  <div id='table_div6'></div><br/>
  </div>
</div>
</div>

<div class="row_tab_abert">
<div class="row">
  <div class='tab_title' style="text-align: center; margin-top: 2%; margin-left: 24%;">Diferença percentual entre Cortes Gerados</div></div><br/>
<div class="row">
  <div class='table_div_estilo6' style="margin-left: 24.5%;">
  <div id='table_div8'></div><br/>
  </div>
</div>
<?php }  $soma_totx = number_format($soma_tot, 0, ',','.');

echo " <div class=\"row\"> <p align=\"left\">Total de OS Geradas: <b>$soma_totx</b></p><br/></div>";


?>
          
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