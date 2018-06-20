(function($) {
    window.MHMMapBuilder = {};
    
    MHMMapBuilder.Collections = {};
    MHMMapBuilder.Storage = {};
    MHMMapBuilder.Models = {};
    
    MHMMapBuilder.Models.Center = Backbone.Model.extend({
        defaults: {
            lat: 51.505786,
            lng: -0.131888
        }
    });
    MHMMapBuilder.Storage.center = new MHMMapBuilder.Models.Center();
    
    MHMMapBuilder.Models.Filter = Backbone.Model.extend({
        defaults: {
            name: "",
            label: "",
            icon: ""
        },
        toTemplateData: function() {
            return _.extend({index: this.cid}, this.toJSON());
        }
    });
    MHMMapBuilder.Collections.Filters = Backbone.Collection.extend({
        model: MHMMapBuilder.Models.Filter,
        getFiltersDD: function() {
            return this.map(function(filter) {
                return {name: filter.get("name"), label: filter.get("label")};
            });
        }
    });
    MHMMapBuilder.Storage.filters = new MHMMapBuilder.Collections.Filters();
    
    MHMMapBuilder.Models.Marker = Backbone.Model.extend({
        defaults: {
            lat: "",
            lng: "",
            filter: "",
            icon: "",
            title: "",
            thumb: "",
            full_image: "",
            text: "",
            cta_title: "",
            cta_url: "",
            cta_nt: "yes",
            marker: null
        },
        toTemplateData: function() {
            return {
                index: this.cid,
                lat: this.get("lat"),
                lng: this.get("lng"),
                filter: this.get("filter"),
                icon: this.get("icon"),
                title: this.get("title"),
                thumb: this.get("thumb"),
                full_image: this.get("full_image"),
                text: this.get("text"),
                cta_title: this.get("cta_title"),
                cta_url: this.get("cta_url"),
                cta_nt: this.get("cta_nt"),
                filterdd: MHMMapBuilder.Storage.filters.getFiltersDD()
            };
        }
    });
    MHMMapBuilder.Collections.Markers = Backbone.Collection.extend({
        model: MHMMapBuilder.Models.Marker
    });
    MHMMapBuilder.Storage.markers = new MHMMapBuilder.Collections.Markers();
    
    MHMMapBuilder.Views = {
        Filter: Backbone.View.extend({
            tagName: "div",
            className: "mhmmb-filter-icon",
            attributes: function() {
                return {
                    "data-modelid" : this.model.cid
                };
            },
            template: _.template($("#mhmbt-filter-icon").html()),
            initialize: function() {
                this.listenTo(this.model, "change", this.render);
                this.listenTo(this.model, "destroy", this.remove);
            },
            render: function() {
                this.$el.html(this.template(this.model.toTemplateData()));
                return this;
            }
        }),
        Marker: Backbone.View.extend({
            tagName: "div",
            className: "mhmmb-mf",
            attributes: function() {
                return {
                    "data-modelid" : this.model.cid
                };
            },
            template: _.template($("#mhmbt-marker-field").html()),
            initialize: function() {
                this.listenTo(this.model, "change", this.render);
                this.listenTo(this.model, "destroy", this.remove);
                if(_.isObject(this.model.get("marker"))){
                    var marker = this.model.get("marker");
                    marker.addListener('click', _.bind(this.markerClicked, this));
                    marker.addListener('dragend', _.bind(this.markerDragged, this));
                }
            },
            render: function() {
                this.$el.html(this.template(this.model.toTemplateData()));
                return this;
            },
            markerClicked: function(e) {
                this.model.trigger("marker.clicked", this.model, e);
            },
            markerDragged: function() {
                var marker = this.model.get("marker");
                this.model.set(marker.getPosition().toJSON());
                //this.model.trigger("marker.dragged", this.model);
            }
        })
    };
    MHMMapBuilder.builderView = Backbone.View.extend({
        el: $("#mhm-map-builder-wrap"),
        events: {
            "click #mhm-set-center": "setCenter",
            "click #mhm-bdone": "saveCenter",
            "click #mhm-bcancel": "cancelCenter",
            
            "click #mhm-add-filter": "showFilterForm",
            "click #mhm-filter-save": "saveFilter",
            "click #mhm-filter-delete": "deleteFilter",
            "click #mhm-filter-cancel": "closeEditor",
            "click .mhmmb-filter-icon ": "editFilterIcon",
            
            "click #mhm-add-marker": "showMarkerPin",
            "click #mhm-mcancel": "cancelMarker",
            "click #mhm-mdone": "showMarkerForm",
            "click #mhm-marker-save": "saveMarker",
            "click #mhm-marker-delete": "deleteMarker",
            "click #mhm-marker-cancel": "closeMarkerForm",
            
            
            "click .mhmmb-upload": "mediaUpload",
        },
        centerFieldsTemplate: _.template($("#mhmbt-center-field").html()),
        filterFormTemplate: _.template($("#mhmbt-filter-form").html()),
        markerFormTemplate: _.template($("#mhmbt-marker-form").html()),
        initialize: function() {
            this.activeMarker = null;
            this.activeButton = null;
            this.centerFields = this.$("#mhm-center-fields");
            this.markerFields = this.$("#mhm-marker-fields");
            this.editor = this.$("#mhm-editor-form");
            
            this.filterIcons = this.$("#mhm-filter-icons");
            
            this.listenTo(MHMMapBuilder.Storage.center, "change", this.updateCenter);
            this.listenTo(MHMMapBuilder.Storage.filters, "add", this.addFilterIcon);
            this.listenTo(MHMMapBuilder.Storage.markers, "add", this.addMarkerField);
            this.listenTo(MHMMapBuilder.Storage.markers, "marker.clicked", this.markerClicked);
            //this.listenTo(MHMMapBuilder.Storage.markers, "marker.dragged", this.markerDragged);
            
            !_.isEmpty(MHMMapBuilderData.center) && MHMMapBuilder.Storage.center.set(MHMMapBuilderData.center);
            this.initMap();
            !_.isEmpty(MHMMapBuilderData.filters) && MHMMapBuilder.Storage.filters.set(MHMMapBuilderData.filters);
            
            !_.isEmpty(MHMMapBuilderData.markers) && this.addExistingMarkers();
            
            this.render();
        },
        render: function(){
            this.centerFields.html(this.centerFieldsTemplate(MHMMapBuilder.Storage.center.toJSON()));
            return this;
        },
        addExistingMarkers: function() {
            _.each(MHMMapBuilderData.markers, function(markerData){
                var mapMarker = new google.maps.Marker({
                    map: MHMMapBuilder.map,
                    draggable: true,
                    animation: null,
                    position: {lat: markerData.lat, lng: markerData.lng}
                });
                markerData.marker = mapMarker;
            }, this);
            MHMMapBuilder.Storage.markers.set(MHMMapBuilderData.markers);
        },
        updateCenter: function() {
            _.isObject(MHMMapBuilder.map) && MHMMapBuilder.map.setCenter(MHMMapBuilder.Storage.center.toJSON());
            this.centerFields.html(this.centerFieldsTemplate(MHMMapBuilder.Storage.center.toJSON()));
        },
        setCenter: function(e) {
            _.isObject(e) && e.preventDefault();
            if(this.$el.hasClass("mhm-setting-center")){
                return;
            }
            this.$el.addClass("mhm-setting-center");
            this.activeMarker = new google.maps.Marker({
                map: MHMMapBuilder.map,
                draggable: true,
                animation: google.maps.Animation.BOUNCE,
                position: MHMMapBuilder.map.getCenter()
            });

        },
        saveCenter: function(e) {
            _.isObject(e) && e.preventDefault();
            if(!this.$el.hasClass("mhm-setting-center")){
                return;
            }
            MHMMapBuilder.Storage.center.set(this.activeMarker.getPosition().toJSON());
            this.activeMarker.setMap(null);
            this.activeMarker = null;
            this.$el.removeClass("mhm-setting-center");
        },
        cancelCenter: function(e) {
            _.isObject(e) && e.preventDefault();
            if(!this.$el.hasClass("mhm-setting-center")){
                return;
            }
            this.activeMarker.setMap(null);
            this.activeMarker = null;
            this.$el.removeClass("mhm-setting-center");
            this.updateCenter();
        },
        showFilterForm: function(e) {
            _.isObject(e) && e.preventDefault();
            this.editor.addClass("mhm-form-new");
            this.showEditor(this.filterFormTemplate({name: "", label: "", icon: ""}));
        },
        saveFilter: function(e) {
            _.isObject(e) && e.preventDefault();
            var filterData = {
                name: this.editor.find("#mhmmb-ff-name").val(),
                label: this.editor.find("#mhmmb-ff-label").val(),
                icon: this.editor.find("#mhmmb-ff-icon").val()
            };
            var modelID = this.editor.data("modelid");
            var filter = null;
            if(modelID){
                filter = MHMMapBuilder.Storage.filters.get(modelID);
                filter.set(filterData);
            }else{
                filter  = new MHMMapBuilder.Models.Filter(filterData);
            }
            if(filterData.name  && filterData.label && filterData.icon ){
                MHMMapBuilder.Storage.filters.set(filter, {remove: false});
                this.closeEditor();
            }else{
                alert("All fields are mandatory");
            }
        },
        editFilterIcon: function(e) {
            _.isObject(e) && e.preventDefault();
            var modelID = this.$(e.currentTarget).data("modelid");
            var filter = MHMMapBuilder.Storage.filters.get(modelID);
            this.editor.data("modelid", modelID);
            this.showEditor(this.filterFormTemplate(filter.toJSON()));
        },
        deleteFilter: function(e) {
            _.isObject(e) && e.preventDefault();
            var modelID = this.editor.data("modelid");
            if(modelID){
                filter = MHMMapBuilder.Storage.filters.get(modelID);
                filter.destroy();
            }
            this.closeEditor();
        },
        addFilterIcon: function(filter) {
            var filterView = new MHMMapBuilder.Views.Filter({model: filter});
            this.filterIcons.append(filterView.render().el);
        },
        showMarkerPin: function(e) {
            _.isObject(e) && e.preventDefault();
            if(this.$el.hasClass("mhm-setting-marker")){
                return;
            }
            this.$el.addClass("mhm-setting-marker");
            this.activeMarker = new google.maps.Marker({
                map: MHMMapBuilder.map,
                draggable: true,
                animation: google.maps.Animation.BOUNCE,
                position: MHMMapBuilder.map.getCenter()
            });
        },
        showMarkerForm: function(e) {
            _.isObject(e) && e.preventDefault();
            var latlong = this.activeMarker.getPosition().toJSON();
            this.$el.removeClass("mhm-setting-marker");
            this.editor.addClass("mhm-form-new");
            var markerModel = new MHMMapBuilder.Models.Marker({lat: latlong.lat, lng: latlong.lng});
            this.showEditor(this.markerFormTemplate(markerModel.toTemplateData()));
            markerModel.destroy();
        },
        markerClicked: function(marker, e) {
            this.activeMarker = marker.get("marker");
            this.activeMarker.setAnimation(google.maps.Animation.BOUNCE);
            this.editor.data("modelid", marker.cid);
            this.showEditor(this.markerFormTemplate(marker.toTemplateData()));
        },
        closeMarkerForm: function(e) {
             _.isObject(e) && e.preventDefault();
             
            this.editor.hasClass("mhm-form-new") && this.activeMarker.setMap(null);
            this.activeMarker.setAnimation(null);
            this.activeMarker = null;
            this.closeEditor();
        },
        saveMarker: function(e) {
            _.isObject(e) && e.preventDefault();
            var latlong = {
                lat: parseFloat(this.editor.find("#mhmmb-mf-lat").val()),
                lng: parseFloat(this.editor.find("#mhmmb-mf-lng").val())
            };
            console.log(latlong);
            this.activeMarker.setPosition(latlong);
            var markerData = {
                lat: latlong.lat,
                lng: latlong.lng,
                filter: this.editor.find("#mhmmb-mf-filter").val(),
                icon: this.editor.find("#mhmmb-mf-icon").val(),
                title: this.editor.find("#mhmmb-mf-title").val(),
                thumb: this.editor.find("#mhmmb-mf-thumb").val(),
                full_image: this.editor.find("#mhmmb-mf-full-image").val(),
                text: this.editor.find("#mhmmb-mf-text").val(),
                cta_title: this.editor.find("#mhmmb-mf-cta-title").val(),
                cta_url: this.editor.find("#mhmmb-mf-cta-url").val(),
                cta_nt: this.editor.find("#mhmmb-mf-cta-nt").is(":checked") ? "yes" : "no",
                marker: this.activeMarker
            };
            var modelID = this.editor.data("modelid");
            var markder = null;
            if(modelID){
                marker = MHMMapBuilder.Storage.markers.get(modelID);
                marker.set(markerData);
            }else{
                marker  = new MHMMapBuilder.Models.Marker(markerData);
            }
            if(markerData.title && markerData.icon ){
                MHMMapBuilder.Storage.markers.set(marker, {remove: false});
                this.activeMarker.setAnimation(null);
                this.activeMarker = null;
                this.$el.removeClass("mhm-setting-marker");
                this.closeEditor();
            }else{
                alert("All fields are mandatory");
            }
        },
        deleteMarker: function(e) {
            _.isObject(e) && e.preventDefault();
            var modelID = this.editor.data("modelid");
            if(modelID){
                marker = MHMMapBuilder.Storage.markers.get(modelID);
                var mapMarker = marker.get("marker");
                _.isObject(mapMarker) && mapMarker.setMap(null);
                marker.destroy();
            }
            this.closeEditor();
        },
        addMarkerField: function(marker) {
            var markerView = new MHMMapBuilder.Views.Marker({model: marker});
            this.markerFields.append(markerView.render().el);
        },
        cancelMarker: function(e) {
            _.isObject(e) && e.preventDefault();
            if(!this.$el.hasClass("mhm-setting-marker")){
                return;
            }
            this.activeMarker.setMap(null);
            this.activeMarker = null;
            this.$el.removeClass("mhm-setting-marker");
            this.updateCenter();
        },
        showEditor: function(html) {
            this.$el.addClass("mhm-editor-shown");
            this.editor.html(html);
        },
        closeEditor: function(e) {
            _.isObject(e) && e.preventDefault();
            this.$el.removeClass("mhm-editor-shown");
            this.editor.data("modelid", null);
            this.editor.html("").removeClass("mhm-form-new");;
        },
        mediaUpload: function(e) {
            _.isObject(e) && e.preventDefault();
            var $button = $(e.currentTarget), $field = $(e.currentTarget).prev('input'), $sub;
            file_frame = wp.media.frames.file_frame = wp.media({
                title: 'Select Image',
                button: {
                text: 'Use This Image'
                },
                multiple: false
            });
            file_frame.on( 'select', function() {
                var attachment = file_frame.state().get('selection').toJSON();
                attachment = attachment[0];
                if($button.hasClass("thumb-full")){
                    $button.siblings(".mhmup-full").val(attachment.url);
                    $button.siblings(".mhmup-thumb").val(attachment.sizes.thumbnail.url);
                }else{
                    $button.prev('input').val(attachment.url);
                }
                if($button.hasClass("mhm-has-prev")){
                    $button.siblings(".mhmbb-upload-prev").html('<img src="' + attachment.sizes.thumbnail.url + '"/>')
                }
            });
            file_frame.open();
        },
        initMap: function() {
            MHMMapBuilder.map = new google.maps.Map(document.getElementById("mhm-map-container"), {
            center: MHMMapBuilder.Storage.center.toJSON(),
            zoom: 12
        });
        }
    });
    MHMMapBuilder.init = function() {
        var mapBuilder = new MHMMapBuilder.builderView;
    };
    window.MHMMBInitMap = function(){
        MHMMapBuilder.init();
    };
})(jQuery);