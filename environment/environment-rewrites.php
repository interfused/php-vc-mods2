<?php
/**
 * mdl_env_url_rewrites
 *
 * Takes page content within Visual Composer and removes *.mdlive.com specific urls and replaces them with shortcodes equivalents thus making server migrations easier by having dynamic paths inserted.
 * //regex pattern: (?:http|https)://(?:\w*-|)(\w*).mdlive.com
 * //regext tester (http://www.phpliveregex.com/)
 * EX: "This is my sample url: https://members.mdlive.com/company/myimg.jpg" would return "This is my sample url: [env var='MEMBERS']/company/myimg.jpg"	
 *
 * @since 1.0.0
 *
 * @param string $content Content within wordpress page/post
 * @return string
 */
function mdl_env_url_rewrites($content){
	$pattern = "/(?:http|https)(:\/\/|%3A%2F%2F)(?:\w*-|)(\w*).mdlive.com/";
	$content = preg_replace_callback(
		$pattern,
		function ($matches) {
			
			return "[env var='".strtoupper($matches[2])."'". ($matches[1]=='%3A%2F%2F'? " encoded":"" ) ."]";
		} ,
		$content
		);

	$content=str_replace(array(get_site_url(),urlencode(get_site_url())),array("[env var='SITE']","[env var='SITE' encoded]"),$content);

	return $content;
}
add_filter( 'content_save_pre', 'mdl_env_url_rewrites', 1000000, 1 );

function mdl_test340(){
$tmp = get_post(15);
write_log( '' );
write_log( '' );
write_log( '' );
write_log( $tmp->post_content );
//write_log($post->post_content);

}
add_filter('vc_before_init_base','mdl_test340');
add_filter('vc_after_init_base','mdl_test340');

function mdl_env_url_setter($atts){
	switch($atts['var']){
		case "MEMBERS":
		case "PATIENT":
		return Environment::get_var( $atts['var'] ); 
		break;
		case "SITE":
		return get_site_url();
		break;
		default:
		return $atts['var'];
		break;
	}
}

function mdl_process_env_shortcode($content){
	//write_log("////////////////// BEFORE");
	
	//write_log($content);
	if ( false === strpos( $content, '[env' ) ) {
		return $content;
	}

	$pattern = "/\[env var='(\w*)'(?:\s|)(encoded|)\]/";

	$content = preg_replace_callback(
		$pattern,
		function ($matches) {
			$env = (array("var" => $matches[1] ));
			if(!empty($matches[2])){
				//escape env output
				$env = urlencode($env);
			}
			return $env;
		} ,
		$content
		);	
	//write_log("//////////////////AFTER");
	//write_log($content);
	return $content;
}
add_filter( 'the_content', "mdl_process_env_shortcode" ,0 );
add_filter( 'the_editor_content', "mdl_process_env_shortcode" ,0 );

add_filter( 'vc_base_build_shortcodes_custom_css', "mdl_process_env_shortcode" ,0 );
