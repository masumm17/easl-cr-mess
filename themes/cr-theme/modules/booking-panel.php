<?php
if (!defined('ABSPATH')) die('-1');

$panel_title = crt_get_theme_mode( 'booking_panel_title', '');
$panel_color = crt_get_theme_mode( 'booking_panel_color', '');
$panel_image = crt_get_mode_img( 'booking_panel_bg_image', '');

if(!in_array($panel_color, array('white', 'black'))) {
	$panel_color = 'white';
}


$panel_cl_url = crt_get_theme_mode( 'booking_panel_cl_url', '');
$panel_cl_title = crt_get_theme_mode( 'booking_panel_cl_title', '');
$panel_cl_nt = crt_get_theme_mode( 'booking_panel_cl_nt', '');

$panel_rac_url = crt_get_theme_mode( 'booking_panel_rac_url', '');
$panel_rac_title = crt_get_theme_mode( 'booking_panel_rac_title', '');
$panel_rac_nt = crt_get_theme_mode( 'booking_panel_rac_nt', '');

$panel_brg_url = crt_get_theme_mode( 'booking_panel_brg_url', '');
$panel_brg_title = crt_get_theme_mode( 'booking_panel_brg_title', '');
$panel_brg_nt = crt_get_theme_mode( 'booking_panel_brg_nt', '');

$panel_errro_message = crt_get_theme_mode( 'booking_panel_filter_error', '');


$panel_kewords = crt_get_theme_mode( 'booking_panel_kewords', '');
$panel_default_keword = crt_get_theme_mode( 'booking_panel_default_keyword', '');
$panel_residences_column = crt_get_theme_mode( 'booking_panel_dropdown_cols', '');

$panel_kewords = explode( "\n", trim($panel_kewords) );
$residences_data = array();
$residences_data_flat = array();
foreach($panel_kewords as $pwline){
	$pwline = trim($pwline);
	if(!$pwline) {
		continue;
	}
	$line_data = explode('::', $pwline);
	if(!$line_data || count($line_data) < 3) {
		continue;
	}
	if(!isset($residences_data[$line_data[0]])){
		$residences_data[$line_data[0]] = array();
	}
	$residences_data[$line_data[0]][] = array(
		'category' => $line_data[0],
		'value' => $line_data[2],
		'label' => $line_data[2],
		'disable' => !empty($line_data[3]) && ($line_data[3] == 'disable') ? true : false,
	);
	$residences_data_flat[] = array(
		'category' => $line_data[0],
		'value' => $line_data[2],
		'label' => $line_data[2],
		'disable' => !empty($line_data[3]) && ($line_data[3] == 'disable') ? true : false,
	);
}

$panel_residences_column = trim($panel_residences_column);
if($panel_residences_column) {
	$panel_residences_column = explode('|', $panel_residences_column);
}
$dropdown_columns = array();
if(count($panel_residences_column) > 0) {
	foreach($panel_residences_column as $prcol) {
		$prcol = trim($prcol);
		if(!$prcol) {
			continue;
		}
		$pr_col_groups = explode(',', $prcol);
		if(count($pr_col_groups) > 0) {
			$column_groups = array();
			foreach($pr_col_groups as $col_group) {
				if(!isset($residences_data[$col_group])){
					continue;
				}
				$column_groups[$col_group] = $residences_data[$col_group];
			}
			if(count($pr_col_groups) > 0) {
				$dropdown_columns[] = $column_groups;
			}
		}
	}
}

if(count($dropdown_columns) == 0) {
	$dropdown_columns[] = $residences_data;
}

?>
<div id="booking-panel" class="booking-panel" <?php if($panel_image){echo ' style="background-image:url('. esc_url($panel_image) .')" ';} ?>>
	<a class="booking-panel-close" href="#"></a>
	<div class="booking-panel-inner">
		<div class="booking-panel-container">
			<form class="booking-panel-form" action="" method="post">
				<?php if($panel_title): ?>
				<h2 class="booking-panel-title"><?php echo esc_html($panel_title); ?></h2>
				<?php endif; ?>
				<div class="booking-panel-fields">
					<div class="booking-panel-row">
						<div id="booking-panel-residences" class="booking-panel-col booking-panel-col1 cr-has-bg">
							<div class="booking-panel-col-inner">
								<h5 class="booking-panel-label"><?php _e('Choose your residence', 'crt') ?></h5>
								<p class="booking-panel-input-wrap">
									<select name="keyword" id="keyword" class="booking-panel-input-keword-select u-hide">
										<option value="*"><?php _e('-- All Residences --', 'crt') ?></option>
										<?php
										foreach($dropdown_columns as $dd_col):
											foreach($dd_col as $group_label => $col_group):
											?>
											<optgroup label="<?php echo esc_attr($group_label); ?>">
												<?php foreach($col_group as $group_item): ?>
												<option value="<?php echo esc_attr($group_item['value']); ?>" <?php selected($group_item['value'], $panel_default_keword) ?>><?php echo esc_html($group_item['label']) ?></option>
												<?php endforeach;?>
											</optgroup>
											<?php endforeach;?>
										<?php endforeach;?>
									</select>
									<input type="text" id="residences-keyword" value="<?php echo esc_attr(trim($panel_default_keword)); ?>" placeholder="<?php _e('City, Airport, Attraction or Hotel Name', 'crt');?>" data-errormessage="<?php echo esc_attr($panel_errro_message); ?>"/>
									<span id="residences-keyword-dummy" class="booking-panel-residences-dummy"><?php echo esc_attr(trim($panel_default_keword)); ?></span>
									<span id="booking-panel-dd-keywords" class="booking-panel-dd-icon"></span>
								</p>
								<div class="booking-panel-dd-position"></div>
							</div>
						</div>
					</div>
					<div class="booking-panel-row">
						<div class="booking-panel-col booking-panel-col2 cr-has-bg">
							<div class="booking-panel-col-inner" id="bp-arrival-date">
								<h5 class="booking-panel-label"><?php _e('Arrival Date', 'crt') ?></h5>
								<p class="booking-panel-input-wrap">
									<input type="text" value="" id="booking-panel-checkin" class="u-hide"/>
									<span class="booking-panel-value booking-panel-day"><strong></strong><span class="booking-panel-dd-icon"></span></span>
									<span class="booking-panel-monthyear"></span>
								</p>
							</div>
							<div id="booking-panel-checkin-dummy" class="bp-date-picker-div"></div>
						</div>
						<div class="booking-panel-col booking-panel-col2 cr-has-bg">
							<div class="booking-panel-col-inner bp-date-picker-div2" id="bp-departure-date">
								<h5 class="booking-panel-label"><?php _e('Departure Date', 'crt') ?></h5>
								<p class="booking-panel-input-wrap">
									<input type="text" value="" id="booking-panel-departure" class="u-hide"/>
									<span class="booking-panel-value booking-panel-day"><strong></strong><span class="booking-panel-dd-icon"></span></span>
									<span class="booking-panel-monthyear"></span>
								</p>
							</div>
							<div id="booking-panel-departure-dummy" class="bp-date-picker-div"></div>
						</div>
					</div>
					<div class="booking-panel-row booking-panel-row-acp">
						<div class="booking-panel-col booking-panel-col3 cr-has-bg">
							<div class="booking-panel-col-inner">
								<h5 class="booking-panel-label"><?php _e('Adults', 'crt') ?></h5>
								<p class="booking-panel-input-wrap">
									<select name="totalAdults" id="booking-panel-adults" class="u-hide">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4+</option>
									</select>
									<span class="booking-panel-value booking-panel-sb-trigger"><strong>1</strong><span class="booking-panel-dd-icon"></span></span>
								</p>
							</div>
							<div class="booking-panel-select-box">
								<ul>
									<li data-value="1" class="cr-sb-selected">1</li>
									<li data-value="2">2</li>
									<li data-value="3">3</li>
									<li data-value="4">4+</li>
								</ul>
							</div>
						</div>
						<div class="booking-panel-col booking-panel-col3 cr-has-bg">
							<div class="booking-panel-col-inner">
								<h5 class="booking-panel-label"><?php _e('Children', 'crt') ?></h5>
								<p class="booking-panel-input-wrap">
									<select name="totalChild1" id="booking-panel-childs" class="u-hide">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5+</option>
									</select>
									<span class="booking-panel-value booking-panel-sb-trigger"><strong>0</strong><span class="booking-panel-dd-icon"></span></span>
								</p>
							</div>
							<div class="booking-panel-select-box">
								<ul>
									<li data-value="0" class="cr-sb-selected">0</li>
									<li data-value="1">1</li>
									<li data-value="2">2</li>
									<li data-value="3">3</li>
									<li data-value="4">4</li>
									<li data-value="5">5+</li>
								</ul>
							</div>
						</div>
						<div class="booking-panel-col booking-panel-col3 cr-has-bg">
							<div class="booking-panel-col-inner">
								<h5 class="booking-panel-label"><?php _e('Promo Code', 'crt') ?></h5>
								<p class="booking-panel-input-wrap">
									<input name="promotionCode" type="text" value="" id="booking-panel-promo" placeholder="<?php echo _e('Enter promo code', 'crt') ?>" autocomplete="off"/>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="booking-panel-row booking-panel-row-submit">
					<?php if($panel_cl_title): ?>
					<div class="booking-panel-col booking-panel-col2">
						<div class="booking-panel-col-inner">
						<a class="booking-panel-link booking-panel-link-cl" href="<?php echo esc_url($panel_cl_url); ?>" <?php if($panel_cl_nt){echo 'target="_blank"';} ?> title=""><?php echo esc_html($panel_cl_title); ?></a>
						</div>
					</div>
					<?php endif; ?>
					<div class="booking-panel-col booking-panel-col2 booking-panel-col-button">
						<div class="booking-panel-col-inner">
							<button class="booking-panel-button cr-button"><span cr-button-text><?php _e('Search', 'crt'); ?></span></button>
						</div>
					</div>
				</div>
				<?php if($panel_rac_title || $panel_brg_title): ?>
				<div class="booking-panel-row booking-panel-row-bottom">
					<?php if($panel_rac_title): ?>
					<div class="booking-panel-col booking-panel-col2">
						<div class="booking-panel-col-inner">
							<a class="booking-panel-link booking-panel-link-rac" href="<?php echo esc_url($panel_rac_url); ?>" <?php if($panel_rac_title){echo 'target="_blank"';} ?> title=""><?php echo esc_html($panel_rac_title); ?></a>
						</div>
					</div>
					<?php endif; ?>
					<?php if($panel_brg_title): ?>
					<div class="booking-panel-col booking-panel-col2 booking-panel-col-brg">
						<div class="booking-panel-col-inner">
							<a class="booking-panel-link booking-panel-link-brg" href="<?php echo esc_url($panel_brg_url); ?>" <?php if($panel_brg_nt){echo 'target="_blank"';} ?> title=""><?php echo esc_html($panel_brg_title); ?></a>
						</div>
					</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	var BookingPanelData = {source: <?php echo wp_json_encode($residences_data_flat); ?>, column: <?php echo wp_json_encode($dropdown_columns); ?>};
</script>