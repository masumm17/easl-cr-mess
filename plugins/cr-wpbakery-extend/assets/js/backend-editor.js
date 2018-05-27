(function($) {
    window.CrScContainerView = VcColumnView.extend({
        initialize: function(options) {
            this.maxShortcodes = this.maxShortcodes || 1000;
            window.CrScContainerView.__super__.initialize.call(this, options);
        },
        clone: function(e) {
            var shortcodes = vc.shortcodes.where({
                parent_id: this.model.id
            });
            if(shortcodes.length < this.maxShortcodes){
                return window.CrScContainerView.__super__.addElement.clone(this,e);
            } else {
                _.isObject(e) && e.preventDefault();
                alert("Maximum number(" + this.maxShortcodes + ") of items added!");
                return false;
            }
            
        },
        addElement: function(e) {
            var shortcodes = vc.shortcodes.where({
                parent_id: this.model.id
            });
            if(shortcodes.length < this.maxShortcodes){
                window.CrScContainerView.__super__.addElement.call(this,e);
            } else {
                _.isObject(e) && e.preventDefault();
                alert("Maximum number(" + this.maxShortcodes + ") of items added!");
            }
        }
    });
    window.CrScItemView = vc.shortcode_view.extend({
        clone: function(e) {
            var parent = vc.shortcodes.get(this.model.get("parent_id")), maxItems = parent.view.maxShortcodes || 1000, shortcodes = vc.shortcodes.where({
                parent_id: parent.id
            });
            
            if(shortcodes.length < maxItems){
                return window.CrScItemView.__super__.clone.call(this,e);
            } else {
                _.isObject(e) && e.preventDefault();
                alert("Maximum number(" + maxItems + ") of items added!");
                return false;
            }
            
        }
    });
    // Hero Slider Container View
    window.CrScHeroSliderView = window.CrScContainerView.extend({
        maxShortcodes: 6,
        changeShortcodeParams2: function(model) {
            var params, icon;
            //window.CrScHeroSliderItemView.__super__.changeShortcodeParams.call(this, model);
            params = model.get("params");
            console.log(params);
        }
    });
    // Hero Slider Item View
    window.CrScHeroSliderItemView = window.CrScItemView.extend({
        changeShortcodeParams2: function(model) {
            var params, icon;
            //window.CrScHeroSliderItemView.__super__.changeShortcodeParams.call(this, model);
            params = model.get("params");
            console.log(params);
        }
    });
    // Property Slider Container View
    window.CrScPropertySliderView = window.CrScContainerView.extend({
        maxShortcodes: 20,
        minShortcodes: 3,
        changeShortcodeParams2: function(model) {
            var params, icon;
            //window.CrScHeroSliderItemView.__super__.changeShortcodeParams.call(this, model);
            params = model.get("params");
            console.log(params);
        }
    });
    // Property Slider Item View
    window.CrScPropertySliderItemView = window.CrScItemView.extend({
        changeShortcodeParams2: function(model) {
            var params, icon;
            //window.CrScHeroSliderItemView.__super__.changeShortcodeParams.call(this, model);
            params = model.get("params");
            console.log(params);
        }
    });
    // Fixed Width Grid Container View
    window.CrScFixedWidthGridView = window.CrScContainerView.extend({

    });
    // Fixed Width Grid Item View
    window.CrScFixedWidthGridItemView = window.CrScItemView.extend({

    });
    // Full Width Grid Container View
    window.CrScFullWidthGridView = window.CrScContainerView.extend({

    });
    // Full Width Grid Item View
    window.CrScFullWidthGridItemView = window.CrScItemView.extend({
        changeShortcodeParams: function(model) {
            var params, colClass, removeClass;
            window.CrScFullWidthGridItemView.__super__.changeShortcodeParams.call(this, model);
            params = model.get("params");
            if(_.isObject(params) && _.isString(params.grid_size)) {
                switch(params.grid_size) {
                    case "3_3":
                        removeClass = "vc_col-sm-4 vc_col-sm-8";
                        colClass = "vc_col-sm-12";
                        break;
                    case "2_3":
                        removeClass = "vc_col-sm-4 vc_col-sm-12";
                        colClass = "vc_col-sm-8";
                        break;
                    default:
                        removeClass = "vc_col-sm-8 vc_col-sm-12";
                        colClass = "vc_col-sm-4";
                        break;
                }
            }
            this.$el.addClass(colClass).removeClass(removeClass);
        }
    });
   
    // Expanding Images Container View
    window.CrScExpandingImagesView = window.CrScContainerView.extend({
        maxShortcodes: 5
    });
    // Expanding Image Item View
    window.CrScExpandingImageItemView = window.CrScItemView.extend({

    });
    // Property Gallery Container View
    window.CrScGalleryView = window.CrScContainerView.extend({
        maxShortcodes: 40,
    });
    // Property Gallery Item View
    window.CrScGalleryItemView = window.CrScItemView.extend({
        
    });
})(jQuery);