<script type="text/javascript">
(function($){
	$('body').on('vcPanel.shown', function(e){
		$('.vc_edit-form-tab-control', $(e.target)).each(function(){
			var $t = $(this), text = $t.find('button').text();//Design Options
			if(['Extra Options', 'Design Options'].indexOf(text) !== -1){
				$t.hide();
			}
		});
	});
})(jQuery);
</script>