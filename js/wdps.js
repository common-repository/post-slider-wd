jQuery(document).ready(function () {
  jQuery(".wdps_form .colspanchange").attr("colspan", jQuery(".wdps_form table>thead>tr>th").length);
  jQuery(".wdps_requried").each(function () {
    jQuery(this).on("keypress", function () {
      jQuery(this).removeAttr("style");
    });
  });
});

function spider_ajax_save(form_id, event) {
	error = false;
	if (!wdps_check_required()) {
		error = true;	
	}  
	if(wdps_check_audio_file()){	
		error = true;	
	}
  if (error === false) {
		  /* Loading.*/
		  jQuery(".spider_load").show();
		  var post_data = {};
		  post_data["task"] = "apply";
		  /* Global.*/
		  post_data["current_id"] = jQuery("#current_id").val();
		  post_data["save_as_copy"] = jQuery("#save_as_copy").val();
		  post_data["nonce_wd"] = jQuery("#nonce_wd").val();
		  post_data["slide_ids_string"] = jQuery("#slide_ids_string").val();
		  post_data["del_slide_ids_string"] = jQuery("#del_slide_ids_string").val();
		  post_data["nav_tab"] = jQuery("#nav_tab").val();
		  post_data["tab"] = jQuery("#tab").val();
		  post_data["sub_tab"] = jQuery("#sub_tab").val();
		  post_data["name"] = jQuery("#name").val();
		  post_data["width"] = jQuery("#width").val();
		  post_data["height"] = jQuery("#height").val();
		  post_data["full_width"] = jQuery("input[name=full_width]:checked").val();
		  post_data["bg_fit"] = jQuery("input[name=bg_fit]:checked").val();
		  post_data["align"] = jQuery("#align").val();
		  post_data["effect"] = jQuery("#effect").val();
		  post_data["time_intervval"] = jQuery("#time_intervval").val();
		  post_data["autoplay"] = jQuery("input[name=autoplay]:checked").val();
		  post_data["stop_animation"] = jQuery("input[name=stop_animation]:checked").val();
		  post_data["shuffle"] = jQuery("input[name=shuffle]:checked").val();
		  post_data["music"] = jQuery("input[name=music]:checked").val();
		  post_data["music_url"] = jQuery("#music_url").val();
		  post_data["preload_images"] = jQuery("input[name=preload_images]:checked").val();
		  post_data["background_color"] = jQuery("#background_color").val();
		  post_data["background_transparent"] = jQuery("#background_transparent").val();
		  post_data["glb_border_width"] = jQuery("#glb_border_width").val();
		  post_data["glb_border_style"] = jQuery("#glb_border_style").val();
		  post_data["glb_border_color"] = jQuery("#glb_border_color").val();
		  post_data["glb_border_radius"] = jQuery("#glb_border_radius").val();
		  post_data["glb_margin"] = jQuery("#glb_margin").val();
		  post_data["glb_box_shadow"] = jQuery("#glb_box_shadow").val();
		  post_data["image_right_click"] = jQuery("input[name=image_right_click]:checked").val();
		  post_data["layer_out_next"] = jQuery("input[name=layer_out_next]:checked").val();
		  post_data["layer_word_count"] = jQuery("#layer_word_count").val();
		  post_data["published"] = jQuery("input[name=published]:checked").val();
		  post_data["start_slide_num"] = jQuery("#start_slide_num").val();
		  post_data["effect_duration"] = jQuery("#effect_duration").val();
		  post_data["parallax_effect"] = jQuery("input[name=parallax_effect]:checked").val();
		  post_data["twoway_slideshow"] = jQuery("input[name=twoway_slideshow]:checked").val();
		  post_data["hide_on_mobile"] = jQuery("#hide_on_mobile").val();
		  post_data["slider_loop"] = jQuery("input[name=slider_loop]:checked").val();
		  post_data["full_width_for_mobile"] = jQuery("#full_width_for_mobile").val();
		  post_data["order_dir"] = jQuery("input[name=order_dir]:checked").val();

		  /*Carousel.*/
		  post_data["carousel"] = jQuery("input[name=carousel]:checked").val();
		  post_data["carousel_image_counts"] = jQuery("#carousel_image_counts").val();
		  post_data["carousel_image_parameters"] = jQuery("#carousel_image_parameters").val();
		  post_data["carousel_fit_containerWidth"] = jQuery("input[name=carousel_fit_containerWidth]:checked").val();
		  post_data["carousel_width"] = jQuery("#carousel_width").val();
		  post_data["carousel_degree"] = jQuery("#carousel_degree").val();
		  post_data["carousel_grayscale"] = jQuery("#carousel_grayscale").val();
		  post_data["carousel_transparency"] = jQuery("#carousel_transparency").val();
		  /*Dynamic.*/
		  post_data["dynamic"] = jQuery("input[name=dynamic]:checked").val();
		  post_data["cache_expiration_count"] = jQuery("#cache_expiration_count").val();
		  post_data["cache_expiration"] = jQuery("#cache_expiration_name").val();
		  post_data["posts_count"] = jQuery("#posts_count").val();
		  post_data["choose_post"] = jQuery("#choose_post").val();
		  post_data["post_sort"] = jQuery("#post_sort").val();
		  post_data["order_by_posts"] = jQuery("input[name=order_by_posts]:checked").val();
		  post_data["author_name"] = jQuery("#author_name").val();
		  jQuery("#taxonomies_id").children().each(function () {
			if (jQuery(this).val() != '') {
			  post_data[jQuery(this).attr("id")] =  jQuery(this).val();
			}
		  });
		  /* Navigation.*/
		  post_data["prev_next_butt"] = jQuery("input[name=prev_next_butt]:checked").val();
		  post_data["play_paus_post_butt"] = jQuery("input[name=play_paus_post_butt]:checked").val();
		  post_data["navigation"] = jQuery("input[name=navigation]:checked").val();
		  post_data["rl_butt_img_or_not"] = jQuery("input[name=rl_butt_img_or_not]:checked").val();
		  post_data["rl_butt_style"] = jQuery("#rl_butt_style").val();
		  post_data["right_butt_url"] = jQuery("#right_butt_url").val();
		  post_data["left_butt_url"] = jQuery("#left_butt_url").val();
		  post_data["right_butt_hov_url"] = jQuery("#right_butt_hov_url").val();
		  post_data["left_butt_hov_url"] = jQuery("#left_butt_hov_url").val();
		  post_data["rl_butt_size"] = jQuery("#rl_butt_size").val();
		  post_data["pp_butt_size"] = jQuery("#pp_butt_size").val();
		  post_data["butts_color"] = jQuery("#butts_color").val();
		  post_data["hover_color"] = jQuery("#hover_color").val();
		  post_data["nav_border_width"] = jQuery("#nav_border_width").val();
		  post_data["nav_border_style"] = jQuery("#nav_border_style").val();
		  post_data["nav_border_color"] = jQuery("#nav_border_color").val();
		  post_data["nav_border_radius"] = jQuery("#nav_border_radius").val();
		  post_data["nav_bg_color"] = jQuery("#nav_bg_color").val();
		  post_data["butts_transparent"] = jQuery("#butts_transparent").val();
		  post_data["play_paus_butt_img_or_not"] = jQuery("input[name=play_paus_butt_img_or_not]:checked").val();
		  post_data["play_butt_url"] = jQuery("#play_butt_url").val();
		  post_data["play_butt_hov_url"] = jQuery("#play_butt_hov_url").val();
		  post_data["paus_butt_url"] = jQuery("#paus_butt_url").val();
		  post_data["paus_butt_hov_url"] = jQuery("#paus_butt_hov_url").val();

		  /* Bullets.*/
		  post_data["enable_bullets"] = jQuery("input[name=enable_bullets]:checked").val();
		  post_data["bull_position"] = jQuery("#bull_position").val();
		  post_data["bull_style"] = jQuery("#bull_style").val();
		  post_data["bullets_img_main_url"] = jQuery("#bullets_img_main_url").val();
		  post_data["bullets_img_hov_url"] = jQuery("#bullets_img_hov_url").val();
		  post_data["bull_butt_img_or_not"] = jQuery("input[name=bull_butt_img_or_not]:checked").val();
		  post_data["bull_size"] = jQuery("#bull_size").val();
		  post_data["bull_color"] = jQuery("#bull_color").val();
		  post_data["bull_act_color"] = jQuery("#bull_act_color").val();
		  post_data["bull_margin"] = jQuery("#bull_margin").val();
		  post_data["bull_hover"] = jQuery("input[name=bull_hover]:checked").val();
		  post_data["show_thumbnail"] = jQuery("input[name=show_thumbnail]:checked").val();
		  post_data["thumb_size"] = jQuery("input[name=wdps_thumb_size]").val();

		  /* Filmstrip.*/
		  post_data["enable_filmstrip"] = jQuery("input[name=enable_filmstrip]:checked").val();
		  post_data["film_pos"] = jQuery("#film_pos").val();
		  post_data["film_thumb_width"] = jQuery("#film_thumb_width").val();
		  post_data["film_thumb_height"] = jQuery("#film_thumb_height").val();
		  post_data["film_bg_color"] = jQuery("#film_bg_color").val();
		  post_data["film_tmb_margin"] = jQuery("#film_tmb_margin").val();
		  post_data["film_act_border_width"] = jQuery("#film_act_border_width").val();
		  post_data["film_act_border_style"] = jQuery("#film_act_border_style").val();
		  post_data["film_act_border_color"] = jQuery("#film_act_border_color").val();
		  post_data["film_dac_transparent"] = jQuery("#film_dac_transparent").val();

		  /* Timer bar.*/
		  post_data["enable_time_bar"] = jQuery("input[name=enable_time_bar]:checked").val();
		  post_data["timer_bar_type"] = jQuery("#timer_bar_type").val();
		  post_data["timer_bar_size"] = jQuery("#timer_bar_size").val();
		  post_data["timer_bar_color"] = jQuery("#timer_bar_color").val();
		  post_data["timer_bar_transparent"] = jQuery("#timer_bar_transparent").val();
		  
		  /* Css.*/
		  post_data["css"] = jQuery("#css").val();
		  
		  /*font*/
		  post_data["possib_add_ffamily"] = jQuery("#possib_add_ffamily").val();
		  post_data["possib_add_google_fonts"] = jQuery("input[name=possib_add_google_fonts]:checked").val();
		  post_data["possib_add_ffamily_google"] = jQuery("#possib_add_ffamily_google").val();
		  
		   /*Smart Crop*/
		  post_data["smart_crop"] = jQuery("input[name=smart_crop]:checked").val();
		  post_data["crop_image_position"] = jQuery("input[name=crop_image_position]:checked").val();

		  post_data["bull_back_act_color"] = jQuery("#bull_back_act_color").val();
		  post_data["bull_back_color"] = jQuery("#bull_back_color").val();
		  post_data["bull_radius"] = jQuery("#bull_radius").val();
		  post_data["featured_image"] = jQuery("input[name=featured_image]:checked").val();
		  
		  post_data["mouse_swipe_nav"] = jQuery("input[name=mouse_swipe_nav]:checked").val();
		  post_data["touch_swipe_nav"] = jQuery("input[name=touch_swipe_nav]:checked").val();
		  post_data["mouse_wheel_nav"] = jQuery("input[name=mouse_wheel_nav]:checked").val();
		  post_data["keyboard_nav"] = jQuery("input[name=keyboard_nav]:checked").val();

		  var wdps_slide_ids = jQuery("#slide_ids_string").val();
		  var slide_ids_array = wdps_slide_ids.split(",");
		  for (var i in slide_ids_array) {
			if (slide_ids_array.hasOwnProperty(i) && slide_ids_array[i] && slide_ids_array[i] != ",") {
			  var slide_id = slide_ids_array[i];
			  post_data["title" + slide_id] = jQuery("#title" + slide_id).val();
			  post_data["order" + slide_id] = jQuery("#order" + slide_id).val();
			  if (post_data["order" + slide_id] == 0) {
				post_data["order" + slide_id] = parseInt(i) + 1;
			  }
			  post_data["published" + slide_id] = jQuery("input[name=published" + slide_id + "]:checked").val();
			  post_data["link" + slide_id] = jQuery("#link" + slide_id).val();
			  post_data["post_id" + slide_id] = jQuery("#wdps_post_id" + slide_id).val();
			  post_data["target_attr_slide" + slide_id] = jQuery("input[name=target_attr_slide" + slide_id +" ]:checked").val();
			  post_data["type" + slide_id] = jQuery("#type" + slide_id).val();
			  post_data["image_url" + slide_id] = jQuery("#image_url" + slide_id).val();
			  post_data["thumb_url" + slide_id] = jQuery("#thumb_url" + slide_id).val();
			  if (post_data["title" + slide_id] == 'prototype') {
				post_data["link" + slide_id] = jQuery("input[name=link" + slide_id +" ]:checked").val();
			  }
			  var layer_ids_string = jQuery("#slide" + slide_id + "_layer_ids_string").val();
			  post_data["slide" + slide_id + "_layer_ids_string"] = layer_ids_string;
			  post_data["slide" + slide_id + "_del_layer_ids_string"] = jQuery("#slide" + slide_id + "_del_layer_ids_string").val();
			  if (layer_ids_string) {
				var layer_ids_array = layer_ids_string.split(",");
				for (var i in layer_ids_array) {
				  if (layer_ids_array.hasOwnProperty(i) && layer_ids_array[i] && layer_ids_array[i] != ",") {
					var json_data = {};
					var layer_id = layer_ids_array[i];
					var prefix = "slide" + slide_id + "_layer" + layer_id;
					var type = jQuery("#" + prefix + "_type").val();
					json_data["type"] = type;
					json_data["title"] = jQuery("#" + prefix + "_title").val();
					json_data["depth"] = jQuery("#" + prefix + "_depth").val();
					json_data["infinite_in"] = jQuery("input[name=" + prefix + "_infinite_in]").val();
					json_data["infinite_out"] = jQuery("input[name=" + prefix + "_infinite_out]").val();
					switch (type) {
					  case "text": {
						json_data["text"] = jQuery("#" + prefix + "_text").val();
						json_data["image_width"] = jQuery("#" + prefix + "_image_width").val();
						json_data["image_height"] = jQuery("#" + prefix + "_image_height").val();
						json_data["image_scale"] = jQuery("input[name=slide" + slide_id + "_layer" + layer_id + "_image_scale]:checked").val();
						json_data["size"] = jQuery("#" + prefix + "_size").val();
						json_data["color"] = jQuery("#" + prefix + "_color").val();
						json_data["ffamily"] = jQuery("#" + prefix + "_ffamily").val();
						json_data["google_fonts"] = jQuery("input[name=slide" + slide_id + "_layer" + layer_id + "_google_fonts]:checked").val();
						json_data["fweight"] = jQuery("#" + prefix + "_fweight").val();
						json_data["link"] = jQuery("#" + prefix + "_link").val();
						json_data["target_attr_layer"] = jQuery("input[name=" + prefix + "_target_attr_layer]:checked").val();
						json_data["padding"] = jQuery("#" + prefix + "_padding").val();
						json_data["fbgcolor"] = jQuery("#" + prefix + "_fbgcolor").val();
						json_data["transparent"] = jQuery("#" + prefix + "_transparent").val();
						json_data["border_width"] = jQuery("#" + prefix + "_border_width").val();
						json_data["border_style"] = jQuery("#" + prefix + "_border_style").val();
						json_data["border_color"] = jQuery("#" + prefix + "_border_color").val();
						json_data["border_radius"] = jQuery("#" + prefix + "_border_radius").val();
						json_data["shadow"] = jQuery("#" + prefix + "_shadow").val();
						json_data["layer_characters_count"] = jQuery("#" + prefix + "_layer_characters_count").val();
						json_data["align_layer"] = jQuery("input[name=" + prefix + "_align_layer]:checked").val();
						json_data["text_alignment"] = jQuery("#" + prefix + "_text_alignment").val();
						json_data["remove_shortcode"] = jQuery("input[name=" + prefix + "_remove_shortcode]:checked").val();
						json_data["hover_color_text"] = jQuery("#" + prefix + "_hover_color_text").val();
						json_data["min_size"] = jQuery("#" + prefix + "_min_size").val();
						break;
					  }
					  case "image": {
						json_data["image_url"] = jQuery("#" + prefix + "_image_url").val();
						json_data["image_width"] = jQuery("#" + prefix + "_image_width").val();
						json_data["image_height"] = jQuery("#" + prefix + "_image_height").val();
						json_data["image_scale"] = jQuery("input[name=slide" + slide_id + "_layer" + layer_id + "_image_scale]:checked").val();
						json_data["alt"] = jQuery("#" + prefix + "_alt").val();
						json_data["link"] = jQuery("#" + prefix + "_link").val();
						json_data["target_attr_layer"] = jQuery("input[name=" + prefix + "_target_attr_layer]:checked").val();
						json_data["imgtransparent"] = jQuery("#" + prefix + "_imgtransparent").val();
						json_data["border_width"] = jQuery("#" + prefix + "_border_width").val();
						json_data["border_style"] = jQuery("#" + prefix + "_border_style").val();
						json_data["border_color"] = jQuery("#" + prefix + "_border_color").val();
						json_data["border_radius"] = jQuery("#" + prefix + "_border_radius").val();
						json_data["shadow"] = jQuery("#" + prefix + "_shadow").val();
						break;
					  }
					  case "video": {
						json_data["image_url"] = jQuery("#" + prefix + "_image_url").val();
						json_data["image_width"] = jQuery("#" + prefix + "_image_width").val();
						json_data["image_height"] = jQuery("#" + prefix + "_image_height").val();
						json_data["image_scale"] = jQuery("input[name=slide" + slide_id + "_layer" + layer_id + "_image_scale]:checked").val();
						json_data["link"] = jQuery("#" + prefix + "_link").val();
						json_data["alt"] = jQuery("#" + prefix + "_alt").val();
						json_data["border_width"] = jQuery("#" + prefix + "_border_width").val();
						json_data["border_style"] = jQuery("#" + prefix + "_border_style").val();
						json_data["border_color"] = jQuery("#" + prefix + "_border_color").val();
						json_data["border_radius"] = jQuery("#" + prefix + "_border_radius").val();
						json_data["shadow"] = jQuery("#" + prefix + "_shadow").val();
						break;
					  }
					  case "social": {
						json_data["social_button"] = jQuery("#" + prefix + "_social_button").val();
						json_data["size"] = jQuery("#" + prefix + "_size").val();
						json_data["transparent"] = jQuery("#" + prefix + "_transparent").val();
						json_data["color"] = jQuery("#" + prefix + "_color").val();
						json_data["hover_color"] = jQuery("#" + prefix + "_hover_color").val();
						break;
					  }
					  default:
						break;
					}
					if(typeof(jQuery("#" + prefix + "_left").val())!="undefined"){
						json_data["left"] = jQuery("#" + prefix + "_left").val();
					}	
					if(typeof(jQuery("#" + prefix + "_top").val())!="undefined"){	
						json_data["top"] = jQuery("#" + prefix + "_top").val();
					}	
					json_data["published"] = jQuery("input[name=slide" + slide_id + "_layer" + layer_id + "_published]:checked").val();
					json_data["start"] = jQuery("#" + prefix + "_start").val();
					json_data["layer_effect_in"] = jQuery("#" + prefix + "_layer_effect_in").val();
					json_data["duration_eff_in"] = jQuery("#" + prefix + "_duration_eff_in").val();
					json_data["end"] = jQuery("#" + prefix + "_end").val();
					json_data["layer_effect_out"] = jQuery("#" + prefix + "_layer_effect_out").val();
					json_data["duration_eff_out"] = jQuery("#" + prefix + "_duration_eff_out").val();
					post_data[prefix + "_json"] = JSON.stringify(json_data);
					json_data = null;
				  }
				 
				}
			  }
			}
		  }
		 
		  jQuery.post(
			jQuery('#' + form_id).action,
			post_data,
			function (data) {
			  var content = jQuery(data).find(".wdps_nav_global_box").parent();
			  var str = content.html();
			  jQuery(".wdps_nav_global_box").parent().html(str);
			  var str = jQuery(data).find(".wdps_task_cont").html();
			  jQuery(".wdps_task_cont").html(str);
			  var str = jQuery(data).find(".wdps_buttons").html();
			  jQuery(".wdps_buttons").html(str);
			  var content = jQuery(data).find(".wdps_slides_box");
			  var str = content.html();
			  jQuery(".wdps_slides_box").html(str);
			  var post_btn_href = jQuery(data).find("#wdps_posts_btn").attr("href");
			  jQuery("#wdps_posts_btn").attr("href", post_btn_href);
			}
		  ).success(function (data, textStatus, errorThrown) {
			 wdps_success(form_id,0);
			 wdps_change_taxonomies();
			 wdps_tooltip();
		  });
    if (event.preventDefault) {
      event.preventDefault();
    }
    else {
      event.returnValue = false;
    }
	}
}

function wdps_add_post(ids_string, single) {
  var ids_array = ids_string.split(",");
  /* Delete active slide if it has now image.*/
  if (!single) {
    window.parent.jQuery(".wdps_box input[id^='image_url']").each(function () {
      var slide_id = window.parent.jQuery(this).attr("id").replace("image_url", "");
      if (!window.parent.jQuery("#image_url" + slide_id).val() && !window.parent.jQuery("#slide" + slide_id + "_layer_ids_string").val()) {
        window.parent.wdps_remove_slide(slide_id, 0);
      }
    });
  }
  else {
    var slideID = jQuery("#slide_id").val();
  }
  
  for (var i in ids_array) {
    if (ids_array.hasOwnProperty(i) && ids_array[i]) {
      var id = ids_array[i];
      if (jQuery("#check_" + id).prop('checked') == true) {
        if (!single || slideID == 0) {
          var slideID = window.parent.wdps_add_slide(jQuery.parseJSON(jQuery('#post_feild_val' + id).val()),id);
        }
        window.parent.jQuery("#title" + slideID).val(jQuery("#wdps_title_" + id).val());
        window.parent.jQuery("#type" + slideID).val("image");
        window.parent.jQuery("#image_url" + slideID).val(jQuery("#wdps_image_url_" + id).val());
        window.parent.jQuery("#thumb_url" + slideID).val(jQuery("#wdps_thumb_url_" + id).val());
        window.parent.jQuery("#wdps_preview_image" + slideID).css({backgroundImage: "url('" + jQuery("#wdps_image_url_" + id).val() + "')"});
        window.parent.jQuery("#wdps_tab_image" + slideID).css({backgroundImage: "url('" + jQuery("#wdps_image_url_" + id).val() + "')"});
        var layerID = window.parent.wdps_add_layer('text', slideID,'','',1,'','',jQuery.parseJSON(jQuery('#post_feild_val' + id).val()));
        var prefix = 'slide' + slideID + '_layer' + layerID;
        var text='';
        window.parent.jQuery("#" + prefix + "_text").html(jQuery("#wdps_content_" + id).val());
        window.parent.jQuery("#" + prefix + "_link").val(jQuery("#wdps_link_" + id).val());
        window.parent.jQuery("#" + prefix).html(jQuery("#wdps_content_" + id).val());
        var post_data = jQuery.parseJSON(jQuery('#post_feild_val' + id).val());
        for (var i=0; i < post_data.length; ++i) {
        if(typeof(post_data[i])!='number' && typeof(post_data[i]) != "undefined") {
           post_data[i] = wdps_ReplaceAll(post_data[i],'"',"**###**");
        }
         text += '<input type="button" class="button-primary" id="'+prefix+'_post_feilds_" value="' + post_data[i] + '" style="line-height:4px;display:table;float:left; margin:3px;" onclick="wdps_add_post_feilds(\''+prefix+ '\',\'' + post_data[i] + '\')" ' + fv_disabled + '/>';
        }
        
        window.parent.jQuery("#" + prefix +'_post_feild').html(text);
        window.parent.jQuery("#wdps_post_id" + slideID).val(id);
      }
    }
  }
}
function wdps_ReplaceAll(Source, stringToFind, stringToReplace) {
    var temp = Source;
    var index = temp.indexOf(stringToFind);
    
    while (index != -1) {
      temp = temp.replace(stringToFind, stringToReplace);
      index = temp.indexOf(stringToFind);
    }
    return temp;
}
function wdps_action_after_save(form_id) {
  var post_data = {};
  post_data["task"] = jQuery("#task").val();
  post_data["current_id"] = jQuery("#current_id").val();
  post_data["nonce_wd"] = jQuery("#nonce_wd").val();
  jQuery.post(
    jQuery("#" + form_id).attr("action"),
    post_data,
    function (data) {
      jQuery(".wdps_preview").find("div[class^='wdps_preview_image']").each(function() {
        var image = jQuery(this).css("background-image");
        jQuery(this).css({backgroundImage: image.replace('")', Math.floor((Math.random() * 100) + 1) + '")')});
      });
    }
  ).success(function (data, textStatus, errorThrown) {
    wdps_success(form_id, 1);
  });
}

function wdps_success(form_id, end) {
  jQuery("#" + form_id).parent().find(".spider_message").remove();
  var task = jQuery("#task").val();
  var message;
  switch (task) {
    case "save": {
      jQuery("#" + form_id).submit();
      break;
    }
    case "reset":
    case "duplicate": {
      jQuery("#" + form_id).submit();
      break;
    }
    default: {
      message = "<div class='updated'><strong><p>" + wdps_objectL10B.saved + "</p></strong></div>";
      break;
    }
  }
   
  /* Loading.*/
  jQuery(".spider_load").hide();
  if (message) {
    jQuery(".spider_message_cont").html(message);
    jQuery(".spider_message_cont").show();
  }
  wdps_onload();
  jscolor.bind();
}


function wdps_onload() {
  var type_key;
  var color_key;
  var bull_type_key;
  var bull_color_key;
  jQuery(".wdps_tabs").show();
  var nav_tab = jQuery("#nav_tab").val();
  wdps_change_nav(jQuery(".wdps_nav_tabs li[tab_type='" + nav_tab + "']"), 'wdps_nav_' + nav_tab + '_box');
  var tab = jQuery("#tab").val();
    wdps_change_tab(jQuery("." + tab  + "_tab_button_wrap"), 'wdps_' + tab + '_box');

  wdps_slide_weights();
  if (jQuery("#music1").is(":checked")) {
    wdps_enable_disable('', 'tr_music_url', 'music1');
  }
  else {
    wdps_enable_disable('none', 'tr_music_url', 'music0');
  }
   if (jQuery("#bg_fit_cover").is(":checked") || jQuery("#bg_fit_contain").is(":checked")) {
    jQuery('#tr_smart_crop').show();
  }
  else {
    jQuery('#tr_smart_crop').hide();
  }
  if (jQuery("#smart_crop1").is(":checked")) {
    wdps_enable_disable('', 'tr_crop_pos', 'smart_crop1');
  }
  else {
    wdps_enable_disable('none', 'tr_crop_pos', 'smart_crop0');
  }
  if (jQuery("#show_thumbnail1").is(":checked")) {
    wdps_enable_disable('', 'tr_thumb_size', 'show_thumbnail1');
  }
  else {
    wdps_enable_disable('none', 'tr_thumb_size', 'show_thumbnail0');
  }
  jQuery('.wdps_rl_butt_groups').each(function(i) {
    var type_key = jQuery(this).attr('value');
    var src_top_left	= rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/1/1.png';
    var src_top_right	= rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/1/2.png';
    var src_bottom_left	= rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/1/3.png';
    var src_bottom_right  	= rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/1/4.png';
   
    jQuery(this).find('.src_top_left').attr('src', src_top_left);
    jQuery(this).find('.src_top_right').attr('src', src_top_right);
    jQuery(this).find('.src_bottom_left').attr('src', src_bottom_left);
    jQuery(this).find('.src_bottom_right').attr('src', src_bottom_right);	 
  });

  jQuery('.wdps_rl_butt_col_groups').each(function(i) {
    var color_key = jQuery(this).attr('value');	 
    src_col_top_left	= rl_butt_dir + wdps_rl_butt_type[type_cur_fold]["type_name"] + '/' + wdps_rl_butt_type[type_cur_fold][color_key] + '/1.png';
    src_col_top_right	= rl_butt_dir + wdps_rl_butt_type[type_cur_fold]["type_name"] + '/' + wdps_rl_butt_type[type_cur_fold][color_key] + '/2.png';
    src_col_bottom_left	= rl_butt_dir + wdps_rl_butt_type[type_cur_fold]["type_name"] + '/' + wdps_rl_butt_type[type_cur_fold][color_key] + '/3.png';
    src_col_bottom_right  	= rl_butt_dir + wdps_rl_butt_type[type_cur_fold]["type_name"] + '/' + wdps_rl_butt_type[type_cur_fold][color_key] + '/4.png';
   
    jQuery(this).find('.src_col_top_left').attr('src', src_col_top_left);	
    jQuery(this).find('.src_col_top_right').attr('src', src_col_top_right);
    jQuery(this).find('.src_col_bottom_left').attr('src', src_col_bottom_left);
    jQuery(this).find('.src_col_bottom_right').attr('src', src_col_bottom_right);	 
  });

  jQuery('.wdps_pp_butt_groups').each(function(i) {
    var pp_type_key = jQuery(this).attr('value');
    var pp_src_top_left	= pp_butt_dir + wdps_pp_butt_type[pp_type_key]["type_name"] + '/1/1.png';
    var pp_src_top_right	= pp_butt_dir + wdps_pp_butt_type[pp_type_key]["type_name"] + '/1/2.png';
    var pp_src_bottom_left	= pp_butt_dir + wdps_pp_butt_type[pp_type_key]["type_name"] + '/1/3.png';
    var pp_src_bottom_right  	= pp_butt_dir + wdps_pp_butt_type[pp_type_key]["type_name"] + '/1/4.png';
   
    jQuery(this).find('.pp_src_top_left').attr('src', pp_src_top_left);
    jQuery(this).find('.pp_src_top_right').attr('src', pp_src_top_right);
    jQuery(this).find('.pp_src_bottom_left').attr('src', pp_src_bottom_left);
    jQuery(this).find('.pp_src_bottom_right').attr('src', pp_src_bottom_right);	 
  });

  jQuery('.wdps_pp_butt_col_groups').each(function(i) {
    var pp_color_key = jQuery(this).attr('value');	 
    var pp_src_col_top_left	= pp_butt_dir + wdps_pp_butt_type[pp_type_cur_fold]["type_name"] + '/' + wdps_pp_butt_type[pp_type_cur_fold][pp_color_key] + '/1.png';
    var pp_src_col_top_right = pp_butt_dir + wdps_pp_butt_type[pp_type_cur_fold]["type_name"] + '/' + wdps_pp_butt_type[pp_type_cur_fold][pp_color_key] + '/2.png';
    var pp_src_col_bottom_left = pp_butt_dir + wdps_pp_butt_type[pp_type_cur_fold]["type_name"] + '/' + wdps_pp_butt_type[pp_type_cur_fold][pp_color_key] + '/3.png';
    var pp_src_col_bottom_right = pp_butt_dir + wdps_pp_butt_type[pp_type_cur_fold]["type_name"] + '/' + wdps_pp_butt_type[pp_type_cur_fold][pp_color_key] + '/4.png';
   
    jQuery(this).find('.pp_src_col_top_left').attr('src', pp_src_col_top_left);	
    jQuery(this).find('.pp_src_col_top_right').attr('src', pp_src_col_top_right);
    jQuery(this).find('.pp_src_col_bottom_left').attr('src', pp_src_col_bottom_left);
    jQuery(this).find('.pp_src_col_bottom_right').attr('src', pp_src_col_bottom_right);	 
  });

  jQuery('.wdps_bull_butt_groups').each(function(i) {
    bull_type_key = jQuery(this).attr('value');
    bull_src_left	= blt_img_dir + wdps_blt_img_type[bull_type_key]["type_name"] + '/1/1.png';
    bull_src_right	= blt_img_dir + wdps_blt_img_type[bull_type_key]["type_name"] + '/1/2.png';
   
    jQuery(this).find('.bull_src_left').attr('src', bull_src_left);
    jQuery(this).find('.bull_src_right').attr('src', bull_src_right);	 
  });

  jQuery('.wdps_bull_butt_col_groups').each(function(i) {
    bull_color_key = jQuery(this).attr('value');	 
    bull_col_src_left	= blt_img_dir + wdps_blt_img_type[bull_type_cur_fold]["type_name"] + '/' + wdps_blt_img_type[bull_type_cur_fold][bull_color_key] + '/1.png';
    bull_col_src_right	= blt_img_dir + wdps_blt_img_type[bull_type_cur_fold]["type_name"] + '/' + wdps_blt_img_type[bull_type_cur_fold][bull_color_key] + '/2.png';
   
    jQuery(this).find('.bull_col_src_left').attr('src', bull_col_src_left);	
    jQuery(this).find('.bull_col_src_right').attr('src', bull_col_src_right);	 
  });
  jQuery('input:radio').on('change', function(){
    var radios = jQuery(this).closest('td').find('label').removeClass('selected_color');
    var label_for = jQuery("label[for='"+jQuery(this).attr('id')+"']");
    label_for.addClass('selected_color');
  });
  
  wdps_change_post_nav();    
}

function spider_select_value(obj) {
  obj.focus();
  obj.select();
 
}

function spider_run_checkbox() {
  jQuery("tbody").children().children(".check-column").find(":checkbox").click(function (l) {
    if ("undefined" == l.shiftKey) {
      return true
    }
    if (l.shiftKey) {
      if (!i) {
        return true
      }
      d = jQuery(i).closest("form").find(":checkbox");
      f = d.index(i);
      j = d.index(this);
      h = jQuery(this).prop("checked");
      if (0 < f && 0 < j && f != j) {
        d.slice(f, j).prop("checked", function () {
          if (jQuery(this).closest("tr").is(":visible")) {
            return h
          }
          return false
        })
      }
    }
    i = this;
    var k = jQuery(this).closest("tbody").find(":checkbox").filter(":visible").not(":checked");
    jQuery(this).closest("table").children("thead, tfoot").find(":checkbox").prop("checked", function () {
      return(0 == k.length)
    });
    return true
  });
  jQuery("thead, tfoot").find(".check-column :checkbox").click(function (m) {
    var n = jQuery(this).prop("checked"), l = "undefined" == typeof toggleWithKeyboard ? false : toggleWithKeyboard, k = m.shiftKey || l;
    jQuery(this).closest("table").children("tbody").filter(":visible").children().children(".check-column").find(":checkbox").prop("checked", function () {
      if (jQuery(this).is(":hidden")) {
        return false
      }
      if (k) {
        return jQuery(this).prop("checked")
      } else {
        if (n) {
          return true
        }
      }
      return false
    });
    jQuery(this).closest("table").children("thead,  tfoot").filter(":visible").children().children(".check-column").find(":checkbox").prop("checked", function () {
      if (k) {
        return false
      } else {
        if (n) {
          return true
        }
      }
      return false
    })
  });
}

// Set value by id.
function spider_set_input_value(input_id, input_value) {
  if (document.getElementById(input_id)) {
    document.getElementById(input_id).value = input_value;
  }
}

// Submit form by id.
function spider_form_submit(event, form_id) {
  if (document.getElementById(form_id)) {
    document.getElementById(form_id).submit();
  }
  if (event.preventDefault) {
    event.preventDefault();
  }
  else {
    event.returnValue = false;
  }
}

// Check if required field is empty.
function wdps_check_required() {
  var flag = true;
  jQuery(".wdps_requried").each(function () {
    if (jQuery(this).val() == '') {
      alert(jQuery(this).data('name') + ' is required.');
      wdps_change_tab(jQuery(".wdps_tab_label[tab_type='slides']"), 'wdps_slides_box');
      jQuery(this).css({borderColor: '#FF0000'});
      jQuery(this).focus();
      jQuery('html, body').animate({
        scrollTop:jQuery(this).offset().top - 200
      }, 500);
      flag = false;
      return;
    }
  });
  return flag;
}

// Check audio file is valid.
function wdps_check_audio_file() {
	error =  false;
	var music_url = jQuery("#music_url");
    if (jQuery("#music1").is(":checked")) { 
		if(music_url.val() != ''){
			var extension = music_url.val().substr((music_url.val().lastIndexOf('.') +1));
			switch(extension) {
				case 'aac':
				case 'm4a':
				case 'f4a':
				case 'mp3':
				case 'ogg':
				case 'oga':
					error =  false;
					music_url.css({borderColor: '#dddddd'});
				break;				
				default:
					error =  true;
					music_url.css({borderColor: '#FF0000'}).focus();
					alert(wdps_objectL10B.please_selcet_valid_audio_file);
				break;			
			}	
		}
	}
	return error;	
}

// Show/hide order column and drag and drop column.
function spider_show_hide_weights() {
  if (jQuery("#show_hide_weights").val() == 'Show order column') {
    jQuery(".connectedSortable").css("cursor", "default");
    jQuery("#tbody_arr").find(".handle").hide(0);
    jQuery("#th_order").show(0);
    jQuery("#tbody_arr").find(".spider_order").show(0);
    jQuery("#show_hide_weights").val("Hide order column");
    if (jQuery("#tbody_arr").sortable()) {
      jQuery("#tbody_arr").sortable("disable");
    }
  }
  else {
    jQuery(".connectedSortable").css("cursor", "move");
    var page_number;
    if (jQuery("#page_number") && jQuery("#page_number").val() != '' && jQuery("#page_number").val() != 1) {
      page_number = (jQuery("#page_number").val() - 1) * 20 + 1;
    }
    else {
      page_number = 1;
    }
    jQuery("#tbody_arr").sortable({
      handle:".connectedSortable",
      connectWith:".connectedSortable",
      update:function (event, tr) {
        jQuery("#draganddrop").attr("style", "");
        jQuery("#draganddrop").html("<strong><p>"+ wdps_objectL10B.wdps_changes_mode_saved + "</p></strong>");
        var i = page_number;
        jQuery('.spider_order').each(function (e) {
          if (jQuery(this).find('input').val()) {
            jQuery(this).find('input').val(i++);
          }
        });
      }
    });//.disableSelection();
    jQuery("#tbody_arr").sortable("enable");
    jQuery("#tbody_arr").find(".handle").show(0);
    jQuery("#tbody_arr").find(".handle").attr('class', 'handle connectedSortable');
    jQuery("#th_order").hide(0);
    jQuery("#tbody_arr").find(".spider_order").hide(0);
    jQuery("#show_hide_weights").val(wdps_objectL10B.show_order);
  }
}

// Check all items.
function spider_check_all_items() {
  spider_check_all_items_checkbox();
  // if (!jQuery('#check_all').attr('checked')) {
    jQuery('#check_all').trigger('click');
  // }
}

function spider_check_all_items_checkbox() {
  if (jQuery('#check_all_items').attr('checked')) {
    jQuery('#check_all_items').attr('checked', false);
    jQuery('#draganddrop').hide();
  }
  else {
    var saved_items = (parseInt(jQuery(".displaying-num").html()) ? parseInt(jQuery(".displaying-num").html()) : 0);
    var added_items = (jQuery('input[id^="check_pr_"]').length ? parseInt(jQuery('input[id^="check_pr_"]').length) : 0);
    var items_count = added_items + saved_items;
    jQuery('#check_all_items').attr('checked', true);
    if (items_count) {
      jQuery('#draganddrop').html("<strong><p>Selected " + items_count + " item" + (items_count > 1 ? "s" : "") + ".</p></strong>");
      jQuery('#draganddrop').show();
    }
  }
}

function spider_check_all(current) {
  if (!jQuery(current).attr('checked')) {
    jQuery('#check_all_items').attr('checked', false);
    jQuery('#draganddrop').hide();
  }
}

// Set uploader to button class.
function spider_uploader(button_id, input_id, delete_id, img_id) {
  if (typeof img_id == 'undefined') {
    img_id = '';
  }
  jQuery(function () {
    var formfield = null;
    window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor = function (html) {
      if (formfield) {
        var fileurl = jQuery('img', html).attr('src');
        if (!fileurl) {
          var exploded_html;
          var exploded_html_askofen;
          exploded_html = html.split('"');
          for (i = 0; i < exploded_html.length; i++) {
            exploded_html_askofen = exploded_html[i].split("'");
          }
          for (i = 0; i < exploded_html.length; i++) {
            for (j = 0; j < exploded_html_askofen.length; j++) {
              if (exploded_html_askofen[j].search("href")) {
                fileurl = exploded_html_askofen[i + 1];
                break;
              }
            }
          }
          if (img_id != '') {
            alert(wdps_objectL10B.wdps_select_image);
            tb_remove();
            return;
          }
          window.parent.document.getElementById(input_id).value = fileurl;
          window.parent.document.getElementById(button_id).style.display = "none";
          window.parent.document.getElementById(input_id).style.display = "inline-block";
          window.parent.document.getElementById(delete_id).style.display = "inline-block";
        }
        else {
          if (img_id == '') {
            alert(wdps_objectL10B.wdps_select_audio);
            tb_remove();
            return;
          }
          window.parent.document.getElementById(input_id).value = fileurl;
          window.parent.document.getElementById(button_id).style.display = "none";
          window.parent.document.getElementById(delete_id).style.display = "inline-block";
          if ((img_id != '') && window.parent.document.getElementById(img_id)) {
            window.parent.document.getElementById(img_id).src = fileurl;
            window.parent.document.getElementById(img_id).style.display = "inline-block";
          }
        }
        formfield.val(fileurl);
        tb_remove();
      }
      else {
        window.original_send_to_editor(html);
      }
      formfield = null;
    };
    formfield = jQuery(this).parent().parent().find(".url_input");
    tb_show('', 'media-upload.php?type=image&TB_iframe=true');
    jQuery('#TB_overlay,#TB_closeWindowButton').bind("click", function () {
      formfield = null;
    });
    return false;
  });
}

// Remove uploaded file.
function spider_remove_url(input_id, img_id) {
  var id = input_id.substr(9);
  if (typeof img_id == 'undefined') {
    img_id = '';
  }
  if (document.getElementById(input_id)) {
    document.getElementById(input_id).value = '';
  }
  if ((img_id != '') && document.getElementById(img_id)) {
    document.getElementById(img_id).style.backgroundImage = "url('')";
  }
}

function spider_reorder_items(tbody_id) {
  jQuery("#" + tbody_id).sortable({
    handle: ".connectedSortable",
    connectWith: ".connectedSortable",
    update: function (event, tr) {
      spider_sortt(tbody_id);
    }
  });
}

function spider_sortt(tbody_id) {
  var str = "";
  var counter = 0;
  jQuery("#" + tbody_id).children().each(function () {
    str += ((jQuery(this).attr("id")).substr(3) + ",");
    counter++;
  });
  jQuery("#albums_galleries").val(str);
  if (!counter) {
    document.getElementById("table_albums_galleries").style.display = "none";
  }
}

function spider_remove_row(tbody_id, event, obj) {
  var span = obj;
  var tr = jQuery(span).closest("tr");
  jQuery(tr).remove();
  spider_sortt(tbody_id);
}

function spider_jslider(idtaginp) {
  jQuery(function () {
    var inpvalue = jQuery("#" + idtaginp).val();
    if (inpvalue == "") {
      inpvalue = 50;
    }
    jQuery("#slider-" + idtaginp).slider({
      range:"min",
      value:inpvalue,
      min:1,
      max:100,
      slide:function (event, ui) {
        jQuery("#" + idtaginp).val("" + ui.value);
      }
    });
    jQuery("#" + idtaginp).val("" + jQuery("#slider-" + idtaginp).slider("value"));
  });
}

function spider_get_items(e) {
  if (e.preventDefault) {
    e.preventDefault();
  }
  else {
    e.returnValue = false;
  }
  var trackIds = [];
  var titles = [];
  var types = [];
  var tbody = document.getElementById('tbody_albums_galleries');
  var trs = tbody.getElementsByTagName('tr');
  for (j = 0; j < trs.length; j++) {
    i = trs[j].getAttribute('id').substr(3);
    if (document.getElementById('check_' + i).checked) {
      trackIds.push(document.getElementById("id_" + i).innerHTML);
      titles.push(document.getElementById("a_" + i).innerHTML);
      types.push(document.getElementById("url_" + i).innerHTML == "Album" ? 1 : 0);
    }
  }
  window.parent.wdps_add_items(trackIds, titles, types);
}
function change_rl_butt_style(type_key) {
  jQuery("#wdps_left_style").removeClass().addClass("fa " + type_key + "-left");
  jQuery("#wdps_right_style").removeClass().addClass("fa " + type_key + "-right");
}

function change_bull_style(type_key) {
  jQuery("#wdps_act_bull_style").removeClass().addClass("fa " + type_key.replace("-o", ""));
  jQuery("#wdps_deact_bull_style").removeClass().addClass("fa " + type_key);
}

function change_rl_butt_type(that) {
  var type_key = jQuery(that).attr('value');
  src	= rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/1/1.png';
  var options = '';
  var divs = '';
  for (var i = 0; i < wdps_rl_butt_type[type_key].length - 1; i++) {
    var num = i + 1;
    divs += '<div class="spider_option_cont" value="' + i + '"  onclick="change_rl_butt_color(this, ' + type_key + ')" > ' +
			  '<div  class="spider_option_cont_title" >' +
			    'Color-'+ num +
			  '</div>' +
			  '<div class="spider_option_cont_img" >' + 
			    '<img  src="' + rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/'+wdps_rl_butt_type[type_key][i]+'/1.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			    '<img  src="' + rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/'+wdps_rl_butt_type[type_key][i]+'/2.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			    '<img  src="' + rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/'+wdps_rl_butt_type[type_key][i]+'/3.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			    '<img  src="' + rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/'+wdps_rl_butt_type[type_key][i]+'/4.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			  '</div>' +
		    '</div>';
  }
  jQuery(".spider_options_cont .spider_option_cont").css({backgroundColor: ""});
  jQuery(that).css({backgroundColor: "#3399FF"});
  jQuery('.spider_options_color_cont').html(divs);
  jQuery('#rl_butt_img_l').attr("src", rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/1/1.png');
  jQuery('#rl_butt_img_r').attr("src", rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/1/2.png');
  jQuery('#rl_butt_hov_img_l').attr("src", rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/1/3.png');
  jQuery('#rl_butt_hov_img_r').attr("src", rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/1/4.png');

  jQuery('#left_butt_url').val(rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/1/1.png');
  jQuery('#right_butt_url').val(rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/1/2.png');
  jQuery('#left_butt_hov_url').val(rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/1/3.png');
  jQuery('#right_butt_hov_url').val(rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/1/4.png');
}

function change_play_paus_butt_type(that) {
  var type_key = jQuery(that).attr('value');
  var src	= pp_butt_dir + wdps_pp_butt_type[type_key]["type_name"] + '/1/1.png';
  var options = '';
  var divs = '';
  for (var i = 0; i < wdps_pp_butt_type[type_key].length; i++) {
    var num = i + 1;
    divs += '<div class="spider_option_cont" value="' + i + '" onclick="change_play_paus_butt_color(this, ' + type_key + ')" > ' +
			  '<div  class="spider_option_cont_title" >' +
			    'Color-'+ num +
			  '</div>' +
			  '<div class="spider_option_cont_img" >' + 
			    '<img  src="' + pp_butt_dir + wdps_pp_butt_type[type_key]["type_name"] + '/'+wdps_pp_butt_type[type_key][i]+'/1.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			    '<img  src="' + pp_butt_dir + wdps_pp_butt_type[type_key]["type_name"] + '/'+wdps_pp_butt_type[type_key][i]+'/2.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			    '<img  src="' + pp_butt_dir + wdps_pp_butt_type[type_key]["type_name"] + '/'+wdps_pp_butt_type[type_key][i]+'/3.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			    '<img  src="' + pp_butt_dir + wdps_pp_butt_type[type_key]["type_name"] + '/'+wdps_pp_butt_type[type_key][i]+'/4.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			  '</div>' +
		    '</div>';
  }
  jQuery(".spider_pp_options_cont .spider_option_cont").css({backgroundColor: ""});
  jQuery(that).css({backgroundColor: "#3399FF"});
  jQuery('.spider_pp_options_color_cont').html(divs);
  jQuery('#pp_butt_img_play').attr("src", pp_butt_dir + wdps_pp_butt_type[type_key]["type_name"] + '/1/1.png');
  jQuery('#pp_butt_img_paus').attr("src", pp_butt_dir + wdps_pp_butt_type[type_key]["type_name"] + '/1/3.png');
  jQuery('#pp_butt_hov_img_play').attr("src", pp_butt_dir + wdps_pp_butt_type[type_key]["type_name"] + '/1/2.png');
  jQuery('#pp_butt_hov_img_paus').attr("src", pp_butt_dir + wdps_pp_butt_type[type_key]["type_name"] + '/1/4.png');

  jQuery('#play_butt_url').val(pp_butt_dir + wdps_pp_butt_type[type_key]["type_name"] + '/1/1.png');
  jQuery('#paus_butt_url').val(pp_butt_dir + wdps_pp_butt_type[type_key]["type_name"] + '/1/3.png');
  jQuery('#play_butt_hov_url').val(pp_butt_dir + wdps_pp_butt_type[type_key]["type_name"] + '/1/2.png');
  jQuery('#paus_butt_hov_url').val(pp_butt_dir + wdps_pp_butt_type[type_key]["type_name"] + '/1/4.png');
}

function change_rl_butt_color(that, type_key) {
  var color_key = jQuery(that).attr('value');
  jQuery(".spider_options_color_cont .spider_option_cont").css({backgroundColor: ""});
  jQuery(that).css({backgroundColor: "#3399FF"});
  var src = rl_butt_dir + wdps_rl_butt_type[type_key]["type_name"] + '/' + wdps_rl_butt_type[type_key][color_key];
  jQuery('#rl_butt_img_l').attr("src", src + '/1.png');
  jQuery('#rl_butt_img_r').attr("src", src + '/2.png');
  jQuery('#rl_butt_hov_img_l').attr("src", src + '/3.png');
  jQuery('#rl_butt_hov_img_r').attr("src", src + '/4.png');

  jQuery('#left_butt_url').val(src + '/1.png');
  jQuery('#right_butt_url').val(src + '/2.png');
  jQuery('#left_butt_hov_url').val(src + '/3.png');
  jQuery('#right_butt_hov_url').val(src + '/4.png');
}

function change_play_paus_butt_color(that, type_key) {
  var color_key = jQuery(that).attr('value');
  jQuery(".spider_pp_options_color_cont .spider_option_cont").css({backgroundColor: ""});
  jQuery(that).css({backgroundColor: "#3399FF"});
  var src = pp_butt_dir + wdps_pp_butt_type[type_key]["type_name"] + '/' + wdps_pp_butt_type[type_key][color_key];
  jQuery('#pp_butt_img_play').attr("src", src + '/1.png');
  jQuery('#pp_butt_img_paus').attr("src", src + '/3.png');
  jQuery('#pp_butt_hov_img_play').attr("src", src + '/2.png');
  jQuery('#pp_butt_hov_img_paus').attr("src", src + '/4.png');

  jQuery('#play_butt_url').val(src + '/1.png');
  jQuery('#paus_butt_url').val(src + '/3.png');
  jQuery('#play_butt_hov_url').val(src + '/2.png');
  jQuery('#paus_butt_hov_url').val(src + '/4.png');
}

function change_src() {
  var src_l = jQuery('#rl_butt_img_l').attr("src");
  var src_r = jQuery('#rl_butt_img_r').attr("src");

  var src_h_l = jQuery('#rl_butt_hov_img_l').attr("src");
  var src_h_r = jQuery('#rl_butt_hov_img_r').attr("src");

  jQuery('#rl_butt_img_l').attr("src", src_h_l);
  jQuery('#rl_butt_img_r').attr("src", src_h_r);
  jQuery('#rl_butt_hov_img_l').attr("src", src_l);
  jQuery('#rl_butt_hov_img_r').attr("src", src_r);

  jQuery('#left_butt_url').val(src_h_l);
  jQuery('#right_butt_url').val(src_h_r);
  jQuery('#left_butt_hov_url').val(src_l);
  jQuery('#right_butt_hov_url').val(src_r);
}

function wdps_choose_option(that) {
  jQuery('.spider_options_cont').toggle(1, function() {});
  jQuery(that).find("i").toggleClass("fa-angle-down").toggleClass("fa-angle-up");
}

function wdps_choose_option_color(that) {
  jQuery('.spider_options_color_cont').toggle(1, function() {});
  jQuery(that).find("i").toggleClass("fa-angle-down").toggleClass("fa-angle-up");
}

function wdps_choose_pp_option(that) {
  jQuery('.spider_pp_options_cont').toggle(1, function() {});
  jQuery(that).find("i").toggleClass("fa-angle-down").toggleClass("fa-angle-up");
}

function wdps_choose_pp_option_color(that) {
  jQuery('.spider_pp_options_color_cont').toggle(1, function() {});
  jQuery(that).find("i").toggleClass("fa-angle-down").toggleClass("fa-angle-up");
}

function wdps_choose_bull_option(that) {
  jQuery('.spider_bull_options_cont').toggle(1, function() {});
  jQuery(that).find("i").toggleClass("fa-angle-down").toggleClass("fa-angle-up");
}

function wdps_choose_bull_option_color(that) {
  jQuery('.spider_bull_options_color_cont').toggle(1, function() {});
  jQuery(that).find("i").toggleClass("fa-angle-down").toggleClass("fa-angle-up");
}

function wdps_change_custom_src() {
  var src_l = jQuery('#left_butt_img').attr("src");
  var src_r = jQuery('#right_butt_img').attr("src");

  var src_h_l = jQuery('#left_butt_hov_img').attr("src");
  var src_h_r = jQuery('#right_butt_hov_img').attr("src");

  jQuery('#left_butt_img').attr("src", src_h_l);
  jQuery('#right_butt_img').attr("src", src_h_r);
  jQuery('#left_butt_hov_img').attr("src", src_l);
  jQuery('#right_butt_hov_img').attr("src", src_r);

  jQuery('#left_butt_url').val(src_h_l);
  jQuery('#right_butt_url').val(src_h_r);
  jQuery('#left_butt_hov_url').val(src_l);
  jQuery('#right_butt_hov_url').val(src_r);
}

function wdps_change_play_paus_custom_src() {
  var src_l = jQuery('#play_butt_img').attr("src");
  var src_r = jQuery('#paus_butt_img').attr("src");

  var src_h_l = jQuery('#play_butt_hov_img').attr("src");
  var src_h_r = jQuery('#paus_butt_hov_img').attr("src");

  jQuery('#play_butt_img').attr("src", src_h_l);
  jQuery('#paus_butt_img').attr("src", src_h_r);
  jQuery('#play_butt_hov_img').attr("src", src_l);
  jQuery('#paus_butt_hov_img').attr("src", src_r);

  jQuery('#play_butt_url').val(src_h_l);
  jQuery('#paus_butt_url').val(src_h_r);
  jQuery('#play_butt_hov_url').val(src_l);
  jQuery('#paus_butt_hov_url').val(src_r);
}


function change_play_paus_src() {
  var src_l = jQuery('#pp_butt_img_play').attr("src");
  var src_r = jQuery('#pp_butt_img_paus').attr("src");

  var src_h_l = jQuery('#pp_butt_hov_img_play').attr("src");
  var src_h_r = jQuery('#pp_butt_hov_img_paus').attr("src");

  jQuery('#pp_butt_img_play').attr("src", src_h_l);
  jQuery('#pp_butt_img_paus').attr("src", src_h_r);
  jQuery('#pp_butt_hov_img_play').attr("src", src_l);
  jQuery('#pp_butt_hov_img_paus').attr("src", src_r);

  jQuery('#play_butt_url').val(src_h_l);
  jQuery('#paus_butt_url').val(src_h_r);
  jQuery('#play_butt_hov_url').val(src_l);
  jQuery('#paus_butt_hov_url').val(src_r);
}

function wdps_change_bullets_custom_src() {
  var src_m = jQuery('#bull_img_main').attr("src");
  var src_h = jQuery('#bull_img_hov').attr("src"); 

  jQuery('#bull_img_main').attr("src", src_h);
  jQuery('#bull_img_hov').attr("src", src_m);

  jQuery('#bullets_img_main_url').val(src_h);
  jQuery('#bullets_img_hov_url').val(src_m);
}

function change_bullets_images_type(that) {
  var type_key = jQuery(that).attr('value');
  var src	= blt_img_dir + wdps_blt_img_type[type_key]["type_name"] + '/1/1.png';
  var options = '';
  var divs = '';
  for (var i = 0; i < wdps_blt_img_type[type_key].length-1; i++) {
    var num = i + 1;
    divs += '<div class="spider_option_cont" value="'+i+'"  onclick="change_bullets_images_color(this, ' + type_key + ')" > ' +
			  '<div  class="spider_option_cont_title" style="width: 64%" >' +
				'Color-'+ num +
			  '</div>' +
			  '<div class="spider_option_cont_img" style="width: 22%;padding: 6px 5px 0px 5px;" >' + 
				'<img  src="' + blt_img_dir + wdps_blt_img_type[type_key]["type_name"] + '/'+wdps_blt_img_type[type_key][i]+'/1.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
				'<img  src="' + blt_img_dir + wdps_blt_img_type[type_key]["type_name"] + '/'+wdps_blt_img_type[type_key][i]+'/2.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			  '</div>' +
			'</div>';
	
  }
  jQuery(".spider_bull_options_cont .spider_option_cont").css({backgroundColor: ""});
  jQuery(that).css({backgroundColor: "#3399FF"});
  var select = '<select class="select_icon" name="bullets_images_color" id="bullets_images_color" onchange="change_bullets_images_color(this, '+type_key+')">' + options + '</select>';
  jQuery('.spider_bull_options_color_cont').html(divs);
  jQuery('#bullets_images_color_cont').html(select);
  jQuery('#bullets_img_main').attr("src", blt_img_dir + wdps_blt_img_type[type_key]["type_name"] + '/1/1.png');
  jQuery('#bullets_img_hov').attr("src", blt_img_dir + wdps_blt_img_type[type_key]["type_name"] + '/1/2.png');

  jQuery('#bullets_img_main_url').val(blt_img_dir + wdps_blt_img_type[type_key]["type_name"] + '/1/1.png');
  jQuery('#bullets_img_hov_url').val(blt_img_dir + wdps_blt_img_type[type_key]["type_name"] + '/1/2.png');
}

function change_bullets_images_color(that, type_key) {
  var color_key = jQuery(that).attr('value');
  jQuery(".spider_bull_options_color_cont .spider_option_cont").css({backgroundColor: ""});
  jQuery(that).css({backgroundColor: "#3399FF"});
  var src = blt_img_dir + wdps_blt_img_type[type_key]["type_name"] + '/' + wdps_blt_img_type[type_key][color_key];
  jQuery('#bullets_img_main').attr("src", src + '/1.png');
  jQuery('#bullets_img_hov').attr("src", src + '/2.png');

  jQuery('#bullets_img_main_url').val(src + '/1.png');
  jQuery('#bullets_img_hov_url').val(src + '/2.png');
}

function change_bullets_src() {
  var src_l = jQuery('#bullets_img_main').attr("src");
  var src_r = jQuery('#bullets_img_hov').attr("src");

  jQuery('#bullets_img_main').attr("src", src_r);
  jQuery('#bullets_img_hov').attr("src", src_l);

  jQuery('#bullets_img_main_url').val(src_r);
  jQuery('#bullets_img_hov_url').val(src_l);
}

function image_for_next_prev_butt(display) {
  switch (display) {
    case 'our' : {
      jQuery("#rl_butt_img_or_not_our").attr('checked', 'checked');
      jQuery("#right_left_butt_style").css('display', 'none');
      jQuery("#right_butt_upl").css('display', 'none');
      jQuery("#right_left_butt_select").css('display', '');
      jQuery("#tr_butts_color").css('display', 'none');
      jQuery("#tr_hover_color").css('display', 'none');
      break;
    }
    case 'custom' : {
      jQuery("#rl_butt_img_or_not_custom").attr('checked', 'checked');
      jQuery("#right_butt_upl").css('display', '');
      jQuery("#right_left_butt_select").css('display', 'none');
      jQuery("#right_left_butt_style").css('display', 'none');
      jQuery("#tr_butts_color").css('display', 'none');
      jQuery("#tr_hover_color").css('display', 'none');
      break;
    }
    case 'style' : {
      jQuery("#rl_butt_img_or_not_0").attr('checked', 'checked');
      jQuery("#right_butt_upl").css('display', 'none');
      jQuery("#right_left_butt_select").css('display', 'none');
      jQuery("#right_left_butt_style").css('display', '');
      jQuery("#tr_butts_color").css('display', '');
      jQuery("#tr_hover_color").css('display', '');
      break;
    }
    default: {
      break;
    }
  }
}

function image_for_bull_butt(display) {
  switch (display) {
    case 'our' : {
      jQuery("#bull_butt_img_or_not_our").attr('checked', 'checked');
      jQuery("#bullets_style").css('display', 'none');
      jQuery("#bullets_images_cust").css('display', 'none');  
      jQuery("#bullets_images_select").css('display', '');
      jQuery("#bullets_act_color").css('display', 'none');
      jQuery("#bullets_color").css('display', 'none');
      jQuery("#bullets_back_act_color").css('display', 'none');
      jQuery("#bullets_back_color").css('display', 'none');
      jQuery("#bullets_radius").css('display', 'none');
      break;
    }

    case 'custom' : {
      jQuery("#bull_butt_img_or_not_cust").attr('checked', 'checked');
      jQuery("#bullets_images_cust").css('display', '');
      jQuery("#bullets_images_select").css('display', 'none');
      jQuery("#bullets_style").css('display', 'none');
      jQuery("#bullets_act_color").css('display', 'none');
      jQuery("#bullets_color").css('display', 'none');
      jQuery("#bullets_back_act_color").css('display', 'none');
      jQuery("#bullets_back_color").css('display', 'none');
      jQuery("#bullets_radius").css('display', 'none');
      break;
    }
	
    case 'style' : {
      jQuery("#bull_butt_img_or_not_stl").attr('checked', 'checked');
      jQuery("#bullets_images_select").css('display', 'none');
	  jQuery("#bullets_images_cust").css('display', 'none');  
      jQuery("#bullets_style").css('display', '');
      jQuery("#bullets_act_color").css('display', '');
      jQuery("#bullets_color").css('display', '');
      jQuery("#bullets_back_act_color").css('display', 'none');
      jQuery("#bullets_back_color").css('display', 'none');
      jQuery("#bullets_radius").css('display', 'none');
      break;
    }
    case 'text' : {
      jQuery("#bull_butt_img_or_not_txt").attr('checked', 'checked');
      jQuery("#bullets_images_select").css('display', 'none');
	    jQuery("#bullets_images_cust").css('display', 'none');  
      jQuery("#bullets_style").css('display', 'none');
      jQuery("#bullets_act_color").css('display', 'none');
      jQuery("#bullets_color").css('display', '');
      jQuery("#bullets_back_act_color").css('display', '');
      jQuery("#bullets_back_color").css('display', '');
      jQuery("#bullets_radius").css('display', '');
      break;
    }
    default: {
      break;
    }
  }
}

function image_for_play_pause_butt(display) {
  switch (display) {
    case 'our' : {
      jQuery("#play_pause_butt_img_or_not_our").attr('checked', 'checked');
      jQuery("#play_pause_butt_style").css('display', 'none');
      jQuery("#play_pause_butt_cust").css('display', 'none');
      jQuery("#play_pause_butt_select").css('display', '');
      jQuery("#tr_butts_color").css('display', 'none');
      jQuery("#tr_hover_color").css('display', 'none');
      break;
    }
    case 'custom' : {
      jQuery("#play_pause_butt_img_or_not_cust").attr('checked', 'checked');
      jQuery("#play_pause_butt_cust").css('display', '');
      jQuery("#play_pause_butt_select").css('display', 'none');
      jQuery("#play_pause_butt_style").css('display', 'none');
      jQuery("#tr_butts_color").css('display', 'none');
      jQuery("#tr_hover_color").css('display', 'none');
      break;
    }
    case 'style' : {
      jQuery("#play_pause_butt_img_or_not_style").attr('checked', 'checked');
      jQuery("#play_pause_butt_cust").css('display', 'none');
      jQuery("#play_pause_butt_select").css('display', 'none');
      jQuery("#play_pause_butt_style").css('display', '');
      jQuery("#tr_butts_color").css('display', '');
      jQuery("#tr_hover_color").css('display', '');
      break;
    }
    default: {
      break;
    }
  }
}
function showhide_for_dynamic_fildes(display) {
     if(display == 1) { 
       jQuery("#dynamic1").attr('checked', 'checked');
       jQuery("#dynamic_fildes").css('display', '');
     }
     else {
       jQuery("#dynamic0" ).attr('checked', 'checked');
       jQuery("#dynamic_fildes").css('display', 'none');
     }
}
function showhide_for_carousel_fildes(display) {
     if(display == 1) { 
       jQuery("#carousel1").attr('checked', 'checked');
       jQuery("#carousel_fildes").css('display', '');
     }
     else {
       jQuery("#carousel0" ).attr('checked', 'checked');
       jQuery("#carousel_fildes").css('display', 'none');
     }
}
function spider_check_isnum(e) {
  var chCode1 = e.which || e.paramlist_keyCode;
  if (chCode1 > 31 && (chCode1 < 48 || chCode1 > 57) && (chCode1 != 46) && (chCode1 != 45)) {
    return false;
  }
  return true;
}

function wdps_add_image_url(id) {
  jQuery('#add_image_url_button').attr("onclick", "if (spider_set_image_url('" + id + "')) {jQuery('.opacity_add_image_url').hide();} return false;");
  jQuery('.opacity_add_image_url').show();
  return false;
}
function spider_set_image_url(id) {
  if (!jQuery("#image_url_input").val()) {
    return false;
  }
  jQuery("#image_url" + id).val(jQuery("#image_url_input").val());
  jQuery("#thumb_url" + id).val(jQuery("#image_url_input").val());
  jQuery("#wdps_preview_image" + id).css("background-image", "url('" + jQuery("#image_url_input").val() + "')");
  jQuery("#delete_image_url" + id).css("display", "inline-block");
  jQuery("#wdps_preview_image" + id).css("display", "inline-block");
  jQuery("#image_url_input").val("");
  jQuery("#type" + id).val("image");
  jQuery("#trlink" + id).show();
  return true;
}

function spider_media_uploader(id, e, multiple) {
  if (typeof multiple == "undefined") {
    var multiple = false;
  }
  var custom_uploader;
  e.preventDefault();
  // If the uploader object has already been created, reopen the dialog.
  if (custom_uploader) {
    custom_uploader.open();
    // return;
  }
  // Extend the wp.media object.
  var library_type = (id == 'music') ? 'audio' : 'image'
  custom_uploader = wp.media.frames.file_frame = wp.media({
    title: 'Choose ' + library_type,
    library : { type : library_type},
    button: { text: 'Insert'},
    multiple: multiple
  });
  // When a file is selected, grab the URL and set it as the text field's value
  custom_uploader.on('select', function() {
    if (multiple == false) {
      attachment = custom_uploader.state().get('selection').first().toJSON();
    }
    else {
      attachment = custom_uploader.state().get('selection').toJSON();
    }
    var image_url = attachment.url;
    var thumb_url = (attachment.sizes && attachment.sizes.thumbnail)  ? attachment.sizes.thumbnail.url : image_url;
    switch (id) {
      case 'settings': {
        document.getElementById("background_image_url").value = image_url;
        document.getElementById("background_image").src = image_url;
        document.getElementById("button_bg_img").style.display = "none";
        document.getElementById("delete_bg_img").style.display = "inline-block";
        document.getElementById("background_image").style.display = "";
        document.getElementById("background_image_url").style.display = "";
        break;
      }
     
      case 'music': {
        var music_url = image_url;
        document.getElementById("music_url").value = music_url;
        break;
      }
      case 'nav_left_but': {
        /* Add image for left button.*/
        jQuery("#left_butt_img").attr("src", image_url);
        jQuery("#left_butt_url").val(image_url);
        break;
      }
      case 'nav_right_but': {
        /* Add image for right buttons.*/
        jQuery("#right_butt_img").attr("src", image_url);
        jQuery("#right_butt_url").val(image_url);
        break;
      }
      case 'nav_left_hov_but': {
        /* Add hover image for right buttons.*/
        jQuery("#left_butt_hov_img").attr("src", image_url);
        jQuery("#left_butt_hov_url").val(image_url);
        break;
      }
      case 'nav_right_hov_but': {
        /* Add hover image for left button.*/
        jQuery("#right_butt_hov_img").attr("src", image_url);
        jQuery("#right_butt_hov_url").val(image_url);
        break;
      }
      case 'bullets_main_but': {
        /* Add image for main button.*/
        jQuery("#bull_img_main").attr("src", image_url);
        jQuery("#bullets_img_main_url").val(image_url);
        break;
      }
      case 'bullets_hov_but': {
        /* Add image for hover button.*/
        jQuery("#bull_img_hov").attr("src", image_url);
        jQuery("#bullets_img_hov_url").val(image_url);
        break;
      }
	    case 'play_but': {
        /* Add image for play button.*/
        jQuery("#play_butt_img").attr("src", image_url);
        jQuery("#play_butt_url").val(image_url);
        break;
      }
      case 'play_hov_but': {
        /* Add image for pause button.*/
        jQuery("#play_butt_hov_img").attr("src", image_url);
        jQuery("#play_butt_hov_url").val(image_url);
        break;
      }
      case 'paus_but': {
        /* Add hover image for play button.*/
        jQuery("#paus_butt_img").attr("src", image_url);
        jQuery("#paus_butt_url").val(image_url);
        break;
      }
      case 'paus_hov_but': {
        /* Add hover image for pause button.*/
        jQuery("#paus_butt_hov_img").attr("src", image_url);
        jQuery("#paus_butt_hov_url").val(image_url);
        break;
      }
      case 'button_image_url': {
        /* Delete active slide if it has now image.*/
        jQuery(".wdps_box input[id^='image_url']").each(function () {
          var slide_id = jQuery(this).attr("id").replace("image_url", "");
          if (!jQuery("#image_url" + slide_id).val() && !jQuery("#slide" + slide_id + "_layer_ids_string").val()) {
            wdps_remove_slide(slide_id, 0);
          }
        });
        /* Add one or more slides.*/
        for (var i in attachment) {
          wdps_add_slide('');
          var slides_count = jQuery(".wbs_subtab div[id^='wbs_subtab']").length;
          var new_slide_id = "pr_" + slides_count;
          jQuery("#image_url" + new_slide_id).val(attachment[i]['url']);
          var thumb_url = (attachment[i]['sizes'] && attachment[i]['sizes']['thumbnail'])  ? attachment[i]['sizes']['thumbnail']['url'] : attachment[i]['url'];
          jQuery("#thumb_url" + new_slide_id).val(thumb_url);
          jQuery("#wdps_preview_image" + new_slide_id).css("background-image", 'url("' + attachment[i]['url'] + '")');
          jQuery("#wdps_tab_image" + new_slide_id).css("background-image", 'url("' + attachment[i]['url'] + '")');
          jQuery("#delete_image_url" + new_slide_id).css("display", "inline-block");
          jQuery("#wdps_preview_image" + new_slide_id).css("display", "inline-block");
          jQuery("#type" + new_slide_id).val("image");
          jQuery("#trlink" + new_slide_id).show();
        }
        break;
      }
      default: {
        jQuery("#image_url" + id).val(image_url);
        jQuery("#thumb_url" + id).val(thumb_url);
        jQuery("#wdps_preview_image" + id).css("background-image", "url('" + image_url + "')");
        jQuery("#wdps_tab_image" + id).css("background-image", "url('" + image_url + "')");
        jQuery("#delete_image_url" + id).css("display", "inline-block");
        jQuery("#wdps_preview_image" + id).css("display", "inline-block");
        jQuery("#type" + id).val("image");
        jQuery("#trlink" + id).show();
      }
	  }
  });
  // Open the uploader dialog.
  custom_uploader.open();
}

function wdps_add_image(files, image_for, slide_id, layer_id) {
  switch (image_for) {
    case 'add_slides': {
      /* Delete active slide if it has now image.*/
      jQuery(".wdps_box input[id^='image_url']").each(function () {
        var slide_id = jQuery(this).attr("id").replace("image_url", "");
        if (!jQuery("#image_url" + slide_id).val() && !jQuery("#slide" + slide_id + "_layer_ids_string").val()) {
          wdps_remove_slide(slide_id, 0);
        }
      });
      /* Add one or more slides.*/
      for (var i in files) {
        wdps_add_slide('');
        var slides_count = jQuery(".wbs_subtab div[id^='wbs_subtab']").length;
        var new_slide_id = "pr_" + slides_count;
        jQuery("#image_url" + new_slide_id).val(files[i]['url']);
        jQuery("#thumb_url" + new_slide_id).val(files[i]['thumb_url']);
        jQuery("#wdps_preview_image" + new_slide_id).css("background-image", 'url("' + files[i]['url'] + '")');
        jQuery("#wdps_tab_image" + new_slide_id).css("background-image", 'url("' + attachment[i]['url'] + '")');
        jQuery(".wdps_video_container" + new_slide_id).html("");
        jQuery("#delete_image_url" + new_slide_id).css("display", "inline-block");
        jQuery("#wdps_preview_image" + new_slide_id).css("display", "inline-block");
        jQuery("#type" + new_slide_id).val("image");
        jQuery("#trlink" + new_slide_id).show();
      }
    break;
    }
    case 'add_layer': {
      /* Add image layer to current slide.*/
      wdps_add_layer('image', slide_id, '', '', files);
      break;
    }
    case 'add_update_layer': {
      /* Update current layer image.*/
      if (typeof layer_id == "undefined") {
        var layer_id = "";
      }
      jQuery("#slide" + slide_id + "_layer" + layer_id).attr('src', files[0]['url']);
      jQuery("#slide" + slide_id + "_layer" + layer_id+"_image_url").val(files[0]['url']);  
      break;
    }
    case 'add_update_slide': {
      /* Add or update current slide.*/
      var file_resolution = [];						                                 							
      jQuery("#image_url" + slide_id).val(files[0]['url']);
      jQuery("#thumb_url" + slide_id).val(files[0]['thumb_url']);
      jQuery("#wdps_preview_image" + slide_id).css("background-image", 'url("' + files[0]['url'] + '")');
      jQuery("#wdps_tab_image" + slide_id).css("background-image", 'url("' + files[0]['url'] + '")');
      jQuery(".wdps_video_container" + slide_id).html("");
      jQuery("#delete_image_url" + slide_id).css("display", "inline-block");
      jQuery("#wdps_preview_image" + slide_id).css("display", "inline-block");
      jQuery("#type" + slide_id).val("image");
      jQuery("#trlink" + slide_id).show();
      break;
    }
   
    case 'nav_right_but': {
      /* Add image for right buttons.*/
      document.getElementById("right_butt_url").value = files[0]['url']; 
      document.getElementById("right_butt_img").src = files[0]['url'];
      break;
    }
    case 'nav_left_but': {
      /* Add image for left button.*/
      document.getElementById("left_butt_url").value = files[0]['url']; 
      document.getElementById("left_butt_img").src = files[0]['url'];
      break;
    }
    case 'nav_right_hov_but': {
      /* Add hover image for right buttons.*/
      document.getElementById("right_butt_hov_url").value = files[0]['url']; 
      document.getElementById("right_butt_hov_img").src = files[0]['url'];
      break;
    }
    case 'nav_left_hov_but': {
      /* Add hover image for left button.*/
      document.getElementById("left_butt_hov_url").value = files[0]['url']; 
      document.getElementById("left_butt_hov_img").src = files[0]['url'];
      break;
    }
    case 'bullets_main_but': {
      /* Add image for main button.*/
      document.getElementById("bullets_img_main_url").value = files[0]['url'];
      document.getElementById("bull_img_main").src = files[0]['url'];
      break;
    }
    case 'bullets_hov_but': {
      /* Add image for hover button.*/
      document.getElementById("bullets_img_hov_url").value = files[0]['url'];
      document.getElementById("bull_img_hov").src = files[0]['url'];
      break;
    }

	case 'play_but': {
      /* Add hover image for right buttons.*/
      document.getElementById("play_butt_url").value = files[0]['url']; 
      document.getElementById("play_butt_img").src = files[0]['url'];
      break;
    }
    case 'play_hov_but': {
      /* Add hover image for left button.*/
      document.getElementById("play_butt_hov_url").value = files[0]['url']; 
      document.getElementById("play_butt_hov_img").src = files[0]['url'];
      break;
    }
	
	 case 'paus_but': {
      /* Add image for main button.*/
      document.getElementById("paus_butt_url").value = files[0]['url']; 
      document.getElementById("paus_butt_img").src = files[0]['url'];
      break;
    }
	case 'paus_hov_but': {
      /* Add image for hover button.*/
      document.getElementById("paus_butt_hov_url").value = files[0]['url']; 
      document.getElementById("paus_butt_hov_img").src = files[0]['url'];
      break;
    }
    default: {
      break;
    }
  }
}

function wdps_change_sub_tab_title(that, box) {
 var slideID = box.substring("9");
  jQuery("#sub_tab").val(jQuery(that).attr("tab_type"));
  jQuery(".tab_buttons").removeClass("wdps_sub_active");
  jQuery(".tab_link").removeClass("wdps_sub_active");
  jQuery(".wdps_tab_title_wrap").removeClass("wdps_sub_active");
  jQuery(that).parent().addClass("wdps_sub_active");
  jQuery(".wdps_box").removeClass("wdps_sub_active");
  jQuery("." + box).addClass("wdps_sub_active");
  jQuery(".wdps_sub_active .wdps_tab_title").focus();
  jQuery(".wdps_sub_active .wdps_tab_title").select();
 
}
function wdps_change_sub_tab(that, box) {
  var slideID = box.substring("9");
  jQuery("#sub_tab").val(jQuery(that).attr("tab_type"));
  jQuery(".tab_buttons").removeClass("wdps_sub_active");
  jQuery(".tab_link").removeClass("wdps_sub_active");
  jQuery(".wdps_tab_title_wrap").removeClass("wdps_sub_active");
  jQuery(".wdps_box").removeClass("wdps_sub_active");
  jQuery(".wdps_dynamic_box").removeClass("wdps_sub_active");
  jQuery(that).parent().addClass("wdps_sub_active");
  jQuery("." + box).addClass("wdps_sub_active");
  jQuery(".tab_image").css('border-color','#B4AFAF');
  jQuery(that).css('border-color','#00A0D4');
  jQuery('.tab_image').find('input').blur();

}
function wdps_change_tab(that, box) {
  jQuery("#tab").val(jQuery(that).find("span[tab_type]").attr("tab_type"));
  jQuery(".tab_button_wrap a").removeClass("wdps_active");
  jQuery(that).children().addClass("wdps_active");
  jQuery(".wdps_settings").css('background-image', 'url("' + plugin_dir + 'settings_grey.png")');
  jQuery(".wdps_slides").css('background-image', 'url("' + plugin_dir + 'slider_grey.png")');
  jQuery(".tab_button_wrap").children().css('border-color','#ddd');
  if(jQuery(that).children().hasClass('wdps_active')) {
    jQuery(that).children().css('border-color','#00A0D4');
  }

  jQuery(".wdps_box").removeClass("wdps_active");
  jQuery(".wdps_dynamic_box").removeClass("wdps_active");
  jQuery("." + box).addClass("wdps_active");
  if (box == "wdps_settings_box") {
    jQuery(".wdps_reset_button").show();
    jQuery(".wdps_settings").css('background-image', 'url("' + plugin_dir + 'settings.png")');
  }
  else {
    jQuery(".wdps_reset_button").hide();
    jQuery(".wdps_slides").css('background-image', 'url("' + plugin_dir + 'slider.png")');
  }
	
	jQuery(".tab_button_wrap").css('border-color','#ddd');
	if(jQuery(".wdps_settings_box:visible").length>0){
		jQuery(".setting_tab_button_wrap a").css('border-color','#00A0D4');
    jQuery(".wdps_settings").css('background-image', 'url("' + plugin_dir + 'settings.png")');
     wdps_change_post_nav();
	}
	else if(jQuery(".wdps_slides_box:visible").length>0){
		jQuery(".slides_tab_button_wrap a").css('border-color','#00A0D4');
    jQuery(".wdps_slides").css('background-image', 'url("' + plugin_dir + 'slider.png")');
     wdps_change_post_nav();
	}
}
function wdps_change_nav(that, box) {
  jQuery("#nav_tab").val(jQuery(that).attr("tab_type"));
  jQuery(".wdps_nav_tabs li").removeClass("wdps_active");
  jQuery(that).addClass("wdps_active");
  jQuery(".wdps_nav_box").removeClass("wdps_active");
  jQuery("." + box).addClass("wdps_active");
}
function wdps_change_post_nav() {
  if(jQuery("input[name=dynamic]:checked").val() == 1) {
    box = 'dynamic_slides';
    jQuery(".dynamic_slide").hide();
    
  }
  else {
    box = 'static_slides';
  }
  jQuery(".wdps_slides_box div").removeClass("wdps_active");
  jQuery("." + box).addClass("wdps_active");
}
function wdps_showhide_layer(tbodyID, always_show) {
  jQuery(".wdps_layer_tr").not("#" + tbodyID + " .wdps_layer_tr").hide();
  jQuery("#" + tbodyID).css("background-color", "#FFFFFF");
  jQuery("#" + tbodyID).children().each(function() {
    if (!jQuery(this).hasClass("wdps_layer_head_tr")) {
      if (jQuery(this).is(':hidden') || always_show) {
        jQuery(this).show();
      }
      else {
        jQuery("#" + tbodyID).css("background-color", "#e1e1e1");
        jQuery("#" + tbodyID + " .wdps_layer_head_tr").css("background-color", "#e1e1e1");
        jQuery(this).hide();
      }
    }
  });
}

function wdps_delete_layer(id, layerID) {
  
  if (confirm(wdps_objectL10B.wdps_delete_layer)) {
    var prefix = "slide" + id + "_layer" + layerID;
	if (jQuery("#" + prefix).parent().attr("id") == prefix + "_div") {
       jQuery("#" + prefix).parent().remove();
       }
	else {
	   jQuery("#" + prefix).remove();
        }
    jQuery("#" + prefix + "_tbody").remove();

    var layerIDs = jQuery("#slide" + id + "_layer_ids_string").val();
    layerIDs = layerIDs.replace(layerID + ",", "");
    jQuery("#slide" + id + "_layer_ids_string").val(layerIDs);
    var dellayerIds = jQuery("#slide" + id + "_del_layer_ids_string").val() + layerID + ",";
    jQuery("#slide" + id + "_del_layer_ids_string").val(dellayerIds);
  }
}

function wdps_duplicate_layer(type, id, layerID, new_id) {
  var prefix = "slide" + id + "_layer" + layerID;
  var new_layerID = "pr_" + wdps_layerID;
  var new_prefix = "slide" + id + "_layer" + new_layerID;
  if (typeof new_id != 'undefined') {
    /* From slide duplication.*/
    new_prefix = "slide" + new_id + "_layer" + new_layerID;
    id = new_id;
    jQuery("#" + new_prefix + "_left").val(jQuery("#" + prefix + "_left").val());
    jQuery("#" + new_prefix + "_top").val(jQuery("#" + prefix + "_top").val());
    jQuery("#" + new_prefix + "_div_left").val(jQuery("#" + prefix + "_div_left").val());
    jQuery("#" + new_prefix + "_div_top").val(jQuery("#" + prefix + "_div_top").val());
  }
  else {
    /* From layer duplication.*/
    jQuery("#" + new_prefix + "_left").val(0);
    jQuery("#" + new_prefix + "_top").val(0);
    jQuery("#" + new_prefix + "_div_left").val(20);
    jQuery("#" + new_prefix + "_div_top").val(20);
  }
  jQuery("#" + new_prefix + "_text").val(jQuery("#" + prefix + "_text").val());
  jQuery("#" + new_prefix + "_link").val(jQuery("#" + prefix + "_link").val());
  jQuery("#" + new_prefix + "_start").val(jQuery("#" + prefix + "_start").val());
  jQuery("#" + new_prefix + "_end").val(jQuery("#" + prefix + "_end").val());
  jQuery("#" + new_prefix + "_delay").val(jQuery("#" + prefix + "_delay").val());
  jQuery("#" + new_prefix + "_duration_eff_in").val(jQuery("#" + prefix + "_duration_eff_in").val());
  jQuery("#" + new_prefix + "_duration_eff_out").val(jQuery("#" + prefix + "_duration_eff_out").val());
  jQuery("#" + new_prefix + "_color").val(jQuery("#" + prefix + "_color").val());
  jQuery("#" + new_prefix + "_size").val(jQuery("#" + prefix + "_size").val());
  jQuery("#" + new_prefix + "_padding").val(jQuery("#" + prefix + "_padding").val());
  jQuery("#" + new_prefix + "_fbgcolor").val(jQuery("#" + prefix + "_fbgcolor").val());
  jQuery("#" + new_prefix + "_transparent").val(jQuery("#" + prefix + "_transparent").val());
  jQuery("#" + new_prefix + "_border_width").val(jQuery("#" + prefix + "_border_width").val());
  jQuery("#" + new_prefix + "_border_color").val(jQuery("#" + prefix + "_border_color").val());
  jQuery("#" + new_prefix + "_border_radius").val(jQuery("#" + prefix + "_border_radius").val());
  jQuery("#" + new_prefix + "_shadow").val(jQuery("#" + prefix + "_shadow").val());
  jQuery("#" + new_prefix + "_image_url").val(jQuery("#" + prefix + "_image_url").val());
  jQuery("#" + new_prefix + "_image_width").val(jQuery("#" + prefix + "_image_width").val());
  jQuery("#" + new_prefix + "_image_height").val(jQuery("#" + prefix + "_image_height").val());
  jQuery("#" + new_prefix + "_alt").val(jQuery("#" + prefix + "_alt").val());
  jQuery("#" + new_prefix + "_imgtransparent").val(jQuery("#" + prefix + "_imgtransparent").val());
  jQuery("#" + new_prefix + "_hover_color").val(jQuery("#" + prefix + "_hover_color").val());
  jQuery("#" + new_prefix + "_type").val(jQuery("#" + prefix + "_type").val());
  jQuery("#" + new_prefix + "_layer_characters_count").val(jQuery("#" + prefix + "_layer_characters_count").val());
  jQuery("#" + new_prefix + "_infinite_in").val(jQuery("#" + prefix + "_infinite_in").val());
  jQuery("#" + new_prefix + "_infinite_out").val(jQuery("#" + prefix + "_infinite_out").val());
  jQuery("#" + new_prefix + "_hover_color_text").val(jQuery("#" + prefix + "_hover_color_text").val());
  jQuery("#" + new_prefix + "_min_size").val(jQuery("#" + prefix + "_min_size").val());

  if (jQuery("#" + prefix + "_published1").is(":checked")) {
    jQuery("#" + new_prefix + "_published1").attr("checked", "checked");
  }
  else if (jQuery("#" + prefix + "_published0").is(":checked")) {
    jQuery("#" + new_prefix + "_published0").attr("checked", "checked");
  }
  if (type == "video") {
    if (jQuery("#" + prefix + "_image_scale1").is(":checked")) {
      jQuery("#" + new_prefix + "_image_scale1").attr("checked", "checked");
    }
    else if (jQuery("#" + prefix + "_image_scale0").is(":checked")) {
      jQuery("#" + new_prefix + "_image_scale0").attr("checked", "checked");
    }
  }
  else {
    if (jQuery("#" + prefix + "_image_scale").is(":checked")) {
      jQuery("#" + new_prefix + "_image_scale").attr("checked", "checked");
    }
  }
  if (jQuery("#" + prefix + "_target_attr_layer").is(":checked")) {
      jQuery("#" + new_prefix + "_target_attr_layer").attr("checked", "checked");
  } else {
	  jQuery("#" + new_prefix + "_target_attr_layer").removeAttr("checked");
  }
  if (jQuery("#" + prefix + "_align_layer").is(":checked")) {
      jQuery("#" + new_prefix + "_align_layer").attr("checked", "checked");
  } else {
	  jQuery("#" + new_prefix + "_align_layer").removeAttr("checked");
  }
  jQuery("#" + new_prefix + "_transition option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_transition").val()) {
      jQuery(this).attr("selected", "selected");
    }
  });
  jQuery("#" + new_prefix + "_ffamily option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_ffamily").val()) {
      jQuery(this).attr("selected", "selected");
    }
  });
  jQuery("#" + new_prefix + "_fweight option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_fweight").val()) {
  
      jQuery(this).attr("selected", "selected");
    }
  });
  jQuery("#" + new_prefix + "_border_style option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_border_style").val()) {
      jQuery(this).attr("selected", "selected");
    }
  });
  jQuery("#" + new_prefix + "_social_button option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_social_button").val()) {
      jQuery(this).attr("selected", "selected");
    }
  });
  jQuery("#" + new_prefix + "_layer_effect_in option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_layer_effect_in").val()) {
      jQuery(this).attr("selected", "selected");
    }
  });
  jQuery("#" + new_prefix + "_layer_effect_out option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_layer_effect_out").val()) {
      jQuery(this).attr("selected", "selected");
    }
  });
  if (jQuery("#" + prefix + "_google_fonts1").is(":checked")) {
    jQuery("#" + new_prefix + "_google_fonts1").attr("checked", "checked");
  }
  else if (jQuery("#" + prefix + "_google_fonts0").is(":checked")) {
    jQuery("#" + new_prefix + "_google_fonts0").attr("checked", "checked");
  }
  jQuery("#" + new_prefix + "_text_alignment option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_text_alignment").val()) {
      jQuery(this).attr("selected", "selected");
    }
  });
  if (jQuery("#" + prefix + "_remove_shortcode1").is(":checked")) {
    jQuery("#" + new_prefix + "_remove_shortcode1").attr("checked", "checked");
  }
  else if (jQuery("#" + prefix + "_remove_shortcode0").is(":checked")) {
    jQuery("#" + new_prefix + "_remove_shortcode0").attr("checked", "checked");
  }
  if (type == "text") {
    wdps_new_line(new_prefix);
    jQuery("#" + new_prefix).attr({
      id: new_prefix,
      onclick: "wdps_showhide_layer('" + new_prefix + "_tbody', 1)",
      style: "z-index: " + jQuery("#" + new_prefix + "_depth").val() + ";" +
             "left: " + jQuery("#" + new_prefix + "_left").val() + "px;" +
             "top: " + jQuery("#" + new_prefix + "_top").val() + "px;" +
             "display: inline-block;" +
             "color: #" + jQuery("#" + prefix + "_color").val() + "; " +
             "font-size: " + jQuery("#" + prefix + "_size").val() + "px; " +
             "line-height: 1.25em; " +
             "font-family: " + jQuery("#" + prefix + "_ffamily").val() + "; " +
             "font-weight: " + jQuery("#" + prefix + "_fweight").val() + "; " +
             "padding: " + jQuery("#" + prefix + "_padding").val() + "; " +
             "background-color: " + wdps_hex_rgba(jQuery("#" + prefix+ "_fbgcolor").val(), (100 - jQuery("#" + prefix+ "_transparent").val())) + "; " +
             "border: " + jQuery("#" + prefix + "_border_width").val() + "px " + jQuery("#" + prefix+ "_border_style").val() + " #" + jQuery("#" + prefix+ "_border_color").val() + "; " +
             "border-radius: " + jQuery("#" + prefix + "_border_radius").val() + ";" +
             "text-align: " + jQuery("#" + prefix + "_text_alignment").val() + ";" + 
             "position: absolute;"
    });
    jQuery("#" + new_prefix).hover(function() {jQuery(this).css("color", jQuery("#" + prefix + "_hover_color_text").val()); }, function() { jQuery(this).css("color", jQuery("#" + prefix + "_color").val()); });
    wdps_text_width("#" + new_prefix + "_image_width", new_prefix);
    wdps_text_height("#" + new_prefix + "_image_height", new_prefix);
    wdps_break_word("#" + new_prefix + "_image_scale", new_prefix);
  }
  else if (type == "image") {
    jQuery("#wdps_preview_image" + id).append(jQuery("<img />").attr({
      id: new_prefix,
      src: jQuery("#" + prefix).attr("src"),
      "class": "wdps_draggable_" + id + " wdps_draggable",
      onclick: "wdps_showhide_layer('" + new_prefix + "_tbody', 1)",
      style: "z-index: " + jQuery("#" + new_prefix + "_depth").val() + "; " +
             "left: " + jQuery("#" + new_prefix + "_left").val() + "px;" +
             "top: " + jQuery("#" + new_prefix + "_top").val() + "px;" +
             "opacity: " + (100 - jQuery("#" + prefix + "_imgtransparent").val()) / 100 + "; filter: Alpha(opacity=" + (100 - jQuery("#" + prefix+ "_imgtransparent").val()) + "); " +
             "border: " + jQuery("#" + prefix + "_border_width").val() + "px " + jQuery("#" + prefix+ "_border_style").val() + " #" + jQuery("#" + prefix+ "_border_color").val() + "; " +
             "border-radius: " + jQuery("#" + prefix + "_border_radius").val() + "; " +
             "box-shadow: " + jQuery("#" + prefix + "_shadow").val() + "; " +
             "position: absolute;"
    }));
    wdps_scale("#" + new_prefix + "_image_scale", new_prefix);
  }
  jscolor.bind();
  wdps_drag_layer(id);
}

function wdps_duplicate_slide(slide_id,post_id) {
  var new_slide_id = wdps_add_slide('');
  var type;
  var prefix;
  var layer_id;
  var tab_image = jQuery('#wdps_tab_image' + slide_id).css('background-image');
  jQuery("input[name=published" + new_slide_id + "]:checked").val(jQuery("input[name=published" + slide_id + "]:checked").val());
  jQuery("#link" + new_slide_id).val(jQuery("#link" + slide_id).val());
  jQuery("input[name=target_attr_slide" + new_slide_id +" ]:checked").val(jQuery("input[name=target_attr_slide" + slide_id +" ]:checked").val());
  jQuery("#type" + new_slide_id).val(jQuery("#type" + slide_id).val());
  jQuery("#image_url" + new_slide_id).val(jQuery("#image_url" + slide_id).val());
  jQuery("#thumb_url" + new_slide_id).val(jQuery("#thumb_url" + slide_id).val());
  
  if (jQuery("#type" + new_slide_id).val() == 'image') {
    jQuery("#wdps_preview_image" + new_slide_id).css("background-image", 'url("' + jQuery("#image_url" + slide_id).val() + '")');
    jQuery("#wdps_tab_image" + new_slide_id).css("background-image", tab_image );
    jQuery("#trlink" + new_slide_id).show();
    jQuery("#controls" + new_slide_id).hide();
    jQuery("#autoplay" + new_slide_id).hide();
    window.parent.jQuery("#wdps_post_id" + new_slide_id).val(post_id);
    jQuery(".edit_thumb").text("Edit Thumbnail");
  }
  else {
    jQuery("#wdps_preview_image" + new_slide_id).css("background-image", 'url("' + jQuery("#thumb_url" + slide_id).val() + '")');
    jQuery("#wdps_tab_image" + new_slide_id).css("background-image", tab_image );
    jQuery("#trlink" + new_slide_id).hide();
    window.parent.jQuery("#wdps_post_id" + new_slide_id).val(post_id);
    jQuery("#controls" + new_slide_id).show();
    jQuery("#autoplay" + new_slide_id).show();
    jQuery(".edit_thumb").text("Edit Thumbnail");
  }
  var layer_ids_string = jQuery("#slide" + slide_id + "_layer_ids_string").val();
  if (layer_ids_string) {
    var layer_ids_array = layer_ids_string.split(",");
    for (var i in layer_ids_array) {
      if (layer_ids_array.hasOwnProperty(i) && layer_ids_array[i] && layer_ids_array[i] != ",") {
      layer_id = layer_ids_array[i];
      prefix = "slide" + slide_id + "_layer" + layer_id;
      type = jQuery("#" + prefix + "_type").val();		
      wdps_add_layer(type, new_slide_id, '', 1);
      wdps_duplicate_layer(type, slide_id, layer_id, new_slide_id);
      }
    }
  }
}

var wdps_layerID = 0;
function wdps_add_layer(type, id, layerID, duplicate, files, edit, by_text_layer, fildes_name) {
  var wdps_post_fildes_name = jQuery("#fildes_name_").val();
  if (wdps_post_fildes_name == '') {
    wdps_post_fildes_name = fildes_name;
  }
  if (by_text_layer == 'post'){
    wdps_post_fildes_name_ = wdps_post_fildes_name.split(',');
  }
  var layers_count = jQuery(".wdps_slide" + id + " .layer_table_count").length;
  wdps_layerID = layers_count + 1;
  if (typeof layerID == "undefined" || layerID == "") {
    var layerID = "pr_" + wdps_layerID;
    jQuery("#slide" + id + "_layer_ids_string").val(jQuery("#slide" + id + "_layer_ids_string").val() + layerID + ',');
  }
  if (typeof duplicate == "undefined") {
    var duplicate = 0;
  }
  if (typeof edit == "undefined") {
    var edit = 0;
  }

  var layer_effects_in_option = "";
  var layer_effects_out_option = "";
  var free_layer_effects = ['none', 'bounce', 'tada', 'bounceInDown', 'bounceOutUp', 'fadeInLeft', 'fadeOutRight'];
  var layer_effects_in = {
    'none' : wdps_objectL10B.none,
    'bounce' : wdps_objectL10B.bounce,
    'tada' : wdps_objectL10B.Tada,
    'bounceInDown' : wdps_objectL10B.bounceInDown,
    'fadeInLeft' : wdps_objectL10B.fadeInLeft,
    'flash' : wdps_objectL10B.flash,
    'pulse' : wdps_objectL10B.pulse,
    'rubberBand' : wdps_objectL10B.rubberBand,
    'shake' : wdps_objectL10B.shake,
    'swing' : wdps_objectL10B.swing,
    'tada' : wdps_objectL10B.tada,
    'wobble' : wdps_objectL10B.wobble,
    'hinge' : wdps_objectL10B.hinge,
    'lightSpeedIn' : wdps_objectL10B.lightSpeedIn,
    'rollIn' : wdps_objectL10B.rollIn,
	
    'bounceIn' : wdps_objectL10B.bounceIn,
    'bounceInLeft' : wdps_objectL10B.bounceInLeft,
    'bounceInRight' : wdps_objectL10B.bounceInRight,
    'bounceInUp' : wdps_objectL10B.bounceInUp,

    'fadeIn' : wdps_objectL10B.fadeIn,
    'fadeInDown' : wdps_objectL10B.fadeInDown,
    'fadeInDownBig' : wdps_objectL10B.fadeInDownBig,
    'fadeInLeftBig' : wdps_objectL10B.fadeInLeftBig,
    'fadeInRight' : wdps_objectL10B.fadeInRight,
    'fadeInRightBig' : wdps_objectL10B.fadeInRightBig,
    'fadeInUp' : wdps_objectL10B.fadeInUp,
    'fadeInUpBig' : wdps_objectL10B.fadeInUpBig,

    'flip' : wdps_objectL10B.flip,
    'flipInX' : wdps_objectL10B.flipInX,
    'flipInY' : wdps_objectL10B.flipInY,

    'rotateIn' : wdps_objectL10B.rotateIn,
    'rotateInDownLeft' : wdps_objectL10B.rotateInDownLeft,
    'rotateInDownRight' : wdps_objectL10B.rotateInDownRight,
    'rotateInUpLeft' : wdps_objectL10B.rotateInUpLeft,
    'rotateInUpRight' : wdps_objectL10B.rotateInUpRight,
	
    'zoomIn' : wdps_objectL10B.zoomIn,
    'zoomInDown' : wdps_objectL10B.zoomInDown,
    'zoomInLeft' : wdps_objectL10B.zoomInLeft,
    'zoomInRight' : wdps_objectL10B.zoomInRight,
    'zoomInUp' : wdps_objectL10B.zoomInUp 
  };

  var layer_effects_out = {
    'none' : wdps_objectL10B.none,
    'bounce' : wdps_objectL10B.bounce,
    'tada' : wdps_objectL10B.tada,
    'bounceOutUp' : wdps_objectL10B.bounceOutUp,
    'fadeOutRight' : wdps_objectL10B.fadeOutRight,
    'flash' : wdps_objectL10B.flash,
    'pulse' : wdps_objectL10B.pulse,
    'rubberBand' : wdps_objectL10B.rubberBand,
    'shake' : wdps_objectL10B.shake,
    'swing' : wdps_objectL10B.swing,
    'tada' : wdps_objectL10B.tada,
    'wobble' : wdps_objectL10B.wobble,
    'hinge' : wdps_objectL10B.hinge,
    'lightSpeedOut' : wdps_objectL10B.lightSpeedOut,
    'rollOut' : wdps_objectL10B.rollOut,
	
    'bounceOut' : wdps_objectL10B.bounceOut,
    'bounceOutLeft' : wdps_objectL10B.bounceOutLeft,
    'bounceOutRight' : wdps_objectL10B.bounceOutRight,
    'bounceOutDown' : wdps_objectL10B.bounceOutDown,

    'fadeOut' : wdps_objectL10B.fadeOut,
    'fadeOutDown' : wdps_objectL10B.fadeOutDown,
    'fadeOutDownBig' : wdps_objectL10B.fadeOutDownBig,
    'fadeOutLeftBig' : wdps_objectL10B.fadeOutLeftBig,
    'fadeOutLeft' : wdps_objectL10B.fadeOutLeft,
    'fadeOutRightBig' : wdps_objectL10B.fadeOutRightBig,
    'fadeOutUp' : wdps_objectL10B.fadeOutUp,
    'fadeOutUpBig' : wdps_objectL10B.fadeOutUpBig,

    'flip' : wdps_objectL10B.flip,
    'flipOutX' : wdps_objectL10B.flipOutX,
    'flipOutY' : wdps_objectL10B.flipOutY,

    'rotateOut' : wdps_objectL10B.rotateOut,
    'rotateOutDownLeft' : wdps_objectL10B.rotateOutDownLeft,
    'rotateOutDownRight' : wdps_objectL10B.rotateOutDownRight,
    'rotateOutUpLeft' : wdps_objectL10B.rotateOutUpLeft,
    'rotateOutUpRight' : wdps_objectL10B.rotateOutUpRight,
	
    'zoomOut' : wdps_objectL10B.zoomOut,
    'zoomOutDown' : wdps_objectL10B.zoomOutDown,
    'zoomOutLeft' : wdps_objectL10B.zoomOutLeft,
    'zoomOutRight' : wdps_objectL10B.zoomOutRight,
    'zoomOutUp' : wdps_objectL10B.zoomOutUp
  };

  for (var i in layer_effects_in) {
    layer_effects_in_option += '<option ' + ((jQuery.inArray(i, free_layer_effects) == -1) ? 'disabled="disabled" title="This effect is disabled in free version."' : '') + ' value="' + i + '">' + layer_effects_in[i] + '</option>';
  }
  for (var i in layer_effects_out) {
     layer_effects_out_option += '<option ' + ((jQuery.inArray(i, free_layer_effects) == -1) ? 'disabled="disabled" title="This effect is disabled in free version."' : '') + ' value="' + i + '">' + layer_effects_out[i] + '</option>';
  }
  
  var font_families_option = "";
  var families = {'arial' : 'Arial', 'lucida grande' : 'Lucida grande', 'segoe ui' : 'Segoe ui', 'tahoma' : 'Tahoma', 'trebuchet ms' : 'Trebuchet ms', 'verdana' : 'Verdana', 'cursive' : 'Cursive', 'fantasy' : 'Fantasy', 'monospace' : 'Monospace', 'serif' : 'Serif'};
  for (var i in families) {
    font_families_option += '<option value="' + i + '">' + families[i] + '</option>';
  }
  var font_weights_option = "";
  var font_weights = {'lighter' : wdps_objectL10B.lighter, 'normal' : wdps_objectL10B.normal, 'bold' : wdps_objectL10B.bold};
  for (var i in font_weights) {
    font_weights_option += '<option value="' + i + '">' + font_weights[i] + '</option>';
  }
  var border_styles_option = "";
  var border_styles = {'none' : wdps_objectL10B.none, 'solid' : wdps_objectL10B.solid, 'dotted' : wdps_objectL10B.dotted, 'dashed' : wdps_objectL10B.dashed, 'double' : wdps_objectL10B.wdps_double, 'groove' : wdps_objectL10B.groove, 'ridge' : wdps_objectL10B.ridge, 'inset' : wdps_objectL10B.inset, 'outset' : wdps_objectL10B.outset};
  for (var i in border_styles) {
    border_styles_option += '<option value="' + i + '">' + border_styles[i] + '</option>';
  }
  var social_button_option = "";
  var social_button = {"facebook" : wdps_objectL10B.facebook, "google-plus" : wdps_objectL10B.google_plus, "twitter" : wdps_objectL10B.twitter, "pinterest" : wdps_objectL10B.pinterest, "tumblr" : wdps_objectL10B.tumblr};
  for (var i in social_button) {
    social_button_option += '<option value="' + i + '">' + social_button[i] + '</option>';
  }

 
  var prefix = "slide" + id + "_layer" + layerID;
  var tbodyID = prefix + "_tbody";
  var slid_id =  id;
  var text_alignments_option = "";
  var text_alignments = {'left' : wdps_objectL10B.wdps_left, 'center' : wdps_objectL10B.wdps_center, 'right' : wdps_objectL10B.wdps_right};
  for (var i in text_alignments) {
    text_alignments_option += '<option value="' + i + '">' + text_alignments[i] + '</option>';
  }
    jQuery(".wdps_slide" + id + ">table").append(jQuery("<tbody />").attr("id", tbodyID));
    jQuery('#' + tbodyID).attr('style',"background-color:#fff");
    jQuery('#' + tbodyID).addClass("layer_table_count");
  var tbody = '<tr class="wdps_layer_head_tr">' +
                '<td class="wdps_layer_head" colspan="4">' +
                  '<div class="wdps_layer_left"><div class="layer_handle handle connectedSortable" title"' + wdps_objectL10B.wdps_drag_re_order + '"></div>' +
                  '<span class="wdps_layer_label" onclick="wdps_showhide_layer(\'' + tbodyID + '\', 0)"><input id="' + prefix + '_title" name="' + prefix + '_title" type="text" class="wdps_layer_title" style="width: 80px;padding:5px; color:#00A2D0;" value="Layer ' + wdps_layerID + '" title="' + wdps_objectL10B.wdps_layer_title + '" ' + fv_disabled +'/></span></div>' +
                  '<div class="wdps_layer_right"><span class="wdps_layer_remove" title="' + wdps_objectL10B.wdps_delete_layer + '" onclick="' + (!fv ? 'wdps_delete_layer(\'' + id + '\', \'' + layerID + '\');' : "alert(\'" + wdps_objectL10B.disabled_free_version + "\')") + ';"></span>' +
                  '<span class="wdps_layer_dublicate" title="' + wdps_objectL10B.wdps_duplicate_layer + '" onclick="' + (!fv ? 'wdps_add_layer(\'' + type + '\', \'' + id + '\', \'\', 1,1,0,\'' + 'post' + '\',\'' + fildes_name + '\'); wdps_duplicate_layer(\'' + type + '\', \'' + id + '\', \'' + layerID + '\');' : "alert(\'" + wdps_objectL10B.disabled_free_version + "\')") + ';"></span>' +
                  '<input type="text" name="' + prefix + '_depth" id="' + prefix + '_depth" prefix="' + prefix + '" value="' + wdps_layerID + '" class="wdps_layer_depth spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({zIndex: jQuery(this).val()})" title="z-index" ' + fv_disabled + '/></div><div class="wdps_clear"></div></td>' +
              '</tr>';
            
  var text = '<td class="spider_label ' + fv_class + '"><label for="' + prefix + '_text">' + wdps_objectL10B.text + ' </label></td>' +
             '<td > <textarea  id="' + prefix + '_text" name="' + prefix + '_text" style="width: 500px; height: 120px; resize: vertical;" onkeyup="wdps_new_line(\'' + prefix + '\')" ' + fv_disabled + '>' + wdps_objectL10B.sample_text + '</textarea>'+
             '<div id="' + prefix + '_post_feild"></div>';
             '</td>';
                 if (by_text_layer == 'post') {
                   for (var i = 0; i < wdps_post_fildes_name_.length; ++i) {
                     text += '<input type="button" style="line-height:4px;display:table;float:left; margin:3px;" class="button-primary" value="' + wdps_post_fildes_name_[i]+ '" \'' + fv_disabled + '\' onclick="wdps_add_post_feilds(\''+prefix + '\',\'' + wdps_post_fildes_name_[i] + '\')" ' + fv_disabled + '/>';
                   }
                }
  var text_dimensions = '<td title="' + wdps_objectL10B.wdps_leave_blank + '" class="wdps_tooltip spider_label ' + fv_class +'">           <label for="' + prefix + '_image_width">'+ wdps_objectL10B.dimensions + ' </label></td>' +
                        '<td>' +
                          '<input id="' + prefix + '_image_width" class="spider_int_input" type="text" onchange="wdps_text_width(this, \'' + prefix + '\')" value="" name="' + prefix + '_image_width" ' + fv_disabled + '/> x ' +
                          '<input id="' + prefix + '_image_height" class="spider_int_input" type="text" onchange="wdps_text_height(this,\'' + prefix + '\')" value="" name="' + prefix + '_image_height" ' + fv_disabled + '/> % ' +
                          '<input id="' + prefix + '_image_scale" type="checkbox" onchange="wdps_break_word(this, \'' + prefix + '\')" name="' + prefix + '_image_scale" checked="checked" ' + fv_disabled + '/><label class="' + fv_class + '" for="' + prefix + '_image_scale">' + wdps_objectL10B.break_word + '</label>' +
                          '</td>';
  var alt = '<td class="spider_label ' + fv_class + '"><label for="' + prefix + '_alt">' + wdps_objectL10B.wdps_alt + ' </label></td>' +
             '<td><input type="text" id="' + prefix + '_alt" name="' + prefix + '_alt" value="" ' + fv_disabled + '/>' +
                 '<div class="spider_description">' + wdps_objectL10B.wdps_set_HTML_attribute_specified + '</div></td>';
 if (jQuery("input[name=dynamic]:checked").val() == 0 || type != 'text' ) {
   var link = '<td title="' + wdps_objectL10B.wdps_use_links + '" class="wdps_tooltip spider_label ' + fv_class + '"><label for="' + prefix           + '_link">' + wdps_objectL10B.wdps_link + '</label></td>' +
              '<td><input type="text" id="' + prefix + '_link" name="' + prefix + '_link" value="" ' + fv_disabled + '/>' +
              '<input id="' + prefix + '_target_attr_layer" type="checkbox"  name="' + prefix + '_target_attr_layer" value="1" checked="checked" ' + fv_disabled + '/><label class="' + fv_class + '" for="' + prefix + '_target_attr_layer">' + wdps_objectL10B.wdps_open_new_window +'</label>' +
              '</td>';
 }
 else {
   link ='';
 }
  var position = '<td title="' + wdps_objectL10B.wdps_in_addition + '" class="wdps_tooltip spider_label ' + fv_class + '"><label>' +                wdps_objectL10B.position + ' </label></td>' +
                 '<td> X <input type="text" name="' + prefix + '_left" id="' + prefix + '_left" value="0" class="spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({left: jQuery(this).val() + \'px\'})" ' + fv_disabled + '/>' +
                 ' Y <input type="text" name="' + prefix + '_top" id="' + prefix + '_top" value="0" class="spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({top: jQuery(this).val() + \'px\'})" ' + fv_disabled + '/>';
  if (type == 'text') {
    position += '<input id="' + prefix + '_align_layer" type="checkbox" name="' + prefix + '_align_layer" value="1" onchange="wdps_position_left_disabled(\'' + prefix + '\');" ' + fv_disabled + '/><label for="' + prefix + '_align_layer">' + wdps_objectL10B.wdps_alignment +'</label>';
  } 
   position += '</td>';
  var text_alignment = '<td class="spider_label ' + fv_class + '"><label for="' + prefix + '_text_alignment">' + wdps_objectL10B.text_align + ' </label></td>' +
                        '<td><select class="select_icon" style="width: 70px;" name="' + prefix + '_text_alignment" id="' + prefix + '_text_alignment"    onchange="jQuery(\'#' + prefix + '\').css({textAlign: jQuery(this).val()})" ' + fv_disabled + '>' + text_alignments_option + '</select><div class="spider_description"></div></td>';  
  var published = '<td class="spider_label ' + fv_class + '"><label>' + wdps_objectL10B.published + '  </label></td>' +
                  '<td><input type="radio" id="' + prefix + '_published1" name="' + prefix + '_published" checked="checked" value="1" '+ fv_disabled + '/><label class="' + fv_class + '" for="' + prefix + '_published1">' + wdps_objectL10B.yes + '</label>' +
                  '<input type="radio" id="' + prefix + '_published0" name="' + prefix + '_published" value="0" ' + fv_disabled + '/><label class="' + fv_class + '"for="' + prefix + '_published0">' + wdps_objectL10B.no + '</label><div class="spider_description"></div></td>';
  var color = '<td class="spider_label ' + fv_class + '"><label for="' + prefix + '_color">' + wdps_objectL10B.color + ' </label></td>' +
               '<td><input type="text" name="' + prefix + '_color" id="' + prefix + '_color" value="" class="color" onchange="jQuery(\'#' + prefix + '\').css({color: \'#\' + jQuery(this).val()})" ' + fv_disabled + '/><div class="spider_description"></div></td>';
  var hover_color_text = '<td class="spider_label"><label for="' + prefix + '_hover_color_text">' + wdps_objectL10B.hover_color +                       '</label></td>' +
                          '<td><input type="text" name="' + prefix + '_hover_color_text" id="' + prefix + '_hover_color_text" value="" class="color" onchange="jQuery(\'#' + prefix + '\').hover(function() { jQuery(this).css({color: \'#\' + jQuery(\'#' + prefix + '_hover_color_text\').val()}); }, function() { jQuery(this).css({color: \'#\' + jQuery(\'#' + prefix + '_color\').val()}); })" ' + fv_disabled + ' /><div class="spider_description"></div></td>';
  var size = '<td class="spider_label ' + fv_class + '"><label for="' + prefix + '_size">' + wdps_objectL10B.size + ' </label></td>' +
              '<td>' +
                '<span style="display:table-cell;">' +
                  '<input type="text" name="' + prefix + '_size" id="' + prefix + '_size" value="18" class="spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({fontSize: jQuery(this).val() + \'px\', lineHeight: jQuery(this).val() + \'px\'})" ' + fv_disabled + '/> px' +
                '</span>' +
                '<span style="display:table-cell;">' +
                  '<input type="text" name="' + prefix + '_min_size" id="' + prefix + '_min_size" value="11" class="spider_int_input" onchange="wdps_min_size_validation(\'' + prefix + '\')" onkeypress="return spider_check_isnum(event)" ' + fv_disabled + '/> px' +
                  '<div class="spider_description">' + wdps_objectL10B.wdps_min_size + '</div>' +
                '</span>' +
              '</td>';            
  var ffamily = '<td class="spider_label ' + fv_class + '"><label for="' + prefix + '_ffamily">'+ wdps_objectL10B.font_family +'</label></td>' +
                '<td><select class="select_icon"  style="width: 200px;" name="' + prefix + '_ffamily" id="' + prefix + '_ffamily" onchange="wdps_change_fonts(\'' + prefix + '\', 1)" ' + fv_disabled + '></select>' +
                    '<input type="radio" id="' + prefix + '_google_fonts1" name="' + prefix + '_google_fonts" value="1" onchange="wdps_change_fonts(\'' + prefix + '\');" ' + fv_disabled + '/><label class="' + fv_class + '"for="' + prefix + '_google_fonts1">'+ wdps_objectL10B.google_fonts +'</label>' +
                    '<input type="radio" id="' + prefix + '_google_fonts0" name="' + prefix + '_google_fonts" checked="checked" value="0" onchange="wdps_change_fonts(\'' + prefix + '\');" ' + fv_disabled + '/><label class="' + fv_class + '"for="' + prefix + '_google_fonts0">'+wdps_objectL10B.wdps_default+'</label>' +
                    '<div class="spider_description"></div></td>';
  var fweight = '<td class="spider_label ' + fv_class + '"><label for="' + prefix + '_fweight">' + wdps_objectL10B.font_weight + '           </label></td>' +
                '<td><select class="select_icon" name="' + prefix + '_fweight" id="' + prefix + '_fweight" onchange="jQuery(\'#' + prefix + '\').css({fontWeight: jQuery(this).val()})" ' + fv_disabled +'>' + font_weights_option + '</select><div class="spider_description"></div></td>';
  var padding = '<td title="' + wdps_objectL10B.use_css_type_value + '" class="wdps_tooltip spider_label ' + fv_class + '"><label for="' +               prefix + '_padding">' + wdps_objectL10B.padding + ' </label></td>' +
                '<td><input type="text" name="' + prefix + '_padding" id="' + prefix + '_padding" value="5px" class="spider_char_input" onchange="document.getElementById(\'' + prefix + '\').style.padding=jQuery(this).val()" ' + fv_disabled + '/></td>';
  var fbgcolor = '<td class="spider_label ' + fv_class + '"><label for="' + prefix + '_fbgcolor">' + wdps_objectL10B.background_color + '</label></td>' +
                 '<td><input type="text" name="' + prefix + '_fbgcolor" id="' + prefix + '_fbgcolor" value="000000" class="color" onchange="jQuery(\'#' + prefix + '\').css({backgroundColor: wdps_hex_rgba(jQuery(this).val(), 100 - jQuery(\'#' + prefix + '_transparent\').val())})" ' + fv_disabled + '/><div class="spider_description"></div></td>';
  var fbgtransparent = '<td title="' + wdps_objectL10B.wdps_value_must +'" class="wdps_tooltip spider_label ' + fv_class + '"><label for="' + prefix + '_transparent">' + wdps_objectL10B.transparent +  '  </label></td>' +
                       '<td><input type="text" name="' + prefix + '_transparent" id="' + prefix + '_transparent" value="50" class="spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({backgroundColor: wdps_hex_rgba(jQuery(\'#' + prefix + '_fbgcolor\').val(), 100 - jQuery(this).val())})" ' + fv_disabled + '/> %</td>';
  var imgtransparent = '<td title="' + wdps_objectL10B.wdps_value_must +'" class="wdps_tooltip spider_label ' + fv_disabled + '"><label for="' + prefix + '_imgtransparent">' + wdps_objectL10B.transparent + '  </label></td>' +
                       '<td><input type="text" name="' + prefix + '_imgtransparent" id="' + prefix + '_imgtransparent" value="0" class="spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({opacity: (100 - jQuery(this).val()) / 100, filter: \'Alpha(opacity=\' + 100 - jQuery(this).val() + \')\'})" ' + fv_disabled + '/> %</td>';
  var border_width = '<td class="spider_label ' + fv_class + '"><label for="' + prefix + '_border_width">'+ wdps_objectL10B.border + '</label></td>' +
                     '<td><input type="text" name="' + prefix + '_border_width" id="' + prefix + '_border_width" value="2" class="spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({borderWidth: jQuery(this).val() + \'px\'})" ' + fv_disabled + '/> px ' +
                        '<select class="select_icon" name="' + prefix + '_border_style" id="' + prefix + '_border_style" style="width: 80px;" onchange="jQuery(\'#' + prefix + '\').css({borderStyle: jQuery(this).val()})" ' + fv_disabled + '>' + border_styles_option + '</select> ' +
                        '<input type="text" name="' + prefix + '_border_color" id="' + prefix + '_border_color" value="" class="color" onchange="jQuery(\'#' + prefix + '\').css({borderColor: \'#\' + jQuery(this).val()})" /><div class="spider_description"></div></td>';
  var border_radius = '<td title="' + wdps_objectL10B.use_css_type_value + '" class="wdps_tooltip spider_label ' + fv_class + '">         <label for="' + prefix + '_border_radius">' + wdps_objectL10B.radius + '  </label></td>' +
                      '<td><input type="text" name="' + prefix + '_border_radius" id="' + prefix + '_border_radius" value="2px" class="spider_char_input" onchange="jQuery(\'#' + prefix + '\').css({borderRadius: jQuery(this).val()})" ' + fv_disabled + '/></td>';
  var shadow = '<td title="' + wdps_objectL10B.use_css_type_value + ' (e.g. 10px 10px 5px #888888)." class="wdps_tooltip spider_label ' + fv_class + '"><label for="' + prefix + '_shadow">'+ wdps_objectL10B.shadow + '  </label></td>' +
               '<td><input type="text" name="' + prefix + '_shadow" id="' + prefix + '_shadow" value="" class="spider_char_input" onchange="jQuery(\'#' + prefix + '\').css({boxShadow: jQuery(this).val()})" ' + fv_disabled + '/></td>';
  var layer_characters_count = '<td title="' + wdps_objectL10B.layer_characters_div + '" class="wdps_tooltip spider_label ' + fv_class + '"><label     for="' + prefix + '_layer_characters_count">'+ wdps_objectL10B.text_layer_character_limit + '  </label></td>' + '<td><input type="text" name="' + prefix + '_layer_characters_count" id="' + prefix +              '_layer_characters_count" value="250" class="spider_int_input" ' + fv_disabled + '/></td>';             
  var dimensions = '<td class="spider_label ' + fv_class + '"><label>' + wdps_objectL10B.dimensions + ' </label></td>' +
                   '<td>' +
                     '<input type="hidden" name="' + prefix + '_image_url" id="' + prefix + '_image_url" />' +
                     '<input type="text" name="' + prefix + '_image_width" id="' + prefix + '_image_width" value="" class="spider_int_input" onkeyup="wdps_scale(\'#' + prefix + '_image_scale\', \'' + prefix + '\')" ' + fv_disabled +'/> x ' +
                     '<input type="text" name="' + prefix + '_image_height" id="' + prefix + '_image_height" value="" class="spider_int_input" onkeyup="wdps_scale(\'#' + prefix + '_image_scale\', \'' + prefix + '\')" ' + fv_disabled + '/> px ' +
                     '<input type="checkbox" name="' + prefix + '_image_scale" id="' + prefix + '_image_scale" onchange="wdps_scale(this, \'' + prefix + '\')" /><label for="' + prefix + '_image_scale">Scale</label>' +
                     '<input class="button-secondary wdps_free_button" type="button" value="Edit Image" onclick="alert(\'' + wdps_objectL10B.disabled_free_version + '\')" ' + fv_disabled + '/>' +
                     '<div class="spider_description">Set width and height of the image.</div></td>';
  var social_button = '<td class="spider_label ' + fv_class + '"><label for="' + prefix + '_social_button">'+ wdps_objectL10B.social_button + ' </label></td>' +
                      '<td><select class="select_icon" name="' + prefix + '_social_button" id="' + prefix + '_social_button" onchange="jQuery(\'#' + prefix + '\').attr(\'class\', \'wdps_draggable fa fa-\' + jQuery(this).val())" ' + fv_disabled + '>' + social_button_option + '</select><div class="spider_description"></div></td>';
  var transparent = '<td title="' + wdps_objectL10B.wdps_value_must +'" class="wdps_tooltip spider_label ' + fv_class + '"><label for="' +                  prefix + '_transparent">'+ wdps_objectL10B.transparent + ' </label></td>' +
                    '<td><input type="text" name="' + prefix + '_transparent" id="' + prefix + '_transparent" value="0" class="spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({opacity: (100 - jQuery(this).val()) / 100, filter: \'Alpha(opacity=\' + 100 - jQuery(this).val() + \')\'})" '+ fv_disabled + '/> %</td>';
  var hover_color = '<td class="spider_label ' + fv_class + '"><label for="' + prefix + '_hover_color">' + wdps_objectL10B.hover_color + ' </label></td>' +
                    '<td><input type="text" name="' + prefix + '_hover_color" id="' + prefix + '_hover_color" value="" class="color" onchange="jQuery(\'#' + prefix + '\').hover(function() { jQuery(this).css({color: \'#\' + jQuery(\'#' + prefix + '_hover_color\').val()}); }, function() { jQuery(this).css({color: \'#\' + jQuery(\'#' + prefix + '_color\').val()}); })" ' + fv_disabled + '/><div class="spider_description"></div></td>';
  var layer_type = '<input type="hidden" name="' + prefix + '_type" id="' + prefix + '_type" value="' + type + '" ' + fv_disabled + '/>';
  var layer_effect_in = '<td class="spider_label ' + fv_class + '"><label>' + wdps_objectL10B.effect_in + ' </label></td>' +
                   '<td>' +
                    '<span style="display: table-cell;">' +
                      '<input type="text" name="' + prefix + '_start" id="' + prefix + '_start" value="1000" class="spider_int_input" ' +fv_disabled + '/> ms' +
                      '<div class="spider_description">' + wdps_objectL10B.start + '</div>' +
                    '</span>' +
                    '<span style="display: table-cell;">' +
                      '<select class="select_icon" name="' + prefix + '_layer_effect_in" id="' + prefix + '_layer_effect_in" style="width:150px;" onchange="wdps_trans_effect_in(\'' + id + '\', \'' + prefix + '\', ' + ((type == 'social') ? 1 : 0) + '); wdps_trans_end(\'' + prefix + '\', jQuery(this).val());" ' + fv_disabled + '>' + layer_effects_in_option + '</select>' +
                      '<div class="spider_description">' + wdps_objectL10B.effect + '</div>' +
                    '</span>' +
                    '<span style="display: table-cell;">' +
                      '<input id="' + prefix + '_duration_eff_in" class="spider_int_input" type="text"  onkeypress="return spider_check_isnum(event)" onchange="wdps_trans_effect_in(\'' + id + '\', \'' + prefix + '\', ' + ((type == 'social') ? 1 : 0) + '); wdps_trans_end(\'' + prefix + '\', jQuery(\'#' + prefix + '_layer_effect_in\').val());" value="1000" name="' + prefix + '_duration_eff_in" ' + fv_disabled + '> ms' +
                      '<div class="spider_description">' + wdps_objectL10B.duration + '</div>' +
                    '</span>' +
                    '<span style="display: table-cell;">' +
                      '<input id="' + prefix + '_infinite_in" type="text" name="' + prefix + '_infinite_in" value="1" class="spider_int_input" title="' + wdps_objectL10B.iteration_title + '"  onchange="wdps_trans_effect_in(\'' + id + '\', \'' + prefix + '\', ' + ((type == 'social') ? 1 : 0) + '); wdps_trans_end(\'' + prefix + '\', jQuery(\'#' + prefix + '_layer_effect_in\').val());" disabled="disabled" />' +
                      '<div class="spider_description">' + wdps_objectL10B.wdps_iteration + '</div>' +
                    '</span>' +
                   '</td>';
  var layer_effect_out = '<td class="spider_label ' + fv_class + '"><label>' + wdps_objectL10B.effect_out + ' </label></td>' +
                   '<td>' +
                    '<span style="display: table-cell;">' +
                      '<input type="text" name="' + prefix + '_end" id="' + prefix + '_end" value="3000" class="spider_int_input" ' + fv_disabled + '/> ms' +
                      '<div class="spider_description">' + wdps_objectL10B.start + '</div>' +
                    '</span>' +
                    '<span style="display: table-cell;">' +
                      '<select class="select_icon" name="' + prefix + '_layer_effect_out" id="' + prefix + '_layer_effect_out" style="width:150px;" onchange="wdps_trans_effect_out(\'' + id + '\', \'' + prefix + '\', ' + ((type == 'social') ? 1 : 0) + '); wdps_trans_end(\'' + prefix + '\', jQuery(this).val());" ' + fv_disabled + '>' + layer_effects_out_option + '</select>' +
                      '<div class="spider_description">' + wdps_objectL10B.effect + '</div>' +
                    '</span>' +
                    '<span style="display: table-cell;">' +
                      '<input id="' + prefix + '_duration_eff_out" class="spider_int_input" type="text" onkeypress="return spider_check_isnum(event)" onchange="wdps_trans_effect_out(\'' + id + '\', \'' + prefix + '\', ' + ((type == 'social') ? 1 : 0) + '); wdps_trans_end(\'' + prefix + '\', jQuery(\'#' + prefix + '_layer_effect_out\').val());" value="1000" name="' + prefix + '_duration_eff_out" ' + fv_disabled + '> ms' +
                      '<div class="spider_description">' + wdps_objectL10B.duration + '</div>' +
                    '</span>' +
                    '<span style="display: table-cell;">' +
                      '<input id="' + prefix + '_infinite_out" type="text" name="' + prefix + '_infinite_out" value="1" class="spider_int_input" title="' + wdps_objectL10B.iteration_title + '"  onchange="wdps_trans_effect_out(\'' + id + '\', \'' + prefix + '\', ' + ((type == 'social') ? 1 : 0) + '); wdps_trans_end(\'' + prefix + '\', jQuery(\'#' + prefix + '_layer_effect_out\').val());" disabled="disabled" />' +
                      '<div class="spider_description">' + wdps_objectL10B.wdps_iteration + '</div>' +
                    '</span>' +
                   '</td>';
  var remove_shortcode = '<td class="spider_label ' + fv_class + '"><label>' + wdps_objectL10B.wdps_remove_shortcode + '  </label></td>' +
                       '<td><input type="radio" id="' + prefix + '_remove_shortcode1" name="' + prefix + '_remove_shortcode" checked="checked" value="1" ' + fv_disabled + '/><label class ="' + fv_class + '" for="' + prefix + '_remove_shortcode1">' + wdps_objectL10B.yes + '</label>' +
                       '<input type="radio" id="' + prefix + '_remove_shortcode0" name="' + prefix + '_remove_shortcode" value="0" ' + fv_disabled + '/><label class ="' + fv_class + '" for="' + prefix + '_remove_shortcode0">' + wdps_objectL10B.no + '</label><div class="spider_description"></div></td>';
  switch(type) {
    case 'text': {
      jQuery("#wdps_preview_image" + id).append(jQuery("<span />").attr({
        id: prefix,
        "class": "wdps_draggable_" + id + " wdps_draggable",
        onclick: "wdps_showhide_layer('" + tbodyID + "', 1)",
        style: "z-index: " + layerID.replace("pr_", "") + "; " +
               "word-break: normal;" +
               "display: inline-block; " +
               "position: absolute;" +
               "left: 0; top: 0; " +
               "color: #FFFFFF; " +
               "font-size: 18px; " +
               "line-height: 1.25em; " +
               "font-family: Arial; " +
               "font-weight: normal; " +
               "padding: 5px; " +
               "background-color: " + wdps_hex_rgba('000000', 50) + "; " +
               "border-radius: 2px;"
      }).html(wdps_objectL10B.sample_text));
      jQuery("#" + tbodyID).append(tbody + '<tr class ="wdps_layer_tr">' + fv_message_layer + '<td colspan=2>'+ 
				'<table class="layer_table_left" style="width: 57%">' + 
        '<tr>' +
          text +
        '</tr><tr>' +
          text_dimensions +
        '</tr><tr>' +
          position +
        '</tr><tr>' +
          size +
        '</tr><tr>' +
          color +
        '</tr><tr>' +
					hover_color_text +  
        '</tr><tr>' +
          ffamily +
        '</tr><tr>' +
          fweight +
        '</tr><tr>' +
          link +
        '</tr><tr>' +
          text_alignment +
        '</tr><tr>' +
          published +'</tr></table>'+			
				'<table class="layer_table_right" style="width:43%">'+
				'<tr>' +
						layer_effect_in +
					'</tr>' + fv_message_effects + '<tr>' +
						layer_effect_out +
					'</tr>' + fv_message_effects + '<tr>' +
						padding +
					'</tr><tr>' +
						fbgcolor +
					'</tr><tr>' +
						fbgtransparent +  
					'</tr><tr>' +
						border_width +
					'</tr><tr>' +
						border_radius +
					'</tr><tr>' +
						shadow +
					'</tr><tr>' +
						layer_characters_count +
          '</tr><tr>' +
						remove_shortcode +            
					'</tr>' +				
				'</table>'+  
				'</td></tr>' + layer_type 
      );
      wdps_change_fonts(prefix);
      break;
    }
    case 'image': {
      if(edit == 0) {
        var tbody_html = tbody + '<tr class="wdps_layer_tr" ><td colspan=2>'+ 
				'<table class="layer_table_left" style="width: 57%">' +
        '<tr>' +
          dimensions +
        '</tr><tr>' +
          alt +
        '</tr><tr>' +
          link +
        '</tr><tr>' +
          position +
        '</tr><tr>' +
          imgtransparent + 
        '</tr><tr>' +
          published +'</tr></table>'+			
				'<table class="layer_table_right" style="width:43%">'+
				'<tr>' +
          layer_effect_in +
        '</tr><tr>' +
          layer_effect_out +
        '</tr><tr>' +
          border_width +
        '</tr><tr>' +
          border_radius +
        '</tr><tr>' +
          shadow +
					'</tr>' +			
				'</table>'+  
				'</td></tr>' + layer_type
      }
      if (!duplicate) {
        // Add image layer by media uploader.
          image_escape = wdps_add_image_layer(prefix, tbodyID, id, layerID, tbody_html, edit);
      }
      else {
        jQuery("#" + tbodyID).append(tbody_html);
      }
      break;
    }
    default: {
      break;
    }
  }
  
  if (!duplicate) {
    wdps_drag_layer(id);
    jscolor.bind();
  }

  wdps_layer_weights(id);
  wdps_onkeypress();
  wdps_tooltip();
  return layerID;
}
function wdps_add_post_feilds(prefix,feilds_val) {
  feilds_val = wdps_ReplaceAll(feilds_val,"**###**",'"');
  var s,s1,s2;
  var a = jQuery("#" + prefix + '_text').prop("selectionStart");
  var b = jQuery("#" + prefix + '_text').prop("selectionEnd");
  if(a == b) {
   s = jQuery("#" + prefix + '_text').val().slice(0,a);
   s1 = jQuery("#" + prefix + '_text').val().slice(a,jQuery("#" + prefix + '_text').val().length);
   s2 = s + '{' + feilds_val + '}' + s1;
  jQuery("#" + prefix).html(s2);
  jQuery("#" + prefix + '_text').val(s2);
  }
  else {
    s = jQuery("#" + prefix + '_text').val().slice(0,a);
    s1 = jQuery("#" + prefix + '_text').val().slice(b,jQuery("#" + prefix + '_text').val().length);
    s2 = s + '{' + feilds_val + '}' + s1;
    jQuery("#" + prefix).html(s2);
    jQuery("#" + prefix + '_text').val(s2);
  }
 
  return false;
}
function wdps_scale(that, prefix) {
  var wdps_theImage = new Image();
  wdps_theImage.src = jQuery("#" + prefix).attr("src");
  var wdps_origWidth = wdps_theImage.width;
  var wdps_origHeight = wdps_theImage.height;
  var width = jQuery("#" + prefix + "_image_width").val();
  var height = jQuery("#" + prefix + "_image_height").val();
  jQuery("#" + prefix).css({maxWidth: width + "px", maxHeight: height + "px", width: "", height: ""});
  if (!jQuery(that).is(':checked') || !jQuery(that).val()) {
    jQuery("#" + prefix).css({width: width + "px", height: height + "px"});
  }
  else if (wdps_origWidth <= width || wdps_origHeight <= height) {
    if (wdps_origWidth / width > wdps_origHeight / height) {
      jQuery("#" + prefix).css({width: width + "px"});
    }
    else {
      jQuery("#" + prefix).css({height: height + "px"});
    }
  }
}

function wdps_drag_layer(id) {
  jQuery(".wdps_draggable_" + id).draggable({ containment: "#wdps_preview_wrapper_" + id, scroll: false });
  jQuery(".wdps_draggable_" + id).bind('dragstart', function(event) {
    jQuery(this).addClass('wdps_active_layer');
  }).bind('drag', function(event) {
    var prefix = jQuery(this).attr("id");
    var check = jQuery('#' + prefix + '_align_layer').is(":checked");
    if (!check) {
      jQuery("#" + prefix + "_left").val(parseInt(jQuery(this).offset().left - jQuery(".wdps_preview_image" + id).offset().left));
    }
    jQuery("#" + prefix + "_top").val(parseInt(jQuery(this).offset().top - jQuery(".wdps_preview_image" + id).offset().top));

    // Do not set layer width/height on drag.
    if (jQuery("#" + prefix + "_image_width").val() == 0) {
      jQuery("#" + prefix).css({'width': ''});
    }
    if (jQuery("#" + prefix + "_image_height").val() == 0) {
      jQuery("#" + prefix).css({'height': ''});
    }
  });
  jQuery(".wdps_draggable_" + id).bind('dragstop', function(event) {
    jQuery(this).removeClass('wdps_active_layer');
    var prefix = jQuery(this).attr("id");
    var check = jQuery('#' + prefix + '_align_layer').is(":checked");
    var left = parseInt(jQuery(this).offset().left - jQuery(".wdps_preview_image" + id).offset().left);
    var layer_center = left + jQuery("#" + prefix).width() / 2;
    var pos_center = -jQuery("#" + prefix).width() / 2 + jQuery(".wdps_preview_image" + id).width() / 2;
    var pos_rigth = (jQuery(".wdps_preview_image" + id).width() - jQuery("#" + prefix).width()) - 2 * parseInt(jQuery("#" + prefix + "_padding").val());
    if (check) {
      /*center*/
      if ((layer_center > jQuery(".wdps_preview_image" + id).width() / 4 && layer_center < jQuery(".wdps_preview_image" + id).width() / 2) || (layer_center >jQuery(".wdps_preview_image" + id).width() / 2 && layer_center <= 3 * jQuery(".wdps_preview_image" + id).width() / 4)) {
        jQuery("#" + prefix).css({left:pos_center + 'px'});
        jQuery("#" + prefix + "_left").val(parseInt(pos_center));
      }
      /*right*/
      else if (layer_center > (3 * jQuery(".wdps_preview_image" + id).width() / 4) && layer_center < jQuery(".wdps_preview_image" + id).width()) {
        jQuery("#" + prefix).css({left:pos_rigth + 'px'});
        jQuery("#" + prefix + "_left").val(parseInt(pos_rigth));
      }
      /*left*/
      else if (layer_center > 0 && layer_center <= jQuery(".wdps_preview_image" + id).width() / 4){
       jQuery("#" + prefix).css({left:'0px'});
       jQuery("#" + prefix + "_left").val(0);
      }
    }
  });
}

function wdps_layer_weights(id) {
  jQuery(".ui-sortable" + id + "").sortable({
    handle: ".connectedSortable",
    connectWith: ".connectedSortable",
    update: function (event) {
      var i = 1;
      jQuery(".wdps_slide" + id + " .wdps_layer_depth").each(function (e) {
        if (jQuery(this).val()) {
          jQuery(this).val(i++);
          prefix = jQuery(this).attr("prefix");
          jQuery("#" + prefix).css({zIndex: jQuery(this).val()});
        }
      });
    }
  });//.disableSelection();
  // jQuery(".ui-sortable").sortable("enable");
}

function wdps_slide_weights() {
  jQuery(".aui-sortable").sortable({
    connectWith: ".connectedSortable",
    items: ".connectedSortable",
    update: function (event) {
      var i = 1;
      jQuery(".wbs_subtab input[id^='order']").each(function (e) {
        if (jQuery(this).val()) {
          jQuery(this).val(i++);
        }
      });
    }
  });
  jQuery(".aui-sortable").disableSelection();
}

function wdps_add_image_layer(prefix, tbodyID, id, layerID, tbody_html, edit) {
  var custom_uploader;
  /*event.preventDefault();*/
  // If the uploader object has already been created, reopen the dialog.
  if (custom_uploader) {
    custom_uploader.open();
    return;
  }
  if (typeof edit == "undefined") {
    var edit = 0;
  }
  // Extend the wp.media object.
  custom_uploader = wp.media.frames.file_frame = wp.media({
    title: 'Choose Image',
    library : { type : 'image'},
    button: { text: 'Insert'},
    multiple: false
  });
  // When a file is selected, grab the URL and set it as the text field's value
  custom_uploader.on('select', function() {
    jQuery("#" + tbodyID).append(tbody_html);
    attachment = custom_uploader.state().get('selection').first().toJSON();
    if (edit == 0) {
      jQuery("#wdps_preview_image" + id).append(jQuery("<img />").attr({
        id: prefix,
        "class": "wdps_draggable_" + id + " wdps_draggable",
        onclick: "wdps_showhide_layer('" + tbodyID + "', 1)",
        src: attachment.url,
        style: "z-index: " + layerID.replace("pr_", "") + "; " +
               "left: 0; top: 0; " +
               "border: 2px none #FFFFFF; " +
               "border-radius: 2px; " +
               "opacity: 1; filter: Alpha(opacity=100); " +
               "position: absolute;"
      }));

      var att_width = attachment.width ? attachment.width : jQuery("#" + prefix).width();
      var att_height = attachment.height ? attachment.height : jQuery("#" + prefix).height();
      var width = Math.min(att_width, jQuery("#wdps_preview_image" + id).width());
      var height = Math.min(att_height, jQuery("#wdps_preview_image" + id).height());

      jQuery("#" + prefix + "_image_url").val(attachment.url);
      jQuery("#" + prefix + "_image_width").val(width);
      jQuery("#" + prefix + "_image_height").val(height);
      jQuery("#" + prefix + "_image_scale").attr("checked", "checked");
      wdps_scale("#" + prefix + "_image_scale", prefix);
    }
    else {
      jQuery("#" + prefix).attr("src", attachment.url);
      jQuery("#" + prefix + "_image_url").val(attachment.url);
    }
    wdps_drag_layer(id);
    jscolor.bind();
    wdps_tooltip();
  });

  // Open the uploader dialog.
  custom_uploader.open();
}

function wdps_hex_rgba(color, transparent) {
  color = "#" + color;
  var redHex = color.substring(1, 3);
  var greenHex = color.substring(3, 5);
  var blueHex = color.substring(5, 7);

  var redDec = parseInt(redHex, 16);
  var greenDec = parseInt(greenHex, 16);
  var blueDec = parseInt(blueHex, 16);

  var colorRgba = 'rgba(' + redDec + ', ' + greenDec + ', ' + blueDec + ', ' + transparent / 100 + ')';
  return colorRgba;
}

function wdps_add_slide(wdps_post_fildes_name_, post_id) {
  if (wdps_post_fildes_name_ == undefined) {
    var wdps_post_fildes_name_ = ["ID", "post_author", "post_date", "post_date_gmt", "post_content", "post_title", "post_excerpt", "post_status", "comment_status", "ping_status", "post_password", "post_name", "to_ping", "pinged", "post_modified", "post_modified_gmt", "post_content_filtered", "post_parent", "goid", "menu_order", "post_type", "post_mine_type", "comment_count", "filter", "_thumbnail_id",  "_edit_lock", "_edit_last"];
  }
  var slides_count = jQuery(".wbs_subtab div[id^='wbs_subtab']").length;
  var tmp_arr = [];
  var order_arr = [];
  var tmp_i = 0;
  jQuery(".wbs_subtab").find(".tab_link").each(function() {
    var tmp_id = jQuery(this).attr("id");
    if (tmp_id.indexOf("pr_") !== -1) {
      tmp_arr[tmp_i++] = tmp_id.replace("wbs_subtabpr_", "");
    }
    order_arr.push(jQuery('#order' + tmp_id.replace("wbs_subtab", "")).val()) ;
  });
  if (typeof tmp_arr !== 'undefined' && tmp_arr.length > 0) {
    var slideID = "pr_" + (Math.max.apply(Math, tmp_arr) + 1);
    ++slides_count;
  }
  else {
    var slideID = "pr_" + ++slides_count;
  }
  var order_id = 1;
  if (typeof order_arr !== 'undefined' && order_arr.length > 0) {
    order_id = Math.max.apply(Math, order_arr) + 1;
  }
  var uploader_href_for_add_slide = uploader_href.replace('slideID', slideID);
  var uploader_href_for_add_layer = uploader_href_for_add_slide.replace('add_update_slide', 'add_layer'); 
   /*slide_upload_by = ' <input id="button_image_url' + slideID + '" class="button-primary" type="button" value="Add Image from Media Library" onclick="spider_media_uploader(\'' + slideID + '\', event); return false;" />';*/
    
    edit_slide_by = '<a href="' + wdps_add_post_href.replace("action=WDPSPosts", "action=WDPSPosts&slide_id=" + slideID) + '" class="wdps_change_thumbnail thickbox thickbox-preview" title="' + wdps_objectL10B.edit_post + '" onclick="if (!wdps_check_required()) {jQuery(this).removeClass(\'thickbox\').removeClass(\'thickbox-preview\');return false;}; jQuery(this).addClass(\'thickbox\').addClass(\'thickbox-preview\'); return false;"></a>';
    img_layer_upload_by = ' <input class="action_buttons add_image_layer ' + ("wdps_free_button") + '  button-small" type="button" value="Add Image Layer" onclick="' + ("alert(\'" + wdps_objectL10B.disabled_free_version + "\')") + '; return false;" />'
 
  jQuery("#slide_ids_string").val(jQuery("#slide_ids_string").val() + slideID + ',');
  jQuery(".wdps_slides_box *").removeClass("wdps_sub_active");
  jQuery(
    '<div id="wdps_subtab_wrap' + slideID + '" class="wdps_subtab_wrap connectedSortable"><div id="wbs_subtab' + slideID + '" class="tab_link wdps_sub_active" href="#" style="background-position:center;display:block !important; width:149px; height:140px; padding:0; margin-right: 25px;">' +
      '<div  onclick="wdps_change_sub_tab(this, \'wdps_slide' + slideID + '\')" class="tab_image" id="wdps_tab_image' + slideID + '">' + 
        '<div class="tab_buttons">' + 
          '<div class="handle_wrap"><div class="handle" title="' + wdps_objectL10B.wdps_drag_re_order + '"></div></div>' +
          '<div class="wdps_tab_title_wrap"> <input onclick="wdps_change_sub_tab_title(this, \'wdps_slide' + slideID + '\')" type="text" id="title' + slideID + '" name="title' + slideID + '" value="Slide ' + order_id + '" class="wdps_tab_title" tab_type="slide' + slideID + '"  /></div><input  type="hidden" name="order' + slideID + '" id="order' + slideID + '" value="' + order_id + '" /></div>' +
          '<div class="overlay"><div id="hover_buttons">' +
          edit_slide_by + 
          ' <span class="wdps_slide_dublicate" onclick="wdps_duplicate_slide(\'' + slideID + '\',\'' + post_id + '\');" title="'+ wdps_objectL10B.duplicate_slide + '"></span>' +
          ' <span class="wdps_tab_remove" title="'+ wdps_objectL10B.delete_slide +'" onclick="wdps_remove_slide(\'' + slideID + '\')"></span></div></div>' +
         ' </div></div></div>').insertBefore(".new_tab_image");
  wdps_change_sub_tab(jQuery('#title' + slideID), 'wdps_slide' + slideID);
  jQuery(".wbs_subtab").after(
    '<div class="wdps_box wdps_sub_active wdps_slide' + slideID + '">' +
      '<table class="ui-sortable' + slideID + '">' +
        '<thead><tr><td colspan="4"> </td></tr></thead>' +
        '<tbody>' +
          '<input type="hidden" name="type' + slideID + '" id="type' + slideID + '" value="image" />' +
          '<input type="hidden" id="wdps_video_type' + slideID + '" name="wdps_video_type' + slideID + '" value="" />' +
          '<tr><td colspan="4">' +
           /*slide_upload_by +
            ' <input class="button-primary" type="button" value="Add Image by URL" onclick="wdps_add_image_url(\'' + slideID + '\')" />' +
            ' <input class="button-primary" type="button" id="show_add_embed" onclick="wdps_add_video(\'' +  slideID + '\', \'video\')" value="Embed Media" />' +*/
            '<div class="slide_add_buttons_wrap"> <a href="' + wdps_add_post_href.replace("action=WDPSPosts", "action=WDPSPosts&slide_id=" + slideID) + '" class="action_buttons add_post thickbox thickbox-preview" title="' + wdps_objectL10B.add_post + '" onclick="if (!wdps_check_required()) {jQuery(this).removeClass(\'thickbox\').removeClass(\'thickbox-preview\');return false;}; jQuery(this).addClass(\'thickbox\').addClass(\'thickbox-preview\'); return false;">' + wdps_objectL10B.add_post + '</a>' +
            '</div><div class="slide_add_buttons_wrap"><input id="delete_image_url' + slideID + '" class="action_buttons delete" type="button" value="'+ wdps_objectL10B.remove + '" onclick="spider_remove_url(\'image_url' + slideID + '\', \'wdps_preview_image' + slideID + '\')" />' +
            ' <input id="image_url' + slideID + '" type="hidden" value="" name="image_url' + slideID + '" />' +
            ' </div><div class="slide_add_buttons_wrap"><input id="thumb_url' + slideID + '" type="hidden" value="" name="thumb_url' + slideID + '" /></td>' +
          '</tr><tr class="bgcolor"><td colspan="4">' +
            '<div id="wdps_preview_wrapper_' + slideID + '" class="wdps_preview_wrapper" style="width: ' + jQuery("#width").val() + 'px; height: ' + jQuery("#height").val() + 'px;">' +
            '<div class="wdps_preview" style="overflow: hidden; position: absolute; width: inherit; height: inherit; background-color: transparent; background-image: none; display: block;">' +
            '<div id="wdps_preview_image' + slideID + '" class="wdps_preview_image' + slideID + '" ' +
                 'style="background-color: ' + wdps_hex_rgba(jQuery("#background_color").val(), (100 - jQuery("#background_transparent").val())) + '; ' +
                        'background-image: url(\'\'); ' +
                        'background-position: center center; ' +
                        'background-repeat: no-repeat; ' +
                        'background-size: ' + jQuery('input[name=bg_fit]:radio:checked').val() + '; ' +
                        'border-width: ' + jQuery('#glb_border_width').val() + 'px; ' +
                        /*'border-style: ' + jQuery('#glb_border_style').val() + '; ' +
                        'border-color: #' + jQuery('#glb_border_color').val() + '; ' +
                        'border-radius: ' + jQuery('#glb_border_radius').val() + '; ' +
                        'box-shadow: ' + jQuery('#glb_box_shadow').val() + '; ' +*/
                        'width: inherit; height: inherit;"></div></div></div></td>' +
          '</tr><tr><td><table class="wdps_slide_radio_left"><tr><td class="spider_label"><label>' + wdps_objectL10B.published + ' </label></td>' +
              '<td><input id="published' + slideID + '1" type="radio" value="1" checked="checked" name="published' + slideID + '">' +
                  '<label for="published' + slideID + '1">' + wdps_objectL10B.yes + '</label>' +
                  '<input id="published' + slideID + '0" type="radio" value="0" name="published' + slideID + '">' +
                  '<label for="published' + slideID + '0">' + wdps_objectL10B.no + '</label></td>' +
          '</tr></table><table class="wdps_slide_radio_right"><tr id="trlink' + slideID + '"><td title="'+ wdps_objectL10B.wdps_redirection_link +'" class="wdps_tooltip spider_label"><label for="link' + slideID + '">' + wdps_objectL10B.link_slide + ' </label></td>' +
                 '<td><input id="link' + slideID + '" type="text" size="39" value="" name="link' + slideID + '" />' +
                 '<input id="target_attr_slide' + slideID + '" type="checkbox"  name="target_attr_slide' + slideID + '" value="1" checked="checked" /><label for="target_attr_slide' + slideID + '"> '+ wdps_objectL10B.wdps_open_new_window + '</label>' +
                 '</td>' +
          '</tr></table></td></tr><tr><td colspan="4">' +
            ' <div class="layer_add_buttons_wrap"><input class="action_buttons add_text_layer ' + (fv ? " wdps_free_button" : "") + ' button-small" type="button" value="' + wdps_objectL10B.text_layer+'" onclick="' + (!fv ? "wdps_add_layer(\'text\', \'" + slideID + "\',\'" + '' + "\',\'" + '' + "\',\'" + 1 + "\',\'" + '' + "\',\'" + 'post' + "\',\'" + wdps_post_fildes_name_ + "\')" : "alert(\'" + wdps_objectL10B.disabled_free_version + "\')") + '; return false;">' +
            img_layer_upload_by + '<input type="hidden" id="wdps_post_id'+slideID+'" name="wdps_post_id'+slideID+'" value="" '+ fv_disabled + '/>'+
            /*' <input class="button-primary button button-small" type="button" onclick="wdps_add_video(\'' +  slideID + '\', \'video_layer\')" value="Embed Media Layer" />'*/ 
            '</div><div class="layer_add_buttons_wrap"><input class="action_buttons add_social_layer button-small wdps_free_button" type="button" value="Add Social Buttons Layer" onclick="alert(\'' + wdps_objectL10B.disabled_free_version + '\'); return false;">' +
	    '</div><div class="layer_add_buttons_wrap"><input class="action_buttons add_hotspot_layer button-small wdps_free_button" type="button" value="Add Hotspot Layer" onclick="alert(\'' + wdps_objectL10B.disabled_free_version + '\'); return false;"></td>' +
          '</tr></tbody></table>' +
          '<input id="slide' + slideID + '_layer_ids_string" name="slide' + slideID + '_layer_ids_string" type="hidden" value="" />' +
          '<input id="slide' + slideID + '_del_layer_ids_string" name="slide' + slideID + '_del_layer_ids_string" type="hidden" value="" />' +
          '<script>' +
            'jQuery(window).load(function() {' +
              'wdps_drag_layer(\'' + slideID + '\');' +
            '});' +
            'spider_remove_url(\'image_url' + slideID + '\', \'wdps_preview_image' + slideID + '\');' +
          '</script>' +
          '</div>');
  jQuery('#wbs_subtab' + slideID).addClass("wdps_sub_active");        
  wdps_slide_weights();
  wdps_onkeypress();
  jQuery(function(){
    jQuery(document).on("click","#wdps_tab_image" + slideID ,function(){
        wdps_change_sub_tab(this, 'wdps_slide' + slideID);
    });
    jQuery(document).on("click","#wdps_tab_image" + slideID + " input",function(e){
        e.stopPropagation();
    });
    jQuery(document).on("click","#title" + slideID,function(){
        wdps_change_sub_tab(jQuery("#wdps_tab_image" + slideID), 'wdps_slide' + slideID);
        wdps_change_sub_tab_title(this, 'wdps_slide' + slideID);
    });
  });
  return slideID;
}

function wdps_remove_slide(slideID, conf) {
  if (typeof conf == "undefined") {
    var conf = 1;
  }
  if (conf) {
    if (!confirm(wdps_objectL10B.remove_slide)) {
      return;
    }
  }
  jQuery("#sub_tab").val("");
  jQuery(".wdps_slides_box *").removeClass("wdps_sub_active");
  jQuery(".wdps_slide" + slideID).remove();
  jQuery("#wbs_subtab" + slideID).remove();
  jQuery("#wdps_subtab_wrap" + slideID).remove();

  var slideIDs = jQuery("#slide_ids_string").val();
  slideIDs = slideIDs.replace(slideID + ",", "");
  jQuery("#slide_ids_string").val(slideIDs);
  var delslideIds = jQuery("#del_slide_ids_string").val() + slideID + ",";
  jQuery("#del_slide_ids_string").val(delslideIds);

  jQuery(".wbs_subtab div[id^='wbs_subtab']").each(function () {
    var id = jQuery(this).attr("id");
    firstSlideID = id.replace("wbs_subtab", "");
    jQuery("#wbs_subtab" + firstSlideID).addClass("wdps_sub_active");
    jQuery(".wdps_slide" + firstSlideID).addClass("wdps_sub_active");
  })
}

function wdps_trans_end(id, effect) {
  var transitionEvent = wdps_whichTransitionEvent();
  if (jQuery("#"+id).parent().attr('id')==id+"_div") {
    var e = document.getElementById(id+'_div');
    transitionEvent && e.addEventListener(transitionEvent, function() {
      jQuery("#" + id + "_div").removeClass("wdps_animated").removeClass(effect);
    });
  }
  else {
     var e = document.getElementById(id);
     transitionEvent && e.addEventListener(transitionEvent, function() {
      jQuery("#" + id).removeClass("wdps_animated").removeClass(effect);
    });
  }
}

function wdps_whichTransitionEvent() {
  var t;
  var el = document.createElement('fakeelement');
  var transitions = {
    'animation':'animationend',
    'OAnimation':'oAnimationEnd',
    'MozAnimation':'animationend',
    'WebkitAnimation':'webkitAnimationEnd'
  }
  for (t in transitions) {
    if (el.style[t] !== undefined) {
      return transitions[t];
    }
  }
}

function wdps_new_line(prefix) {
  jQuery("#" + prefix).html(jQuery("#" + prefix + "_text").val().replace(/(\r\n|\n|\r)/gm, "<br />"));
}

function wdps_trans_effect_in(slider_id, prefix, social) {
  if (jQuery("#" + prefix + "_layer_effect_in").val() != 'none') {
    jQuery("#" + prefix + "_infinite_in").removeAttr("disabled");
  }
  else {
    jQuery("#" + prefix + "_infinite_in").attr('disabled', 'disabled')
  }
  var cont = jQuery("#" + prefix);
  var social_class = social ? ' fa fa-' + jQuery("#" + prefix + "_social_button").val() : "";
  cont.css(
    '-webkit-animation-duration', jQuery("#" + prefix + "_duration_eff_in").val() / 1000 + "s").css(
    'animation-duration' , jQuery("#" + prefix + "_duration_eff_in").val() / 1000 + "s");
  cont.removeClass().addClass(
    jQuery("#" + prefix + "_layer_effect_in").val() + " wdps_animated wdps_draggable_" + slider_id + social_class + " wdps_draggable ui-draggable");
  var iteration_count = jQuery("#" + prefix + "_infinite_in").val() == 0 ? 'infinite' : jQuery("#" + prefix + "_infinite_in").val();
  cont.css(
    '-webkit-animation-iteration-count', iteration_count).css(
    'animation-iteration-count', iteration_count
  );
}

function wdps_trans_effect_out(slider_id, prefix, social) {
  if (jQuery("#" + prefix + "_layer_effect_out").val() != 'none') {
    jQuery("#" + prefix + "_infinite_out").removeAttr("disabled");
  }
  else {
    jQuery("#" + prefix + "_infinite_out").attr('disabled', 'disabled')
  }
  var cont = jQuery("#" + prefix);
  var social_class = social ? ' fa fa-' + jQuery("#" + prefix + "_social_button").val() : "";
  cont.css(
    '-webkit-animation-duration', jQuery("#" + prefix + "_duration_eff_out").val() / 1000 + "s").css(
    'animation-duration' , jQuery("#" + prefix + "_duration_eff_out").val() / 1000 + "s");
  cont.removeClass().addClass(
    jQuery("#" + prefix + "_layer_effect_out").val() + " wdps_animated wdps_draggable_" + slider_id + social_class + " wdps_draggable ui-draggable");
  var iteration_count = jQuery("#" + prefix + "_infinite_out").val() == 0 ? 'infinite' : jQuery("#" + prefix + "_infinite_out").val();
  cont.css(
    '-webkit-animation-iteration-count', iteration_count).css(
    'animation-iteration-count', iteration_count
  );
}

function wdps_break_word(that, prefix) {
  if (jQuery(that).is(':checked')) {
    jQuery("#" + prefix).css({wordBreak: "normal"});
  }
  else {
    jQuery("#" + prefix).css({wordBreak: "break-all"});  
  }
}


function wdps_text_width(that, prefix) {
  var width = parseInt(jQuery(that).val());
  if (width) {
    if (width >= 100) {
       width = 100;
       jQuery("#" + prefix).css({left : 0});
       jQuery("#" + prefix + "_left").val(0);
    }
    else {
      var layer_left_position = parseInt(jQuery("#" + prefix).css("left"));	
      var layer_parent_div_width = parseInt(jQuery("#" + prefix).parent().width());
      var left_position_in_percent = (layer_left_position / layer_parent_div_width) * 100;
      if ((parseInt(left_position_in_percent) + width) > 100) {
        var left_in_pix = parseInt((100 - width) * (layer_parent_div_width / 100));
        jQuery("#" + prefix).css({left : left_in_pix + "px"});
        jQuery("#" + prefix + "_left").val(left_in_pix);
      }
    }
    jQuery("#" + prefix).css({width: width + "%"});
    jQuery(that).val(width);
  }
  else {
    jQuery("#" + prefix).css({width: ""});
    jQuery(that).val("0");
  }
}

function wdps_text_height(that, prefix) {
  var height = parseInt(jQuery(that).val());
  if (height) {
    if (height >= 100) {
      jQuery("#" + prefix).css({top : 0});
      jQuery("#" + prefix + "_top").val(0);
    }
    else {
      var layer_top_position = parseInt(jQuery("#" + prefix).css("top"));	
      var layer_parent_div_height = parseInt(jQuery("#" + prefix).parent().height());
      var top_position_in_percent = (layer_top_position / layer_parent_div_height) * 100;
      if ((parseInt(top_position_in_percent) + height) > 100) {
        var top_in_pix = parseInt((100 - height) * (layer_parent_div_height / 100 ));
        jQuery("#" + prefix).css({top : top_in_pix});
        jQuery("#" + prefix + "_top").val(top_in_pix);
      }
    }
    jQuery("#" + prefix).css({height: height + "%"});
    jQuery(that).val(height);
  }
  else {
    jQuery("#" + prefix).css({height: ""});
    jQuery(that).val("0");
  }
}

function wdps_whr(forfield) {
  var width = jQuery("#width").val();
  var height = jQuery("#height").val();
  var ratio = jQuery("#ratio").val();
  if (forfield == 'width') {
    if (width && height) {
      jQuery("#ratio").val(Math.round((width / height) * 100) / 100);
    }
    else if (width && ratio) {
      jQuery("#height").val(Math.round((width / ratio) * 100) / 100);
    }
  }
  else if (forfield == 'height') {
    if (width && height) {
      jQuery("#ratio").val(Math.round((width / height) * 100) / 100);
    }
  }
  else {
    if (width && ratio) {
      jQuery("#height").val(Math.round((width / ratio) * 100) / 100);
    }
  }
  jQuery('.wdps_preview_wrapper').width(jQuery("#width").val());
  jQuery('.wdps_preview_wrapper').height(jQuery("#height").val());
}

function wdps_change_taxonomies() {
  jQuery("#choose_post").change(function() {
    var post_data = {};
    post_data["task"] = 'get_taxonoimis';
    post_data["current_id"] = jQuery("#current_id").val();
    post_data["nonce_wd"] = jQuery("#nonce_wd").val();
    post_data["choose_post"] = jQuery("#choose_post").val();
    jQuery.post(
      jQuery('#sliders_form').action,
      post_data,
      function (data) {
        var str = jQuery(data).find(".taxonomies_id").html();
        jQuery("#taxonomies_id").html(str);
        var post_fildes_name = jQuery(data).find("#post_fildes_name").html();
        post_fildes_name = jQuery.parseJSON(post_fildes_name);
        jQuery("#fildes_name_").val(post_fildes_name);
        jQuery(".wdps_draggable").each(function() {
          text = '';
          prefix = jQuery(this).attr('id');
          for (var i = 0; i < post_fildes_name.length; ++i) {
            text += '<input type="button" style="line-height:4px;display:table;float:left; margin:3px;" class="button-primary" value="' + post_fildes_name[i] + '"  onclick="wdps_add_post_feilds(\''+ prefix + '\',\'' + post_fildes_name[i] + '\')"/>';
          }
          jQuery("#" + prefix + "filde_name").html(text);
        });
        if (str == '') {
          jQuery("#taxonomies_id1").css({"display": "none"});
        }
        else {
          jQuery("#taxonomies_id1").css({"display": ""});
        }
      }
    ).success(function (data, textStatus, errorThrown) {});
  });
}

function wdps_onkeypress() {
  jQuery("input[type='text']").on("keypress", function (event) {
    if ((jQuery(this).attr("id") != "search_value") && (jQuery(this).attr("id") != "current_page")) {
      var chCode1 = event.which || event.paramlist_keyCode;
      if (chCode1 == 13) {
        if (event.preventDefault) {
          event.preventDefault();
        }
        else {
          event.returnValue = false;
        }
      }
    }
    return true;
  });
}


jQuery(document).ready(function () {
  wdps_change_taxonomies();
  wdps_onkeypress();
  wdps_tooltip();
});
function wdps_change_text_bg_color(prefix) {
  var bgColor = wdps_hex_rgba(jQuery("#" + prefix + "_fbgcolor").val(), 100 - jQuery("#" + prefix + "_transparent").val());
  jQuery("#" + prefix).css({backgroundColor: bgColor});
}
function wdps_enable_disable(display, id, current) {
  jQuery("#" + current).attr('checked', 'checked');
  jQuery("#" + id).css('display', display);
}
function set_ffamily_value() {
  var font = jQuery("#possib_add_ffamily_input").val();
  if (font != '' ) {
    if (jQuery("#possib_add_google_fonts").is(":checked")) {
      var ffamily_google = jQuery('#possib_add_ffamily_google').val();
      if(ffamily_google.indexOf(font) == -1) {
        if (ffamily_google != '') {
          ffamily_google += "*WD*" + font;
        }
        else {
          ffamily_google = font;
        }
        jQuery('#possib_add_ffamily_google').val(ffamily_google);
      }
      
    }
    else {
      var ffamily = jQuery('#possib_add_ffamily').val();
      if(ffamily.indexOf(font) == -1) {
        if (ffamily != '') {
          ffamily += "*WD*" + font;
        }
        else {
          ffamily = font;
        }
        jQuery('#possib_add_ffamily').val(ffamily);
      }
    }
  }
  jQuery("#possib_add_ffamily_input").val('');
}
function wdps_get_checked() {
  var ids_string = "";
  if (jQuery('#check_all_items').is(':checked')) {
    ids_string = 'all';
  }
  else {
    jQuery("#sliders_form input[type='checkbox']").each(function () {
      if (jQuery(this).is(':checked')) {
        var id = jQuery(this).attr("id");
        if (id != 'check_all' && id != 'check_all_items' && id != 'imagesexport') {
          id = id.replace("check_", "");
          ids_string += id + ", ";
        }
      }
    });
  }
  if (jQuery('#imagesexport').is(':checked')) {
    var imagesexport_checked = true;
  }
  else {
    var imagesexport_checked = false;
  }
  var href = jQuery(".wdps_export").attr("href");
  if (href.indexOf("&imagesexport") !== -1) {
    href = href.substr(0, href.indexOf("&imagesexport")); 
  }
    jQuery(".wdps_export").attr("href", href + "&imagesexport=" + imagesexport_checked + "&slider_ids=" + ids_string);
    jQuery('.wdps_opacity_export').hide();
    jQuery('.wdps_exports').hide();
}

function wdps_getfileextension(filename) {
  if (filename.length == 0) {
    alert(wdps_objectL10B.choose_file);
    return false;
  }
  var dot = filename.lastIndexOf(".");
  var extension = filename.substr(dot + 1, filename.length);
  var exten = 'zip';
  // exten=exten.replace(/\./g,'');
  // exten=exten.replace(/ /g,'');
  if (extension.toLowerCase() == exten.toLowerCase()) {
    return true;
  }
  else {
    alert(wdps_objectL10B.message_upload);
  }
  return false;
}
function wdps_change_fonts(prefix, change) {
  var fonts;
  if (jQuery("#" + prefix + "_google_fonts1").is(":checked")) {
    fonts = wdps_objectGGF;
  }
  else {
    fonts = wdps_objectFGF;
  }
  if (typeof change == "undefined") {
    var fonts_option = "";
    for (var i in fonts) {
      fonts_option += '<option value="' + i + '">' + fonts[i] + '</option>';
    }
    jQuery("#" + prefix + "_ffamily").html(fonts_option);
  }
  var font = jQuery("#" + prefix + "_ffamily").val();
  jQuery("#" + prefix).css({fontFamily: fonts[font]});
}

function wdps_bulk_actions(that) {
  var action = jQuery(that).val();
  if (action != '') {
    if (action == 'delete_all') {
      if (!confirm(wdps_objectL10B.delete_message)) {
        return false;
      }
    }
    else if (action == 'duplicate_all') {
      if (!confirm(wdps_objectL10B.duplicate_message) ) {
        return false;
      }
    }
    spider_set_input_value('task', action);
    jQuery('#sliders_form').submit();     
  }
  else {
    return false;
  }
  return true;
}

function wdps_position_left_disabled(that) {
  if (jQuery("#" + that + "_align_layer").is(":checked")) {
    jQuery("#" + that + "_left").attr('disabled', 'disabled');
  }
  else {
    jQuery("#" + that + "_left").removeAttr("disabled");
  }
}

function wdps_reset(event) {
  if (confirm(wdps_objectL10B.reset_confirm)) {
    if (!wdps_check_required()) {
      return false;
    };
    spider_set_input_value('task', 'reset');
    spider_ajax_save('sliders_form', event);
    return true;
  }
  return false;
}
function wdps_tooltip() {
  if (typeof jQuery().tooltip !== 'undefined') {
    if (jQuery.isFunction(jQuery().tooltip)) {
      jQuery(".wdps_tooltip").tooltip({
        track: true,
        content: function () {
        return jQuery(this).prop('title');
        }
      });
    }
  }
}

function wdps_min_size_validation(that) {
  var cont = jQuery("#" + that + "_min_size");
  var min_size = parseInt(cont.val());
  var size = parseInt(jQuery("#" + that + "_size").val());
  if (min_size > size) {
    cont.val(0);
    cont.css({'borderColor': 'rgb(255, 0, 0)'});
  }
  else {
    cont.removeAttr('style');
  }
}