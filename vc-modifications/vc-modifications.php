<?php
/* MODIFICATIONS TO VISUAL COMPOSER */



/*
ADD ADDITIONAL FEATURES TO DEFAULT BUTTON
add button id
add data attributes

REFERENCES
https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332#vc_map()-Addexistingshortcode
https://wpbakery.atlassian.net/wiki/display/VC/Create+New+Param+Type
*/

require_once('vc-btn3.php');
require_once('mdl-standard-content.php');
//write_log(  plugin_dir_url(__FILE__).'vc-modifications/css/vc-modifications.css'  );
function vc_mods_admin_style() {
  wp_enqueue_style('admin-styles', plugin_dir_url(__FILE__).'css/vc-modifications-admin.css');
}
add_action('admin_enqueue_scripts', 'vc_mods_admin_style');



$attributes = array(
    array(
        'type' => 'textfield',
        'heading' => "ID",
        'param_name' => 'style',
        'value' => '',
        'description' => __( "What ID do you want to give your button", "my-text-domain" )
        ),
    array(
        'type' => 'dropdown',
        'heading' => "Another Style",
        'param_name' => 'another_style',
        'value' => array( "four", "five", "six" ),
        'description' => __( "New style attribute", "my-text-domain" )
        )
    );
vc_add_params( 'vc_button', $attributes );

/* BOOTSTRAP MODAL SHORTCODE */

function mdl_bootstrap_modal_func( $atts, $content = "" ) {
    $atts = shortcode_atts( array(
        'title' => 'Default Title',
        'modal_footer' => 'N',
        'id' => 'modalID_'. rand(),
        'button_text' => 'Default Button',
        ), $atts, 'mdl_bootstrap_modal' );
    
    $modalLabel = $atts['modal_id'].'Label';

    $htmlStr = '';

    $htmlStr = '<div class="modal fade" id="'.$atts['id'].'" tabindex="-1" role="dialog" aria-labelledby="'.$modalLabel.'">';
    $htmlStr .= '<div class="modal-dialog" role="document">';
    $htmlStr .= '<div class="modal-content">';

    //HEADER
    $htmlStr .= '<div class="modal-header">';
    $htmlStr .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    if($atts['title'] != 'Default Title'){
        $htmlStr .= '<h4 class="modal-title" id="myModalLabel">'. $atts['title'] .'</h4>';
    }
    $htmlStr .= '</div>';

    ///BODY
    $htmlStr .= '<div class="modal-body">'.$content.'</div>';
    
    //FOOTER
    if($atts['modal_footer'] == 'Y'){
        $htmlStr .= '<div class="modal-footer"  >';
        $htmlStr .= '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
        $htmlStr .= '<button type="button" class="btn btn-primary">Save changes</button>';
        $htmlStr .= '</div>'; 
    }
    $htmlStr .= '</div>';

    $htmlStr .= '</div></div></div>';
    $htmlStr .= "<br>buttton should go below this<hr />";

    $htmlStr .= do_shortcode('[adv_btn id="'.$atts['id'].'_btn" button_text="'.$atts['button_text'].'"  additional_attr_labels="data-toggle|data-target" additional_attr_values="modal|#'.$atts['id'].'"    ][/adv_btn]');

    return $htmlStr;
}
add_shortcode( 'mdl_bootstrap_modal', 'mdl_bootstrap_modal_func' );

/* MAP BOOSTRAP MODAL TO VC */
add_action( 'vc_before_init', 'mdl_bootstrap_modal_integrateWithVC' );
function mdl_bootstrap_modal_integrateWithVC() {
 vc_map( array(
  "name" => __( "Bootrap Modal", "my-text-domain" ),
  "base" => "mdl_bootstrap_modal",
  "description" => "This adds a boostrap modal window.",
  "class" => "",
  "category" => __( "Content", "my-text-domain"),
  "params" => array(
   array(
    "type" => "textfield",
    "holder" => "div",
    "class" => "",
    "heading" => __( "Modal Title", "my-text-domain" ),
    "param_name" => "title",
    "value" => __( "Default Title", "my-text-domain" ),
    "description" => __( "Title to display on the modal header.", "my-text-domain" )
    ),
   array(
    "type" => "textarea_html",
    "holder" => "div",
    "class" => "",
    "heading" => __( "Content", "my-text-domain" ),
            "param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
            "value" => __( "<p>I am test text block. Click edit button to change this text.</p>", "my-text-domain" ),
            "description" => __( "Enter your content.", "my-text-domain" )
            ),
   array(
    "type" => "textfield",
    "holder" => "div",
    "class" => "",
    "heading" => __( "Modal ID", "my-text-domain" ),
    "param_name" => "id",
    "value" => __( "myModalID", "my-text-domain" ),
    "description" => __( "Give your modal an ID. Without it, you won't be able to fire off the modal window appropriately. (No spaces or special characters)", "my-text-domain" )
    ),
   array(
    "type" => "textfield",
    "holder" => "div",
    "class" => "",
    "heading" => __( "Text on Button", "my-text-domain" ),
    "param_name" => "button_text",
    "description" => __( "What link text do you want displayed?", "my-text-domain" )
    )
   )
) );
}

