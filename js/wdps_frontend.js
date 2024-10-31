
function wdps_show_thumb(key, wdps) {
  var data = window["wdps_data_" + wdps][key];
  var bg_fit = window["wdps_data_" + wdps][key]["bg_fit"];
  var full_width = window["wdps_data_" + wdps][key]["full_width"];
  var bull_position = window["wdps_data_" + wdps][key]["bull_position"];
  var image_url = data["image_url"];
  var dot_conteiner_width = jQuery('.wdps_slideshow_dots_container_' + wdps).width() / 2;
  var dot_conteiner_height = jQuery('.wdps_slideshow_dots_container_' + wdps).height();
  var wdps_bulframe_width = jQuery('.wdps_bulframe_' + wdps).width() / 2;
  var dot_position = jQuery('#wdps_dots_' + key + '_' + wdps ).position();
  var dot_width = jQuery('#wdps_dots_' + key + '_' + wdps ).width() / 2;
  dot_position = dot_position.left;
  var childPos = jQuery('#wdps_dots_' + key + '_' + wdps ).offset();
  var parentPos = jQuery('.wdps_slideshow_dots_thumbnails_' + wdps).parent().offset();
  var childOffset = childPos.left - parentPos.left;
  var right_offset = 0;
  var rt = (dot_conteiner_width * 2) - childOffset;
  if (wdps_bulframe_width >= rt && rt > 0 ){
    right_offset =  wdps_bulframe_width - rt ;
    dot_width = 0;
  }
  if (full_width == '1') {
    if (wdps_bulframe_width >= childOffset) {
      wdps_bulframe_width = childOffset - parentPos.left ;  
      dot_width = 0;
    }
  }
  else {
    if (wdps_bulframe_width >= childOffset) {
      wdps_bulframe_width = childOffset ;  
      dot_width = 0;
    }
  }
  dot_position = childOffset - wdps_bulframe_width + dot_width - right_offset ;
  jQuery('.wdps_bulframe_' + wdps ).css({
    'position' : 'absolute',
    'z-index' : '9999',
    'left': dot_position,
    'background-image' :'url("' + image_url + '")',
    'background-size' : bg_fit,
    'background-repeat' : 'no-repeat',
    'background-position' : 'center center'});
  jQuery('.wdps_bulframe_' + wdps ).css(bull_position, dot_conteiner_height);
  jQuery('.wdps_bulframe_' + wdps ).fadeIn();
}

function wdps_hide_thumb(wdps) {
  jQuery('.wdps_bulframe_' + wdps ).css({'background-image':''});
  jQuery('.wdps_bulframe_' + wdps ).fadeOut();
}
function wdps_get_overall_parent(obj) {
  if (obj.parent().width()) {
    obj.width(obj.parent().width());
    var a = obj.parent().width();
    return a;
  }
  else {
    return wdps_get_overall_parent(obj.parent());
  }
}
function wdps_set_text_dots_cont(wdps) {
  var wdps_bull_width = 0;
  jQuery(".wdps_slideshow_dots_" + wdps).each(function(){
    wdps_bull_width += jQuery(this).outerWidth() + 2 * parseInt(jQuery(this).css("margin-left"));
  });
  jQuery(".wdps_slideshow_dots_thumbnails_" + wdps).css({width: wdps_bull_width});
}