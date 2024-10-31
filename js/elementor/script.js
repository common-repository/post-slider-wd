jQuery("document").ready(function () {
    elementor.hooks.addAction( 'panel/open_editor/widget/wdps-elementor', function( panel, model, view ) {
        var wdps_obj = jQuery('select[data-setting="wdps_slider_id"]',window.parent.document);
        wdps_edit_slider_link(wdps_obj);
    });
    jQuery('body').on('change', 'select[data-setting="wdps_slider_id"]',window.parent.document, function (){
        wdps_edit_slider_link(jQuery(this));
    });
});

function wdps_edit_slider_link(el) {
	var id = el.val();
	var link = el.closest('.elementor-control-content').find('.elementor-control-field-description').find('a');
	var href = 'admin.php?page=sliders_wdps';
	// @TODO should be fix in the next version!
	// if ( id !== '0' ) {
		// href = 'admin.php?page=sliders_wdps&task=edit&current_id=' + id;
	// }
	link.attr( 'href', href);
}