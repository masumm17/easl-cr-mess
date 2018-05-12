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
})(jQuery);