(function($){
    var toHide = ['cr_title_icons', 'cr_accommodations', 'cr_enquiry_form', 'cr_sitemap', 'cr_allora_integration', 'cr_gravity_form'];
    var crSites = ['Cheval Residences', 'Radisson Blu', 'Hillgrove']
	$('body').on('vcPanel.shown', function(e){
		$('.vc_edit-form-tab-control', $(e.target)).each(function(){
			var $t = $(this), text = $t.find('button').text();//Design Options
			if(['Extra Options', 'Design Options'].indexOf(text) !== -1){
				$t.hide();
			}
		});
	});
    //vc.edit_element_block_view
    vc && vc.events && vc.events.on('app.render', function(){
        var filterValue = '';
        vc.add_element_block_view.on('afterRender', function(){
            this.$el.find('[data-vc-ui-element="panel-tab-control"]').each(function(){
                var $element = $(this);
                if( -1  !== _.indexOf(crSites, $.trim($element.text())) ){
                    filterValue = $element.data("filter");
                    $(this).click();
                }else{
                  $element.closest('li.vc_edit-form-tab-control').addClass('crrm-hide');  
                }
            });
            $('[data-vc-ui-element="add-element-button"]', this.$content).not(filterValue).addClass('crrm-hide');
            $('[data-vc-ui-element="add-element-button"]' + filterValue, this.$content).each(function(){
                var $element = $(this);
                var sc = $element.data('element');
                if(sc && (-1  !== _.indexOf(toHide, sc )) ){
                    vc.app.$('[data-element_type="' + sc + '"]').length ? $element.addClass('crrm-grayedout-element') : $element.addClass('crrm-hide');  
                }
            });
        });
    });
    /**
     * cr_title_icons
     * cr_accommodations
     * 
     * cr_enquiry_form
     * cr_sitemap
     * cr_instagram_feed
     * cr_allora_integration
     * cr_gravity_form
     */
})(jQuery);