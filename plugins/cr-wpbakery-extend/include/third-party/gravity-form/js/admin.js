function SetCRPhoneProperties(){
    field = GetSelectedField();

    //Only save the hide country property for address types that have that option (ones with no country)
    var country = jQuery("#field_cr_phone_default_country").val();

    SetFieldProperty("defaultCountry",country);

    jQuery(".field_selected #input_" + field.id + "_3").val(jQuery("#field_cr_phone_default_country").val());
}

jQuery(document).bind('gform_load_field_settings', function (event, field, form) {
    if (field.type === 'cr_phone') {
        jQuery("#field_cr_phone_default_country").val(field.defaultCountry == undefined ? "" : field.defaultCountry);
    }
});