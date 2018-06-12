<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * @var $el_class
 * @var $el_id
 * @var $this CR_VcE_Sc_Enquiry_Form
 */
$el_class = $css = $css_animation = '';
$title = $subtitle = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class_to_filter = '';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $atts['el_id'] ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $atts['el_id'] ) . '"';
}

?>
<section class="cr-module-wrap enquiry-form-wrap <?php echo esc_attr( $css_class ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?>>
	<?php if($title || $subtitle): ?> 
	<div class="cr-title-subtitle-wrapper <?php if($subtitle){ echo 'cr-title-has-subtitle'; } ?>">
		<h2 class="cr-sc-title"><span class="cr-title-inner cr-animate-when-visible"><?php echo esc_html($title); ?></span></h2>
		<?php if ($subtitle): ?>
		<h2 class="cr-sc-subtitle"><span class="cr-subtitle-inner cr-animate-when-visible"><?php echo esc_html($subtitle); ?></span></h2>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<div class="enquiry-form-inner">
		<div class="enquiry-form-con">
			<form action="https://test.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8" method="POST">
				<input type=hidden name="oid" value="00D6E000000DNMp">
				<input type=hidden name="retURL" value="https://www.chevalresidences.com/thank-you.html">

				<!--  ----------------------------------------------------------------------  -->
				<!--  NOTE: These fields are optional debugging elements. Please uncomment    -->
				<!--  these lines if you wish to test in debug mode.                          -->
				<!--  <input type="hidden" name="debug" value=1>                              -->
				<!--  <input type="hidden" name="debugEmail"                                  -->
				<!--  value="leanne@purusconsultants.com">                                    -->
				<!--  ----------------------------------------------------------------------  -->

				<label for="first_name">First Name</label> 
				<input  id="first_name" maxlength="40" name="first_name" size="20" type="text" /><br>

				<label for="last_name">Last Name</label> 
				<input  id="last_name" maxlength="80" name="last_name" size="20" type="text" /><br>

				<label for="email">Email</label> 
				<input  id="email" maxlength="80" name="email" size="20" type="text" /><br>

				<label for="phone">Phone</label> 
				<input  id="phone" maxlength="40" name="phone" size="20" type="text" /><br>

				Residence: 
				<select  id="00N6E000001gj7X" multiple="multiple" name="00N6E000001gj7X" title="Residence">
					<option value="Calico House">Calico House</option>
					<option value="Gloucester Park">Gloucester Park</option>
					<option value="Harrington Court">Harrington Court</option>
					<option value="Hyde Park Gate">Hyde Park Gate</option>
					<option value="Knightsbridge">Knightsbridge</option>
					<option value="Phoenix House">Phoenix House</option>
					<option value="Thorney Court">Thorney Court</option>
					<option value="Three Quays">Three Quays</option>
				</select><br>

				Apartment Type: 
				<select  id="00N6E000001gj90" multiple="multiple" name="00N6E000001gj90" title="Apartment Type"><option value="One Bedroom">One Bedroom</option>
					<option value="Two Bedroom">Two Bedroom</option>
					<option value="Three Bedroom">Three Bedroom</option>
					<option value="Penthouse">Penthouse</option>
					<option value="Extended Stay">Extended Stay</option>
					<option value="One Bedroom Open Plan">One Bedroom Open Plan</option>
					<option value="Executive One Bedroom">Executive One Bedroom</option>
				</select><br>

				Arriving: <span class="dateInput dateOnlyInput"><input  id="00N6E000001gj9Y" name="00N6E000001gj9Y" size="12" type="text" /></span><br>

				Departing: <span class="dateInput dateOnlyInput"><input  id="00N6E000001gj9Z" name="00N6E000001gj9Z" size="12" type="text" /></span><br>

				No of people: <input  id="00N6E000001gjAC" name="00N6E000001gjAC" size="20" type="text" /><br>

				<label for="description">Description</label> 
				<textarea name="description"></textarea><br>

				Are you an: 
				<select  id="00N6E000001gjB0" name="00N6E000001gjB0" title="Are you an"><option value="">--None--</option><option value="Agent">Agent</option>
					<option value="Corporate">Corporate</option>
					<option value="Individual">Individual</option>
				</select><br>

				How did you hear about us?: 
				<select  id="00N6E000001gjBF" name="00N6E000001gjBF" title="How did you hear about us?">
					<option value="">--None--</option>
					<option value="Google">Google</option>
					<option value="Bing">Bing</option>
					<option value="Recommendation">Recommendation</option>
					<option value="Internet Search">Internet Search</option>
					<option value="Google Ad">Google Ad</option>
					<option value="Google +">Google +</option>
					<option value="Yahoo">Yahoo</option>
					<option value="Visit London">Visit London</option>
					<option value="Visit Britain">Visit Britain</option>
					<option value="Facebook">Facebook</option>
					<option value="Twitter">Twitter</option>
					<option value="Blogs">Blogs</option>
				</select><br>

				I would like to receive email updates: <input  id="00N6E000001gjEE" name="00N6E000001gjEE" type="checkbox" value="1" /><br>

				<input class="cr-button" type="submit" name="submit">

			</form>
		</div>
	</div>
</section>