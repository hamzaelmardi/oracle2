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


       wp_update_post(array(
            'ID'    =>  $post_id,
            'post_status'   =>  'rejected'
        ));
       
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

