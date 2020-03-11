<?php
date_default_timezone_set('America/Belem');
 /**

* Função para calcular o próximo dia útil de uma data
* Formato de entrada da $data: AAAA-MM-DD
*/

function noSpecials($texto){
	/* função que gera uma texto limpo pra virar URL:
	- limpa acentos e transforma em letra normal
	- limpa cedilha e transforma em c normal, o mesmo com o ñ
	- transforma espaços em hifen (-)
	- tira caracteres invalidos
	by Micox - elmicox.blogspot.com - www.ievolutionweb.com
	*/
	//desconvertendo do padrão entitie (tipo á para á)
	
	$texto = trim(html_entity_decode($texto));
	
	//tirando os acentos
	$texto = preg_replace('![áàãâä]+!u','a',$texto);
	
	$texto= preg_replace('![éèêë]+!u','e',$texto);
	$texto= preg_replace('![íìîï]+!u','i',$texto);
	$texto= preg_replace('![óòõôö]+!u','o',$texto);
	$texto= preg_replace('![úùûü]+!u','u',$texto);
	//parte que tira o cedilha e o ñ
	$texto= preg_replace('![ç]+!u','c',$texto);
	$texto= preg_replace('![ñ]+!u','n',$texto);
	//tirando outros caracteres invalidos
	$texto= preg_replace('[^a-z0-9\-]','-',$texto);
	//tirando espaços
	$texto = str_replace(' ','-',$texto);
	//trocando duplo espaço (hifen) por 1 hifen só
	$texto = str_replace('--','-',$texto);

	return strtolower($texto);
}

function removeacento($no_prz2)
           {           		
           $from = 'ÀÁÃÂÉÊÍÓÕÔÚÜÇàáãâéêíóõôúüç? ';
           $to   = 'aaaaeeiooouucaaaaeeiooouuca-';
           return strtr($no_prz2, $from, $to);
           }


function proximoDiaUtil($data, $saida = 'Y-m-d') {
	// Converte $data em um UNIX TIMESTAMP
	$timestamp = strtotime($data);
	// Calcula qual o dia da semana de $data
	// O resultado será um valor numérico:
	// 1 -> Segunda ... 7 -> Domingo
	$dia = date('N', $timestamp);
	
	// Se for sábado (6) ou domingo (7), calcula a próxima segunda-feira
	if ($dia == 6) {
		$timestamp = strtotime("+2 days",strtotime($data));
		$timestamp_final = $timestamp;
		//$timestamp_final = $timestamp + ((8 - $dia) * 3600 * 24);
	}
	elseif ($dia == 7) {
		$timestamp = strtotime("+1 day",strtotime($data));
		$timestamp_final = $timestamp;
		//$timestamp_final = $timestamp + ((8 - $dia) * 3600 * 24);
	}
	
	else {
		// Não é sábado nem domingo, mantém a data de entrada
		$timestamp_final = $timestamp;
	}
	return date($saida, $timestamp_final);
	//echo proximoDiaUtil('2016-09-04');
}


function proximoDiaUtilPr($data, $saida = 'Y-m-d') {
	// Converte $data em um UNIX TIMESTAMP
	$timestamp = strtotime($data);
	// Calcula qual o dia da semana de $data
	// O resultado será um valor numérico:
	// 1 -> Segunda ... 7 -> Domingo
	$dia = date('N', $timestamp);

	if ($dia == 5) {
	$timestamp = strtotime("+3 days",strtotime($data));
	$timestamp_final = $timestamp;
	}
	// Se for sábado (6) ou domingo (7), calcula a próxima segunda-feira
	elseif ($dia == 6) {
		$timestamp = strtotime("+2 days",strtotime($data));
		$timestamp_final = $timestamp;
		//$timestamp_final = $timestamp + ((8 - $dia) * 3600 * 24);
	}
	
	else {
		// Não é sábado nem domingo, mantém a data de entrada
		$timestamp = strtotime("+1 day",strtotime($data));
		$timestamp_final = $timestamp;
		
	}
	return date($saida, $timestamp_final);
	//echo proximoDiaUtil('2016-09-04');
}


function proximoDiaCorridoPr($data, $saida = 'Y-m-d') {
	// Converte $data em um UNIX TIMESTAMP
	$timestamp = strtotime($data);
	// Calcula qual o dia da semana de $data
	// O resultado será um valor numérico:
	// 1 -> Segunda ... 7 -> Domingo
	$dia = date('N', $timestamp);

	// Calculando dias corridos
	$timestamp = strtotime("+1 day",strtotime($data));
	$timestamp_final = $timestamp;
		
	
	return date($saida, $timestamp_final);
	//echo proximoDiaUtil('2016-09-04');
}



function verificarposferiado($data, $saida = 'Y/m/d') {
	// Converte $data em um UNIX TIMESTAMP
	$timestamp = strtotime($data);
	// Calcula qual o dia da semana de $data
	// O resultado será um valor numérico:
	// 1 -> Segunda ... 7 -> Domingo
	$dia = date('N', $timestamp);
	
	// Se for sábado (6) ou domingo (7), calcula a próxima segunda-feira
	if ($dia == 6) {
		$timestamp = strtotime("+2 days",strtotime($data));
		$timestamp_final = $timestamp;
		//$timestamp_final = $timestamp + ((8 - $dia) * 3600 * 24);
	}
	elseif ($dia == 7) {
		$timestamp = strtotime("+1 day",strtotime($data));
		$timestamp_final = $timestamp;
		//$timestamp_final = $timestamp + ((8 - $dia) * 3600 * 24);
	}
	
	else {
		// Não é sábado nem domingo, mantém a data de entrada		
		$timestamp_final = $timestamp;
	}
	return date($saida, $timestamp_final);
	//echo proximoDiaUtil('2016-09-04');
}
 

function diasUteis($datainicial,$datafinal=null,$feriados=0){
if (!isset($datainicial)) return false;
if (!is_numeric($feriados)) $feriados = 0;
$segundos_datainicial = strtotime($datainicial);
if (!isset($datafinal)) $segundos_datafinal=time();
else $segundos_datafinal = strtotime($datafinal);
$dias = abs(floor(floor(($segundos_datafinal-$segundos_datainicial)/3600)/24 ) );
$uteis=0;
$confere_feriado = $datainicial;
for($i=0;$i<=$dias;$i++)

{




$diai = $segundos_datainicial+($i*3600*24);


$w = date('w', $diai);

if ($w > 0 && $w < 6){ 
	$uteis++; 

	$sql = "SELECT dat_ini FROM feriados WHERE dat_ini = '$confere_feriado'";
$result = mysql_query($sql);
$registro = mysql_fetch_array($result);
$ferdat = $registro['dat_ini'];

if (!empty($ferdat)){

$feriados++;

}


}

$confere_feriado = date('Y-m-d', strtotime("+1 day", strtotime($confere_feriado)));


}

if ($segundos_datafinal < $segundos_datainicial){
	$uteis = $uteis * -1;
	return ($uteis + ($feriados));

} else {
return ($uteis - ($feriados));
}
}

 
?>