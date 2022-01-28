<?php 
ob_start();
session_start();
include('index.php');
function mon_compte_shortcode() {
  $wpcon = mysqli_connect("localhost","root","","wordpress");
  $user_data = checklogin($wpcon);
  $login = $_SESSION['login'] ;
  $user= get_user_by('login', $login);
  $nom = $user->data->display_name;
  $email = $user->data->user_email;

 return $var = '
 <head>
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
 </head>
 <style>
input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  padding-top: 60px;
}

.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 50%; /* Could be more or less, depending on screen size */
}


.close {
  position: absolute;
  right: 25px;
  top: 0;
  color: #000;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: red;
  cursor: pointer;
}


.animate {
  -webkit-animation: animatezoom 0.6s;
  animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
  from {-webkit-transform: scale(0)} 
  to {-webkit-transform: scale(1)}
}
  
@keyframes animatezoom {
  from {transform: scale(0)} 
  to {transform: scale(1)}
}


@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
.containermo {
  padding: 40px;
}
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
  padding: 40px;
  
}
#iv{
    margin: 0 auto;
    width:40% 
}
 .imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}
img.avatar {
margin-bottom: -27px;
  width: 30%;
  border-radius: 50%;
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
   background-color: #1409e3;
  color: white;
  border: 2px solid #1409e3;
  
}
.button2 {
   background-color: #c20c1d;
  color: white;
  border: 2px solid #c20c1d;
  
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
.title {color: grey; }
#label {color: #d93025; font-size: 14px;align-items: flex-start;display:none;margin-top: -6px}
input { box-shadow: 0 0 3px black; margin: 10px }
</style>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div id="iv" class="container" > 

  <div class="imgcontainer">
    <img src="https://www.w3schools.com/howto/img_avatar2.png" alt="Avatar" class="avatar">
 </div>
 
  <div class="container1">

    <h6 class="title">Nom et Prenom : <b>'. $nom .' </b></h6>
    <h6 class="title">Email : <b>'. $email .'</b></h6>
    <h6 class="title">Non d\'utilisateur : <b>'. $login  .'</b></h6>
    </div>
     <center> <button  class="button button1" onclick="document.getElementById(\'id01\').style.display=\'block\'"> modifier</button>  <button  class="button button2" id ="delete"> supprimer </button></center> 
  </div>
     </div>

<div id="id01" class="modal">
  
  <div class="modal-content animate">
    <div class="imgcontainer">
    <h1>Modifier</h1>
      <span onclick="document.getElementById(\'id01\').style.display=\'none\'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="containermo">
     <label for="psw"><b>Ancien mot de passe</b></label>
      <input id ="oldpassword" name="oldpassword" type="password" placeholder="Enter votre ancien mot de passe" name="psw" >
      <label class="oldpassword" id="label" >Entrez un mot de passe</label>
      <label for="psw"><b>Nouveau mot de passe</b></label>
      <input id ="newpassword" name="newpassword" type="password" placeholder="Enter votre nouveau mot de passe" name="psw" >
      <label class="newpassword" id="label" >Entrez un mot de passe</label>
      <center>  
      <button class="button button1" id ="update">modifier</button>
      
    </div>
     

<script>
var modal = document.getElementById(\'id01\');
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
   
  ';
}

add_shortcode('mon_compte','mon_compte_shortcode');