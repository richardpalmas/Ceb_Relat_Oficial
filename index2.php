<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<?php require("main.php"); ?>
<!DOCTYPE html>
<html>
    
<head>
  <title>CEB RELAT - SISTEMAS DE RELATÓRIOS DA CEB</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <link href="css/bootstrap.min.css" rel="stylesheet">
     <link href="_css/estilo01.css" rel="stylesheet">
<style type="text/css">
  /* Coded with love by Mutiullah Samim */
    body,
    html {
      margin: 0;
      padding: 0;
      height: 100%;
      background: #60a3bc !important;
    }
    .user_card {
      height: 400px;
      width: 350px;
      margin-top: auto;
      margin-bottom: auto;
      background: #f39c12;
      position: relative;
      display: flex;
      justify-content: center;
      flex-direction: column;
      padding: 10px;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      -webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      -moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      border-radius: 5px;

    }
    .brand_logo_container {
      position: absolute;
      height: 170px;
      width: 170px;
      top: -75px;
      border-radius: 50%;
      background: #60a3bc;
      padding: 10px;
      text-align: center;
    }
    .brand_logo {
      height: 150px;
      width: 150px;
      border-radius: 50%;
      border: 2px solid white;
    }
    .form_container {
      margin-top: 100px;
    }
    .login_btn {
      width: 100%;
      background: #c0392b !important;
      color: white !important;
    }
    .login_btn:focus {
      box-shadow: none !important;
      outline: 0px !important;
    }
    .login_container {
      padding: 0 2rem;
    }
    .input-group-text {
      background: #c0392b !important;
      color: white !important;
      border: 0 !important;
      border-radius: 0.25rem 0 0 0.25rem !important;
    }
    .input_user,
    .input_pass:focus {
      box-shadow: none !important;
      outline: 0px !important;
    }
    .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
      background-color: #c0392b !important;
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
  <div class="container h-100">
    <div class="d-flex justify-content-center h-100">
      <div class="user_card">
        <div class="d-flex justify-content-center">
          <div class="brand_logo_container">
            <div class="brand_logo"> <img src="imagens/logo11.png" alt="Logo" class="logo_index"></div>
            
          </div>
        </div>
        <div class="d-flex justify-content-center form_container">
          <form action="index.php" method="POST" name="formulario" id="formulario">
            <div class="input-group mb-3">
              <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
              <input type="text" id="login" name="matricula" class="form-control input_user" value="" placeholder="Matricula">
            </div>          
            <div class="input-group mb-2">
              <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
              </div>
              <input type="password" id="password" name="senha" class="form-control input_pass" value="" placeholder="Senha">
            </div>
            <div class="form-group">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="customControlInline">
                <label class="custom-control-label" for="customControlInline">Remember me</label>
              </div>
            </div>
         
        </div>
        <div class="d-flex justify-content-center mt-3 login_container">
          <input type="submit" value="Entrar" class="btn login_btn">
           </form>
        </div>
        <div class="mt-4">
        
          <div class="d-flex justify-content-center links">
            <a href="#">Forgot your password?</a>
          </div>
        </div>
      </div>
    </div>
  </div>


  
  <script src="jquery.js" type="text/javascript"></script>
          <script src="js/bootstrap.min.js"></script>



</body>
</html>
