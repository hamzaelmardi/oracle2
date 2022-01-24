<?php
register_post_status( 'rejected', array(
                    'label'                     => _x( 'Rejected', 'post status label', 'plugin-domain' ),
                    'public'                    => false,
                    'label_count'               => _n_noop( 'Rejected <span class="count">(%s)</span>', 'Rejected <span class="count">(%s)</span>', 'plugin-domain' ),
                    'post_type'                 => array( 'verifier_client'), // Define one or more post types the status can be applied to.
                    'show_in_metabox_dropdown'  => false,
                    'show_in_inline_dropdown'   => false,
                    'dashicon'                  => 'dashicons-businessman',
                ) );
add_action('admin_footer-post.php',function(){
    global $post;
    $complete = '';
    $label = '';
    if((($post->post_type == 'verifier_client')  && current_user_can( 'edit_posts' ))) {
        if ( $post->post_status == 'verifier_client') {
            $complete = ' selected=\"selected\"';
            $label    = 'Rejected';
        }
        $script = <<<SD
       jQuery(document).ready(function($){
           $("select#post_status").append("<option value=\"rejected\" '.$complete.'>rejected</option>");
           if( "{$post->post_status}" == "rejected" ){
                $("span#post-status-display").html("$label");
                $("input#save-post").val("Enregistrer");
           }
           var jSelect = $("select#post_status");
           $("a.save-post-status").on("click", function(){
                if( jSelect.val() == "rejected" ){
                    $("input#save-post").val("Enregistrer");
                }
           });
      });
SD;
        echo '<script type="text/javascript">' . $script . '</script>';
    }
});
add_action('admin_footer-edit.php',function() {
    global $post;
    if( (($post->post_type == 'verifier_client') && current_user_can( 'edit_posts' )) ){
        echo "<script>
    jQuery(document).ready( function() {
        jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"rejected\">Rejected</option>' );
    });
    </script>";
    }
});
 

 //-----------------accepted-----------


register_post_status( 'accepted', array(
                    'label'                     => _x( 'Accepted', 'post status label', 'plugin-domain' ),
                    'public'                    => false,
                    'label_count'               => _n_noop( 'Accepted <span class="count">(%s)</span>', 'Accepted <span class="count">(%s)</span>', 'plugin-domain' ),
                    'post_type'                 => array( 'verifier_client'), // Define one or more post types the status can be applied to.
                    'show_in_metabox_dropdown'  => false,
                    'show_in_inline_dropdown'   => false,
                    'dashicon'                  => 'dashicons-businessman',
                ) );
add_action('admin_footer-post.php',function(){
    global $post;
    $complete = '';
    $label = '';
    if((($post->post_type == 'verifier_client')  && current_user_can( 'edit_posts' ))) {
        if ( $post->post_status == 'verifier_client') {
            $complete = ' selected=\"selected\"';
            $label    = 'Accepted';
        }
        $script = <<<SD
       jQuery(document).ready(function($){
           $("select#post_status").append("<option value=\"accepted\" '.$complete.'>rejected</option>");
           if( "{$post->post_status}" == "accepted" ){
                $("span#post-status-display").html("$label");
                $("input#save-post").val("Enregistrer");
           }
           var jSelect = $("select#post_status");
           $("a.save-post-status").on("click", function(){
                if( jSelect.val() == "accepted" ){
                    $("input#save-post").val("Enregistrer");
                }
           });
      });
SD;
        echo '<script type="text/javascript">' . $script . '</script>';
    }
});
add_action('admin_footer-edit.php',function() {
    global $post;
    if( (($post->post_type == 'verifier_client') && current_user_can( 'edit_posts' )) ){
        echo "<script>
    jQuery(document).ready( function() {
        jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"accepted\">Accepted</option>' );
    });
    </script>";
    }
});