<?php
function form_inscription_client_shortcode() {
 return $var = '
 <html >
 <head>
 <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 </head>
 <style>
 .fa{
    margin-left: 5px;
}
 ::placeholder {
  color: grey;
}
 .container {
  border-radius: 5px;
  background-color: #f8f4f4;
  padding: 30px;
}

  input[type=text],input[type=tel] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
.button {
border-radius: 4px 4px 4px 4px;
  border: none;
  color: #30404b;
  padding: 10px 24px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 21px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
}
.button1 {
   background-color: #8cc63f;
  color: white;
  border: 2px solid #8cc63f;
  
}
.button1:hover {
 background-color: #30404b; 
  color: white; 
  border: 2px solid #30404b;
}
input,span { box-shadow: 0 0 2px grey; margin: 10px }
#label {
 color: #d93025; font-size: 12px;align-items: flex-start;margin-left: 10px;display:none;margin-top: -6px
}
#iv{
    margin: 0 auto;
    width:70% 
}
</style>
<body>
<center>
<div>
     <h1>Inscription Client </h1> 
  </div>
 </center>
<div id="iv" class="container" >  

        <input type="text" id ="rs" name="rs" placeholder="RS" required>
         <label  class="rs" id="label">Saisissez votre rs</label> 
        <input type="text" id ="nom2" name="nom2" placeholder="nom" required>
         <label  class="nom2" id="label">Saisissez votre nom</label> 
        <input type="text" id ="prenom2" name="prenom2" placeholder="prenom" required>
         <label  class="prenom2" id="label">Saisissez votre prenom</label> 
        <input type="text"  id ="code2" name="code2" placeholder="code client SNTL" required>
         <label  class="code2" id="label">Saisissez votre code client SNTL</label> 
        <div class="input-group mb-0">
             <input type="text"  id ="email2" name="email2" placeholder="adresse email" style="width: 100%;"required >
        <div class="input-group-append" style="height: 58px;position: absolute;right: -9px;top: -1px;">
             <span class="input-group-text">example@example.com</span>
        </div>
        </div>
         <label  class="email2" id="label">Saisissez votre adresse email</label> 
        <div class="input-group">
            <div class="input-group-prepend position_icon_fr" style="height: 45px;">
            <span class="input-group-text" id="basic-addon4" style="height: 37px;position: absolute;left: -9px;top: -2px;width: 57px;"><i class="fa fa-phone" style="font-size:25px;color:#30404b"></i></span>
            </div>
            <input type="tel" id ="tel2" name="tel2" placeholder="telephone" style="width: 50%;right: 430px; height: 37px;margin-left: 60px;"/>
        </div>
         <label  class="tel2" id="label">Saisissez votre numero de telephone</label> 
        <input type="text"  id ="login2" name="login2" placeholder="login" required>
         <label  class="login2" id="label">Saisissez votre login</label> 
        <input type="text"  id ="password" name="password" placeholder="password" required>
         <label  class="password" id="label">Saisissez votre password</label> 
     <center>
    <div class="container" >
       <button class="button button1" id ="inscriptioncli" > inscription </button> 
      </div>
     </center>
      </body>
      </html>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
  ';
}

add_shortcode('myformshortcodecli','form_inscription_client_shortcode');