<?php

function adv_btn_func( $atts, $content = '' ) {
	$atts = shortcode_atts( array(
		'button_text' => 'Text on Button',
		'link_url' => '#',
		'link_type' => 'button',
		'id' => 'adv_btn_id',
		'additional_attr_labels' => '',
		'additional_attr_values' => '',
		'additional_css_classes' => '',
		'regular_link_style' => 0,
		'data_attributes_str' => ''
		), $atts, 'adv_btn' );
	
	$htmlStr = '';
	$dataAttributesStr = '';

	//build additional data attributes
		$dataAttributesLabels_arr = array();
		if($atts['additional_attr_labels'] != ''){
			$dataAttributesLabels_arr = explode( '|', $atts['additional_attr_labels'] );
		}

		$dataAttributesValues_arr = array();
		if($atts['additional_attr_values'] != ''){
			$dataAttributesValues_arr = explode( '|', $atts['additional_attr_values'] );
		}

	//each attribute label must have a value
		if(count($dataAttributesLabels_arr) == count($dataAttributesValues_arr) ){
			for($i=0; $i<count($dataAttributesLabels_arr); $i++ ){
				$dataAttributesStr.= $dataAttributesLabels_arr[$i] .'="'.  $dataAttributesValues_arr[$i]. '" ';
			}
		}

	/* 
		data_attributes_str takes precendence,
		otherwise create data attributes off of pipe separated strings
	*/
	if($atts['data_attributes_str'] != ''){
		$dataAttributesStr = $atts['data_attributes_str'];
	}

//	write_log(__FILE__ . __LINE__ . ":" . $atts['link_url']);
//	write_log(vc_build_link( $atts['link_url'] ));

	$link_val_arr = vc_build_link( $atts['link_url'] );
	
	$targetStr ='';
	if($link_val_arr['target']){
		$targetStr = "target='".trim($link_val_arr['target'])."'";
	}

	///all based off of VC classic style
	$btnShape = 'vc_btn3-shape-rounded';
	$btnSize = 'vc_btn3-size-md';
	$btnColor = 'vc_btn3-color-grey';

	$css_classes = "vc_general vc_btn3 $btnSize $btnShape vc_btn3-style-classic $btnColor ". $atts['additional_css_classes'];

	$openTag = "<a id='".$atts['id']."' href='". $link_val_arr['url'] ."' class='". $css_classes ."' $dataAttributesStr $targetStr >";
	$closeTag =  '</a>';

	//write_log($atts['button_text']);

	if($link_val_arr['title'] != null){
		$content = $link_val_arr['title'];
	}else{
		$content = $atts['button_text'];
	}

	$htmlStr .= $openTag . $content . $closeTag;

	return $htmlStr;
}
add_shortcode( 'adv_btn', 'adv_btn_func' );


/*
<button class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-rounded vc_btn3-style-modern vc_btn3-icon-left vc_btn3-color-grey" data-toggle="modal" data-target="#videoModal"><i class="vc_btn3-icon fa fa-play-circle"></i> Click for Video</button>
*/
/* INTEGRATE WITH VISUAL COMPOSER */
//vc_add_shortcode_param('data_attributes','data_attributes_fields',plugin_dir_url(__FILE__).'vc-modifications/js/vc-btn3-add-remove-data-attrs.js');
vc_add_shortcode_param('data_attributes','data_attributes_fields');
function data_attributes_fields( $settings, $value ) {
	ob_start();
	?>
	<div class="data_parameters_block">
		<?php
		echo '<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput wpb-data-key' .
		esc_attr( $settings['param_name'] ) . ' ' .
		esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" />' ;
		?>
		<div class="data_parameters_keypair_wrapper">
		<div class="data_parameters_keypair vc_row">
			<div class="wpb_vc_column vc_col-sm-5 keyWrapper">
				<input class="data_attr_key" type="text" placeholder="Key" >
				<div class="error_note">* Required</div>
			</div>
			<div class="wpb_vc_column vc_col-sm-5 valWrapper">
				<input class="data_attr_val" type="text" placeholder="Value">
				<div class="error_note">* Required</div>
			</div>
			<div class="wpb_vc_column vc_col-sm-2 text-right">
				<button class="btn-add-data-attr">+</button>
				<button class="btn-delete-data-attr">-</button>
			</div>
		</div>
		 
		</div>

		<script type="text/javascript">
		
		function vc_set_data_attrs_str (){
			var htmlStr = '';
			jQuery(".data_parameters_keypair").each(function(idx){
				var dataAttrKey = jQuery(this).find(".data_attr_key").val(); 
				var dataAttrVal = jQuery(this).find(".data_attr_val").val();
				if(dataAttrKey != '' && dataAttrVal != '' ){
					if(idx > 0){
						htmlStr += ' ';
					}
					htmlStr += dataAttrKey + '=' + dataAttrVal ;
				}
			});
			jQuery('input[name=data_attributes_str]').val(htmlStr);
		}

		jQuery(".btn-delete-data-attr").click(function(e){
			e.preventDefault();
			var n = jQuery( ".data_parameters_keypair" ).length;
			var baseEl = jQuery(this).closest('.data_parameters_keypair');
			if(n > 1){
				baseEl.remove();
			}else{
				baseEl.find(".data_attr_key").val('');
				baseEl.find(".data_attr_val").val('');
			}
			vc_set_data_attrs_str();
		});

		jQuery(".btn-add-data-attr").click(function(e){
			e.preventDefault();
			//check if both have values
			var baseEl = jQuery(this).closest('.data_parameters_keypair');
			var dataAttrKey = jQuery.trim( baseEl.find(".data_attr_key").val() );
			var dataAttrVal = jQuery.trim( baseEl.find(".data_attr_val").val() );
			
			baseEl.find('.error_note').hide();

			if(dataAttrKey != '' && dataAttrVal != '' ){
				vc_set_data_attrs_str();
				cloneEl = baseEl.clone(true); 
				cloneEl.insertAfter(baseEl);
				cloneEl.find(".data_attr_key").val('');
				cloneEl.find(".data_attr_val").val('');
			}else{
				if(dataAttrKey == ''){
					baseEl.find(".keyWrapper .error_note").show();
				}
				if(dataAttrVal == ''){
					baseEl.find(".valWrapper .error_note").show();
				}
			}
		}); 

		jQuery(".data_attr_key, .data_attr_val").focusout(function(event) {
			vc_set_data_attrs_str();
		});

		/* BUILD OUT KEY/VALUE ARRAY ON INITIAL VIEW */
		 if(jQuery("input[name='data_attributes_str']").val() != ''){
		 	var tmp_arr = jQuery("input[name='data_attributes_str']").val().split(" ");
		 	//explode on spaces
		 	var baseEl = jQuery(".data_parameters_keypair");
		 	
		 	for(var i=0;i<tmp_arr.length;i++){
		 		//data_parameters_keypair
		 		if(i > 0){
		 			baseEl.clone(true).appendTo('.data_parameters_keypair_wrapper');
		 		}
		 		 var currEl = jQuery(".data_parameters_keypair").eq(i);
		 		 var tmp_arr2 = tmp_arr[i].split("=");
		 		 currEl.find(".data_attr_key").val(tmp_arr2[0]);
		 		 currEl.find(".data_attr_val").val(tmp_arr2[1]);
		 	}
		 }
		</script>

		<style type="text/css">
		.error_note{
			display: none;
			color: #f00;
			font-size: .8em;
		}
		.data_parameters_keypair{
			padding-top: 1em;
		}
		.data_parameters_keypair:nth-of-type(1){
			padding-top: 0;
		}
		</style>

		<?php

		$content = ob_get_clean();
		return $content;

        }//end data_attributes_fields function

        add_action( 'vc_before_init', 'adv_btn_integrateWithVC' );
        function adv_btn_integrateWithVC() {
        	vc_map( array(
        		"name" => __( "Advanced Button", "my-text-domain" ),
        		"base" => "adv_btn",
        		"description" => "This adds an advanced button.",
        		"class" => "",
        		"category" => __( "Content", "my-text-domain"),
        		"params" => array(
        			array(
        				"type" => "textfield",
        				"holder" => "div",
        				"class" => "",
        				"heading" => __( "Text on Button", "my-text-domain" ),
        				"param_name" => "button_text",
        				"value" => __( "Default Button", "my-text-domain" ),
        				"description" => __( "Title to display on the button header.", "my-text-domain" )
        				),
        			array(
        				"type" => "vc_link",
        				"holder" => "div",
        				"class" => "",
        				"heading" => __( "Link", "my-text-domain" ),
        				"param_name" => "link_url",
        				"value" => __( "#", "my-text-domain" ),
        				"description" => __( "What is your link?", "my-text-domain" )
        				),
        			array(
        				"type" => "textfield",
        				"holder" => "div",
        				"class" => "",
        				"heading" => __( "Button ID", "my-text-domain" ),
        				"param_name" => "id",
        				"value" => __( "myButtonID", "my-text-domain" ),
        				"description" => __( "Give your button an ID. (No spaces or special characters)", "my-text-domain" )
        				),
        			array(
        				"type" => "textfield",
        				"holder" => "div",
        				"class" => "",
        				"heading" => __( "Extra CSS classes", "my-text-domain" ),
        				"param_name" => "additional_css_classes",
        				"value" => __( "", "my-text-domain" ),
        				"description" => __( "Separate additional CSS classes by spaces", "my-text-domain" )
        				),
        			array(
        				"type" => "data_attributes",
        				"holder" => "div",
        				"class" => "",
        				"heading" => __( "Data Attributes", "my-text-domain" ),
        				"param_name" => "data_attributes_str",
        				"value" => __( "", "my-text-domain" ),
        				"description" => __( "Add any additional data attributes in key/pair combinations. No spaces for values.", "my-text-domain" )
        				)
        			)
) );
}

