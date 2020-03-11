<?php 
$x = 'Gerar Relatorio GS'; 
include 'criarlog.php';

//Faz a conexão com as seguintes páginas
//diautil é utilizada para auxiliar na contagem de dias uteis
//ferteste é utilizado para buscar informações sobre o feriado 
//remove_acento é utilizado para chamar a função de remção de acentos
require_once("diautil.php");
require_once("ferteste01.php");
require_once("remove_acento.php");


//função para chamar página responsável pela conexao ao banco de dados
require("main3.php"); 

//obter mês e ano do relatório 
$mes_relat = $_POST['mes_relat'];
$ano_relat = $_POST['ano_relat'];

//obtem o link atual da página de acesso
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

//aqui são os links esperados caso o sistema esteja no processo de 
//upload e geração de arquivos
$urlref = 'http://localhost/novosicob/relat_gs.php?upload=1';
$urlref2 = 'http://10.68.14.67/novosicob/relat_gs.php?upload=1';

//caso o sistema esteja em processo de upload faz-se:
if($url == $urlref || $url == $urlref2){ 

// Define-se os atributos para log no banco de dados como $nomeArquivo, 
 //$nomeUsuario, $dataInsert (data_da_ação) e então é feito o comando 
 //para que o log seja armazenado no banco de dados;

  $nomeArquivo = "Anexo III ART 32";

  $sql = "SELECT nome FROM usuarios WHERE login = '$matricula'";
$resultado = mysql_query($sql);
while($registro = mysql_fetch_array($resultado)){
      $nomeUsuario = $registro['nome'];
      } 

$dataInsert = date('Y-m-d H:i:s');

  $sql = "INSERT INTO uploads(id, nomeArquivo, NomeUsuario, dataInsert) VALUES ('', '$nomeArquivo', '$nomeUsuario', '$dataInsert')";

  $result = mysql_query($sql) or die(mysql_error());

//Ativa o buffer de saída através da função ob_start();
ob_start();

//Descarrega (envia) o conteúdo do buffer de saída através da função ob_flush;
  ob_flush();
//Cria uma array $test que irá ser usada mais tarde para armazenar o nome dos arquivos dentro da pasta raiz;
  $test = array();

  //Aqui cria-se ou reduz-se a zero a pasta que conterá todos os registros 
  //da pasta ANEXO_III_ART_32_MOD
  $arquivoi = fopen ("\\\\ntbkp01\Privado3\GPGC\\2019\BANCO_GPGC\ANEXO_III_ART_32_MOD\sap_base.csv", 'w');
  //fecha-se o documento sap_base
  fclose($arquivoi);

//Define quais erros serão reportados através da função error_reporting();  
  error_reporting(0);
  //Define o valor de uma opção de configuração através da função ini_set();
  ini_set(“display_errors”, 0 );


  //Cria-se uma variável de controle $i;  
  $i=1;
//É feita a leitura do nome de todos os arquivos que estão dentro da pasta 
//BASE_SAP com as funções FilesystemIterator e getFilename;
  $files = new FilesystemIterator('\\\\ntbkp01\Privado3\GPGC\\2019\BANCO_GPGC\ANEXO_III_ART_32\BASE_SAP\\\\');

  //Para cada um dos conteúdos/arquivos obtem-se o nome
      foreach($files as $file)
      {
        //cria-se um array que armazenará o nome do arquivo
        $test[$i++] = $file->getFilename();
        
      } 
  //var_dump($test);
  $data = array();
  //echo count($test);

//É criado uma variável de controle 
  $ii=1;

  //contador que será usado para os arrays dos documentos 
  //presentes na pasta ANEXO I 
  $ob=1;

  //enquanto ob for menor ou igual a quantidade de arquivos
  //presentes no array $test faça
  while ($ob <= count($test)) {
    
  //a variável $arquivos recebe o nome do primeiro arquivo 
  //armazenado na posição 1 do array $teste  
  $arquivos = $test[$ob];




  // Abre o documento armazenado em $arquivos no Modo r (para leitura)
  $arquivo = fopen ("\\\\ntbkp01\Privado3\GPGC\\2019\BANCO_GPGC\ANEXO_III_ART_32\BASE_SAP\\$arquivos", 'r');
  // Abre o documento base no Modo a (para escrita)
  //no final do processo esse documento irá ajuntar todos os registros
  //encontrados na
  $arquivoi = fopen ("\\\\ntbkp01\Privado3\GPGC\\2019\BANCO_GPGC\ANEXO_III_ART_32_MOD\sap_base.csv", 'a');

//Cria-se uma variável de controle chamada $ib;
  $ib = 1;

//Cria-se o array $arqc que será responsável pela separação de cada coluna dentro dos arquios
    $arqc = array();
 // Cria-se um loop while para ler cada linha do $arquivo até que se chegue ao seu
 // fim através da função !feof($arquivo) dentro deste loop cada linha é 
 //armazenada dentro do array $arqc[$ib] a função que obtém os dados de cada linha
 //é a fgets($arquivo, 30000) onde 30000 indica até quantas linhas deve-se ler;
    while(!feof($arquivo))
    {
      $arqc[$ib] = fgets($arquivo, 30000);
      $ib++;
      
    }
//Cria-se uma variável de controle chamada $ii;
    $ii=1;
//é criado um novo loop que irá ter como base a quantidade de linhas obtidas no 
//$arquivo pelo $arqc;
  while ($ii <= count($arqc)-1) {
//É criado uma condicional if que irá ignorar a primeira linha que é a linha dos 
//títulos e será executado sempre que a condição while anterior for atendida;
   if ($ii > 1) {
//É criado uma array chamada $converte_array que irá quebrar o resultado de cada
// linha com base nas divisões de ponto e vírgula que corresponde a separação de
// colunas;
    $converte_array = explode(";",$arqc[$ii]);
//É criado uma variável como o nome $text que armazenará todos os dados que constarão na linha;
  $text = "".$converte_array[06].";".$converte_array[38].";\n";
//É usada a função ‘fwrite’ para escrever a linha que foi armazenada dentro do arquivo aberto e armazenado em $arquivoi;
  fwrite($arquivoi, $text);

  }
  //São incremetandas as variáveis $ii e $ob com +1;
    $ii++;
  }

      $ob++;
  }
  //Fecha-se os arquivos $arquivoi e $arquivo com a função ‘fclose’;
  fclose($arquivoi);
  fclose($arquivo);

//Exclui-se os dados da tabela relat_sap com a função TRUNCATE TABLE;
  $query = "TRUNCATE TABLE relat_sap";
//O êxito da ação anterior é confirmada com a função mysqlquery();  
  $result = mysql_query($query) or die(mysql_error());
//Utiliza-se a variável $query para executar a função SQL que irá inserir os dados
// da planilha base dentro do banco de dados, Esta função é a LOAD DATA LOCAL 
//INFILE que irá procurar o arquivo através do seu diretório especificará quais 
//são as divisões que separam cada dado (FIELDS TERMINATED BY ‘;’)  depois se 
//especifica quais colunas que serão armazenados cada dado;
  $query = "LOAD DATA LOCAL INFILE '\\\\\\\\ntbkp01\\\\Privado3\\\\GPGC\\\\2019\\\\BANCO_GPGC\\\\ANEXO_III_ART_32_MOD\\\\sap_base.csv' INTO TABLE relat_sap FIELDS TERMINATED BY ';' ESCAPED BY '\\\\' LINES TERMINATED BY '\\n'(`prot`,`descricao`)";
  //Verifica-se o êxito da ação com a função mysql_query();
    $result = mysql_query($query) or die(mysql_error());
    //Deleta-se clientes que tenham seu código igual a zero;
    $query = "DELETE FROM tratrec WHERE prot = '0'";
    //Verifica-se o êxito da ação anterior;
    $result = mysql_query($query) or die(mysql_error());


ob_start();
 ob_flush();
  $test = array();

  error_reporting(0);
  ini_set(“display_errors”, 0 );


  //Visualiza o conteudo dentro da pasta BASE_GS
  $i=1;
  $files = new FilesystemIterator('\\\\ntbkp01\Privado3\GPGC\\2019\BANCO_GPGC\ANEXO_III_ART_32\BASE_GS\\\\');

  //Para cada um dos conteúdos/arquivos obtem-se o nome
      foreach($files as $file)
      {
        //cria-se um array que armazenará o nome do arquivo
        $test[$i++] = $file->getFilename();
        
      } 
  //var_dump($test);
  $data = array();
  //echo count($test);

  $ii=1;

  //contador que será usado para os arrays dos documentos 
  //presentes na pasta ANEXO I 
  $ob=1;

  //enquanto ob for menor ou igual a quantidade de arquivos
  //presentes no array $test faça
  while ($ob <= count($test)) {
    
  //a variável $arquivos2 recebe o nome do primeiro arquivo 
  //armazenado na posição 1 do array $teste  
      $arquivos2 = $test[$ob];


      $arquivo2 = fopen ("\\\\ntbkp01\Privado3\GPGC\\2019\BANCO_GPGC\ANEXO_III_ART_32\BASE_GS\\$arquivos2", 'r');
      // Abre o documento base no Modo a (para escrita)
      //no final do processo esse documento irá ajuntar todos os registros
      //encontrados na
      $arquivoj = fopen ("\\\\ntbkp01\Privado3\GPGC\\2019\BANCO_GPGC\ANEXO_III_ART_32_MOD\gs_base.csv", 'w');

//Cria-se uma variável de controle chamada $ib;
    $ib = 1;
//Cria-se o array $arqc que será responsável pela separação de cada coluna dentro 
//dos arquios
    $arqc = array();
//Cria-se um loop while para ler cada linha do $arquivo até que se chegue ao seu 
//fim através da função !feof($arquivo) dentro deste loop cada linha é armazenada 
//dentro do array $arqc[$ib] a função que obtém os dados de cada linha é a 
//fgets($arquivo, 30000) onde 30000 indica até quantas linhas deve-se ler;
    while(!feof($arquivo2))
        {
          $arqc[$ib] = fgets($arquivo2, 30000);
          $ib++;
          
        }


//Insere-se a primeira linha na planilha que conterá os títulos de cada coluna
  $ii=1;

      while ($ii <= 2) {
  //while ($ii <= count($arqc)-1) { 
    //obtem somente a linha nº1 da planilha
     //respectiva ao nome de cada coluna
  if ($ii > 0 && $ii < 2) {
 
  //É criado uma variável como o nome $text que armazenará todos os dados que 
  //constarão na linha;
  $text = "CLIENTE".";"."PROTOCOLO".";"."MATRICULA_ABERTURA".";"."MATRICULA_CONCLUSAO".";"."TIPO_SERVICO".";"."MOTIVO".";"."NUMERO_FASE".";"."PRIORIDADE".";"."SITUACAO".";"."ORGAO_GERADOR".";"."ORGAO_EXECUTOR".";"."DESCRICAO".";"."DATA_ABERTURA".";"."HORA_ABERTURA".";"."DATA_LIMITE".";"."HORA_LIMITE".";"."DATA_CONCLUSAO".";"."HORA_CONCLUSAO".";"."DURACAO_DIAS".";"."FORA_DO_PRAZO".";"."DIAS_ATRASO".";"."HORAS".";"."MONITORA".";"."DESCRICAO".";\n";
//Após isto é usado a função ‘fwrite’ para escrever a linha que foi armazenada
// dentro do arquivo aberto e armazenado em $arquivoj;
  fwrite($arquivoj, $text);
  }
  //É incremetanda a variável $ii
    $ii++;  

  }

//Cria-se uma variável de controle $ii;
    $ii=1;
//Cria-se novamente um loop while com a quantidade de linhas obtidas no arquivo de
// leitura $arquivo2;
    while ($ii <= count($arqc)-1) {
//Cria-se uma condicional IF onde para todas as linhas maiores do que um será executada;    
   if ($ii > 1) {
//É criado uma array chamada $converte_array que irá quebrar o resultado de cada 
//linha com base nas divisões de ponto e vírgula que corresponde a separação de 
//colunas;
    $converte_array = explode(";",$arqc[$ii]);
 
    //é retirado todos os espaços dos dados da coluna de situacao
    $sit = trim($converte_array[8]);    
    
    //é retirado todos os espaços dos dados da coluna de tipo
    $tipo = trim($converte_array[4]);    

  
//O sistema está apresentando problema para analisar os caracteres acentuados do
// campo $tipo e não obtive êxito em converter esses caracteres especiais em 
//caracteres comuns. Por esta razão é extraído para análise os 3 caracteres 
//localizados na posição 17 do campo $tipo2;
    $tipo2 = substr($tipo, 17, 3);    

//É criado uma condição que verifica se a variável $sit é diferente de “cancelada” 
//e “gerada” E se $tipo2 é igual aos caracteres “BTE” (PEDIDO PROJETO SUBTERRÂNEO)
//ou “REO” (PEDIDO PROJETO AÉREO);
 if (($sit != "Cancelada" && $sit != "Gerada") && ($tipo2 == "BTE" || $tipo2 == "REO")){
  //Armazena-se a data de abertura na variável $data_abert;
    $data_abert = $converte_array[12];
    //É feita a conversão de data de abertura para formato compatível com o banco 
    //de dados e o resultado é armazenado em $data_abert;
    $data_abert = implode("-",array_reverse(explode("/", $data_abert)));
    //Armazena-se a data de abertura na variável $data_limit;
    $data_limit = $converte_array[14];
    //É feita a conversão de data limit para formato compatível com o banco de 
    //dados e o resultado é armazenado em $data_limit;
    $data_limit = implode("-",array_reverse(explode("/", $data_limit)));
    //Armazena-se a data de conclusão na variável $data_conc;
    $data_conc = $converte_array[16];
    //É feita a conversão de data conclusão para formato compatível com o banco de
    // dados e o resultado é armazenado em $data_conc;
    $data_conc = implode("-",array_reverse(explode("/", $data_conc)));
    //É retirado todos os espaços do dado referente à coluna monitora  e seu valor é armazenado em $monit;
    $monit = trim($converte_array[22]);
    //O protocolo é extraído da planilha
    $prot = $converte_array[01];
    //O número do protocolo é reduzio para conter apenas 8 digitos
    $prot = substr($prot, 0, 8);
//É feita uma consulta ao banco de dados pelo campo ‘descricao’ na tabela
// relat_sap onde o protocolo seja igual a variável $prot e o resultado é 
//armazenado em $desc;
  $sql = "SELECT descricao FROM relat_sap WHERE prot = '$prot'";
  $result = mysql_query($sql);
  $registro = mysql_fetch_array($result);
  $desc = $registro['descricao'];
  $desc = trim($desc);

//É criado uma variável $text para armazenar os dados presentes em cada coluna;
  $text = "".$converte_array[0].";".$converte_array[1].";".$converte_array[2].";".$converte_array[3].";".$tipo.";".$converte_array[5].";".$converte_array[6].";".$converte_array[7].";".$sit.";".$converte_array[9].";".$converte_array[10].";".$converte_array[11].";".$data_abert.";".$converte_array[13].";".$data_limit.";".$converte_array[15].";".$data_conc.";".$converte_array[17].";".$converte_array[18].";".$converte_array[19].";".$converte_array[20].";".$converte_array[21].";".$monit.";".$desc.";\n";

  //É usado a função ‘fwrite’ para escrever a linha que foi armazenada dentro do 
  //arquivo aberto e armazenado em $arquivoj;

  fwrite($arquivoj, $text);

  }
}
    $ii++;

}
      $ob++;
  }

//fecha-se os arquivos $arquivoj e $arquivo2 com a função ‘fclose’;
  fclose($arquivoj);
  fclose($arquivo2);

//Exclui-se os dados da tabela anexo_iii_art_32 com a função TRUNCATE TABLE;
$query = "TRUNCATE TABLE anexo_iii_art_32";
//O êxito da ação anterior é confirmada com a função mysqlquery();
  $result = mysql_query($query) or die(mysql_error());

//Utiliza-se a variável $query para executar a função SQL que irá inserir os dados
// da planilha base dentro do banco de dados, Esta função é a LOAD DATA LOCAL 
//INFILE que irá procurar o arquivo através do seu diretório especificará quais 
//são as divisões que separam cada dado (FIELDS TERMINATED BY ‘;’)  depois se 
//especifica quais colunas que serão armazenados cada dado;
  $query = "LOAD DATA LOCAL INFILE '\\\\\\\\ntbkp01\\\\Privado3\\\\GPGC\\\\2019\\\\BANCO_GPGC\\\\ANEXO_III_ART_32_MOD\\\\gs_base.csv' INTO TABLE anexo_iii_art_32 FIELDS TERMINATED BY ';' ESCAPED BY '\\\\' LINES TERMINATED BY '\\n' IGNORE 1 LINES (`cli`,`prot`,`mat_abert`,`mat_conc`,`tipo_serv`,`mot`,`num_fase`,`prior`,`sit`,`org_ger`,`org_exe`,`desc`,`data_abert`,`hora_abert`,`data_limit`,`hora_limit`,`data_conc`,`hora_conc`,`dur_dias`,`fora_prz`,`dias_atr`,`horas`,`monit`,`descricao`)";
  //Verifica-se o êxito da ação com a função mysql_query();
    $result = mysql_query($query) or die(mysql_error());


//Abre-se o arquivo gs_base com a função fopen(‘’, r) que somente lerá o arquivo 
//e o armazena na variável $arquivo3;
$arquivo3 = fopen ("\\\\ntbkp01\Privado3\GPGC\\2019\BANCO_GPGC\ANEXO_III_ART_32_MOD\gs_base.csv", 'r');
//Abre-se o arquivo “... GS_Processo_1” com a função fopen(‘’, w) que abrirá o
// arquivo para a leitura e escrita reduzindo a zero e o armazena na variável 
//$arquivok; 
$arquivok = fopen ("\\\\ntbkp01\Privado3\GPGC\\2019\BANCO_GPGC\ANEXO_III_ART_32_MOD\ $mes_relat - $ano_relat GS_Processo_1 - $nomeUsuario.csv", 'w');
//Cria-se uma variável de controle chamada $ib;
$ib = 1;
//Cria-se o array $arqc que será responsável pela separação de cada coluna dentro dos arquivos
    $arqc = array();
   // Cria-se um loop while para ler cada linha do $arquivo até que se chegue ao 
   //seu fim através da função !feof($arquivo3) dentro deste loop cada linha é 
   //armazenada dentro do array $arqc[$ib] a função que obtém os dados de cada 
   //linha é a fgets($arquivo, 30000) onde 30000 indica até quantas linhas deve-se
   // ler;
    while(!feof($arquivo3))
    {
      $arqc[$ib] = fgets($arquivo3, 30000);
      $ib++;
      
    }

//Insere-se a primeira linha na planilha que conterá os títulos de cada coluna
  $ii=1;

      while ($ii <= 2) {
  //while ($ii <= count($arqc)-1) { 
    //obtem somente a linha nº1 da planilha
     //respectiva ao nome de cada coluna
  if ($ii > 0 && $ii < 2) {
 
  //separa as colunas da planilha excel
  //identidade de cada coluna 
  $text = "CLIENTE".";"."PROTOCOLO".";"."MATRICULA_ABERTURA".";"."MATRICULA_CONCLUSAO".";"."TIPO_SERVICO".";"."MOTIVO".";"."NUMERO_FASE".";"."PRIORIDADE".";"."SITUACAO".";"."ORGAO_GERADOR".";"."ORGAO_EXECUTOR".";"."DESCRICAO".";"."DATA_ABERTURA".";"."HORA_ABERTURA".";"."DATA_LIMITE".";"."HORA_LIMITE".";"."DATA_CONCLUSAO".";"."HORA_CONCLUSAO".";"."DURACAO_DIAS".";"."FORA_DO_PRAZO".";"."DIAS_ATRASO".";"."HORAS".";"."MONITORA".";"."DESCRICAO".";\n";
//É usado a função ‘fwrite’ para escrever a linha que foi armazenada dentro do 
//arquivo aberto e armazenado em $arquivok;
  fwrite($arquivok, $text);
  }

  //É incrementada a variável $ii
    $ii++;  

  }

//Cria-se uma variável de controle chamada $ii;
  $ii=1;

//Cria-se novamente um loop while com a quantidade de linhas obtidas no arquivo de
// leitura $arquivo3;
      while ($ii <= count($arqc)-1) {

//Cria-se uma condicional IF onde para todas as linhas maiores do que zero será
// executada;
  if ($ii > 0) {
//É criado uma array chamada $converte_array que irá quebrar o resultado de cada
// linha com base nas divisões de ponto e vírgula que corresponde a separação de
// colunas;
  $converte_array = explode(";",$arqc[$ii]);
//Armazena-se a data de conclusão na variável $data_conc;
  $data_conc = $converte_array[16];
//Extrai-se o ano da data de conclusão através da função substr() e o armazena na
// variável $ano_conc;
  $ano_conc = substr($data_conc, 0, 4);
//Extrai-se o mês da data de conclusão através da função substr() e o armazena na 
//variável $mes_conc;
  $mes_conc = substr($data_conc, 5, 2);
//Extrai-se a descrição e o armazena na variável $desc;
  $desc = $converte_array[23];
//Obtém-se o número do artigo presente na descrição através da função substr() 
//e o sobrescreve em $desc;
  $desc = substr($desc, 0, 11);

//É criado uma condição que verifica se $ano_conc (ano de conclusão) é igual ao 
//$ano_relat (ano informado pelo usuário), $mes_conc é igual a $mes_relat e $desc 
//igual a Artigo – 40 ou Artigo - 41 Artigo – 42;

 if (($ano_conc == $ano_relat) && ($mes_conc == $mes_relat) && ($desc == "Artigo - 40" || $desc == "Artigo - 41" || $desc == "Artigo - 42")){

//Armazena-se a data de abertura na variável $data_abert;
  $data_abert = $converte_array[12];
//É feita a conversão para fins comparativos da data de conclusão e 
//abertura com a função date_create;
    $dataConc = date_create($data_conc);
    $dataAbert = date_create($data_abert);
//É feito o cálculo entre data de abertura e conclusão através da função 
//date_diff e o resultado é armazenado em $intervalo; 
    $intervalo = date_diff($dataAbert, $dataConc);
 //É feito a conversão do resultado armazenado na variável $intervalo 
 //através da função format() e o resultado é armazenado em $dur_dias;
    $dur_dias = $intervalo->format('%R%a');

//Caso $dur_dias seja igual ou menor que 30 a variável $fora_prz vai ser igual a 
//“Nao” Caso seja maior $fora_prz será igual a “Sim”;

 if ($dur_dias <= 30){
    $fora_prz = "Nao";
  } else {
    $fora_prz = "Sim";
  }



//É criado uma variável $text para armazenar os dados presentes em cada coluna;
  $text = "".$converte_array[0].";".$converte_array[1].";".$converte_array[2].";".$converte_array[3].";".$converte_array[4].";".$converte_array[5].";".$converte_array[6].";".$converte_array[7].";".$converte_array[8].";".$converte_array[9].";".$converte_array[10].";".$converte_array[11].";".$converte_array[12].";".$converte_array[13].";".$converte_array[14].";".$converte_array[15].";".$converte_array[16].";".$converte_array[17].";".$dur_dias.";".$fora_prz.";".$converte_array[20].";".$converte_array[21].";".$converte_array[22].";".$converte_array[23].";\n";

  //Escrevem-se esses dados na planilha através da função fwrite;
  fwrite($arquivok, $text);
  

}

}
  //Incrementa-se a variável de controle $ii;
  $ii++;

}

//Fecham-se os arquivos $arquivo3 e $arquivok com a função ‘fclose’;

fclose($arquivo3);
  fclose($arquivok);

//Descarrega (envia) o buffer de saída e desativa o buffer de saída
  ob_end_flush(); 

 
 unlink( "\\\\ntbkp01\Privado3\GPGC\\2019\BANCO_GPGC\ANEXO_III_ART_32_MOD\sap_base.csv" );

 unlink( "\\\\ntbkp01\Privado3\GPGC\\2019\BANCO_GPGC\ANEXO_III_ART_32_MOD\gs_base.csv" );

//É feita um redirecionamento para mesma página enviando a mensagem 
//de sucesso para o endereço url;
  header('Location: relat_gs.php?success=1'); die;

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
  margin-left: 80px;  
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
  float: left;
     border:1px solid #2E9AFE;
      background:#2E9AFE;
      color:#ffffff;
      font-family:'Open Sans';
      font-size:15px;
      font-weight:bold;
      padding:6px 18px;
      margin-left: 5px;
      margin-top: 3px;
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
  var maximo = 100;
  var progresso = new Number();
  var progresso = 0;
  function startProgres(){

    document.getElementById("form1").style.display ="none";  
    document.getElementById("uploadingStatus").style.display ="block";        
    if((progresso + 1) < maximo){
      progresso = progresso + 1;
      document.getElementById("pg").value = progresso;
      setTimeout("startProgres();", 500);
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


   var maximo = new Number();  
  var maximo = 100;
  var progresso = new Number();
  var progresso = 0;
  function startProgres(){

    document.getElementById("form1").style.display ="none";  
    document.getElementById("uploadingStatus").style.display ="block";        
    if((progresso + 1) < maximo){
      progresso = progresso + 1;
      document.getElementById("pg").value = progresso;
      setTimeout("startProgres();", 500);
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
            <li class="nav-item"><a class="nav-link" id="font_config" href="http://10.68.14.67/novosicob/consulta.php">Pág. Inicial<span class="sr-only">(current)</span></a></li>   
           <li class="nav-item"><a class="nav-link" id="font_config" href="http://10.68.14.67/novosicob/anexoIII_leitura.php" tabindex="-1">Enviar Arquivo</a></li>
           <li class="nav-item"><a class="nav-link" id="link_ativo"  href="http://10.68.14.67/novosicob/gerar_relat.php">Gerar Arquivo</a></li>
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
                  <nav class="navbar navbar-dark" style="background-color: #A60202;">
  <a class="navbar-brand" id="title01" href="http://10.68.14.67/novosicob/gerar_relat.php">
    <div class="h4"> Anexo III Art. 32 </div>
  </a>
</nav>
      <div class="container-fluid">


        <div class="row">

           <div id="table03"  > 
                               

                    <?php if (empty($_GET['success'])){ ?>
                      <div id="lista">
                    <form action="relat_gs.php?upload=1" onsubmit="startProgres();"  method="post" enctype="multipart/form-data" name="form1" id="form1" > 
                     <p style="font-size:16px;"> Selecione a data referente ao relatório que se deseja emitir </p>  
                  <div id="lista2"><select id="ano" name="mes_relat" class="custom-select custom-select-sm col-sm-2" style=" clear:both; float:left; margin-left: 4px; margin-top:5px;" required>
  <option value="Ano"> </option>
  <option value="01">Jan</option>
  <option value="02">Fev</option>
  <option value="03">Mar</option>
  <option value="04">Abr</option>
  <option value="05">Mai</option>
  <option value="06">Jun</option>
  <option value="07">Jul</option>
  <option value="08">Ago</option>
  <option value="09">Set</option>
  <option value="10">Out</option>
  <option value="11">Nov</option>
  <option value="12">Dez</option>

</select>

   <select id="ano" name="ano_relat" class="custom-select custom-select-sm col-sm-2" style="  float:left; margin-left: 4px; margin-top:5px;" required>
  <option value="Ano"> </option>
  <option value="2017">2017</option>
  <option value="2018">2018</option>
  <option value="2019">2019</option>
  <option value="2020">2020</option>
  <option value="2021">2021</option>
</select>



          
  <input type="submit" name="Submit" id="Enviar" value="Enviar"/> 

</div>
  </form> <div id="uploadingStatus" style="display:none;"> <font id="fcarrega"> GERANDO RESULTADO! POR FAVOR, AGUARDE! </font> <div name="progConfig" id="progConfig" > <progress max="100" id="pg">                  </progress></div></div> <? }


if ($_GET['success']){ ?>

<b>Documento gerado com sucesso!</b>

<br/>
<a href="http://10.68.14.67/novosicob/relat_gs.php">Enviar novo Anexo III Art. 32</a>
<br/>
<br/>
<a href="C:\\ntbkp01\privado3\GPGC\2019\BANCO_GPGC\ANEXO_III_ART_32_MOD">Diretório: \\ntbkp01\privado3\GPGC\2019\BANCO_GPGC\ANEXO_III_ART_32_MOD</a>

<?php
$caminho = "\\\\\\ntbkp01\privado3\GPGC\\2019\BANCO_GPGC\ANEXO_III_ART_32_MOD";
exec('explorer.exe $caminho');
?>

<? } ?>                              
                                                                                       
                     



                                
               
                <table width="702" height="1" border="0" cellpadding="0" cellspacing="0"></table>
               
            
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