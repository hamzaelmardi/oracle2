<?php 
 ob_start();
    session_start();
function subscriber_connexionb(){

	 $login = $_SESSION['login'] ;
  $user= get_user_by('login', $login);
  $nom = $user->data->display_name;
		
	$domain = get_site_url();
	$account = $domain . '/mon-compte-2';
	$logout = $domain . '/sntl/wp-content/plugins/test/logout';
	
	$dropdown = '<div class="ld-module-dropdown left collapse lqd-dropdown-fade-onhover" id="dropdown-61e81618d1b14" aria-expanded="false">
		<div class="ld-dropdown-menu-content"><ul id="menu-connexion-menu" class="">
			<li id="menu-item-2539" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2539">
				<a href="'. $account . '">'. esc_html__( 'My account', 'woocommerce' ) .'</a>
			</li>
			<li id="menu-item-2539" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2539">
				<a href="'. $logout . '">'. esc_html__( 'Logout', 'woocommerce' ) .'</a>
			</li>
		</ul>
	</div>';
	
	if (!$_SESSION['login']) {
		$content = '<div class="header-module module-button" style="margin-left: 25px;"><a href=" /sntl/connexion-2" target="_blank" class="btn btn-solid btn-sm circle border-none btn-icon-custom-size btn-icon-circle btn-icon-solid btn-has-label ld-module-trigger collapsed ld_header_button_61e8103f1dc26 ld_button_61e8103f1eb6f"><span><span class="btn-txt" data-text="Se connecter">Se connecter</span><span class="btn-icon"><i class="lqd-icn-ess icon-lqd-user"></i></span></span></a></div>';
	} 
	
	else {
		$current_user = $_SESSION['login'] ;
		$username = $nom ;
		
		$content = '<div class="header-module module-button" style="margin-left: 25px;"><a target="_blank" class="btn btn-solid btn-sm circle border-none btn-icon-custom-size btn-icon-circle btn-icon-solid btn-has-label ld-module-trigger collapsed ld_header_button_61e8103f1dc26 ld_button_61e8103f1eb6f" data-ld-toggle="true" data-toggle="collapse" data-target="#dropdown-61e81618d1b14" aria-controls="dropdown-61e81618d1b14" aria-expanded="false" data-toggle-options="{ &quot;type&quot;: &quot;hoverFade&quot; }"><span><span class="btn-txt" ><i class="fas fa-user" style="color:#8cc63f"></i> ' . $username . '</span><span class="btn-icon"><i class="lqd-icn-ess icon-lqd-user"></i></span></span></a></div>'. $dropdown;
		
	} 

	
	return $content;
	
}
add_shortcode('profil', 'subscriber_connexionb');