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
  padding: 40px;
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
<div class="row">
<div class="col-6">
<!--<label ><b>Raison Social :</b></label>-->
        <input type="text" id ="rs" name="rs" placeholder="RS" required>
         <label  class="rs" id="label">Saisissez votre rs</label> 
      <!--   <label ><b>Nom :</b></label>-->
        <input type="text" id ="nom2" name="nom2" placeholder="Nom" required>
         <label  class="nom2" id="label">Saisissez votre nom</label> 
</div>     
 <div class="col-6"> 
 <!--<label ><b>Prenom :</b></label>-->
        <input type="text" id ="prenom2" name="prenom2" placeholder="Prenom" required>
         <label  class="prenom2" id="label">Saisissez votre prenom</label> 
       <!--  <label ><b>Code :</b></label>-->
        <input type="text"  id ="code2" name="code2" placeholder="Code client SNTL" required>
         <label  class="code2" id="label">Saisissez votre code client SNTL</label> 
</div> 
</div>
<div class="row">
<div class="col-6">
      <!-- <label ><b>Email :</b></label>-->
             <input type="text"  id ="email2" name="email2" placeholder="Adresse email" >
    
         <label  class="email2" id="label">Saisissez votre adresse email</label> 
        <!--<label ><b>Telephone :</b></label>-->
            <input type="tel" id ="tel2" name="tel2" placeholder="Telephone" />
         <label  class="tel2" id="label">Saisissez votre numero de telephone</label> 
</div>     
 <div class="col-6"> 
 <!-- <label ><b>Login :</b></label>-->
        <input type="text"  id ="login2" name="login2" placeholder="Login" required>
         <label  class="login2" id="label">Saisissez votre login</label> 
         <!--<label ><b>Password :</b></label>-->
        <input type="text"  id ="password2" name="password" placeholder="Password" required>
         <label  class="password2" id="label">Saisissez votre password</label> 
</div>
</div>
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