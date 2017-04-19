<?php
function mdl_legal_disclaimers($atts,$content=''){
	ob_start();
	?>

	<div class="disclaimers-content">
      <h1 class="disclaimers-content-title">Disclaimers</h1>

      <ul class="disclaimers-content-list generic_270_disclaimers">
        <li>MDLIVE is not an insurance product or a prescription fulfillment warehouse.</li>
        <li>MDLIVE does not replace the existing primary care physician relationship.</li>
        <li>Medical services rendered by your physician are subject to their professional judgment.</li>
        <li>MDLIVE operates subject to state regulation and may not be available in certain states.</li>
        <li>MDLIVE does not guarantee that a prescription will be written.</li>
        <li>MDLIVE physicians do not prescribe DEA controlled substances, non-therapeutic drugs and certain other drugs which may be harmful because of their potential for abuse.</li>
        <li>MDLIVE physicians reserve the right to deny care for potential misuse of services.</li> 
        <li>MDLIVE phone consultations are available 24/7/365, while video consultations are available during the hours of 7 am to 9 pm, 7 days a week or by scheduled availability.</li>
        <li>International consultations are advice-only. You must have a U.S. address and a U.S.-based phone number for the doctor to call back at the time of consultation.</li>
        <li>Video is not available for international consultations.</li>
        <li>Prescriptions are not available for international consultations.</li>
        <li>MDLIVE and the MDLIVE logo are registered trademarks of MDLIVE, Inc. and may not be used without written permission.</li>
        <li>MDLIVE services are limited to interactive-audio consultations along with the ability to prescribe in Texas. Services in Oklahoma and Idaho are limited to audio-video along with the ability to prescribe. Telehealth services are currently not available in Arkansas.</li>
      </ul>

      <p class="disclaimers-content-copyright">Copyright © 2017 MDLIVE, Inc.</p>      
    </div>

		<?php
		return ob_get_clean();
	}
	add_shortcode('mdl_legal_disclaimers','mdl_legal_disclaimers');
