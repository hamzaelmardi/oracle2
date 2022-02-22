<?php
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
    remove_action('save_post','save_post_callback');
    if (isset($_POST['reject_client'])){
$nom = get_field( 'nom',$post_id);
 $email =  get_field( 'email',$post_id);

       wp_update_post(array(
            'ID'    =>  $post_id,
            'post_status'   =>  'rejected'
        ));

  $to = $email;
  $subject  = "SNTL- Inscription non réussie";
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
          <p>Bonjour M/Mme <b>'.$nom.'</b>,<br>
          Votre inscription à la plateforme des clients de la SNTL a été refusée.<br>

Pour plus de détails, nous vous prions de contacter le service responsable par mail: XXX<br>
Cordialement,


</p>
            
        
    </div>

  </body>';
  $headers = "From: hamzatwins10@gmail.com";
  $headers = 'Content-type: text/html; charset=utf-8';
  if (mail($to, $subject , $body, $headers));
       
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
    $tel = get_field( 'telephone',$post_id);
    $code = get_field( 'code_sntl',$post_id);

      $userdata = array(
        'user_login' => $login,
        'first_name' => $prenom,
        'last_name' => $nom,
        'user_pass' => $password,
        'user_email' =>  $email,
        'role' => 'client'
        );
$user_id = wp_insert_user( $userdata ) ;
update_user_meta($user_id,  'tel', $tel );
update_user_meta($user_id,  'code', $code );

 $to = $email;
  $subject  = "SNTL- Validation de compte";
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
          <p>Bonjour Mme/M <b>'.$nom.'</b>,<br>
Votre demande d\'inscription a été accéptée. Votre compte est à présent actif.
Ci-dessous vos informations de connexion:<br>

   - Nom d\'utilisateur : <b>'.$login.'</b><br>
    - Mot de passe : <b>'.$password.'</b><br>
 

Cordialement,</p>
    </div>

  </body>';
  $headers = 'Content-type: text/html; charset=utf-8';
  mail($to, $subject , $body, $headers);
   

wp_update_post(array(
            'ID'    =>  $post_id,
            'post_status'   =>  'accepted'
        ));
  $domaine = get_site_url();
$link = $domaine."/wp-admin/edit.php?post_type=verifier_client";
if (wp_redirect ($link)){
    exit;
}
  }
  add_action('save_post','save_post_callback');
   
  
}