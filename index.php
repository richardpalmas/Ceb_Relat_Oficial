<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<?php require("main.php"); ?>
<!DOCTYPE html>
<html>
    
<head>
  <title>CEB RELAT - SISTEMAS DE RELATÓRIOS DA CEB</title>
  <link rel="stylesheet" href="_css/estilo_slideshow.css">
 <link rel="stylesheet" href="_css/abc.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <link href="css/bootstrap.min.css" rel="stylesheet">
    
<style type="text/css">
  /* Coded with love by Mutiullah Samim */
    body,
    html {
      margin: 0;
      padding: 0;
      height: 100%;
      
          }


#icon{
  position: relative;
  height: 60px;
  margin-left: 13px;  
  margin-top: 10px;
}

#border_icon{
  position: relative;
  height: 90px;
  width: 90px;
  margin-right: 15px; 
}

.navbar-brand{
    margin-right: 615px;  
}

.logo_index {
height: 80px;
width: 160px;
margin-top: 15px;
position: absolute;
margin-left: -80px;
}


</style>
</head>
<script type="text/javascript">


function myFunction() {
    var x = document.getElementById('cont');
    var y = document.getElementById('cont1');
   var z = document.getElementById('teste');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    y.style.display = 'block';
    z.style.display = 'none';
    } else {
    x.style.display = 'none';
  y.style.display = 'none';
  z.style.display = 'block';
    }
}

function hidden() {
document.body.style.overflow='hidden';
}

function bookmarksite(title,url){
if (window.sidebar) // firefox
  window.sidebar.addPanel(title, url, "");
else if(window.opera && window.print){ // opera
  var elem = document.createElement('a');
  elem.setAttribute('href',url);
  elem.setAttribute('title',title);
  elem.setAttribute('rel','sidebar');
  elem.click();
} 
else if(document.all)// ie
  window.external.AddFavorite(url, title);
}

function inicial(){
if (window.sidebar) // firefox
alert('Clique no menu Ferramentas &amp;gt; Opções &amp;gt; Principal e clique em "Usar a Página Aberta"');
else if(window.opera && window.print){ // opera
  var elem = document.createElement('a');
alert('Clique no menu Ferramentas &amp;gt; Opções &amp;gt; Principal e clique em "Usar a Página Aberta"');
} 
else if(document.all)// ie
document.body.style.behavior='url(#default#homepage)';
document.body.setHomePage('http://localhost/geq/');
}

function submete() {
    if ( document.formulario.matricula.value == "" ) {
    alert( 'Informe a matrícula do usuario, com ou sem #.' );
    document.formulario.matricula.focus();
    return;
    
    } 
  else if ( document.formulario.senha.value == "" ) {
    alert( 'Preencha a senha corretamente!' );
    document.formulario.senha.focus();  
  
    } 
  else {
      document.formulario.submit(); 
  }
}
</script>
<body>

  <ul class="slideshow">
  <li><span>Image 01</span></li>
  <li><span>Image 02</span></li>
  <li><span>Image 03</span></li>
  <li><span>Image 04</span></li>
  <li><span>Image 05</span></li>
  <li><span>Image 06</span></li>
</ul>


  <div class="wrapper fadeInDown">
  <div id="formContent">
                <div class="brand_logo_container">
            <div class="brand_logo"> <img src="imagens/logo_ceb.png" alt="Logo" class="logo_index"></div>
            </div>
       


  CEB RELAT - SISTEMA DE RELAT&OacuteRIOS DA CEB<br>
    <!-- Tabs Titles -->


    <!-- Login Form -->

  <div id="cont1">
    <form action="index.php" method="POST" name="formulario" id="formulario">
      <br>
      <div class="fadeIn second">

<div class="input-group mb-3" style="margin-left: 95px;">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
  </div>
  <input input type="text" id="login" name="matricula" class="col-sm-6 input-user" placeholder="Matricula" aria-label="Username" aria-describedby="basic-addon1">
</div>     
    </div>    
      <div class="fadeIn third">
<div class="input-group mb-1" style="margin-left: 95px;">
              <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
              </div>
              <input type="password" id="password" name="senha" class="col-sm-6 input_pass" value="" placeholder="Senha">
            </div>    
            <div class="d-flex justify-content-center mt-3 login_container">
          <input type="submit" value="Entrar" class="btn login_btn" style="cursor: pointer;">      
    </form>
</div>
<div id="teste" style="display: none;">
<br>A senha de acesso a GEQ deve ser mantida em sigilo absoluto, caso tenha esquecido sua senha, entre em contato com o administrador do Sistema.<br><br>
</div>
    <!-- Remind Passowrd -->
 <!--   <div id="formFooter">
      <a class="underlineHover" href="#">Forgot Password?</a>
    </div>
-->
  </div>
</div>





  <script src="jquery.js" type="text/javascript"></script>
          <script src="js/bootstrap.min.js"></script>
</body>
</html>
