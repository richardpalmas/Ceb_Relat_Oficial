<?php
//realiza a conexão com banco de dados
	require("main3.php");
//armazena o tipo de relatorio obtido em select	
	$vvv = $_POST["relatorio"];
//obtém o mês e o ano do relatório desejado
	$anoox = $_POST['ano_uc'];
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

  $classe = array();

  $mes_abert = array();
  $ano_abert = array();

  $mes_uc = array();
  $ano_uc = array();
  $situacao = array();
  $tipo_ligacao = array();

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




<?php 

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

?>

  
</head><body>
  <?php   if(empty($_POST["relatorio"])){
echo "<script language='javascript' type='text/javascript'>alert('Data de referência não definida');window.location.href='relatorios.php'</script>";} ?>
<script src="jquery.js" type="text/javascript"></script>  
<script src="jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script language="Javascript"> 

  google.charts.load('current', {'packages':['bar']});
      google.charts.load('current', {'packages':['corechart']});
   google.charts.load('current', {'packages':['table']});
google.charts.setOnLoadCallback(drawChart0);
google.charts.setOnLoadCallback(drawChart1);
google.charts.setOnLoadCallback(drawChart2);
google.charts.setOnLoadCallback(drawChart3);
google.charts.setOnLoadCallback(drawTable);
google.charts.setOnLoadCallback(drawChart4);
google.charts.setOnLoadCallback(drawTable2);
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


       function drawChart2() {
          //   var data = new google.visualization.DataTable();

       var data = google.visualization.arrayToDataTable([
    ['Desligamentos', 'Qtde por mes'],
    <?php
        echo "['RESIDENCIAL', ".$classe[RESIDENCIAL][0]."],"; 
        echo "['COMERCIAL', ".$classe[COMERCIAL][0]."],"; 
        echo "['RURAL', ".$classe[RURAL][0]."],"; 
        echo "['P. PÚBLICO', ".$classe[PPUBLICO][0]."],"; 
        echo "['C. PRÓPRIO', ".$classe[CPROPRIO][0]."],"; 
        echo "['S. PUBLICO', ".$classe[SPUBLICO][0]."],"; 
        echo "['INDUSTRIAL', ".$classe[INDUSTRIAL][0]."],"; 
        echo "['CONCESSIO.', ".$classe[CONCESSIO][0]."]";

       ?>
 ]);
        var options = {
      <?php   echo "title: 'Qtde de UC Sem Medição Por Classe Referente ao Mês $mees', "; 
      
         ?>
         pieResidueSliceLabel: 'OUTROS',          
      is3D: true,
      backgroundColor: 'transparent', 
      legend: {'position': 'bottom'}  
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
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

//Parâmetros para configuração de botões

      function optionCheck1(){
            document.getElementById("columnchart_material_2").style.visibility ="hidden";
            document.getElementById("columnchart_material_2").style.position ="absolute";
            document.getElementById("piechart").style.visibility ="visible"; 
           document.getElementById("piechart").style.position ="relative";   
            document.getElementById("D1").style.display ="none";
             document.getElementById("D2").style.display ="block";
          }


    function optionCheck2(){ 
          document.getElementById("columnchart_material_2").style.visibility ="visible";
          document.getElementById("columnchart_material_2").style.position ="relative";
          document.getElementById("piechart").style.visibility ="hidden";    
          document.getElementById("piechart").style.position ="absolute";  
          document.getElementById("D1").style.display ="block";
          document.getElementById("D2").style.display ="none";
           }

           function optionCheck3(){
          document.getElementById("columnchart_material_3").style.display ="none";
            document.getElementById("relat_sit_table").style.display ="block";    
            document.getElementById("D3").style.display ="none";
             document.getElementById("D4").style.display ="block";
     /*if (document.getElementById("columnchart_material_4").style.display == 'block'){
             document.getElementById("columnchart_material_4").style.marginTop ="-50px";
             document.getElementById("relat_tipo_det1").style.marginTop ="-50px";
         }
     if (document.getElementById("relat_tipo_table").style.display == 'block'){
             document.getElementById("relat_tipo_table").style.marginTop ="-50px";             
         } */
          }

function optionCheck4(){
  document.getElementById("button_sit1").focus();
            document.getElementById("columnchart_material_3").style.display ="block";
            document.getElementById("relat_sit_table").style.display ="none";    
            document.getElementById("D3").style.display ="block";
             document.getElementById("D4").style.display ="none";
           //  document.getElementById("columnchart_material_4").style.marginTop ="0px";
            // document.getElementById("relat_tipo_det1").style.marginTop ="5px";
            /*if (document.getElementById("relat_tipo_table").style.display == 'block'){
             document.getElementById("relat_tipo_table").style.marginTop ="0px";             
         }  */ 
          }


function optionCheck5(){

            document.getElementById("columnchart_material_4").style.display ="none";
            document.getElementById("relat_tipo_table").style.display ="block";    
            document.getElementById("D5").style.display ="none";
             document.getElementById("D6").style.display ="block";      

          }

function optionCheck6(){
            document.getElementById("columnchart_material_4").style.display ="block";
            document.getElementById("relat_tipo_table").style.display ="none";    
            document.getElementById("D5").style.display ="block";
             document.getElementById("D6").style.display ="none";         
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

 

  <section id="corpo_meio_relat_uc">
            <nav class="navbar navbar-dark" style="background-color: #B43104;">
  <a class="navbar-brand" id="title01" href="http://10.68.14.67/novosicob/tratrec_load.php">
    <div class="h4"> Relatório UC Sem Medidor </div>
  </a>
</nav>
      <div class="container-fluid">
  <div id="barchart_material" style="width: 88%; height: 30em; margin-left: 5%; margin-top: 3%"></div><br/>

    <div class='tab_title' style="margin-left: 3%;">Total  <?php echo "$qtd_total_result"; ?></div><br/><br/>

  <div id="columnchart_material_2" style="width: 88%; height: 23em; margin-left: 5%; margin-top: 3% visibility: visible; position: relative;"><br/><br/><r/></div>

<div id="piechart" style="width: 86%; height: 23em; margin-left: 8%; visibility: hidden; position: absolute;"><br/><br/><r/></div>



  <div id="D1" style="display:block;"><p align="left"> <button type="button"  style="margin-left: 8%;" 
    id="button_class1" class="btn btn-primary" onClick="optionCheck1()">Veja detalhes do mês atual </button>
</p></div>

  <div id="D2" tabindex="0" style="display:none; "><p align="left">  <button type="button" style="margin-left: 8%;"
    id="button_class2" class="btn btn-primary" onClick="optionCheck2()">Veja comparação entre os últimos meses</button>
</p></div>
<br/><br/>

<div class="left" style="float: left; width: 40%; margin-left: 3%;">

<div id="columnchart_material_3" style="width: 100%; height: 23em; float: left; margin-left: 5%; display:block;"><br/><br/><r/></div>

<div id="D3" style="display:block; clear: both; "><p class="relat_sit_det1"><button type="button" style="margin-left: 8%; margin-top: 1%;" 
  class="btn btn-primary" id="button_sit1" onClick="optionCheck3()">Veja detalhes do mês atual</button>
</p></div>

<div id="relat_sit_table" style="display:none;">
  <div class='tab_title' style="margin-left: 3%;">Situa&ccedil;&atilde;o UC Sem Medidor <?php echo "($mees/$anoo)"; ?></div>
    <div id='table_div_estilo2' style="width: 100%; margin-left: 8%;"><br/>
      <div id='table_div3' ></div></div><br/>
</div>

<div id="D4" style="display:none"><p class="relat_sit_det2"> <button type="button" style="margin-left: 8%;" 
  class="btn btn-primary"  id="button_sit2" onClick="optionCheck4()">Veja comparação entre os últimos meses </button>
</p></div>
</div>

<div class="right" style="float: left; width: 40%; margin-left: 10%;">
<!-- Gráfico em colunas referente a tipo medição UC Sem Medidor -->
<div id="columnchart_material_4" style="width: 100%; height: 23em; float: right;  margin-top: 0px; display:block;"><br/><br/><r/></div>

<div id="D5" style="display:block; clear: both; float: left; margin-top: 25%; margin-left: 3%; position: absolute;"><p class="relat_tipo_det1">  <button type="button" style=" width: 100%; " class="btn btn-primary" id="button_tipo1" onClick="optionCheck5()">Veja detalhes do mês atual</button></p></div>

<div id="relat_tipo_table" style="display:none;">
<div class='tab_title'>Tipo de Medição UC Sem Medidor <?php echo "($mees/$anoo)"; ?></div>
    <div id='table_div_estilo2' style="width: 100%; margin-right: 3%;"><br/>
      <div id='table_div4'></div></div>
</div>

<div id="D6" style="display:none; margin-top: 1%; margin-left: 0%; position: absolute;"><p class="relat_tipo_det2">  <button type="button" style=" width: 100%; " class="btn btn-primary" id="button_tipo2" onClick="optionCheck6()">Veja comparação entre os últimos meses</button>
</p></div>

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
<li class=""><a title="youtube" target="_blank" href="https://www.youtube.com/"><img alt="youtube" width="30" height="30" src="data:image/png;base64,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"></a></li>
<li class=""><a href="https://www.facebook.com/richard.palmas" target="_blank" title="Facebook"><img alt="Facebook" width="30" height="30" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAAKT2lDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVNnVFPpFj333vRCS4iAlEtvUhUIIFJCi4AUkSYqIQkQSoghodkVUcERRUUEG8igiAOOjoCMFVEsDIoK2AfkIaKOg6OIisr74Xuja9a89+bN/rXXPues852zzwfACAyWSDNRNYAMqUIeEeCDx8TG4eQuQIEKJHAAEAizZCFz/SMBAPh+PDwrIsAHvgABeNMLCADATZvAMByH/w/qQplcAYCEAcB0kThLCIAUAEB6jkKmAEBGAYCdmCZTAKAEAGDLY2LjAFAtAGAnf+bTAICd+Jl7AQBblCEVAaCRACATZYhEAGg7AKzPVopFAFgwABRmS8Q5ANgtADBJV2ZIALC3AMDOEAuyAAgMADBRiIUpAAR7AGDIIyN4AISZABRG8lc88SuuEOcqAAB4mbI8uSQ5RYFbCC1xB1dXLh4ozkkXKxQ2YQJhmkAuwnmZGTKBNA/g88wAAKCRFRHgg/P9eM4Ors7ONo62Dl8t6r8G/yJiYuP+5c+rcEAAAOF0ftH+LC+zGoA7BoBt/qIl7gRoXgugdfeLZrIPQLUAoOnaV/Nw+H48PEWhkLnZ2eXk5NhKxEJbYcpXff5nwl/AV/1s+X48/Pf14L7iJIEyXYFHBPjgwsz0TKUcz5IJhGLc5o9H/LcL//wd0yLESWK5WCoU41EScY5EmozzMqUiiUKSKcUl0v9k4t8s+wM+3zUAsGo+AXuRLahdYwP2SycQWHTA4vcAAPK7b8HUKAgDgGiD4c93/+8//UegJQCAZkmScQAAXkQkLlTKsz/HCAAARKCBKrBBG/TBGCzABhzBBdzBC/xgNoRCJMTCQhBCCmSAHHJgKayCQiiGzbAdKmAv1EAdNMBRaIaTcA4uwlW4Dj1wD/phCJ7BKLyBCQRByAgTYSHaiAFiilgjjggXmYX4IcFIBBKLJCDJiBRRIkuRNUgxUopUIFVIHfI9cgI5h1xGupE7yAAygvyGvEcxlIGyUT3UDLVDuag3GoRGogvQZHQxmo8WoJvQcrQaPYw2oefQq2gP2o8+Q8cwwOgYBzPEbDAuxsNCsTgsCZNjy7EirAyrxhqwVqwDu4n1Y8+xdwQSgUXACTYEd0IgYR5BSFhMWE7YSKggHCQ0EdoJNwkDhFHCJyKTqEu0JroR+cQYYjIxh1hILCPWEo8TLxB7iEPENyQSiUMyJ7mQAkmxpFTSEtJG0m5SI+ksqZs0SBojk8naZGuyBzmULCAryIXkneTD5DPkG+Qh8lsKnWJAcaT4U+IoUspqShnlEOU05QZlmDJBVaOaUt2ooVQRNY9aQq2htlKvUYeoEzR1mjnNgxZJS6WtopXTGmgXaPdpr+h0uhHdlR5Ol9BX0svpR+iX6AP0dwwNhhWDx4hnKBmbGAcYZxl3GK+YTKYZ04sZx1QwNzHrmOeZD5lvVVgqtip8FZHKCpVKlSaVGyovVKmqpqreqgtV81XLVI+pXlN9rkZVM1PjqQnUlqtVqp1Q61MbU2epO6iHqmeob1Q/pH5Z/YkGWcNMw09DpFGgsV/jvMYgC2MZs3gsIWsNq4Z1gTXEJrHN2Xx2KruY/R27iz2qqaE5QzNKM1ezUvOUZj8H45hx+Jx0TgnnKKeX836K3hTvKeIpG6Y0TLkxZVxrqpaXllirSKtRq0frvTau7aedpr1Fu1n7gQ5Bx0onXCdHZ4/OBZ3nU9lT3acKpxZNPTr1ri6qa6UbobtEd79up+6Ynr5egJ5Mb6feeb3n+hx9L/1U/W36p/VHDFgGswwkBtsMzhg8xTVxbzwdL8fb8VFDXcNAQ6VhlWGX4YSRudE8o9VGjUYPjGnGXOMk423GbcajJgYmISZLTepN7ppSTbmmKaY7TDtMx83MzaLN1pk1mz0x1zLnm+eb15vft2BaeFostqi2uGVJsuRaplnutrxuhVo5WaVYVVpds0atna0l1rutu6cRp7lOk06rntZnw7Dxtsm2qbcZsOXYBtuutm22fWFnYhdnt8Wuw+6TvZN9un2N/T0HDYfZDqsdWh1+c7RyFDpWOt6azpzuP33F9JbpL2dYzxDP2DPjthPLKcRpnVOb00dnF2e5c4PziIuJS4LLLpc+Lpsbxt3IveRKdPVxXeF60vWdm7Obwu2o26/uNu5p7ofcn8w0nymeWTNz0MPIQ+BR5dE/C5+VMGvfrH5PQ0+BZ7XnIy9jL5FXrdewt6V3qvdh7xc+9j5yn+M+4zw33jLeWV/MN8C3yLfLT8Nvnl+F30N/I/9k/3r/0QCngCUBZwOJgUGBWwL7+Hp8Ib+OPzrbZfay2e1BjKC5QRVBj4KtguXBrSFoyOyQrSH355jOkc5pDoVQfujW0Adh5mGLw34MJ4WHhVeGP45wiFga0TGXNXfR3ENz30T6RJZE3ptnMU85ry1KNSo+qi5qPNo3ujS6P8YuZlnM1VidWElsSxw5LiquNm5svt/87fOH4p3iC+N7F5gvyF1weaHOwvSFpxapLhIsOpZATIhOOJTwQRAqqBaMJfITdyWOCnnCHcJnIi/RNtGI2ENcKh5O8kgqTXqS7JG8NXkkxTOlLOW5hCepkLxMDUzdmzqeFpp2IG0yPTq9MYOSkZBxQqohTZO2Z+pn5mZ2y6xlhbL+xW6Lty8elQfJa7OQrAVZLQq2QqboVFoo1yoHsmdlV2a/zYnKOZarnivN7cyzytuQN5zvn//tEsIS4ZK2pYZLVy0dWOa9rGo5sjxxedsK4xUFK4ZWBqw8uIq2Km3VT6vtV5eufr0mek1rgV7ByoLBtQFr6wtVCuWFfevc1+1dT1gvWd+1YfqGnRs+FYmKrhTbF5cVf9go3HjlG4dvyr+Z3JS0qavEuWTPZtJm6ebeLZ5bDpaql+aXDm4N2dq0Dd9WtO319kXbL5fNKNu7g7ZDuaO/PLi8ZafJzs07P1SkVPRU+lQ27tLdtWHX+G7R7ht7vPY07NXbW7z3/T7JvttVAVVN1WbVZftJ+7P3P66Jqun4lvttXa1ObXHtxwPSA/0HIw6217nU1R3SPVRSj9Yr60cOxx++/p3vdy0NNg1VjZzG4iNwRHnk6fcJ3/ceDTradox7rOEH0x92HWcdL2pCmvKaRptTmvtbYlu6T8w+0dbq3nr8R9sfD5w0PFl5SvNUyWna6YLTk2fyz4ydlZ19fi753GDborZ752PO32oPb++6EHTh0kX/i+c7vDvOXPK4dPKy2+UTV7hXmq86X23qdOo8/pPTT8e7nLuarrlca7nuer21e2b36RueN87d9L158Rb/1tWeOT3dvfN6b/fF9/XfFt1+cif9zsu72Xcn7q28T7xf9EDtQdlD3YfVP1v+3Njv3H9qwHeg89HcR/cGhYPP/pH1jw9DBY+Zj8uGDYbrnjg+OTniP3L96fynQ89kzyaeF/6i/suuFxYvfvjV69fO0ZjRoZfyl5O/bXyl/erA6xmv28bCxh6+yXgzMV70VvvtwXfcdx3vo98PT+R8IH8o/2j5sfVT0Kf7kxmTk/8EA5jz/GMzLdsAAAAgY0hSTQAAeiUAAICDAAD5/wAAgOkAAHUwAADqYAAAOpgAABdvkl/FRgAAAX1JREFUeNrs1jFrFFEQB/DfeWpCMFVMkaQIsRG1SWORb6DGKkUgpE6qJNiIH0YQFAtFUFKnEC1iY6XBq64SixCwkEvIEXNjM8ISBPe8W6/IDQzLezM7/7fzZv6ztYgwCLlgQDIw4Is9vDuJe5jHKDoI7GC7KuAxbOAu2gl6iimMVAU8htcJ9AANtHCCLdyvKtWbWRt3CnvXcAu3y9ZNt8B1LOFhYe8R1rGXWXhVKlJEdKNzEbEbERO5vh4RzYi42WWcrttpFMc4LKS4gS9VtNMyFvPuZhK8nbYjLOB5rtt4ivd/C1orQZk7WbEv8qANfEjblTzUePqs4WNWe89fHHiHZ3+wtfCysJ7PAuwLZX7L/vycupusBTfwqWBbwdd+3fEmJtL3Et7gKg4wm/e8mr4n2O8XcCv1t/zI9Euq/I5m1dPpMmr9mHDnbx4PgctK58zzvwDXC+xUL8tUvc7jn6mPs3+nyzJVr8AdPElO7iSdvv0X4Nrwh34IXJX8GgCPbKxZUJtpYgAAAABJRU5ErkJggg=="></a></li>
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