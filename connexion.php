<?php
session_start();
include('index.php');
function form_conx_shortcode() {
 return $var = '
 <head>
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
 </head>
 <style>
  .container {
  border-radius: 5px;
  background-color:white;
  padding: 20px;
}
::placeholder {
  color: grey;
}
.container { box-shadow: 0 0 3px black; margin: 10px }
.container1 {
  border-radius: 5px;
  background-color:white;
  padding: 30px;
  
}
#iv{
    margin: 0 auto;
    width:83% 
}
 .imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}
img.avatar {
margin-bottom: -27px;
  width: 100%;
  border-radius: 50%;
}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
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
#myHeader {
  background-color: white;
  color: #63991b;
  font-size: 15px
}
#a {
  background-color: white;
  color: black;
  font-size: 25px
}
#label {
 color: #d93025; font-size: 14px;align-items: flex-start;display:none;margin-top: -6px
}
input { box-shadow: 0 0 3px black; margin: 10px }
</style>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div id="iv" class="container" > 
<div class="row">
<div class="col-5">
  <div class="imgcontainer">
    <img src="https://sntl.twinsmaroc.com/ds/wp-content/uploads/sites/10/2021/08/Login-1536x1536.png" alt="Avatar" class="avatar">
 </div>
 </div>
  <div class="col-7">
  <div class="container1">
      <center>  <input type="text" id ="login" name="login"  placeholder="nom d\'utilisateur *" style="margin-top: 7px"required><br></center>
        <label class="login" id="label">Saisissez votre nom d\'utilisateur</label> 
      <center>   <input type="password" id ="password" name="password" placeholder="mot de passe *"   style="margin-top: 7px" required></center>
        <label class="password" id="label" >Entrez un mot de passe</label>
    </div>
        <center> <button  class="button button1" id ="conx"> se connecter </button><br>
    <div class="container1">
    <a id="myHeader" href="/sntl/inscription-fournisseur" target="_blank">Créer votre compte fournisseur <a id="a">|</a></a> 
  <a id="myHeader" href="/sntl/inscription-client" target="_blank">Créer votre compte client</a> </center>
  
  </div>
  </div>
     </div>
   </div>
    </div>
  ';
}

add_shortcode('myformshortcodeconx','form_conx_shortcode');
