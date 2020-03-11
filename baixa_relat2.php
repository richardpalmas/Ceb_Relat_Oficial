<?php require("main3.php");
$x = 'Baixar Relatório de Corte'; 
include 'criarlog.php';
  
	  
$contador = array();

$contador[dj][total]=0;

$contador[cv][total]=0;

$contador[at][total]=0;


$contador[dj][total_full]=0;

$contador[cv][total_full]=0;

$contador[at][total_full]=0;

$dj = array();
$cv = array();
$at = array();

$mees = substr($_GET["ano"], 0, -5);
$anoo = substr($_GET["ano"], -4);
$ihh = date('t', mktime(0, 0, 0, $mees, '01', $anoo )); 




/*somatorio geral*/
	
$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and SIT IN ('Concluída', 'Concluída com Impedimento', 'Concluída com Inconsistência', 'Concluída por Tempo')";
$resultado = mysql_query($sql);
$contador[dj][total] = mysql_result($resultado, 0);	
if ($contador[dj][total] == null) { $contador[dj][total] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and SIT IN ('Concluída', 'Concluída com Impedimento', 'Concluída com Inconsistência', 'Concluída por Tempo')";
$resultado = mysql_query($sql);
$contador[cv][total] = mysql_result($resultado, 0);	
if ($contador[cv][total] == null) { $contador[cv][total] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and SIT IN ('Concluída', 'Concluída com Impedimento', 'Concluída com Inconsistência', 'Concluída por Tempo')";
$resultado = mysql_query($sql);
$contador[at][total] = mysql_result($resultado, 0);						
if ($contador[at][total] == null){ $contador[at][total] = "0";}


$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and SIT IN ('Concluída', 'Concluída com Impedimento', 'Concluída com Inconsistência', 'Concluída por Tempo')";
$resultado = mysql_query($sql);
$contador[dj][total_fulll] = mysql_result($resultado, 0);	
if ($contador[dj][total_fulll] == null){ $contador[dj][total_fulll] = "0";}


$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and SIT IN ('Despachada', 'Gerada', 'Cancelada', 'Aguardando Despacho', 'Em Execução')";
$resultado = mysql_query($sql);
$contador[dj][total_fullx] = mysql_result($resultado, 0);	
if ($contador[dj][total_fullx] == null){ $contador[dj][total_fullx] = "0";}


$contador[dj][total_full] = $contador[dj][total_fulll]+$contador[dj][total_fullx];



$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and SIT IN ('Concluída', 'Concluída com Impedimento', 'Concluída com Inconsistência', 'Concluída por Tempo')";
$resultado = mysql_query($sql);
$contador[cv][total_fulll] = mysql_result($resultado, 0);	
if ($contador[cv][total_fulll] == null){ $contador[cv][total_fulll] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and SIT IN ('Despachada', 'Gerada', 'Cancelada', 'Aguardando Despacho', 'Em Execução')";
$resultado = mysql_query($sql);
$contador[cv][total_fullll] = mysql_result($resultado, 0);	
if ($contador[cv][total_fullll] == null){ $contador[cv][total_fullll] = "0";}

$contador[cv][total_full] = $contador[cv][total_fulll]+$contador[cv][total_fullll];




$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and SIT IN ('Concluída', 'Concluída com Impedimento', 'Concluída com Inconsistência', 'Concluída por Tempo')";
$resultado = mysql_query($sql);
$contador[at][total_fulll] = mysql_result($resultado, 0);	
if ($contador[at][total_fulll] == null){ $contador[at][total_fulll] = "0";}	

$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and SIT IN ('Despachada', 'Gerada', 'Cancelada', 'Aguardando Despacho', 'Em Execução')";
$resultado = mysql_query($sql);
$contador[at][total_fullll] = mysql_result($resultado, 0);
if ($contador[at][total_fullll] == null){ $contador[at][total_fullll] = "0";}	


$contador[at][total_full] = $contador[at][total_fullll]+$contador[at][total_fulll];



/* 31 dias de levantamento para as concluidas no DJ - BT */

$i=1;
while ($i <=$ihh) {


$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and `sit` = 'Concluída'";
$resultado = mysql_query($sql);
$dj[concluida][$i] = mysql_result($resultado, 0);	
if ($dj[concluida][$i] == null){ $dj[concluida][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and `sit` = 'Aguardando Despacho'";
$resultado = mysql_query($sql);
$dj[agdespacho][$i] = mysql_result($resultado, 0);	
if ($dj[agdespacho][$i] == null){ $dj[agdespacho][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and `sit` = 'Cancelada'";
$resultado = mysql_query($sql);
$dj[cancelada][$i] = mysql_result($resultado, 0);	
if ($dj[cancelada][$i] == null){ $dj[cancelada][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and `sit` = 'Concluída com Impedimento'";
$resultado = mysql_query($sql);
$dj[concluidaimpedimento][$i] = mysql_result($resultado, 0);
if ($dj[concluidaimpedimento][$i] == null){ $dj[concluidaimpedimento][$i] = "0";}
	
$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and `sit` = 'Concluída com Inconsistência'";
$resultado = mysql_query($sql);
$dj[concluidainconsistencia][$i] = mysql_result($resultado, 0);
if ($dj[concluidainconsistencia][$i] == null){ $dj[concluidainconsistencia][$i] = "0";}
	
$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and `sit` = 'Concluída por Tempo'";
$resultado = mysql_query($sql);
$dj[concluidaportempo][$i] = mysql_result($resultado, 0);	
if ($dj[concluidaportempo][$i] == null){ $dj[concluidaportempo][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and `sit` = 'Despachada'";
$resultado = mysql_query($sql);
$dj[despachada][$i] = mysql_result($resultado, 0);
if ($dj[despachada][$i] == null){ $dj[despachada][$i] = "0";}


$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and `sit` = 'Gerada'";
$resultado = mysql_query($sql);
$dj[gerada][$i] = mysql_result($resultado, 0);	
if ($dj[gerada][$i] == null){ $dj[gerada][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and `tiposerv` = 'DESLIGAMENTO UC BT URBANO NO DISJUNTOR' and `sit` = 'Em Execução'";
$resultado = mysql_query($sql);
$dj[execucao][$i] = mysql_result($resultado, 0);
if ($dj[execucao][$i] == null){ $dj[execucao][$i] = "0";}		

/* 31 dias de levantamento para as concluidas no CV */

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and `sit` = 'Concluída'";
$resultado = mysql_query($sql);
$cv[concluida][$i] = mysql_result($resultado, 0);	
if ($cv[concluida][$i] == null){ $cv[concluida][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and `sit` = 'Aguardando Despacho'";
$resultado = mysql_query($sql);
$cv[agdespacho][$i] = mysql_result($resultado, 0);	
if ($cv[agdespacho][$i] == null){ $cv[agdespacho][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and `sit` = 'Cancelada'";
$resultado = mysql_query($sql);
$cv[cancelada][$i] = mysql_result($resultado, 0);	
if ($cv[cancelada][$i] == null){ $cv[cancelada][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and `sit` = 'Concluída com Impedimento'";
$resultado = mysql_query($sql);
$cv[concluidaimpedimento][$i] = mysql_result($resultado, 0);
if ($cv[concluidaimpedimento][$i] == null){ $cv[concluidaimpedimento][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and `sit` = 'Concluída com Inconsistência'";
$resultado = mysql_query($sql);
$cv[concluidainconsistencia][$i] = mysql_result($resultado, 0);
if ($cv[concluidainconsistencia][$i] == null){ $cv[concluidainconsistencia][$i] = "0";}
	
$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and `sit` = 'Concluída por Tempo'";
$resultado = mysql_query($sql);
$cv[concluidaportempo][$i] = mysql_result($resultado, 0);	
if ($cv[concluidaportempo][$i] == null){ $cv[concluidaportempo][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and `sit` = 'Despachada'";
$resultado = mysql_query($sql);
$cv[despachada][$i] = mysql_result($resultado, 0);
if ($cv[despachada][$i] == null){ $cv[despachada][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and `sit` = 'Gerada'";
$resultado = mysql_query($sql);
$cv[gerada][$i] = mysql_result($resultado, 0);	
if ($cv[gerada][$i] == null){ $cv[gerada][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC BAIXA TENSÃO', 'DESLIGAMENTO UC RURAL BAIXA TENSÃO') and `sit` = 'Em Execução'";
$resultado = mysql_query($sql);
$cv[execucao][$i] = mysql_result($resultado, 0);		
if ($cv[execucao][$i] == null){ $cv[execucao][$i] = "0";}

/* 31 dias de levantamento para as concluidas no AT */

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and `sit` = 'Concluída'";
$resultado = mysql_query($sql);
$at[concluida][$i] = mysql_result($resultado, 0);	
if ($at[concluida][$i] == null){ $at[concluida][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and `sit` = 'Aguardando Despacho'";
$resultado = mysql_query($sql);
$at[agdespacho][$i] = mysql_result($resultado, 0);	
if ($at[agdespacho][$i] == null){ $at[agdespacho][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and `sit` = 'Cancelada'";
$resultado = mysql_query($sql);
$at[cancelada][$i] = mysql_result($resultado, 0);
if ($at[cancelada][$i] == null){ $at[cancelada][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and `sit` = 'Concluída com Impedimento'";
$resultado = mysql_query($sql);
$at[concluidaimpedimento][$i] = mysql_result($resultado, 0);
if ($at[concluidaimpedimento][$i] == null){ $at[concluidaimpedimento][$i] = "0";}
	
$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and `sit` = 'Concluída com Inconsistência'";
$resultado = mysql_query($sql);
$at[concluidainconsistencia][$i] = mysql_result($resultado, 0);
if ($at[concluidainconsistencia][$i] == null){ $at[concluidainconsistencia][$i] = "0";}
	
$sql = "SELECT sum(qtd) from corte where year(dataconc) = $anoo and month(dataconc) = $mees and day(dataconc) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and `sit` = 'Concluída por Tempo'";
$resultado = mysql_query($sql);
$at[concluidaportempo][$i] = mysql_result($resultado, 0);	
if ($at[concluidaportempo][$i] == null){ $at[concluidaportempo][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and `sit` = 'Despachada'";
$resultado = mysql_query($sql);
$at[despachada][$i] = mysql_result($resultado, 0);
if ($at[despachada][$i] == null){ $at[despachada][$i] = "0";}

$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and `sit` = 'Gerada'";
$resultado = mysql_query($sql);
$at[gerada][$i] = mysql_result($resultado, 0);	
if ($at[gerada][$i] == null){ $at[gerada][$i] = "0";}	
	
	$sql = "SELECT sum(qtd) from corte where year(dataabert) = $anoo and month(dataabert) = $mees and day(dataabert) = $i and TIPOSERV IN ('DESLIGAMENTO DE UC GRANDES CLIENTES', 'DESLIGAMENTO UC RURAL GRANDES CLIENTES') and `sit` = 'Em Execução'";
$resultado = mysql_query($sql);
$at[execucao][$i] = mysql_result($resultado, 0);	
if ($at[execucao][$i] == null){ $at[execucao][$i] = "0";}	

	$i++;
}	
	
$soma_tot = $contador[dj][total]+$contador[cv][total]+$contador[at][total];

$ixb=1;
		  for($i=0;$i<1;$i++){   
$html[$i] = "";
    $html[$i] .= "<table>";
    $html[$i] .= "<tr bgcolor=\"YELLOW\">";
    $html[$i] .= "<td><b>TIPO DE SUSPENSAO - $mees/$anoo</b></td>";
	$html[$i] .= "</tr>";
	 $html[$i] .= "<tr>";
    $html[$i] .= "<td></td>";

	while($ixb<=$ihh) {
		    $html[$i] .= "<td><b>$ixb/$mees</b></td>";
	   $ixb++;
	}
	 $html[$i] .= "<td><b>Total</b></td>";
    $html[$i] .= "</tr>";
    $html[$i] .= "</table>";
}
 
$i=1;
$ixb=1;
		  for($i=0;$i<1;$i++){  
		  $html[$i] .= "<table>";
	$html[$i] .= "<tr>";
    $html[$i] .= "<td>Corte no Disjuntor</td>";
			while($ixb <= $ihh){  
				$dj_concluidas = $dj[concluida][$ixb]+$dj[concluidaimpedimento][$ixb]+$dj[concluidaportempo][$ixb]+$dj[concluidainconsistencia][$ixb];
    $html[$i] .= "<td>$dj_concluidas</td>";
	$ixb++;
			}
					$dj_t = $contador[dj][total];
			$html[$i] .= "<td>$dj_t</td>";
			$html[$i] .= "</tr>";
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Corte Convencional</td>";
	$ixb=1;
			while($ixb <= $ihh){  
				$cv_concluidas = $cv[concluida][$ixb]+$cv[concluidaimpedimento][$ixb]+$cv[concluidaportempo][$ixb]+$cv[concluidainconsistencia][$ixb];
    $html[$i] .= "<td>$cv_concluidas</td>";
	$ixb++;
			}
			$cv_t = $contador[cv][total];
			$html[$i] .= "<td>$cv_t</td>";
			$html[$i] .= "</tr>";
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Corte AT</td>";
	$ixb=1;
			while($ixb <= $ihh){  
				$at_concluidas = $at[concluida][$ixb]+$at[concluidaimpedimento][$ixb]+$at[concluidaportempo][$ixb]+$at[concluidainconsistencia][$ixb];
    $html[$i] .= "<td>$at_concluidas</td>";
	$ixb++;
			}
			$at_t = $contador[at][total];
			$html[$i] .= "<td>$at_t</td>";
			$html[$i] .= "</tr>";
			
			
			
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td><b>Total Geral</b></td>";
	$ixb=1;
			while($ixb <= $ihh){  
				$xxx = $cv[concluida][$ixb]+$cv[concluidaimpedimento][$ixb]+$cv[concluidaportempo][$ixb]+$cv[concluidainconsistencia][$ixb]+$dj[concluida][$ixb]+$dj[concluidaimpedimento][$ixb]+$dj[concluidaportempo][$ixb]+$dj[concluidainconsistencia][$ixb]+$at[concluida][$ixb]+$at[concluidaimpedimento][$ixb]+$at[concluidaportempo][$ixb]+$at[concluidainconsistencia][$ixb];
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$cv_t = $contador[cv][total]+$contador[dj][total]+$contador[at][total];
			$html[$i] .= "<td><b>$cv_t</b></td>";
			$html[$i] .= "</tr>";
   
			
						$html[$i] .= "<tr>";
    $html[$i] .= "<td>Concluidas s/ impedimento</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$at_concluidas = $at[concluida][$ixb]+$cv[concluida][$ixb]+$dj[concluida][$ixb];
    $html[$i] .= "<td>$at_concluidas</td>";
	$xxx = $dj[concluida][$ixb]+$cv[concluida][$ixb]+$at[concluida][$ixb];
				$calcular = $calcular + $xxx;
	$ixb++;
			}
			$at_t = $contador[at][total];
			$html[$i] .= "<td>$calcular</td>";
			$html[$i] .= "</tr>";
			
			

			
			
			
	
	 $html[$i] .= "<tr>";
    $html[$i] .= "<td></td>";
	$html[$i] .= "</tr>";
	$html[$i] .= "<tr bgcolor=\"YELLOW\">";
    $html[$i] .= "<td><b>DISJUNTOR</b></td>";
	
	$ixb=1;
	while($ixb<=$ihh) {
		    $html[$i] .= "<td bgcolor=\"WHITE\"><b>$ixb/$mees</b></td>";
	   $ixb++;
	}
	 $html[$i] .= "<td bgcolor=\"WHITE\"><b>Total</b></td>";
    $html[$i] .= "</tr>";
	 $html[$i] .= "<tr>";
    $html[$i] .= "<td>Aguardando Despacho</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $dj[agdespacho][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";

			
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Cancelada</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $dj[cancelada][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Concluida</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $dj[concluida][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
			
		$html[$i] .= "<tr>";
    $html[$i] .= "<td>Concluida com Impedimento</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $dj[concluidaimpedimento][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";	
			
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Concluida com Inconsistencia</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $dj[concluidainconsistencia][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Despachada</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $dj[despachada][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Em Execucao</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $dj[execucao][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Gerada</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $dj[gerada][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
	$html[$i] .= "<tr>";
    $html[$i] .= "<td><b>Total</b></td>";
	$ixb=1;
			while($ixb <= $ihh){  
				$xxx = $dj[agdespacho][$ixb]+$dj[cancelada][$ixb]+$dj[concluida][$ixb]+$dj[concluidaimpedimento][$ixb]+$dj[concluidainconsistencia][$ixb]+$dj[despachada][$ixb]+$dj[execucao][$ixb]+$dj[gerada][$ixb];
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$cv_t = $contador[dj][total_full];
			$html[$i] .= "<td><b>$cv_t</b></td>";
			$html[$i] .= "</tr>";
			
	


/****** CONVENCIONAL **********************/

 $html[$i] .= "<tr>";
    $html[$i] .= "<td></td>";
	$html[$i] .= "</tr>";
	$html[$i] .= "<tr bgcolor=\"YELLOW\">";
    $html[$i] .= "<td><b>CONVENCIONAL</b></td>";
	
	$ixb=1;
	while($ixb<=$ihh) {
		    $html[$i] .= "<td bgcolor=\"WHITE\"><b>$ixb/$mees</b></td>";
	   $ixb++;
	}
	 $html[$i] .= "<td bgcolor=\"WHITE\"><b>Total</b></td>";
    $html[$i] .= "</tr>";
	 $html[$i] .= "<tr>";
    $html[$i] .= "<td>Aguardando Despacho</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $cv[agdespacho][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";

			
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Cancelada</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $cv[cancelada][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Concluida</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $cv[concluida][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
			
		$html[$i] .= "<tr>";
    $html[$i] .= "<td>Concluida com Impedimento</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $cv[concluidaimpedimento][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";	
			
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Concluida com Inconsistencia</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $cv[concluidainconsistencia][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Despachada</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $cv[despachada][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Em Execucao</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $cv[execucao][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Gerada</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $cv[gerada][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
	$html[$i] .= "<tr>";
    $html[$i] .= "<td><b>Total</b></td>";
	$ixb=1;
			while($ixb <= $ihh){  
				$xxx = $cv[agdespacho][$ixb]+$cv[cancelada][$ixb]+$cv[concluida][$ixb]+$cv[concluidaimpedimento][$ixb]+$cv[concluidainconsistencia][$ixb]+$cv[despachada][$ixb]+$cv[execucao][$ixb]+$cv[gerada][$ixb];
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$cv_t = $contador[cv][total_full];
			$html[$i] .= "<td><b>$cv_t</b></td>";
			$html[$i] .= "</tr>";


/****** CONVENCIONAL_AT **********************/

 $html[$i] .= "<tr>";
    $html[$i] .= "<td></td>";
	$html[$i] .= "</tr>";
	$html[$i] .= "<tr bgcolor=\"YELLOW\">";
    $html[$i] .= "<td><b>CONVENCIONAL_AT</b></td>";
	
	$ixb=1;
	while($ixb<=$ihh) {
		    $html[$i] .= "<td bgcolor=\"WHITE\"><b>$ixb/$mees</b></td>";
	   $ixb++;
	}
	 $html[$i] .= "<td bgcolor=\"WHITE\"><b>Total</b></td>";
    $html[$i] .= "</tr>";
	 $html[$i] .= "<tr>";
    $html[$i] .= "<td>Aguardando Despacho</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $at[agdespacho][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";

			
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Cancelada</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $at[cancelada][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Concluida</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $at[concluida][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
			
		$html[$i] .= "<tr>";
    $html[$i] .= "<td>Concluida com Impedimento</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $at[concluidaimpedimento][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
				
			
			$html[$i] .= "</tr>";	
			
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Concluida com Inconsistencia</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $at[concluidainconsistencia][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Despachada</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $at[despachada][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Em Execucao</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $at[execucao][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
			$html[$i] .= "<tr>";
    $html[$i] .= "<td>Gerada</td>";
	$ixb=1;
	$calcular = 0;
			while($ixb <= $ihh){  
				$xxx = $at[gerada][$ixb];
				$calcular = $calcular + $xxx;
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$html[$i] .= "<td>$calcular</td>";
			

			$html[$i] .= "</tr>";
			
	$html[$i] .= "<tr>";
    $html[$i] .= "<td><b>Total</b></td>";
	$ixb=1;
			while($ixb <= $ihh){  
				$xxx = $at[agdespacho][$ixb]+$at[cancelada][$ixb]+$at[concluida][$ixb]+$at[concluidaimpedimento][$ixb]+$at[concluidainconsistencia][$ixb]+$at[despachada][$ixb]+$at[execucao][$ixb]+$at[gerada][$ixb];
    $html[$i] .= "<td><b>$xxx</b></td>";
	$ixb++;
			}
			$cv_t = $contador[at][total_full];
			$html[$i] .= "<td><b>$cv_t</b></td>";
			$html[$i] .= "</tr>";
	
	$html[$i] .= "<tr>";
    $html[$i] .= "<td></td>";
	$html[$i] .= "</tr>";
	$html[$i] .= "<tr bgcolor=\"YELLOW\">";
    $html[$i] .= "<td><b>Total Geral</b></td>";
	
	$ixb=1;
	while($ixb<=$ihh) {
				$xxx1 = $at[agdespacho][$ixb]+$at[cancelada][$ixb]+$at[concluida][$ixb]+$at[concluidaimpedimento][$ixb]+$at[concluidainconsistencia][$ixb]+$at[despachada][$ixb]+$at[execucao][$ixb]+$at[gerada][$ixb];
				$xxx2 = $cv[agdespacho][$ixb]+$cv[cancelada][$ixb]+$cv[concluida][$ixb]+$cv[concluidaimpedimento][$ixb]+$cv[concluidainconsistencia][$ixb]+$cv[despachada][$ixb]+$cv[execucao][$ixb]+$cv[gerada][$ixb];
				$xxx3 = $dj[agdespacho][$ixb]+$dj[cancelada][$ixb]+$dj[concluida][$ixb]+$dj[concluidaimpedimento][$ixb]+$dj[concluidainconsistencia][$ixb]+$dj[despachada][$ixb]+$dj[execucao][$ixb]+$dj[gerada][$ixb];
$xxx4 = $xxx1+$xxx2+$xxx3;
				$html[$i] .= "<td><b>$xxx4</b></td>";
	   $ixb++;
	}
$cv_t = $contador[at][total_full]+$contador[cv][total_full]+$contador[dj][total_full];
			$html[$i] .= "<td><b>$cv_t</b></td>";
			$html[$i] .= "</tr>";
	
	
	
	 $html[$i] .= "</table>";
						  }
		  


 
$arquivo = "Relat_Corte_$mees.$anoo.xls";
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename={$arquivo}" );
header ("Content-Description: PHP Generated Data" );
 
for($i=0;$i<=$ihh;$i++){  
    echo $html[$i];
}





?>
