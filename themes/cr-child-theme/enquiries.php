	<!--
	USE this code to insert in text editor:

	<iframe id="enquiry-form" src="https://chevalres.wpengine.com/wp-content/themes/cr-child-theme/enquiries.php" seamless="seamless" scrolling="no" frameborder="0" style=""></iframe>
	<style>#enquiry-form{width: 100% !important; height:2400px;}
	@media only screen and (max-width: 320px){#enquiry-form {height: 2400px;}}
	@media only screen and (min-width: 334px){#enquiry-form {height: 1850px;}}
	@media only screen and (min-width: 481px){#enquiry-form {height: 1650px;}}
	@media only screen and (min-width: 481px){#enquiry-form {height: 2000px;}}
	@media only screen and (min-width: 504px){#enquiry-form {height: 1600px;}}</style>

	-->

<?php if( $_SERVER['REQUEST_METHOD'] == 'POST' ) : ?>

	<?php
		// Fetching Values from URL.
		$name = $_POST['name1'];	
		$email = $_POST['email1'];
		$date1 = $_POST['date1'];
		$date2 = $_POST['date2'];
		$contact = $_POST['contact1'];
		
		$pplno = $_POST['pplno1'];
		$details = $_POST['details1'];
		$cust_type = $_POST['cust_type1'];
		$source = $_POST['source1'];
		$email_updates = $_POST['email_updates1'];
		$room_selections = $_POST['room_selections1'];
		$prop_array =  $_POST['prop_array1'];
			
		//$to = 'jaspreet.singh@avvio.com, reservations@chevalresidences.com';
		$to = 'barry.flanagan@avvio.com';//'reservations@chevalresidences.com';
		
		foreach ($prop_array as $key => $value) {
			switch($value)
			{	case 'Cheval Three Quays':
	        		$to .= ', ' . 'ctq@chevalresidences.com';
	        		break;
	    		case 'Cheval Knightsbridge':
	        		$to .= ', ' . 'ck@chevalresidences.com';
	        		break;
	        	case 'Cheval Phoenix House':
	        		$to .= ', ' . 'cph@chevalresidences.com';
	        		break;
	        	case 'Cheval Calico House':
	        		$to .= ', ' . 'cch@chevalresidences.com';
	        		break;
	        	case 'Cheval Harrington Court':
	        		$to .= ', ' . 'chc@chevalresidences.com';
	        		break;
	        	case 'Cheval Gloucester Park':
	        		$to .= ', ' . 'cgp@chevalreservations.com';
	        		break;
	        	case 'Cheval Thorney Court':
	        		$to .= ', ' . 'ctc@chevalresidences.com';
	        		break;
	        	case 'Cheval Hyde Park Gate':
	        		$to .= ', ' . 'chpg@chevalresidences.com';
	        		break;        						
	    		default:
	        		break;
			}
		}
		
		$email = filter_var($email, FILTER_SANITIZE_EMAIL); // Sanitizing E-mail.
		// After sanitization Validation is performed
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {		
			$subject = 'Cheval Contact form Enquiry from ' .$name;
			// To send HTML mail, the Content-type header must be set.
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From:' . $email. "\r\n"; // Sender's Email
			$template = '<div>Query from ' . $name . ',<br/>'
			. 'Details:<br/>'
			. 'Name: ' . $name . '<br/>'
			. 'Email: ' . $email . '<br/>'
			. 'Contact No: ' . $contact . '<br/>'
			. $room_selections . '<br/>'
			. 'Arrival Date: ' . $date1 . '<br/>'
			. 'Depart Date: ' . $date2 . '<br/>'
			. 'No of people: ' . $pplno . '<br/>'
			. 'Enquiry Details: ' . $details . '<br/>'
			. 'Customer Type: ' . $cust_type . '<br/>'
			. 'How did you hear about us : ' . $source . '<br/>'
			. 'Agree to receive emails: ' . $email_updates . '<br/>'		
			. '<br/>'
			. 'Please reply to customer as soon as possible .</div>';
			$sendmessage = "<div>" . $template . "</div>";
			// Message lines should not exceed 70 characters (PHP rule), so wrap it.
			$sendmessage = wordwrap($sendmessage, 70);
			// Send mail by PHP Mail Function.
			mail( $to, $subject, $sendmessage, $headers);
			echo "Your Query has been received, We will contact you soon.";		
		} 
		else {
			echo "<span>* invalid email *</span>";
		}
	?>

<?php else : ?>

	<html>
		<!DOCTYPE html>
		<head>
			<meta charset="utf-8" />
			<title>Enquiries | 5 Star Serviced Apartments Central London - Cheval Residences</title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">

			<style>
				@import url('https://fonts.googleapis.com/css?family=Open+Sans');
				body {background-color: white !important;}
				form.contact_form{margin: 10px; padding: 10px;}
				form.contact_form .inputfield {max-width: 500px !important; padding: 15px 10px;}
				form.contact_form span {display: block; overflow: hidden;}
				form.contact_form .inputfield input {width: 200px !important;}
				form.contact_form .inputfield input#email_updates { width: 13px !important; }
				form.contact_form .inputfield select {width: 200px !important;} 
				form.contact_form .inputfield textarea {width: 200px !important;} 
				form.contact_form label#acc-choices-label{padding-right:170px;}
				form.contact_form .inputfield.privacy_policy a {color: #E7A615;}
				body {
					    color: #2e2e2e !important;
					    font-family: Open-Sans, sans-serif; !important;
					    font-size:  13px !important;
					    font-weight: 400 !important;
				}
					    
				form.contact_form .inputfield input {color:#ded1b7; font-size:  13px !important;font-weight: 400 !important; font-family: Open-Sans, sans-serif; !important;}
				form.contact_form .inputfield select {color:#ded1b7; font-size:  13px !important;font-weight: 400 !important; font-family: Open-Sans, sans-serif; !important;}
				form.contact_form .inputfield input#submit{color:#2e2e2e;}
			</style>
			<link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
			<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
			<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
			<!--
			<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/i18n/jquery-ui-i18n.min.js"></script>
			-->
		</head>

		<body>
			<form class="ym-form contact_form test" id="form">
				<p id="returnmessage"></p>
				<div class="inputfield"><label for="name">Name *</label><span><input id="name"/></span></div>
			    <div class="inputfield"><label for="email">Email *</label><span><input id="email"/></span></div>
			    <div class="inputfield"><label for="tel">Contact No *</label><span><input id="tel"/></span></div>	   
			    
			    <div class="inputfield choices"><label id="acc-choices-label">Accommodation * </label>				
			    	<div id="acc-choices"><div id="text-choices">Click here for choices  <i class="fa fa-caret-down 2x" style="display: block;"></i> <i style="display: none;" class="fa fa-caret-up 2x"></i></div></div></div>

			    <div class="inputfield selection" id="make_sel">
					<a href="#" class="tooltip"><i class="fa fa-info-circle"></i>
						<span>Please select your choice of Property and Apartments for stay.</span>
					</a>		
				    <div id="mcq">
				    	<div class="element prop1" id="prop1">Cheval Three Quays</div>
				    	<div class="element prop2" id="prop2">Cheval Knightsbridge</div>
				    	<div class="element prop3" id="prop3">Cheval Phoenix House</div>
				    	<div class="element prop4" id="prop4">Cheval Calico House</div>
				    	<div class="element prop5" id="prop5">Cheval Harrington Court</div>
				    	<div class="element prop6" id="prop6">Cheval Gloucester Park</div>
						<div class="element prop7" id="prop7">Cheval Thorney Court</div>
						<div class="element prop8" id="prop8">Cheval Hyde Park Gate</div>
				    	<div class="element prop9" id="prop9">Any Residences</div>
				    </div>
				    <div id="valid_choices">
				    	<div class="element feature1 one_bed">One Bedroom</div>
				    	<div class="element feature2 two_bed">Two Bedroom</div>
				    	<div class="element feature3 three_bed">Three Bedroom</div>
				    	<div class="element feature4 ph">Penthouse</div>
				    	<div class="element feature5 ex_stay">Extended Stay</div>
				    	<div class="element feature6 one_bed_open">One Bedroom Open Plan</div>
				    	<div class="element feature7 one_bed_exec">Executive One Bedroom</div>
				    	<div class="all_elements all_rooms interim">All Rooms</div>
				    	<!--<div class="element feature9">Adjoined Twin Rooms</div>
				    	<div class="element feature10">All Rooms</div>-->		    	
				    </div>
				    <div id="reset_all">Clear All (dev only)</div>
					<div id="show_selection">Show output (dev only)</div>
			    </div>
			    <div class="inputfield"><label readonly="readonly" for="datepicker_one">Arriving *</label><span><input type="text" id="datepicker_one"/></span></div> 
			    <div class="inputfield"><label readonly="readonly" for="datepicker_two">Departing *</label><span><input type="text" id="datepicker_two"/></span></div> 
				<div class="inputfield">
					<label for="pplno">No of people *</label>
					<span>
					<select id="pplno">
						<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>
						<option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option>
					</select>
					</span>
				</div>		
				<div class="inputfield with_text"><label for="details">Enquiry Details</label><span><textarea id="details" rows="5"></textarea></span></div>
				<div class="inputfield">
					<label for="cust_type">Are you an *</label>
					<span>
					<select id="cust_type">
						<option value="Individual">Individual</option>
						<option value="Agent">Agent</option>
						<option value="Company">Company</option>
					</select>
					</span>
				</div>
				<div class="inputfield">
					<label for="cust_type">How did you hear about us?</label>
					<span>
					<select id="source">
						<option value="Google">Google</option><option value="Bing">Bing</option><option value="Recommendation">Recommendation</option>
						<option value="Internet search">Internet search</option><option value="Google Ad">Google Ad</option><option value="Google +">Google +</option>
						<option value="Yahoo">Yahoo</option><option value="Visit London">Visit London</option><option value="Visit Britain"> Visit Britain</option>
						<option value="Facebook">Facebook</option><option value="Twitter">Twitter</option><option value="Blogs">Blogs</option>
					</select>
					</span>
				</div>
			 	<div class="inputfield"><input type="checkbox" id="email_updates" checked="checked"> I would like to receive email updates from Cheval Residences<br></div>
			    <div class="inputfield"><input class="bookbutton" type="button" id="submit" value="Enquire Now"/></div>	
				<div class="inputfield privacy_policy"><a href="http://www.chevalresidences.com/cookies" target="_blank">Read our privacy policy</a></div> 	
			</form>
			<div class="selections"></div>
		</body>

		<script>
		/*Date Validation*/
		(function ($) {
			$("#datepicker_one").datepicker({
				onSelect: function(selected) {
				$("#datepicker_two").datepicker("option","minDate", selected)

				}
			});

			$("#datepicker_two").datepicker({
				onSelect: function(selected) {
				$("#datepicker_one").datepicker("option","maxDate", selected)

				}
			});
		}(jQuery));

		//head.ready( function( $ ) {

		(function ( $ ) {

			var media_query_indicator = $( '.media-query-indicator' ).first();	
			$.datepicker.setDefaults($.datepicker.regional['']);
			$( "#datepicker_one, #datepicker_two" ).datepicker( {
				 dateFormat: "d MM, yy",
				 minDate: 0,
				 onSelect: function(){
					 if( true === jQuery(this).is('#datepicker_one') )
					 {
						$('#datepicker_two').datepicker( 'option', 'minDate', jQuery(this).val() );
					 }
				 }
			});

			$('.choices').toggle(
				function(){
					$('.fa-caret-down').hide();	
					$('.fa-caret-up').show();	
					$('.selection').slideDown(500);
					/*
					if(media_query_indicator.css( 'z-index' ) > 0 )
						$('html, body').animate({
							scrollTop: $("#make_sel").offset().top - 95
						}, 2000);

					*/
				},
				function(){
					$('.selection').slideUp(500);
					$('.fa-caret-up').hide();
					$('.fa-caret-down').show();
				});
			
		 
			//$('.choices').trigger('click');
			var feature_arr = {
					"prop1": ["two_bed", "three_bed", "ph", "one_bed"],
					"prop2": ["two_bed", "three_bed", "ph", "ex_stay"],
					"prop3": ["one_bed_open", "one_bed", "two_bed"],
					"prop4": ["one_bed_open", "one_bed", "two_bed", "ph"],
					"prop5": ["one_bed_open", "one_bed", "two_bed", "ex_stay", "one_bed_exec"],
					"prop6": ["two_bed", "three_bed", "ph", "one_bed"],
					"prop7": ["two_bed", "three_bed", "ph"],
					"prop8": ["two_bed", "three_bed", "one_bed"],
					"prop9": ["one_bed", "two_bed", "three_bed", "ph", "one_bed_open", "one_bed_exec", "ex_stay"],	
				};

			$.each(feature_arr, function(i,v){
				$.each(v, function(k, e){
					$("#valid_choices ."+e).addClass(i);						
				});
			});

			$('#valid_choices .element').addClass('disabled');
			$('#mcq .element').click(function (e)
			{
				e.preventDefault();
				$('#valid_choices').slideDown(250);
				var selected = [];
				var this_id = $(this).attr('id');
				if ($(this).hasClass('on'))
				{
					$(this).removeClass('on');
					$('#mcq .element').each(function(){
						if ($(this).hasClass('on'))
						{
							selected.push($(this).attr('id'));
						}
					});
					$('#valid_choices .'+this_id).each(function () {
						var reset = true;
						var e = $(this);
						$.each(selected, function(k,v){
							if (e.hasClass(v))
								reset = false;
						});
						
						if (reset === true)
						{
							e.addClass('disabled');
							e.removeClass('interim');
						}
					});						
				}
				else
				{
					$(this).addClass('on');
					$('#valid_choices .'+this_id).each(function () {
						$(this).removeClass('disabled');
						$(this).addClass('interim');
					});
				}
			});
			$('#valid_choices .element').toggle(
					function(){
						$(this).addClass('finalised');
					},
					function(){
						$(this).removeClass('finalised');
					}
			);
			$('#reset_all').click(function () {
				$('#valid_choices .element').addClass('disabled');
				$('#valid_choices .element').removeClass('interim');
				$('#valid_choices .element').removeClass('finalised');
				$('#mcq .element').removeClass('on');
			});


			var function_get_selections = function (){
				$('.selections').text('');
				
				var selected_props = ['Selected properties--'];
				var selected_rooms = ['  Selected apartments--'];
				$('#mcq .on').each(function(){
					selected_props.push( $(this).text() );
					selected_props.push( ' | ' );
				});
				$('#valid_choices .finalised').each(function(){
					if( !$(this).hasClass('disabled') ){
						selected_rooms.push( $(this).text() );
						selected_rooms.push( ' | ' );
					}
				});
				
				$.each(selected_props, function(key,value){
					$('.selections').append(value);
					$('.selections').append('<br>');
				});
				$.each(selected_rooms, function(key,value){
					$('.selections').append(value);
					$('.selections').append('<br>');
				});
			};	
			$('.all_rooms').toggle(
				function(){
					$('#valid_choices .interim').addClass('finalised');
					$(this).addClass('on');
				},
				function(){
					$('#valid_choices .interim').removeClass('finalised');
					$(this).removeClass('on');
				}
			);	

			$( ".contact_form #submit" ).click(function() {
				
				function_get_selections();
				var selected_props2 = [];
				$('#mcq .on').each(function(){
					selected_props2.push( $(this).text() );
				});
				
				var name = $("#name").val();
				var email = $("#email").val();	
				var date1 = $("#datepicker_one").val();	
				var date2 = $("#datepicker_two").val();	
				var contact = $("#tel").val();
				var pplno = $("#pplno").val();
				var details = $("#details").val();
				var cust_type = $("#cust_type").val();
				var source = $("#source").val();
				var email_updates = $("#email_updates").attr("checked") ? 'Yes' : 'No';
				var room_selections = $('.selections').text();
				var prop_array = selected_props2;
				$("#returnmessage").empty(); // To empty previous error/success message.
				// Checking for blank fields.		
				if (name == ''){
					alert("Please fill in the Name");
				}		
				else if (email == ''){
					alert("Please fill in a valid email address");
				}
				else if (date1 == ''){
					alert("Please fill in the arrival date");
				}
				else if (date2 == ''){
					alert("Please fill in the departing date");
				}			
				else if (contact == ''){
					alert("Please fill in a contact telephone number");
				}		
				else {
					// Returns successful data submission message when the entered information is stored in database.
					$.post("https://chevalres.wpengine.com/wp-content/themes/cr-child-theme/enquiries.php", {
						name1: name,				
						email1: email,
						date1: date1,
						date2: date2,				
						contact1: contact,
						pplno1: pplno,
						details1: details,
						cust_type1: cust_type,
						source1: source,
						email_updates1: email_updates,
						room_selections1: room_selections,
						prop_array1 : prop_array
					}, function(data) {
						$("#returnmessage").append(data); // Append returned message to message paragraph.
						//window.location.replace("http://www.google.com");				
						window.location.href = "http://chevalresidences.com/thank-you.html";
						if (data == "Your Query has been received, We will contact you soon.") {
							$("#form")[0].reset(); // To reset form fields on success.
							$('.contact_form input').prop('disabled', true);
						}
					});
				}
			});


		}(jQuery));
		// });

		</script>

		<style type="text/css">@media screen {
			body {
				background-color: #EDEAEA;
				color: #767676;
			}

		/*------ Overall Page Background Colour ------*/
			#page {
				background-color: #EDEAEA;
			}

			#page.pushed {
				-webkit-box-shadow: 0px 0px 5px rgba( 0, 0, 0, 0.32 );
				-moz-box-shadow: 0px 0px 5px rgba( 0, 0, 0, 0.32 );
				box-shadow: 0px 0px 5px rgba( 0, 0, 0, 0.32 );
			}

		/*-- Content Background Colour --*/
			#main {
				background: #EDEAEA; /* Old browsers */
				background: -moz-linear-gradient( top,  #EDEAEA 0%, #EDEAEA 100% ); /* FF3.6+ */
				background: -webkit-gradient( linear, left top, left bottom, color-stop( 0%, #EDEAEA ), color-stop( 100%, #EDEAEA ) ); /* Chrome,Safari4+ */
				background: -webkit-linear-gradient( top,  #EDEAEA 0%,#EDEAEA 100% ); /* Chrome10+,Safari5.1+ */
				background: -o-linear-gradient( top,  #EDEAEA 0%,#EDEAEA 100% ); /* Opera 11.10+ */
				background: -ms-linear-gradient( top,  #EDEAEA 0%,#EDEAEA 100% ); /* IE10+ */
				background: linear-gradient( to bottom,  #EDEAEA 0%,#EDEAEA 100% ); /* W3C */
				-ms-filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#EDEAEA', endColorstr='#EDEAEA',GradientType=0 ); /* IE6-9 */
				color: #000000;
			}

		/*------ Page Title H1 ------*/
			.content_title
			{
				color: #000000;
			}

			.page_layout_Flexible .images-and-texts .image-text .text span.title {
				color: #5F523C;
			}
			.page_layout_Flexible .images-and-texts .image-text .text span.description-text
			{
				color: #5F523C;
			}
			.page_layout_Flexible.page_layout_Widget h1.section_title{
				color: #000000;
			}


		/*------ Page Subtitle H2 ------*/
			.content_subtitle {
				border-color: #3D3D3D;
				color: #E7A615;
			}

		/*------ Content Area Header Rules ------*/
			h1 {
				border-color: #3D3D3D;
				color: #5F523C;
			}

			h2 {
				border-color: #3D3D3D;
				color: #5F523C;
			}

			h3 {
				border-color: #3D3D3D;
				color: #E7A615;
			}

			.blog_post > hr {
				border-top-color: #FFF;
			}



			.page_layout_Flexible .section_subtitle
			{
				color: #E7A615;
			}
			.page_layout_Flexible .images-and-texts .image-text .text span.subtitle
			{
				color: #E7A615;
			}


		/*-- Main Navigation Bar --*/
			nav a {
				color: #FFF;
			}

			nav.navtop, nav.mobile, .navmobile-index .firstlevel, .mobile-buttons,
			.mobile-show .icon_cont {
				background: #000000;
				background: -moz-linear-gradient( top,  #000000 0%, #000000 100% );
				background: -webkit-gradient( linear, left top, left bottom, color-stop( 0%, #000000 ), color-stop( 100%, #000000 ) );
				background: -webkit-linear-gradient( top,  #000000 0%, #000000 100% );
				background: -o-linear-gradient( top,  #000000 0%, #000000 100% );
				background: -ms-linear-gradient( top,  #000000 0%, #000000 100% );
				background: linear-gradient( to bottom,  #000000 0%, #000000 100% );
				-ms-filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000000', endColorstr='#000000', GradientType=0 );
			}
			body.is_containing_image_hero.hero_behind_header nav.navtop {
				background: rgb(255,255,255);
				background: rgba(255,255,255,0.3);
			}
			body.is_containing_image_hero.hero_behind_header.fixed_qb nav.navtop {
				background: inherit;
			}

			.page_layout_Flexible .images-and-texts-box .ym-grid {
				background: #000000;
				background: -moz-linear-gradient( top,  #000000 0%, #000000 100% );
				background: -webkit-gradient( linear, left top, left bottom, color-stop( 0%, #000000 ), color-stop( 100%, #000000 ) );
				background: -webkit-linear-gradient( top,  #000000 0%, #000000 100% );
				background: -o-linear-gradient( top,  #000000 0%, #000000 100% );
				background: -ms-linear-gradient( top,  #000000 0%, #000000 100% );
				background: linear-gradient( to bottom,  #000000 0%, #000000 100% );
				-ms-filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000000', endColorstr='#000000', GradientType=0 );
			}

			nav.navtop, nav.mobile {
				border-bottom: 1px solid #E7A615;
				border-top: 1px solid #E7A615;
			}

			nav.navtop, nav.mobile {
				-webkit-box-shadow: 0px 2px 2px rgba( 0, 0, 0, 0.42 );
				-moz-box-shadow:    0px 2px 2px rgba( 0, 0, 0, 0.42 );
				box-shadow:         0px 2px 2px rgba( 0, 0, 0, 0.42 );
			}

			.navmobile-index .firstlevel {
				-webkit-box-shadow: 0 1px 3px rgba( 0, 0, 0, 0.15 );
				-moz-box-shadow: 0 1px 3px rgba( 0, 0 , 0, 0.15 );
				box-shadow: 0 1px 3px rgba( 0, 0, 0, 0.15 );
			}

			.mobile-buttons {
				border-top: 1px solid #E7A615;
				-webkit-box-shadow: 0px -1px 2px rgba( 0, 0, 0, 0.20 );
				-moz-box-shadow: 0px -1px 2px rgba( 0, 0, 0, 0.20 );
				box-shadow: 0px -1px 2px rgba( 0, 0, 0, 0.20 );
			}

			nav.navtop .firstlevel > li {
				border-left: 1px solid #3F3F3F;
			}
			nav.navtop .top_right_nav .firstlevel > li {
				border-left: 0px solid #3F3F3F;
			}

			.mobile-buttons-table li {
				border-right-color: #3F3F3F;
			}

			nav .firstlevel > li li {
				border-bottom-color: #3F3F3F;
				border-top-color: #000;
			}
			.navmobile-index li {
				border-bottom-color: #3D3D3D;
			}
			nav.navmobile-index a:before {
				border-color: #767676;
				background-color: #FFF;
			}
			nav.navmobile-index .promote a:before {
				border-color: #E7A615;
			}
			nav.navmobile-index .promote:hover a:before {
				border-color: #767676;
			}
			nav.navmobile-index a:after {
				border-left-color: #767676;
			}
			nav.navmobile-index .promote a:after {
				border-left-color: #E7A615;
			}
			nav.navmobile-index .promote:hover a:after {
				border-left-color: #767676;
			}

			nav .firstlevel ul {
				background: #000;
				-webkit-box-shadow: 2px 2px 2px rgba( 0, 0, 0, 0.2 );
				-moz-box-shadow:    2px 2px 2px rgba( 0, 0, 0, 0.2 );
				box-shadow:         2px 2px 2px rgba( 0, 0, 0, 0.2 );
			}

			nav li:hover > a, nav.navbottom li:hover > a {
				color: #ffffff;
			}

			nav li:hover, nav li:active { /*Main, Footer and Side Nav Hover Background Colour*/
				background-color: #E7A615;
			}

		/*------ Left Section ------*/
			#sidebar .ym-wbox {
				background: #000000;/* rgba with opacity */
				background: rgba( 0, 0, 0, 0.94 );/* rgba with opacity */
				border-left-color: #000;
				border-right-color: #000;
				-webkit-box-shadow: 2px 0px 2px rgba(0, 0, 0, 0.42);/* Cross Browser Shadow - May need to be adjusted */
				-moz-box-shadow:    2px 0px 2px rgba(0, 0, 0, 0.42);/* Cross Browser Shadow - May need to be adjusted */
				box-shadow:         2px 0px 2px rgba(0, 0, 0, 0.42);/* Cross Browser Shadow - May need to be adjusted */
			}
			.template_minimal #sidebar .ym-wbox {
				background: transparent;
				box-shadow:         0px 0px 0px rgba(0, 0, 0, 0.42);
			}

			#sidebar .sidebar-footer {
				background: #000000;
				border-top-color: #3F3F3F;
			}

		/*------ Quickbook ------*/
			.quickbook {
				/*background: #000000;*/
				border-bottom-color: #3F3F3F;
				border-top-color: #3F3F3F;
				color: #FFF;
			}

			.quickbooklinks {
				background: #000;
				color: #FFF;
			}

			.quickbooklinks a {
				color: #FFF;
			}

			.quickbooklinks a:hover,.quickbooklinks a:active {
				background: #E7A615;
				color: #FFF;
			}

			.quickbooklinks li {
				border-top-color: #3F3F3F;
			}

			.quickbooklinks li  > .bestrate {
				color: #E7A615;
			}

			.quickbooklinks li > a.bestrate:hover, .quickbooklinks li > .bestrate span  {
				background: #E7A615;
				color: #FFF;
			}

			.quickbooklinks span {
				background: #ccc;
				color: #000;
			}

			/*-- Select Box Styling --*/
			input, select, textarea {
				border-color: #a79367;
				color: #000;
			}

			.ym-error input, .ym-error select, .ym-error textarea {
				border-color: #B42F34;
			}

		/*-- Booking Calendar Customise Colours --*/
			.ui-widget-content {
				border-color: #E7A615 /*{borderColorContent}*/;
				background: #FFF /*{bgColorContent}*/;
				color: #E7A615 /*{fcContent}*/;
			}

			.ui-widget-content a {
				color: #000 /*{fcContent}*/;
			}

			.ui-widget-header {
				border-color: #E7A615/*{borderColorHeader}*/;
				background: #E7A615 /*{bgColorHeader}*/;
				color: #FFF /*{fcHeader}*/;
			}

			.ui-widget-header a {
				color: #000000 /*{fcHeader}*/;
			}

			.ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
				border-color: #E7A615 /*{borderColorHighlight}*/;
			}

		/*------ Arrows ------*/
			.arrow-up {
				border-bottom-color: #5F523C;
			}
			.arrow-right {
				border-left-color: #5F523C;
			}
			.arrow-down {
				border-top-color: #5F523C;
			}
			.arrow-left {
				border-right-color: #5F523C;
			}

			.scrolldown, .scrollup, .nav-icons > div, .icons .icon-button {/*-- COLOUR - QUESTION ABOUT MULTIPLE ITEMS --*/
				background-color: #FFF;
				border-color: #646464;
				color: #5F523C;
			}
			.scrolldown:hover, .scrollup:hover, .nav-icons > div:hover, .icons .icon-button:hover {
				background-color: #E7A615;
				border-color: #ACAC7B;
				color: #FFF;
			}
			.nav-icons > div:hover, .icons .icon-button:hover {
				border-color: #646464;
				color: #FFF;
			}
			.icons-minimal span {
				color: #767676;
			}

		/*-- Call to Action - Booking Button --*/
			.bookbutton, .booknow, .promote {
				background-color: #E7A615;
				background-image: -webkit-gradient( linear, left top, left bottom, color-stop( 0%, #E7A615 ), color-stop( 100%, #E7A615 ) );
				background-image: -webkit-linear-gradient( top, #E7A615, #E7A615 );
				background-image: -moz-linear-gradient( top, #E7A615, #E7A615 );
				background-image: -ms-linear-gradient( top, #E7A615, #E7A615 );
				background-image: -o-linear-gradient( top, #E7A615, #E7A615 );
				background-image: linear-gradient( top, #E7A615, #E7A615 );
				-ms-filter: progid:DXImageTransform.Microsoft.gradient( startColorStr='#E7A615', EndColorStr='#E7A615' );
				color: #ffffff;
				text-shadow: 0 1px 0 #D0A100;
			}

			.bookbutton, .booknow {
				border: 1px solid #E7A615;
				border-bottom: 1px solid #E7A615;
				-webkit-box-shadow: inset 0 1px 0 0 #D0A100;
				box-shadow: inset 0 1px 0 0 #D0A100;
			}

			.bookbutton:hover, .booknow:hover, .promote:hover {
				background: #E7A615;
				/*filter: progid:DXImageTransform.Microsoft.gradient( startColorStr='#E7A615', EndColorStr='#E7A615' );*/
			}

			.bookbutton:hover, .booknow:hover {
				border-color: #FFC952;
				border-bottom-color: #FFC952;
				-webkit-box-shadow: inset 0 1px 0 0 #D0A100;
				box-shadow: inset 0 1px 0 0 #D0A100;
				text-shadow: 0 1px 0 #D0A100;
			}

			li.promote a {
				color: #ffffff;
				text-shadow: 0 1px 0 #D0A100;
			}

		/*-- Call to Action - Open Content Button --*/
			.calltoaction {
				background-color: #032856;
				background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #365984), color-stop(100%, #032856));
				background-image: -webkit-linear-gradient(top, #365984, #032856);
				background-image: -moz-linear-gradient(top, #365984, #032856);
				background-image: -ms-linear-gradient(top, #365984, #032856);
				background-image: -o-linear-gradient(top, #365984, #032856);
				background-image: linear-gradient(top, #365984, #032856);
				-ms-filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#365984', EndColorStr='#032856');
				border-color: #011d40;
				border-bottom-color: #011d40;
				-webkit-box-shadow: inset 0 1px 0 0 #3e6697;
				box-shadow: inset 0 1px 0 0 #3e6697;
				color: #fff;
				text-shadow: 0 1px 0 #000;
			}

		/*-- Special Offers Slider --*/
			.bx-wrapper .bx-viewport {
				background-color: rgba( 0, 0, 0, 0.9 );
				border-color: #3F3F3F;
			}

			.rates .title {
				color: #EDEAEA;
			}
			.rates .description {
				color: #ffffff;
			}
			.rates .price {
				color: #E7A615;
			}
			.rates .imagewithtext img {
				border-color: #3F3F3F;
			}

		/*-- Image Sequencer Shadow --*/
			#supersized {
				-webkit-box-shadow: 0px 2px 2px rgba( 0, 0, 0, 0.42 );/* Cross Browser Shadow - May need to be adjusted */
				-moz-box-shadow:    0px 2px 2px rgba( 0, 0, 0, 0.42 );/* Cross Browser Shadow - May need to be adjusted */
				box-shadow:         0px 2px 2px rgba( 0, 0, 0, 0.42 );/* Cross Browser Shadow - May need to be adjusted */
			}

		/*-- Supersized Tagline - Should only be visible when text is entered - if possible --*/
			#slidecaption {
				background: -moz-linear-gradient(top,  rgba(0,0,0,0.65) 0%, rgba(0,0,0,0) 55%); /* FF3.6+ */
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0.65)), color-stop(55%,rgba(0,0,0,0))); /* Chrome,Safari4+ */
				background: -webkit-linear-gradient(top,  rgba(0,0,0,0.65) 0%,rgba(0,0,0,0) 55%); /* Chrome10+,Safari5.1+ */
				background: -o-linear-gradient(top,  rgba(0,0,0,0.65) 0%,rgba(0,0,0,0) 55%); /* Opera 11.10+ */
				background: -ms-linear-gradient(top,  rgba(0,0,0,0.65) 0%,rgba(0,0,0,0) 55%); /* IE10+ */
				background: linear-gradient(to bottom,  rgba(0,0,0,0.65) 0%,rgba(0,0,0,0) 55%); /* W3C */
				-ms-filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a6000000', endColorstr='#00000000',GradientType=0 ); /* IE6-9 */
				text-shadow: 1px 1px 2px rgba(0, 0, 0, 1);
			}

		/*-- Content Link Styling --*/
			.box-content a {
				color: #E7A615 !important;
			}
			a.tooltip i.fa.fa-info-circle {
		    color: #E7A615;
			}

			.box-content a:hover {
				color: #E7A615;
			}

			.box-content a.button {
				color: #ffffff;
			}

			.box-content a.button:hover {
				color: #ffffff;
			}

			/*-- Side Navigation Section --*/
			nav.navside {
				background: #FFFFFF;
				background: -moz-linear-gradient( top, rgba( 255, 255, 255, 1 ) 0%, rgba( 255, 255, 255, 1 ) 50%, rgba( 255, 255, 255, 0 ) 100% ); /* FF3.6+ */
				background: -webkit-gradient( linear, left top, left bottom, color-stop( 0%, rgba( 255, 255, 255, 1 ) ), color-stop( 50%, rgba( 255, 255, 255, 1 ) ), color-stop( 100%, rgba( 255, 255, 255, 0 ) ) ); /* Chrome,Safari4+ */
				background: -webkit-linear-gradient( top, rgba( 255, 255, 255, 1 ) 0%, rgba( 255, 255, 255, 1 ) 50%, rgba( 255, 255, 255, 0 ) 100% ); /* Chrome10+,Safari5.1+ */
				background: -o-linear-gradient( top, rgba( 255, 255, 255, 1 ) 0%, rgba( 255, 255, 255, 1 ) 50%, rgba( 255, 255, 255, 0 ) 100% ); /* Opera 11.10+ */
				background: -ms-linear-gradient( top, rgba( 255, 255, 255, 1 ) 0%, rgba( 255, 255, 255, 1 ) 50%, rgba( 255, 255, 255, 0 ) 100% ); /* IE10+ */
				background: linear-gradient( to bottom, rgba( 255, 255, 255, 1 ) 0%, rgba( 255, 255, 255, 1 ) 50%, rgba( 255, 255, 255, 0 ) 100% ); /* W3C */
				-webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.09);/* Cross Browser Shadow - May need to be adjusted */
				-moz-box-shadow:    0px 2px 2px rgba(0, 0, 0, 0.09);/* Cross Browser Shadow - May need to be adjusted */
				box-shadow:         0px 2px 2px rgba(0, 0, 0, 0.09);/* Cross Browser Shadow - May need to be adjusted */
			}

			nav.navside li {
				border-top-color: #EDEAEA;
				border-bottom-color: #EDEAEA;
			}

			nav.navside li:before {
				color: #E7A615;
			}

			.navside li a {
				color: #666;
			}

		/*-- Awards Bar - Should only be visible when Awards icons are inserted --*/
			.awards {
				background: rgba( 0, 0, 0, 0.5 );/* rgba with opacity */
			}

		/*-- Footer Bar with Address - Same values as Main Navigation Bar but should have the facility to change them via the PHP Edit File --*/
			footer {
				background: #000000; /* Old browsers */
				background: -moz-linear-gradient( top, #000000 0%, #000000 100% ); /* FF3.6+ */
				background: -webkit-gradient( linear, left top, left bottom, color-stop( 0%, #000000 ), color-stop( 100%, #000000 ) ); /* Chrome,Safari4+ */
				background: -webkit-linear-gradient( top, #000000 0%, #000000 100% ); /* Chrome10+,Safari5.1+ */
				background: -o-linear-gradient( top, #000000 0%, #000000 100% ); /* Opera 11.10+ */
				background: -ms-linear-gradient( top, #000000 0%, #000000 100% ); /* IE10+ */
				background: linear-gradient( to bottom, #000000 0%, #000000 100% ); /* W3C */
				border-color: #E7A615;
				color: #767676;
			}
			footer a {
				color: #E7A615;
			}
			footer a:hover {
				color: #E7A615;
			}

		/*-- Footer Border above Contact Details --*/
			.grid-footer-bottom {
				border-color: #E7A615;
			}

		/*-- Bottom Navigation --*/
			nav.navbottom li a {
				color: #ffffff;
			}

			nav.navbottom li:after {
				color: #E7A615;
			}

		/*-- Address --*/
			.address {
				color: #DBDBDB;
			}
		/*-- Contact --*/
			.contact {
				color: #DBDBDB;
			}

		/*-- Link Styling for Avvio Solution --*/
			.copyright a {
				color: #E7A615;
			}

			.copyright a:hover {
				color: #3F3F3F;
			}

			footer .ym-grid{
				color: #DBDBDB;
			}

			footer .ym-gr {
				color: #DBDBDB;
			}

			footer .row-post-nav a {
				color: #E7A615;
			}
			footer .row-post-nav a:hover {
				color: #E7A615;
			}

		/*---- Festures Page Layout ----*/
			.features:not(.larger_setup) .feature {
				border-color: #fff;

				-webkit-box-shadow: 0px 2px 2px rgba( 0, 0, 0, 0.32 );
				-moz-box-shadow: 0px 2px 2px rgba( 0, 0, 0, 0.32 );
				box-shadow: 0px 2px 2px rgba( 0, 0, 0, 0.32 );
			}
			.page_layout_Widget .features:not(.larger_setup) .feature {
				background-color: #FEF8F5;
			}
			.feature-footer {
				background-color: #FEF8F5;
				border-color: #fff;
			}
			.page_layout_Widget .larger_setup .feature-footer {
				background-color: transparent;
				border-color: transparent;
			}
			.feature .text .title {
				color: #5F523C;
			}
			.feature .text .subtitle {
				color: #5F523C;
			}
			.feature .text .description {
				color: #666;
			}
			.feature .text .description-text {
			}
			.page_layout_Widget .feature .text .description, .page_layout_Widget .feature .text .description-text  {
				background-color: #FEF8F5;
			}
			.feature .price {
				color: #5F523C;
			}

			.feature {
				background-color: #ffffff;
			}
			.feature:hover {
				border-color: #ffffff;
			}
			.feature:hover, .feature:hover .text .description, .feature:hover .text .description-text {
				background-color: #ffffff;
			}
			.feature:hover .feature-footer {
				background-color: #ffffff;
				border-color: #ffffff;
			}
			.circle_lrgtile .feature, .circle_lrgtile .feature:hover,
			.circle_lrgtile .feature:hover .feature-footer {
				background-color: transparent;
				border-color: transparent;
			}

			/*---- Sitemap Layout ----*/
			/*.sitemap > ul > li > a {
				color: #5F523C;
			}*/
			.links .desciption {
				color: #767676;
			}
			.social_links li:hover, .social_links li:active {
				background:none;
			}

			/*---- Blog ----*/
			.blog_categories_container {
				background: rgba( 255, 255, 255, 1 );
			}
			.blog_categories_container .blog_categories_header {
				background: #000000;
				color: #FFF;
			}
		}

		@media screen and ( max-width: 990px ) {
			nav.navtop {
				background: #000000;
				-webkit-box-shadow:	none;
				-moz-box-shadow:	none;
				box-shadow:			none;
			}
			nav.navtop .firstlevel > li {
				border-bottom: 1px solid #3F3F3F;
			}
			nav .firstlevel > li li {
				border-bottom-color: transparent;
				border-top-color: transparent;
			}

			nav .firstlevel ul {
				background: #000000;
				-webkit-box-shadow:	none;
				-moz-box-shadow:	none;
				box-shadow:			none;
			}
		}	@media screen{
				#sidebar .ym-wbox {
					width: 330px;
				}
				#sidebar {
					right: 345px;
					z-index: 10000;
				}		
				#sidebar.fixed .quickbook{
					min-height: 70px;
					max-width: 830px!important;
				}
				.two_calendars .ym-form div {
				    position: inherit;
					display: inline-block;
				}
				.two_calendars .ym-form div.rooms,
				.two_calendars .ym-form div.adults,
				.two_calendars .ym-form div.children {
				    width: 50px;			
				}
				.quickbook.two_calendars .nights, 
				.quickbook.two_calendars .date {
					width: auto;
				}
				.quickbook.two_calendars .date input#datepicker,
				.quickbook.two_calendars .nights input#datepicker2{
					width: 150px;
				}
				
				#sidebar.fixed .two_calendars .ym-form div.rooms,
				#sidebar.fixed .two_calendars .ym-form div.adults,
				#sidebar.fixed .two_calendars .ym-form div.children {
				    width: auto;	/* display: none;	 */	
				}
				.quickbookheader {
					font-size: 120%;
				}
				.two_calendars .quickbookcontent
				{
					position: relative;	
				}
				#sidebar.fixed .two_calendars .quickbookcontent
				{
					float: left;	
				}
				.quickbookcontent form{
					padding-bottom: 0;
				}
				.two_calendars .quickbookcontent form#promoCodeForm{
				    padding: 0;
				    width: 165px;
					height: 62px;
				    position: absolute;
				    right: 0;
				    bottom: 0px;
				}
				#sidebar.fixed .two_calendars .quickbookcontent form#promoCodeForm{
					padding: inherit;
				    position: relative;
				    right: auto;
				    top: auto;
					display: inline-block;
				}
				#sidebar.fixed .two_calendars .quickbookcontent form#primary_form{
					/* float: left; */
					display:inline;
					padding: 0;
					min-width: 550px;
				}
				
				#sidebar.fixed .quickbook.two_calendars .ym-form input, 
				#sidebar.fixed .quickbook.two_calendars .ym-form textarea,
				#sidebar.fixed .quickbook.two_calendars .ym-form select,
				#sidebar.fixed .quickbook.two_calendars .nights, 
				#sidebar.fixed .quickbook.two_calendars .date {
					width: auto;
				}
				#sidebar.fixed .quickbook.two_calendars .nights, 
				#sidebar.fixed .quickbook.two_calendars .date {
					width: 125px;
				}
				#sidebar.fixed .quickbook.two_calendars .nights input, 
				#sidebar.fixed .quickbook.two_calendars .date input {
					width: 100%;
				}
				#sidebar.fixed .two_calendars .ym-form div.rooms{
					float: left;
				}
				#sidebar.fixed .two_calendars .ym-fbox-button .book{
					float: right;
				}
				#sidebar.fixed .quickbook label{
					float: none;
				}
				.quickbook.two_calendars .nights img, .quickbook.two_calendars .nights select#nights,
				.two_calendars .ym-form div.rooms, .quickbook .ym-form > div.hotel label,
				#sidebar.fixed .quickbookheader{
					display: none;
				}
				#sidebar.fixed .quickbook .date input#datepicker, #sidebar.fixed .quickbook .ym-form > div.hotel label{
					display: block;	
				}	
				#datepicker[type="text"], #datepicker2[type="text"] {/*-- TO BE DISCUSSED - SHOULD THIS BE ADDED AS A VARIABLE FOR THE ALL COLOUR --*/
					background: #FFF url( "/includes/img/clndr.gif" ) no-repeat 125px;
					padding: 9px 16px 9px 5px;
				}
				.quickbook .book, .quickbook .alternate_book {
					width: 100%;
					text-align: center;
					margin-bottom: 10px;
					margin-top: 15px;		    	
				}
				#sidebar.fixed .quickbook .alternate_book {			
				    position: absolute;
		    		margin-top: 0;
		    		top: 30px;		
				}
				.two_calendars .ym-button {
					width: 310px;
					padding: 5px 0;
					border-radius: 0;
				}
				#sidebar.fixed .two_calendars .ym-button {
					width: auto;			
				}
				#sidebar.fixed form#promoCodeForm input{
					width: 95%;
				}
				.quickbooklinks {
					background: transparent;			
				}
				.two_calendars select{
					padding: 8px 5px;
				}
				/* Safari only override start */
				_::-webkit-full-page-media, _:future, :root .two_calendars select{
					-webkit-appearance: textfield;
					line-height: 12px;
				}
				_::-webkit-full-page-media, _:future, :root .two_calendars .quickbookcontent form#promoCodeForm{
					height: 63px
				}
				/* Safari only override end */
				form#promoCodeForm input{
					padding: 9px 0;
				}
				#sidebar.fixed .quickbookcontent .ym-button{
					padding: 3px 0px;
				}
				.quickbook.two_calendars input, .quickbook.two_calendars select, .quickbook.two_calendars textarea{
					font-size: 11px;
				}
				.template_quickbook #main, .template_quickbook_sidemenu #main 
				{
					margin-top: 70px;
				}
				@-moz-document url-prefix() { 
				 	.two_calendars .quickbookcontent form#promoCodeForm{		    
				    	height: 67px;
					}			
				}
			}
			@media screen and (max-width: 990px){
				nav.navtop .firstlevel > li li a {
					white-space: normal;
					line-height: 20px;
					padding: 0;
					padding-top: 10px;
					
				}
				.template_quickbook #main, .template_quickbook_sidemenu #main 
				{
					margin-top: 0px;
				}
			}</style>


		<!-- external styles-->
		<style>
		@media screen{
			a.tooltip {outline:none;
			    padding-left: 20px;
			    padding: 9px;
			    top: 0;}
			a.tooltip strong {line-height:30px;}
			a.tooltip:hover {text-decoration:none;} 
			a.tooltip span {
			    z-index:10;display:none; padding:14px 20px;
			    margin-top:-30px; margin-left:28px;
			    width:300px; line-height:16px;
			}
			a.tooltip:hover span{
			    display:inline; position:absolute; color:#111;
			    border:1px solid #DCA; background:#fffAF0;}
			.callout {z-index:20;position:absolute;top:30px;border:0;left:-12px;}
			    
			/*CSS3 extras*/
			a.tooltip span
			{
			    border-radius:4px;
			    box-shadow: 5px 5px 8px #CCC;
			}
		   	#mcq, #valid_choices
		   	{
		   		max-width: 460px;
		   		margin: 20px auto;
		   		text-align: center;
		   		border: 0px dotted;
		   		padding: 0px;
		   	} 
			.all_elements.all_rooms.interim {
				text-align: center;
			}			
		   	.element, .all_elements
		   	{
		   		border: 1px solid #E7A615;
			    min-width: 200px;
			    text-align: center;
			    padding: 0 0 0 10px;
			    margin: 5px;
			    display: inline-block;
			    cursor: pointer;
			    text-align:left;
			    font-size: 12px;
			    line-height: 42px;
			    -webkit-transition: all 0.3s ease-out;  /* Android 2.1+, Chrome 1-25, iOS 3.2-6.1, Safari 3.2-6  */
		         	transition: all 0.3s ease-out;  /* Chrome 26, Firefox 16+, iOS 7+, IE 10+, Opera, Safari 6.1+  */  
		 			-webkit-box-shadow: 0px 0px 4px 0px #ffffff;
		         	box-shadow: 0px 0px 4px 0px #ffffff;       
				border-radius: 5px;   	
		   	}
		   	.element span{}
		   	#mcq .element:after,
		   	#valid_choices .element.interim:after{
		   		content: "+";
		   		float: right;
		   		font-size: 28px;
		   		padding: 0 5px;
		   	}    	
		   	#mcq .element.on:after,
		   	#valid_choices .element.interim.finalised:after{
		   		content: "-";
		   	}
		   	#valid_choices .element, .all_elements
		   	{
		   		border: 1px solid #E7A615;
		   		color: black;
		   	}
		   	
		   	#mcq .element:hover, .element.interim:hover{
		   		background-color: #E7A615;
				color: #4B4B4B ;
		   	}
		   	.element.on    	{    	}
		   	#mcq .element.on, .all_rooms.on{
		   		background-color: #E7A615;
				color: white;
		   	}
		   	#valid_choices .element.disabled
		   	{
		   		border: 1px solid #E7A615;
		   		color: #E7A615;
		   		opacity: 0.2;
		   	}
		   	#valid_choices .element.interim.finalised
		   	{    		
		   		border: 1px solid #E7A615;
		   		color: white;
		   		background: #E7A615;
		   	}    	
		   	.choices{
		   		cursor: pointer;
		   	}
			.choices .fa{
				float: right;
			    font-size: 18px;
		   		margin-right: 10px;
			}
			.choices span{
				margin-left: 150px;
			}
		   	/* .choices:after {
			    content: "+";
			    float: right;
			    font-weight: bold;
			    border: 2px solid;
			    border-radius: 30%;
			    padding: 0px 15px;
			}
			.choices.toggled:after {
			    content: "-";		   
			} */
			.inputfield{
				width: 100%;
				max-width: 450px;
				margin: 10px auto;
		   		background-color: #F5EFE3;
		   		padding: 15px;
				min-height: 20px;
			}
			.inputfield.with_text{
				min-height: 80px;
			}
			.inputfield label{
				float: left;		   
			}
			.inputfield input, .inputfield textarea, .inputfield select {
				width: 200px;
				float: right;
			}
			.inputfield input.bookbutton, .inputfield input#email_updates{
				float: left;
			}
			.selection, #valid_choices{
		   		display: none;
		   	}
			#reset_all, #show_selection{
				display: none;
			    background-color: #E7A615;
				color: white;
			    max-width: 150px;
			    margin: 0 auto;
			    padding: 5px 0;
			    margin-top: 10px;
			    text-align: center;
				cursor: pointer;
			}
			.selections{
				/* position: fixed;
				top: 250px;
				right: 0;
				border: 1px dotted;	 */
				display: none;		
			}
			.all_elements
			{
				display: block;	
			}
		}
		@media screen and (max-width:480px)
		{
			.inputfield{
				width: auto;
				max-width: 450px;
		   		/*padding: 15px 0;*/
			}
			.inputfield label, .inputfield input, .inputfield textarea, .inputfield select {
		  			float: none;
			}
			.element, .all_elements
			{
			    border-radius: 0px;
			    width: 100px;
			    min-width: 10px;
			    line-height: 22px;
			    min-height: 0;
			    display: inline-flex;
			    text-align: center;
			    padding: 5px;
			    border-radius: 5px;
			}
			#valid_choices .element, .all_elements
			{
				 min-height: 50px;
			}
			#mcq .element:after, #valid_choices .element.interim:after, .choices span
			{	display: none;}
			.choices .fa {
			    float: none;    
			    margin-right: 0px;
			    margin-left: 80px;
			}
			.template_singular_group_form .ui-widget-content {
		  			z-index: 120000!important;
		  			position: fixed!important;
		  			top: 30px!important;
			}
		}
		</style>
		<style>
			@media screen {
			/*---------- Amendment to Pre-Existing Positional Items ----------*/
			p {
				margin-bottom: 1em;
			}

			.ym-gbox {
				padding: 0;
			}
			.template_quickbook_imagesequencer_sidemenu .ym-gbox, .template_iframe_sidemenu .ym-gbox {
				padding-right: 30px;
			}

			nav.navtop .firstlevel > li:first-child {
					border-left: 0;
			}

			nav li {/*- Main Navigation -*/
				padding: 0 .0em 0 .4em;
			}

			nav .languages li {/*- Main Navigation -*/
				padding: 0 0 0 0;
			}

			#slidecaption {/*- Img Seq Tagline -*/
				padding: 20px 0 0 288px;
				text-align:left;
				width:100%;
			}

			.languages li {/*- Language Translation List -*/
				display: inline-block;
				zoom: 1;
				*display: inline;
				margin: 0 0.0em;
			}

			.sidebar-logos {
				margin:0 auto;
				list-style-type: none;
				width:210px;
				text-align:center;
				display: none;
			}

			.sidebar-logos li {
				margin:12px 0 0 0;
			}

			nav.navside li:before {/*- Nav Side Spacing-*/
				margin-left: 0;
			}

			.quickbook .date select, .quickbook .nights select {
				margin-right: 0;
			}

			.quickbook .date .ui-datepicker-trigger {
				cursor: pointer;
				/*display: none;*/
				margin:0 0 3px 4px;
			}

			.quickbook .date #ci_ym {
				width: 7.2em;
			}

			input, select, textarea {
				padding:4px 4px 4px 3px;
			}
			.quickbooklinks a, .firstlevel li, .scrolldown, .scrollup, .showimages, .navside li, .quickbookcontent, .ym-button:hover, .ym-button:focus, .booknow {
				-o-transition: .5s;
				-ms-transition: .5s;
				-moz-transition: .5s;
				-webkit-transition: .5s;
				transition: .5s;
			}

			.bx-wrapper .bx-viewport { /*-- COLOUR --*/
				border-style: solid;
				border-width: 1px;
				-moz-box-shadow: 0 0 5px #000;
				-webkit-box-shadow: 0 0 5px #000;
				box-shadow: 0 0 5px #000;
			}

			nav.navbottom  a {
				padding:3px 7px 3px 0px;
			}

			.contact {
				padding-right:20px;
				text-align:right;
			}

			footer .ym-gbox.nav {
				padding-right: 20px;
			}

			.grid-footer-bottom {  /*-- COLOUR --*/
				border-top-style:solid;
				border-width:1px;
			}

			.social_links li {
				display:inline-block;
				zoom: 1;
				*display: inline;
			}
			
			.bx-wrapper .bx-prev {
				left: -22px;
			}

			.bx-wrapper .bx-next {
				right: -12px;
			}

			body.move_scrolldown .scrolldown-wrapper {
				top: 18px;
				right: 50px;
				z-index: 1100;
			}

			.scrollup-wrapper {
				right:20px;
			}

			nav.navside {
				margin-top: 67px;
			}

			nav.navside li:before {
				content: '>';
				font-size: .8em;
			}

			nav.navside li {
				padding:0 1.2em;
			}

			.navside li a {
				padding: 3px 15px 3px 14px;
			}

			nav .firstlevel > li li a {
				padding: 6px 16px 5px;
				min-width: 170px;
			}

			.scrolltext {
				margin-right:15px;
			}

			.box-content ul {
				margin-bottom:30px;
			}

			.pusher {
				padding-top: 3.2em;
			}

			.grid-address-contact, .grid-footer-bottom {
				padding:20px 0 10px 0;
			}

			.address, .contact {
				font-size: .95em;
				line-height: 2.5em;
			}

			.hotel-logos ul {
				margin:0;
				list-style-type:none;
			}

			.hotel-logos ul li {
				display:inline-block;
				zoom: 1;
				*display: inline;
				margin: 0 .8em 0 0;
			}


			/*------ All CSS Values are in alphabetical order, except in the case of Gradients, etc. which have multiple values for different browsers. They are specified first and all other values follow alphabetically afterwards ------*/

			/*------ Should Font sizes be changed to equivalent em values?------*/


			/*------ Home Page Content ------*/

			/*------ Page Title H1 ------*/
			.content_title {/*-- COLOUR --*/
				border-bottom:0;
				margin: 0;
				padding: 5px 0px 6px 0;
				font-size: 28px;

			}


			/*------ Page Subtitle H2 ------*/
			.content_subtitle {/*-- COLOUR --*/
				border-bottom-style:solid;
				border-width:1px;
				min-height: 18px;
				margin: 0 0px 0px 0px;
				padding: 0 20px 15px 0px;
				font-size: 18px;
				font-weight: 300;

			}
			.content_subtitle:empty {
				display: none;
			}
			.page_layout_Flexible .content_title, .page_layout_Flexible .content_subtitle {
				text-align: center;
			}
			.page_layout_Flexible .content_subtitle {
				border-bottom:0;
			}
			/*------ Content Area Header Rules ------*/
			h1 {/*-- COLOUR --*/
				border-bottom-style:solid;
				border-width:1px;
				font-size: 16px;
				font-weight: bold;
				margin: 0 0px 20px 0px;
				padding: 0 20px 15px 0px;
			}

			h2 {/*-- COLOUR --*/
				border-bottom-style:solid;
				border-width:1px;
				font-size: 14px;
				font-weight:bold;
				margin: 0 0px 20px 0px;
				padding: 0 20px 15px 0px;
			}

			h3 {/*-- COLOUR --*/
				border-bottom-style:solid;
				border-width:1px;
				font-size: 14px;
				font-weight:bold;
				margin: 0 0px 20px 0px;
				padding: 0 20px 15px 0px;
			}
			.content_title {
				font-weight: 300;
			}
			/*------ Circle Border Radius and Arrows ------*/
			.round {
				-webkit-border-radius: 50%; /* Safari 3-4, iOS 1-3.2, Android 1.6- */
				-moz-border-radius: 50%; /* Firefox 1-3.6 */
				border-radius: 50%;  /* Opera 10.5, IE 9, Safari 5, Chrome, Firefox 4, iOS 4, Android 2.1+ */
			}

			.scrolldown, .scrollup, .nav-icons > div {/*-- COLOUR - QUESTION ABOUT MULTIPLE ITEMS --*/
				border: 1px solid #000;
				cursor: pointer;
				height: 42px;
				line-height: 42px;
				width: 42px;
				-webkit-border-radius: 50%; /* Safari 3-4, iOS 1-3.2, Android 1.6- */
				-moz-border-radius: 50%; /* Firefox 1-3.6 */
				border-radius: 50%;
				text-align: center;
			}
			.nav-icons > div > i {/*-- COLOUR - QUESTION ABOUT MULTIPLE ITEMS --*/
				margin-top: -2px;
				line-height: 42px;
				vertical-align: middle;
			}

			.scrolldown:hover > span {
				border-top: 10px solid #FFF;
			}
			.scrollup:hover > span {
				border-bottom: 10px solid #FFF;
			}
			.arrow-up {/*-- COLOUR --*/
				border-bottom-style:solid;
				border-bottom-width:10px;
				border-left: 10px solid transparent;
				border-right: 10px solid transparent;
				height: 0px;
				margin-top:-4px;
				width: 0px;
			}

			.arrow-right {/*-- COLOUR --*/
				border-bottom: 10px solid transparent;
				border-left-style:solid;
				border-left-width:10px;
				border-top: 10px solid transparent;
				height: 0px;
				width: 0px;
			}

			.arrow-down {/*-- COLOUR --*/
				border-left: 10px solid transparent;
				border-right: 10px solid transparent;
				border-top-style:solid;
				border-top-width:10px;
				height: 0px;
				width: 0px;
			}

			.arrow-left {/*-- COLOUR --*/
				border-top: 10px solid transparent;
				border-bottom: 10px solid transparent;
				border-right-style: solid;
				border-right-width: 10px;
				height: 0px;
				width: 0px;
			}

			/*------ Left Section ------*/

			#sidebar .sidebar-footer {/*-- COLOUR --*/
				border-top-style:solid;
				border-top-width:1px;
			}

			.logo {/*-- COLOUR - QUERY WHETHER WE SHOULD ADD THIS AS A VARIABLE IN THE STYLING.PHP - SPECIFY PATH --*/
				background: url('../img/logo-sample-hotel-group-main.png');
				background-position: center;
				background-repeat: no-repeat;
				height:90px;
			}

			/*------ Quickbook Section ------*/
			.quickbook .ym-form > div.hotel {/*-- Display the Hotel Select Dropdown --*/
				display: block;
			}

			.quickbook {/*-- COLOUR --*/
				border-bottom-style:solid;
				border-bottom-width:0px;
				border-top-style:solid;
				border-top-width:0px;
			}

			.quickbookcontent form {
				padding: 0.5em 1em;
			}

			.quickbook label {
				padding: .5em .5em .5em 0;
			}

			.quickbook .nights {
				width:0;
			}
			#sidebar.fixed .quickbook .nights {
				width: 90px;
				float: left;
			}
			.quickbook.two_calendars .nights {
				width: auto;
			}
			.quickbook .date {
				width: 168px;
			}
			#sidebar.fixed .quickbook .date {
				width: 200px;
			}

			.ym-form input, .ym-form textarea, .ym-form select {
				width: 90%;
			}

			.quickbook .date {
				display: inline-block;
				zoom: 1;
				*display: inline;
			}

			.quickbook .date input#datepicker {
				cursor:pointer;
			}

			.quickbook .book, .quickbook .alternate_book {
				float:none;
				width:94%;
			}
			#sidebar.fixed .quickbook .book ,
			#sidebar.fixed .quickbook .alternate_book {
				float:none;
				max-width:120px;
				margin-top: 0;
			}

			.quickbookcontent .ym-button {
				text-transform:uppercase;
				width:100%;
			}
			#sidebar.fixed .quickbookcontent .ym-button {
				width: auto;
			}

			.quickbooklinks {/*-- COLOUR --*/
				list-style-type: none;
				margin: 0;
				padding: 0;
				text-align: left;
			}

			.quickbooklinks a {/*-- COLOUR --*/
				display:block;
				padding:2px 0 2px 12px;
				font-size:90%;
			}

			.quickbooklinks li {/*-- COLOUR --*/
				border-top-style:solid;
				border-top-width:1px;
				margin-left:0;
			}

			.quickbooklinks li  > .bestrate {/*-- COLOUR --*/
				font-weight:bold;
			}

			.quickbooklinks li > a.bestrate:hover, .quickbooklinks li > .bestrate span  {/*-- COLOUR --*/
			}

			.quickbooklinks span {/*-- COLOUR --*/
				border-radius: 100%;
				float:right;
				font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
				font-size: 100%;
				height: 18px;
				margin: 0 12px 0 10px;
				padding: 0 3px 0px 3px;
				text-decoration: none !important;
				width: 12px;
			}

			/*-- Mobile Booking Button - Hide --*/
			.mobilebook {
				display:none;
			}

			/*-- **************** TIDY UP THIS CSS - START ****************** --*/

			/*-- Select Box Styling --*/
			input, select, textarea {/*-- COLOUR --*/
				border-style:solid;
				border-width:1px;
				font-size:12px;
				margin-right:2px;
				padding:4px;
				width:4.5em;
			}

			input.form_error, select.form_error, textarea.form_error {/*-- COLOUR --*/
				border-style:solid;
				border-width:1px;
			}

			/*-- Date Box Styling --*/
			#datepicker[type="text"], #datepicker2[type="text"] {/*-- TO BE DISCUSSED - SHOULD THIS BE ADDED AS A VARIABLE FOR THE ALL COLOUR --*/
				background: #FFF url( "/includes/img/clndr.gif" ) no-repeat 125px;
				padding: 5px 16px 5px 5px;
			}
			
			/*-- Month / Year Box Styling --*/
			#ci_ym {width: 9.3em;}


			/*-- Calendar Customise Colours --*/
			.ui-widget-content {/*-- COLOUR --*/
				border-style:solid;
				border-width:1px;
			}

			.ui-widget-header {/*-- COLOUR --*/
				border-style:solid;
				border-width:1px;
			}

			.ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
				border-style:solid;
				border-width:1px;
			}

			/*---------- Buttons - Perhaps we should have two separate classes which are applied to each button? One specifying Padding, Height, Min-Width, etc. and separate classes for each button colour? ----------*/
			/*-- Button Dimension Properties --*/
			.button {
				border-radius: 3px;
				font-size: 14px;
				height:auto;
				padding: 5px;
				text-align: center;
				min-width: 80px;
			}
			#sidebar.fixed .button {
				font-size: 12px;
				padding: 0 5px;
			}

			/*-- Call to Action - Booking Button --*/
			.bookbutton {/*-- COLOUR --*/
				border-bottom-style:solid;
				border-bottom-width:1px;
				border-style:solid;
				border-width:1px;
				cursor: pointer;
			}

			.bookbutton:hover {
				border-bottom-style:solid;
				border-bottom-width:1px;
				border-style:solid;
				border-width:1px;
			}

			/*-- Call to Action - Open Content Button --*/
			.calltoaction {
				border-bottom-style:solid;
				border-bottom-width:1px;
				border-style:solid;
				border-width:1px;
			}

			/*-- Special Offers Slider --*/
			.specialoffers {
				border-style:solid;
				border-width:1px;
				height:110px;
				width:320px;
			}

			/*-- Supersized Tagline - Should only be visible when text is entered - if possible --*/
			#slidecaption {
				font: 20px Georgia, Times, "Times New Roman", serif;
			}

			/*-- Content Link Styling --*/
			.box-content a {
				/*text-decoration:underline;*/
			}

			.page_layout_Flexible .box-content a, .box-content  a:hover {
				text-decoration:none;
			}

			nav.navside li:before {
				content: '>';
			}

			nav.navside li, nav .firstlevel > li li { /* Also governs the Border Colours for .navside */
				border-bottom-style:solid;
				border-bottom-width:1px;
				border-top-style:solid;
				border-top-width:1px;
			}

			.navside li a {
			}
			/*- Value alongside Sub-Navigation Styling governs the Border Colours -*/

			/*-- These are the values for the Awards Bar - Should only be visible when Awards icons are inserted --*/
			.awards {
			}

			/*-- Footer Bar with Address - Same values as Main Navigation Bar but should have the facility to change them via the PHP Edit File --*/
			footer {
				border-top-style:solid;
				border-top-width:1px;
			}

			.copyright a {
				font-size:.8em;
			}

			.copyright a:hover {
			}

			/*-- Bottom Navigation --*/
			nav.navbottom  li a {
				font-size:.95em;
			}

			nav.navbottom li:after {
				content: '|';
			}

			nav.navbottom li:last-child:after {
				content: '';
			}

			nav.navbottom.navtopright li:after {
				content: '';
			}

			nav.navbottom.navtopright .firstlevel > li:after {
				content: '';
			}
			/*-- Address --*/
			.address {
				font-size;9px;
			}

			/*-- Link Styling for Avvio Solution --*/
			.footer .copyright a {
				color:#aaa0a0;
			}

			/*-- Blog Standard Styling --*/
			.page_layout_Blog .content_subtitle
			{
				display: none;
			}
			.blog_post
			{
				margin: 2em 0 2em 0;
			}
			.blog_title
			{
				font-size: 18px;
				font-weight: bold;
			}
			.blog_info
			{
				padding: 0 0 1em 0;
			}
			.blog_content
			{
				padding: 1em 0em;
				display: block;
				max-width: 835px;
			}
			.blog_content p
			{
				/*padding: 0px 20px 20px 0px;
				float: left;*/
				clear: right;
			}
			.blog_content_inner {
				clear: both;
			}
			.blog_info small {
				display: block;
				padding: .5em 0;
				font-size: 90%;
			}
			.blog_categories
			{
				margin-left: 2em;
			}
			.blog_post > hr
			{
				height: 0;
				line-height: 0;
				margin: 2em 0 2em 0;
				border: 0;
				border-top-width: 1px;
				border-top-style: solid;
				color: transparent;
				clear: left;
			}
			.blog_home
			{
				text-align: center;
				padding-top: 1em;
			}
			.blog_categories_container {
				min-width: 150px;
				margin: 3em 2em;
			}
			.blog_categories_container .blog_categories_header {
				padding: 1em 1.5em;
			}
			.blog_categories_container ul {
				margin: 0;
				padding: 1em 2em;
				list-style-type: none;
			}
			.blog_categories_container li {
				margin: 0;
				padding: .35em 0;
			}
			/*-- End Blog Standard Styling --*/
		}/*-- /@media screen --*/

		@media screen and ( max-width: 990px ) {
			nav.navside {
				margin-top: 0;
			}
			nav.navside li:before {
				content: '';
			}
			.gbox-blog-posts {
				width: 100%;
			}
			.gbox-blog-categories {
				display: none;
			}
		}/*-- /media screen max-width: 990px  --*/

		@media screen and ( max-width: 600px ) {
			/*-- Mobile Booking Button --*/
			.mobilebook {
				display:block;
				margin: 0 auto;
				padding: 10px 0;
				text-align: center;
				width: 90%;
			}
			/*.quickbooklinks {
				border-bottom: 2px dotted #ddd;
			}*/
			.quickbook .ym-button {
				font-size: 130%;
				min-width: 50%;
				padding: 10px 30px;
			}
		}/*-- /media screen max-width: 600px  --*/

		@media screen and ( max-width: 990px ) {
			nav.navside {
				margin-top: 0;
			}
			nav.navside li:before {
				content: '';
			}
		}

		@media screen and ( max-width: 480px ) {
			/*-- Blog Standard Styling --*/
			.blog_content
			{
				padding: 1em 0;
			}
			.blog_post img, .blog_post img.blog_image_banner, .blog_post img.blog_image_left, .blog_post img.blog_image_right {
				width: 100%;
				float: none;
				padding: 20px 0 20px 0;
			}
			/*-- End Blog Standard Styling --*/
		}/*-- /media screen max-width: 480px  --*/

		</style>

		<!--
		<script>
		AvvioCC.fragments.push( { d:'PHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiIHNyYz0iaHR0cHM6Ly9zZWN1cmUubGVhZGZvcmVuc2ljcy5jb20vanMvMTI2NTAuanMiID48L3NjcmlwdD4=', b:'m', s:document.currentScript } ); // Lead Forensics
		</script>
		<script async src="https://fe.avvio.com/crm/rpc/www.chevalresidences.com/ACC_js.php?lang=en"></script>
		<div id="ACCsmartBodyContainer" style="width:10px;height:10px;position:absolute;bottom:0;right:0;overflow:hidden;z-index:1;"></div>
		-->
	</html>

<?php endif; ?>