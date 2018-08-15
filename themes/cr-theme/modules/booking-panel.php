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


$panel_kewords = trim(crt_get_theme_mode( 'booking_panel_kewords', ''));
$panel_residences_column = crt_get_theme_mode( 'booking_panel_dropdown_cols', '');

$panel_kewords = json_decode($panel_kewords, true);
if(!is_array( $panel_kewords)) {
	$panel_kewords = array();
}
$residences_data = array();
$residences_data_flat = array();
$default_keword_args = array(
	'label' => '',
	'group' => '',
	'keyword' => '',
	'search' => array(),
	'action' => '',
	'status' => 'active',
	'default' => 'no',
);
$panel_default_keword = '';
$panel_default_label = '';
$form_action = 'https://secure.chevalresidences.com/portal/site/www.chevalresidences.com/index.php';
foreach($panel_kewords as $kw_item){
	$kw_item = wp_parse_args($kw_item, $default_keword_args);
	$kw_item['label'] = trim($kw_item['label']);
	$kw_item['group'] = trim($kw_item['group']);
	$kw_item['keyword'] = trim($kw_item['keyword']);
	$kw_item['action'] = trim($kw_item['action']);
	$kw_item['status'] = trim($kw_item['status']);
	
	if(!$kw_item['label'] || !$kw_item['group'] || !$kw_item['keyword'] || !$kw_item['action']) {
		continue;
	}
	if($kw_item['status'] == 'hide') {
		continue;
	}
	if(!is_array($kw_item['search'])) {
		$kw_item['search'] = array();
	}
	$kw_item['search'] = array_merge($kw_item['search'], array($kw_item['label'], $kw_item['keyword']));
	if(!isset($residences_data[$kw_item['group']])){
		$residences_data[$kw_item['group']] = array();
	}
	$residences_data[trim($kw_item['group'])][] = array(
		'category' => $kw_item['group'],
		'keyword' => $kw_item['keyword'],
		'search' => $kw_item['search'],
		'value' => $kw_item['label'],
		'action' => $kw_item['action'],
		'disable' => $kw_item['status'] == 'inactive' ? true : false,
	);
	$residences_data_flat[] = array(
		'category' => $kw_item['group'],
		'keyword' => $kw_item['keyword'],
		'search' => $kw_item['search'],
		'value' => $kw_item['label'],
		'disable' => $kw_item['status'] == 'inactive' ? true : false,
	);
	if($kw_item['default'] == 'yes') {
		$form_action = $kw_item['action'];
		$panel_default_keword = $kw_item['keyword'];
		$panel_default_label = $kw_item['label'];
	}
}

$panel_residences_column = trim($panel_residences_column);
if($panel_residences_column) {
	$panel_residences_column = explode('|', $panel_residences_column);
}
$dropdown_columns = array();
$first_group = '';
if(count($panel_residences_column) > 0) {
	$column_count = 0;
	foreach($panel_residences_column as $prcol) {
		$prcol = trim($prcol);
		if(!$prcol) {
			continue;
		}
		$column_count++;
		$pr_col_groups = explode(',', $prcol);
		if(count($pr_col_groups) > 0) {
			$column_groups = array();
			$column_group_count = 0;
			foreach($pr_col_groups as $col_group) {
				if(!isset($residences_data[$col_group])){
					continue;
				}
				$column_group_count++;
				if($column_count == 1 && $column_group_count == 1){
					$first_group = $col_group;
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
			<form class="booking-panel-form" action="<?php echo esc_url($form_action) ?>" method="post">
				<?php if($panel_title): ?>
				<h2 class="booking-panel-title"><?php echo esc_html($panel_title); ?></h2>
				<?php endif; ?>
				<div class="booking-panel-fields">
					<div class="booking-panel-row">
						<div id="booking-panel-residences" class="booking-panel-col booking-panel-col1 cr-has-bg">
							<div class="booking-panel-col-inner">
								<h5 class="booking-panel-label"><?php _e('Choose your residence', 'crt') ?></h5>
								<div class="booking-panel-kw-wraper">
									<p class="booking-panel-input-wrap">
										<select name="keyword" id="keyword" class="booking-panel-input-keword-select u-hide">
											<option value="" data-actionurl=""><?php _e('-- Select a Residence --', 'crt') ?></option>
											<option value="*" data-actionurl="https://secure.chevalresidences.com/portal/site/www.chevalresidences.com/index.php"><?php _e('-- All Residences --', 'crt') ?></option>
											<?php
											foreach($dropdown_columns as $dd_col):
												foreach($dd_col as $group_label => $col_group):
												?>
												<optgroup label="<?php echo esc_attr($group_label); ?>">
													<?php foreach($col_group as $group_item): ?>
													<option value="<?php echo esc_attr($group_item['keyword']); ?>" <?php selected($group_item['keyword'], $panel_default_keword) ?> data-actionurl="<?php echo esc_url($group_item['action']); ?>"><?php echo esc_html($group_item['value']) ?></option>
													<?php endforeach;?>
												</optgroup>
												<?php endforeach;?>
											<?php endforeach;?>
										</select>
										<input type="text" id="residences-keyword" value="<?php echo esc_attr(trim($panel_default_label)); ?>" placeholder="<?php _e('City, Airport, Attraction or Hotel Name', 'crt');?>" data-errormessage="<?php echo esc_attr($panel_errro_message); ?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" data-gramm="false"/>
										<span id="residences-keyword-dummy" class="booking-panel-residences-dummy"><?php echo esc_attr(trim($panel_default_label)); ?></span>
										<span id="booking-panel-dd-keywords" class="booking-panel-dd-icon"></span>
									</p>
								</div>
								<div class="booking-panel-dd-position"></div>
							</div>
						</div>
					</div>
					<div class="booking-panel-row">
						<div class="booking-panel-col booking-panel-col2 cr-has-bg">
							<div class="booking-panel-col-inner" id="bp-arrival-date">
								<h5 class="booking-panel-label"><?php _e('Arrival Date', 'crt') ?></h5>
								<p class="booking-panel-input-wrap">
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
									<input type="hidden" id="promo_preserve_dates" name="promo_preserve_dates" value="1"/>
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
					<div class="booking-panel-col booking-panel-col-button <?php if(!$panel_cl_title){echo 'booking-panel-col1';}else{echo 'booking-panel-col2';} ?>">
						<div class="booking-panel-col-inner">
							<input type="hidden" value="" id="booking-panel-day" name="day"/>
							<input type="hidden" value="" id="booking-panel-ym" name="yearMonth"/>
							<input type="hidden" value="" id="booking-panel-checkin" name="checkin"/>
							<input type="hidden" value="" id="booking-panel-nights" name="nights"/>
							<input type="hidden" value="false" id="booking-panel-multiroom" name="multiRoom"/>
							<button class="booking-panel-button cr-button"><span cr-button-text><?php _e('Search', 'crt'); ?></span></button>
						</div>
					</div>
				</div>
				<?php if($panel_rac_title || $panel_brg_title): ?>
				<div class="booking-panel-row booking-panel-row-bottom">
					<?php if($panel_rac_title): ?>
					<div class="booking-panel-col booking-panel-col2">
						<div class="booking-panel-col-inner">
							<a class="booking-panel-link booking-panel-link-rac" href="<?php echo esc_url($panel_rac_url); ?>" <?php if($panel_rac_nt){echo 'target="_blank"';} ?> title=""><?php echo esc_html($panel_rac_title); ?></a>
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
				<div class="booking-panel-message">
					<div class="booking-panel-message-inner">
						<div class="booking-panel-message-text"></div>
						<div class="booking-panel-message-close">
							<a class="cr-button" href="#"><?php _e('OK', 'crt') ;?></a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	<?php
	$residences_data_flat[] = array(
		'category' => $first_group,
		'keyword' => "*",
		'search' => array(__('All Residences', 'crt')),
		'value' => __('All Residences', 'crt'),
		'disable' => false,
	);
	$dropdown_columns[0][$first_group][] = array(
		'category' => $first_group,
		'keyword' => "*",
		'search' => array(__('All Residences', 'crt')),
		'value' => __('All Residences', 'crt'),
		'disable' => false,
	);
	//var_dump( $first_group);die();
	?>
	var BookingPanelData = {source: <?php echo wp_json_encode($residences_data_flat); ?>, column: <?php echo wp_json_encode($dropdown_columns); ?>};
</script>