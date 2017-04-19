<?php

require_once('templates/privacy-policy.php');
require_once('templates/terms-of-use.php');
require_once('templates/disclaimers.php');
/*
purpose of this is to use standard content but allow end user to overwrite if neccessary.
*/
function mdl_build_conditions_list_medical( $faqURL='/how_it_works' ){
	ob_start();
	?>
	<div class="treatments">
		<ul id="medical" class="conditions_list">
			<li id="acne">Acne</li>
			<li id="allergies">Allergies</li>
			<li id="constipation">Constipation</li>
			<li id="cough">Cough</li>
			<li id="diarrhea">Diarrhea</li>
			<li id="ear_infections">Ear Problems</li>
			<li id="fever">Fever <a href="<?php echo $faqURL; ?>">*</a></li>
			<li id="cold_flu">Flu</li>
			<li id="headaches">Headache</li>
			<li id="insect_bites">Insect Bites</li>
			<li id="nausea">Nausea</li>
			<li id="pink_eye">Pink Eye</li>
			<li id="rashes">Rash</li>
			<li id="respiratory_infections">Respiratory Problems</li>
			<li id="sore_throat">Sore Throats</li>
			<li id="urinary_tract_infection">Urinary problems/UTI <a href="<?php echo $faqURL; ?>">*</a></li>
			<li id="vaginitis">Vaginitis</li>
			<li id="vomiting">Vomiting</li>
			<li id="and_more">...and More</li>
		</ul>
	</div>
	<?php
	return ob_get_clean();
}

function mdl_conditions_list_medical( $atts, $content='' ){
	$atts = shortcode_atts( array(
		'faqURL' => '/how_it_works',
		'selectboxname' => ''
		), $atts, 'mdl_conditions_list_medical' );
	
	$htmlStr = mdl_build_conditions_list_medical( $atts['faqURL'] );

	if($atts['selectboxname'] != '' ){
		return $atts['selectboxname'].'<hr>'.$content;
	}else{
		return $htmlStr;
	}
}
add_shortcode('mdl_conditions_list_medical','mdl_conditions_list_medical');

add_action( 'vc_before_init', 'mdl_conditions_list_medical_integrateWithVC' );
function mdl_conditions_list_medical_integrateWithVC() {
	vc_map( array(
		"name" => __( "Medical Conditions", "my-text-domain" ),
		"base" => "mdl_conditions_list_medical",
		"description" => "Add medical conditions list typically treated.",
		"class" => "conditions_list_wrapper",
		"category" => __( "MDLIVE Standard Content", "my-text-domain"),
		"params" => array(

			array(
				"type"        => "checkbox",
				"heading"     => __("<h3>Standard List</h3><div class='clearfix'>".mdl_build_conditions_list_medical()."</div>Do you want to overwrite the default list?","my-text-domain"),
				"param_name"  => "selectboxname",
				"admin_label" => true,
				"value"       => array(
					'Overwrite Default Content'=>'overwrite_default'
                                        ), //value
				"description" => __("Click to overwrite default list.")
				),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Content", "my-text-domain" ),
				"param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
				"value" => __( mdl_build_conditions_list_medical(), "my-text-domain" ),
				"description" => __( "Enter your content.", "my-text-domain" ),
				"dependency" => array(
					"element" => "selectboxname",
					"value" => "overwrite_default"
					)
				)
			)
) );
}

/* BEHAVIORAL LIST */
function mdl_build_conditions_list_behavioral( $faqURL='/how_it_works' ){
	ob_start();
	?>
	<div class="treatments">
		<ul id="behavioral" class="conditions_list">
			<li id="adictions">Addictions</li>
			<li id="bipolar_disorders">Bipolar Disorders</li>
			<li id="child_adolescent"><span style="white-space: nowrap;">Child and Adolescent Issues</li>
			<li id="depression">Depression</li>
			<li id="eating_disorders">Eating Disorders</li>
			<li id="transgender_issues"><span style="white-space: nowrap;">Gay/Lesbian/Bisexual/Transgender Issues</li>
			<li id="grief_loss">Grief and Loss</li>
			<li id="life_changes">Life Changes</li>
			<li id="men_issues">Men's Issues</li>
			<li id="panic">Panic Disorders</li>
			<li id="parenting">Parenting Issues</li>
			<li id="postpartum_depression"><span style="white-space: nowrap;">Postpartum Depression</li>
			<li id="relationship_marriage"><span style="white-space: nowrap;">Relationship and Marriage Issues</li>
			<li id="stress">Stress</li>
			<li id="trauma_ptsd">Trauma and PTSD</li>
			<li id="women_issues">Women's Issues</li>
			<li id="and_more">...and More</li>
		</ul>
	</div>
	<?php
	return ob_get_clean();
}

function mdl_conditions_list_behavioral( $atts, $content='' ){
	$atts = shortcode_atts( array(
		'faqURL' => '/how_it_works',
		'selectboxname' => ''
		), $atts, 'mdl_conditions_list_behavioral' );
	
	$htmlStr = mdl_build_conditions_list_medical( $atts['faqURL'] );

	if($atts['selectboxname'] != '' ){
		return $atts['selectboxname'].'<hr>'.$content;
	}else{
		return $htmlStr;
	}
}
add_shortcode('mdl_conditions_list_behavioral','mdl_conditions_list_behavioral');

add_action( 'vc_before_init', 'mdl_conditions_list_behavioral_integrateWithVC' );
function mdl_conditions_list_behavioral_integrateWithVC() {
	vc_map( array(
		"name" => __( "Behavioral Conditions", "my-text-domain" ),
		"base" => "mdl_conditions_list_behavioral",
		"description" => "Add behavioral conditions list typically treated.",
		"class" => "conditions_list_wrapper",
		"category" => __( "MDLIVE Standard Content", "my-text-domain"),
		"params" => array(

			array(
				"type"        => "checkbox",
				"heading"     => __("<h3>Standard List</h3><div class='clearfix'>".mdl_build_conditions_list_medical()."</div>Do you want to overwrite the default list?","my-text-domain"),
				"param_name"  => "selectboxname",
				"admin_label" => true,
				"value"       => array(
					'Overwrite Default Content'=>'overwrite_default'
                                        ), //value
				"description" => __("Click to overwrite default list.")
				),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Content", "my-text-domain" ),
				"param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
				"value" => __( mdl_build_conditions_list_medical(), "my-text-domain" ),
				"description" => __( "Enter your content.", "my-text-domain" ),
				"dependency" => array(
					"element" => "selectboxname",
					"value" => "overwrite_default"
					)
				)
			)
) );
}

/* DISCLAIMERS */

function mdl_build_disclaimers(){
	ob_start();
	?>
	<div class="disclaimers">
	<h3>Disclaimers</h3>
<p class="plsnote">* Please note: Some state laws require that a doctor can only prescribe medication in certain situations and subject to certain limitations.</p>
<p class="plsnote">* MDLIVE physicians may not treat any children with urinary symptoms.</p>
<p class="plsnote">* Parents/guardian will be required to complete a different medical history disclosure form for children under the age of 36-months prior to making an appointment with an MDLIVE physician. Children under 36 months who present with fever must be referred to their pediatrician (medical home), child-friendly urgent care center or emergency department for clinical evaluation and care.</p>
<p>MDLIVE does not replace the primary care physician. MDLIVE is not an insurance product nor a prescription fulfillment warehouse. MDLIVE operates subject to state regulation and may not be available in certain states. MDLIVE does not guarantee that a prescription will be written. MDLIVE does not prescribe DEA controlled substances, non-therapeutic drugs and certain other drugs which may be harmful because of their potential for abuse. MDLIVE physicians reserve the right to deny care for potential misuse of services. MDLIVE and the MDLIVE logo are registered trademarks of MDLIVE, Inc. and may not be used without written permission. For complete terms of use visit {terms_of_use_URL}</p>
<h3>MDLIVE Prescription Policy</h3>
<p>Doctors providing consultations for MDLIVE members offer prescriptions for a wide range of products that deliver direct medicinal value. These include, but are not limited to, drug classes such as antibiotics and antihistamines.</p>
<p>It is important to note that MDLIVE is not a drug fulfillment warehouse. In the event a doctor does prescribe medication, he/she will usually limit the supply to no more than thirty days. Patients with chronic illnesses should visit their primary care doctors or other specialists for extended care. MDLIVE doctors do not issue prescriptions for substances controlled by the DEA, for non-therapeutic use, and/or those which may be harmful (potential for abuse or addiction). For a current list of DEA controlled substances, visit <a href="http://www.deadiversion.usdoj.gov/schedules/">http://www.deadiversion.usdoj.gov/schedules/</a></p>
<p>** MDLIVE services are limited to only phone consultations with the ability to prescribe in Texas. Limited to video and ability to prescribe in Idaho. Telehealth services are currently not available in Arkansas. Please check back soon.</p>
</div>
	<?php

	return ob_get_clean();
}

function mdl_disclaimers( $atts, $content='' ){
	$atts = shortcode_atts( array(
		'faqURL' => '/how_it_works',
		'selectboxname' => ''
		), $atts, 'mdl_disclaimers' );
	$htmlStr = mdl_build_disclaimers();

	if($atts['selectboxname'] != '' ){
		return $atts['selectboxname'].'<hr>'.$content;
	}else{
		return $htmlStr;
	}
}
add_shortcode('mdl_disclaimers','mdl_disclaimers');

add_action( 'vc_before_init', 'mdl_disclaimers_integrateWithVC' );
function mdl_disclaimers_integrateWithVC() {
	vc_map( array(
		"name" => __( "Disclaimers", "my-text-domain" ),
		"base" => "mdl_disclaimers",
		"description" => "Add behavioral conditions list typically treated.",
		"class" => "disclaimers_wrapper",
		"category" => __( "MDLIVE Standard Content", "my-text-domain"),
		"params" => array(

			array(
				"type"        => "checkbox",
				"heading"     => __("<h3>Dislaimer Content</h3><div class='clearfix'>".mdl_build_disclaimers()."</div>Do you want to overwrite the default content?","my-text-domain"),
				"param_name"  => "selectboxname",
				"admin_label" => true,
				"value"       => array(
					'Overwrite Default Content'=>'overwrite_default'
                                        ), //value
				"description" => __("Click to overwrite default content.")
				),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Content", "my-text-domain" ),
				"param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
				"value" => __( mdl_build_disclaimers(), "my-text-domain" ),
				"description" => __( "Enter your content.", "my-text-domain" ),
				"dependency" => array(
					"element" => "selectboxname",
					"value" => "overwrite_default"
					)
				)
			)
) );
}
