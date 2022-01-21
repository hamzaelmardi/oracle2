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
    include(__DIR__ . '/add_client.php');
   
}
// verifier_client
add_action('post_submitbox_misc_actions', 'rejected_to_journaliste_button');
function rejected_to_journaliste_button()
{
    global $post;
    $user = wp_get_current_user();
    
    if (!in_array($post->post_type, ['verifier_client'])) return;
    if (!current_user_can('edit_post', $post->ID)) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    
    echo '<div id="confirm_client" class="misc-pub-section"
    style="border-top-style:solid; border-top-width:1px; border-top-color:#EEEEEE; border-bottom-width:0px;">
    <input id="save-post2" class="button button-secondary"
    type="submit" value="Confirmer" name="confirm_client" style="background-color:#12e652; color:#FFF">
    <input id="save-post2" class="button button-secondary"
    type="submit" value="refuser" name="reject_client" style="background-color:#d02e39; color:#FFF">
        </div>
         ';
       
}

add_filter( 'wp_insert_post_data' , 'rejectedjournaliste_filter_handler' , '99', 2 );
function rejectedjournaliste_filter_handler( $data , $postarr )
{
    $current_user = wp_get_current_user();
    
    if ($postarr['rejected_journaliste'] == 'Renvoyer au journaliste'){
        
        $data['post_status'] = 'rejectedjournaliste';
    
    }
    return $data;
}

add_action('save_post','save_post_callback');
function save_post_callback($post_id){
    if (isset($_POST['reject_client'])){
 wp_trash_post($post_id);
       $domaine = get_site_url();
$link = $domaine."/wp-admin/edit.php?post_type=verifier_client";
if (wp_redirect ($link)){
    exit;
}

    }
  else if(isset($_POST['confirm_client'])) {
     
    $login = get_field('username',$post_id );
    $prenom = get_field('prenom',$post_id );
    $nom = get_field( 'nom',$post_id);
    $password = get_field( 'password',$post_id);
    $email =  get_field( 'email',$post_id);

      $userdata = array(
        'user_login' => $login,
        'first_name' => $prenom,
        'last_name' => $nom,
        'user_pass' => $password,
        'user_email' =>  $email,
        'role' => 'client'
        );
$user_id = wp_insert_user( $userdata ) ;
  }
}
// verifier_client end

add_action('wp_enqueue_scripts', 'WordPress_resources');



// alert fonction 
function capitaine_assets() {
 wp_enqueue_script( 'capitaine', plugin_dir_url( __FILE__ )  . '/assets/scripts.js', array( 'jquery' ), '1.0', true );
 wp_enqueue_script( 'dd', "https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js", array( 'jquery' ), '1.0', true );
 wp_localize_script( 'capitaine', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}
add_action( 'wp_enqueue_scripts', 'capitaine_assets' );

// alert connexion fournisseur
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
// alert inscription personne phyique

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

}
else {
echo json_encode(array('code1'=>404 ,'message'=>'informations saisies ne correspondent pas aux informations saisies sur le système de gestion, veuillez contacter la SNTL'));
}}
    wp_die();
}

// alert inscription personne morale

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

}
else {
echo json_encode(array('code1'=>404 ,'message'=>'informations saisies ne correspondent pas aux informations saisies sur le système de gestion, veuillez contacter la SNTL'));
}}
    wp_die();
}


// alert inscription client

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
if(in_array($rs,$extract['RAISON']) and in_array($email2,$extract['EMAIL']) and in_array($code2,$extract['CODE'])  
    and in_array($tel2,$extract['TEL']) and in_array($nom2,$extract['NOM']) and in_array($prenom2,$extract['PRENOM']) && !$user_m &&  !$user){
    
     echo json_encode(array('code1'=>200 ,'message'=>'le compte est créé et activé')); 
       $userdata = array(
        'user_login' => $login2,
        'first_name' => $prenom2,
        'last_name' => $nom2,
        'user_pass' => $password,
        'user_email' =>  $email2,
        'role' => 'client' 
        );

$user_id = wp_insert_user( $userdata ) ;


$vc= array(
    'post_type' => 'verifier_client',
    'post_title' => $prenom2.' '.$nom2,
    'post_status' => 'publish'
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
echo json_encode(array('code1'=>404 ,'message'=>'informations saisies ne correspondent pas aux informations saisies sur le système de gestion, veuillez contacter la SNTL'));
}}
    wp_die();
}




// check if user is loged in before accessing to  page
function checklogin($wpcon){
    ob_start();
    session_start();
    if(!isset($_SESSION['login'])){
            header('location: /sntl/connexion-2'); 
    }

}


?>