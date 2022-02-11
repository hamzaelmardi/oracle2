<?php
/*
Plugin Name: Plugin_test_oracle_
Description: test test
*/
/**
 *  
 */
 require_once(ABSPATH. WPINC .'/class-phpass.php');
function WordPress_resources() {
    
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_script('main_js', plugin_dir_url( __FILE__ ) . '/assets/main.js', NULL, 1.0, true);

    wp_localize_script('main_js', 'magicalData', array(
        'nonce' => wp_create_nonce('wp_rest'),
        'siteURL' => get_site_url()
    ));
    
    
   include(__DIR__ . '/info.php');
    include(__DIR__ . '/inscription.php');
    include(__DIR__ . '/connexion.php');
    include(__DIR__ . '/client.php');
    include(__DIR__ . '/inscription_cli.php');
    include(__DIR__ . '/oracle.php');
    include(__DIR__ . '/profil.php');
    include(__DIR__ . '/mon_compte.php');
   
}
//----------------- verifier_client --------

include(__DIR__ . '/verifier_client.php');

// ----------------verifier_client end ----------

add_action('wp_enqueue_scripts', 'WordPress_resources');



// alert fonction 
function capitaine_assets() {
 wp_enqueue_script( 'capitaine', plugin_dir_url( __FILE__ )  . '/assets/scripts.js', array( 'jquery' ), '1.0', true );
 wp_enqueue_script( 'dd', "https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js", array( 'jquery' ), '1.0', true );
 wp_localize_script( 'capitaine', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}
add_action( 'wp_enqueue_scripts', 'capitaine_assets' );

//---------- alert connexion fournisseur- --------------

add_action( 'wp_ajax_load_comments', 'capitaine_load_comments' );
add_action( 'wp_ajax_nopriv_load_comments', 'capitaine_load_comments' );

function capitaine_load_comments() {
    
$login = $_POST['login'];
$password = $_POST['pass'];

$vqr= array(
    'pass' =>  $password,
    'login' =>  $login,
  );

  $wp_hasher = new PasswordHash(8,true);

  $user= get_user_by('login', $login);

  if($wp_hasher->CheckPassword($password,$user->user_pass)){

    ob_start();
    session_start();
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    
    echo json_encode(array('code1'=>200,'message'=>'success', 'role'=>$user->roles));
 
} else {

echo json_encode(array('code1'=>404,'message'=>'login ou password incorrect'));

}
    wp_die();

}  
// -------- alert inscription personne phyique ------------

add_action( 'wp_ajax_insert_fourn', 'capitaine_insert_fourn' );
add_action( 'wp_ajax_nopriv_insert_fourn', 'capitaine_insert_fourn' );

function capitaine_insert_fourn() {
    global $wpdb;
    $nom = $_POST['nom'];
    $code = $_POST['code'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $prenom = $_POST['prenom'];
    $cin = $_POST['cin'];
    $tel = $_POST['tel'];
$vqr= array(
    'nom' =>  $nom,
    'prenom' =>  $prenom,
    'cin' =>  $cin,
    'code' =>  $code,
    'password' =>  $hash,
    'login' =>  $login,
    'email' =>  $email,
    'tel' =>  $tel,
  );

if(isset ($_POST['nom'] , $_POST['code'], $_POST['prenom'], $_POST['cin'], $_POST['email'], $_POST['tel'])){
 $user = get_user_by('login', $login);
 $user_m = get_user_by('email', $email);

 $conn = oci_connect('c##hamza','123','localhost/orcl');
    $requete1="select nom,code,prenom,cin,email,tel from FOURNISSEUR where code ='$code'";
    $stmt = oci_parse($conn, $requete1);
     oci_execute($stmt);
     oci_fetch_all($stmt,$extract);
if(in_array($nom,$extract['NOM']) and in_array($code,$extract['CODE']) and in_array($prenom,$extract['PRENOM']) and 
   in_array($cin,$extract['CIN']) and  in_array($email,$extract['EMAIL']) and  in_array($tel,$extract['TEL'])
    && !$user_m &&  !$user){ 
     echo json_encode(array('code1'=>200 ,'message'=>'le compte est créé et activé')); 
     // $wpdb->insert('fournisseur', array('nom' => $nom, 'code' => $code, 'login' => $login, 'password' => $hash)); 
       $userdata = array(
        'user_login' => $login,
        'first_name' => $prenom,
        'last_name' => $nom,
        'user_pass' => $password,
        'user_email' =>  $email,
        'role' => 'fournisseur' 
        );

$user_id = wp_insert_user( $userdata ) ;

$to = $email;
  $subject  = "sntl";
  $body = $body = '<head>
  <style type="text/css">
    @media (min-width: 650px) {
      .content{
        margin: 0 15%;
        padding:0 20px;
        width: 70%;
      }
    }

    @media (max-width: 650px) {
      .content{
        margin: 0;
        width: 100%;
        padding:0
      }
    }

  </style>
</head>
   
   <body style="margin: 0 !important; padding: 0 !important;background-color: white">


       <div class="content" align="center" style="font-family: \'Lato\',Helvetica, Arial, sans-serif; line-height: 30px; font-size: 17px; background-color: #fff;">

            <img src="https://www.leconomiste.com/sites/default/files/eco7/public/snlt-037.jpg" width="200px">
 </div>
 <br>
           <p>Bonjour M/Mme <b style="color: #2c3b98";>'.$nom.'</b>,<br>votre compte est active.<br>
            nom d\'utilisateur : <b style="color: #2c3b98";>'.$login.'</b><br>
            mot de pass  : <b style="color: #2c3b98";>'.$password.'</b></p>
    </div>

  </body>';
  $headers = "From: hamzatwins10@gmail.com";
  $headers = 'Content-type: text/html; charset=utf-8';
  mail($to, $subject , $body, $headers);

}
else {
echo json_encode(array('code1'=>404 ,'message'=>'informations saisies ne correspondent pas aux informations saisies sur le système de gestion, veuillez contacter la SNTL'));
}}
    wp_die();
}

//-------- alert inscription personne morale  -----------------

add_action( 'wp_ajax_insert_morale', 'capitaine_insert_morale' );
add_action( 'wp_ajax_nopriv_insert_morale', 'capitaine_insert_morale' );

function capitaine_insert_morale() {
    global $wpdb;
    $raison = $_POST['raison'];
    $code1 = $_POST['code1'];
    $login1 = $_POST['login1'];
    $password = $_POST['password'];
    $registre = $_POST['registre'];
    $tel1 = $_POST['tel1'];
    $emailm = $_POST['emailm'];
$vqr= array(
    'raison' =>  $raison,
    'tel1' =>  $tel1,
    'code1' =>  $code1,
    'password' =>  $password,
    'login1' =>  $login1,
    'registre' =>  $registre,
    'emailm' =>  $emailm,
  );

if(isset ($_POST['raison'] , $_POST['code1'], $_POST['registre'], $_POST['tel1'], $_POST['emailm'])){

  $user= get_user_by('login', $login1);
$user_m = get_user_by('email', $emailm);

 $conn = oci_connect('c##hamza','123','localhost/orcl');
    $requete1="select raison,code,registre,tel,email from FOURNISSEUR where code ='$code1'";
    $stmt = oci_parse($conn, $requete1);
     oci_execute($stmt);
     oci_fetch_all($stmt,$extract) ;
if(in_array($raison,$extract['RAISON']) and in_array($registre,$extract['REGISTRE']) and in_array($code1,$extract['CODE'])  
    and in_array($tel1,$extract['TEL']) and in_array($emailm,$extract['EMAIL']) && !$user_m &&  !$user){
    
     echo json_encode(array('code1'=>200 ,'message'=>'le compte est créé et activé')); 
       $userdata = array(
        'user_login' => $login1,
        'first_name' => $raison,
        'user_pass' => $password,
    'user_email' =>  $emailm,
        'role' => 'fournisseur' 
        );

$user_id = wp_insert_user( $userdata ) ;

$to = $emailm;
  $subject  = "sntl";
  $body = $body = '<head>
  <style type="text/css">
    @media (min-width: 650px) {
      .content{
        margin: 0 15%;
        padding:0 20px;
        width: 70%;
      }
    }

    @media (max-width: 650px) {
      .content{
        margin: 0;
        width: 100%;
        padding:0
      }
    }

  </style>
</head>
   
   <body style="margin: 0 !important; padding: 0 !important;background-color: white">


       <div class="content" align="center" style="font-family: \'Lato\',Helvetica, Arial, sans-serif; line-height: 30px; font-size: 17px; background-color: #fff;">

            <img src="https://www.leconomiste.com/sites/default/files/eco7/public/snlt-037.jpg" width="200px">
 </div>
 <br>
           <p>Bonjour ,<br>votre compte est active.<br>
            nom d\'utilisateur : <b style="color: #2c3b98";>'.$login1.'</b><br>
            mot de pass  : <b style="color: #2c3b98";>'.$password.'</b></p>
    </div>

  </body>';
  $headers = "From: hamzatwins10@gmail.com";
  $headers = 'Content-type: text/html; charset=utf-8';
  mail($to, $subject , $body, $headers);

}
else {
echo json_encode(array('code1'=>404 ,'message'=>'informations saisies ne correspondent pas aux informations saisies sur le système de gestion, veuillez contacter la SNTL'));
}}
    wp_die();
}


// ----------- alert inscription client ------

add_action( 'wp_ajax_insert_client', 'capitaine_insert_client' );
add_action( 'wp_ajax_nopriv_insert_client', 'capitaine_insert_client' );

function capitaine_insert_client() {
    global $wpdb;
    $rs = $_POST['rs'];
    $nom2 = $_POST['nom2'];
    $prenom2 = $_POST['prenom2'];
    $code2 = $_POST['code2'];
    $login2 = $_POST['login2'];
    $password = $_POST['password'];
    $email2 = $_POST['email2'];
    $tel2 = $_POST['tel2'];


$vqr= array(
    'rs' =>  $rs,
    'tel2' =>  $tel2,
    'code2' =>  $code2,
    'password' =>  $password,
    'login2' =>  $login2,
    'email2' =>  $email2,
    'nom2' =>  $nom2,
    'prenom2' =>  $prenom2,
  );


if(isset ($_POST['rs'] , $_POST['code2'], $_POST['email2'], $_POST['tel2'], $_POST['nom2'], $_POST['prenom2'])){

  $user= get_user_by('login', $login2);
  $user_m = get_user_by('email', $email);

 $conn = oci_connect('c##hamza','123','localhost/orcl');
    $requete1="select nom,prenom,raison,code,email,tel from CLIENT where code ='$code2'";
    $stmt = oci_parse($conn, $requete1);
     oci_execute($stmt);
     oci_fetch_all($stmt,$extract) ;
if(!$user_m &&  !$user){
    
     echo json_encode(array('code1'=>200 ,'message'=>'en cours de traitment')); 

$vc= array(
    'post_type' => 'verifier_client',
    'post_title' => $prenom2.' '.$nom2,
    'post_status' => 'pending'
    );
    //insert param in custom post
   $userc = wp_insert_post($vc);
   update_field('field_61e5475816466',$nom2,$userc);
   update_field('field_61e5480c16467',$prenom2,$userc);
   update_field('field_61e5481d16468',$email2,$userc);
   update_field('field_61e5482c16469',$password,$userc);
   update_field('field_61e548391646a',$login2,$userc);

}
else {
echo json_encode(array('code1'=>404 ,'message'=>'username already exists'));
}}
    wp_die();
}




//------------- check if user is loged in before accessing to  page  ----------
function checklogin($wpcon){
    ob_start();
    session_start();
    if(!isset($_SESSION['login'])){
            header('location: /sntl/connexion-2'); 
    }

}
//------------------- post status ------------

include(__DIR__ . '/new_post_status.php');

//----------- delete account-----------------

    add_action( 'wp_ajax_delete_account', 'capitaine_delete_account' );
    add_action( 'wp_ajax_nopriv_delete_account', 'capitaine_delete_account' );

    function capitaine_delete_account() {
       global $wpdb;
       ob_start();
    session_start();
      $login = $_SESSION['login'] ;

      $user= get_user_by('login', $login);
      
    $id = $user->data->ID;
    if(wp_delete_user( $id )){
        echo json_encode(array('code1'=>200)); 

    unset($_SESSION['login']);
    unset($_SESSION['password']);
      wp_die();
    }
    else {
    echo json_encode(array('code1'=>404));
     wp_die();
    }
    }

// -------- alert update user ------------

add_action( 'wp_ajax_update_user', 'capitaine_update_user' );
add_action( 'wp_ajax_nopriv_update_user', 'capitaine_update_user' );

function capitaine_update_user() {
    global $wpdb;
     ob_start();
    session_start();
      $login = $_SESSION['login'] ;
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    $vqr= array(
    'oldpassword' =>  $oldpassword,
    'newpassword' =>  $newpassword,
    
  );
 $wp_hasher = new PasswordHash(8,true);
 $user = get_user_by('login', $login);
 $pass = $user->data->user_pass;
if($wp_hasher->CheckPassword($oldpassword,$pass)){ 
     echo json_encode(array('code1'=>200 ,'message'=>'Mot de passe a été modifier'));  

    $id = $user->data->ID; 
   wp_update_user( array(
    'ID' => $id,
    'user_pass' => $_POST[ 'newpassword' ]
));

      
}
else {
echo json_encode(array('code1'=>404 ,'message'=> 'Ancien mot de passe incorrect'));
}
    wp_die();
}


?>