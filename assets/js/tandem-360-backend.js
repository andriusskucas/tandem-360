jQuery(document).ready(function($){

    // enable user to select images for 360object
      $('#add_btnn').click(function(e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: true
        }).open()
        .on('select', function(e){
            $('#selected_360_images').html('');
            var length = image.state().get("selection").length;
            var images = image.state().get("selection").models;

            var all_images = new Array();
            for(var iii = 0; iii < length; iii++)
            {

                var image_url = images[iii].changed.url;
                var image_thumb = images[iii].changed.sizes.thumbnail.url;
                var image_title = images[iii].changed.title;
                var this_img = {
                    'image_url': image_url,
                    'image_thumb': image_thumb,
                    'title':image_title
                };

                all_images.push(this_img);

            }
             var len = all_images.length;
            // Set frames count
            $('#tandem_360_frames_field').val(len);

            // sort images in order
               for (var i = len-1; i>=0; i--){
                 for(var j = 1; j<=i; j++){
                   if(parseInt(all_images[j-1].title)>parseInt(all_images[j].title)){
                       var temp = all_images[j-1];
                       all_images[j-1] = all_images[j];
                       all_images[j] = temp;
                    }
                 }
               }

            // Display images
            for(var iii = 0; iii < all_images.length; iii++)
            {
                $('#selected_360_images').append('<img src="'+all_images[iii].image_thumb+'" style="margin:10px;"/>');
            }
            $('#tandem_360_images_field').val(JSON.stringify(all_images));
        });
    });// end of adding imagesavealpha

    // Enable multiple selection
    $.fn.shiftSelectable = function() {
                var lastChecked,
                    $boxes = this;

                $boxes.click(function(evt) {
                    if(!lastChecked) {
                        lastChecked = this;
                        return;
                    }

                    if(evt.shiftKey) {
                        var start = $boxes.index(this),
                            end = $boxes.index(lastChecked);
                        $boxes.slice(Math.min(start, end), Math.max(start, end) + 1)
                            .attr('checked', lastChecked.checked)
                            .trigger('change');
                    }

                    lastChecked = this;
                });
            };

          $('.tandem_360_new_frames_field').shiftSelectable();

          $('#add_hotspot').click(function(e){
              e.preventDefault();
              $('#ad_spot_wrap').fadeIn(600);
              $('#add_hotspot_row').show();
              jQuery('#save_hotspot_row').hide();
          });


          $('#save_hotspot_row').click(function(e){
              e.preventDefault();
              var ii = $(this).data('ii');
              var frames = new Array();
              var frames2 = new Array();

              var $fr = $('.tandem_360_new_frames_field:checked');
              var last = $fr.eq(0).val();
              var first = $fr.eq(0).val();

              var hottitle = $('#tandem_360_new_hot_title_field').val();
              var desc = tinyMCE.get('tandem_360_new_hot_desc_field').getContent();
              var xx = $('#tandem_360_new_hot_x_field').val();
              var yy = $('#tandem_360_new_hot_y_field').val();
              var zz = $('#tandem_360_new_hot_z_field').val();
              var classs = $('#tandem_360_new_hot_class_field').val();

              $fr.each(function(i,el){
                  el = $(el);
                  frames2.push(el.val());
                  if(last < el.val() - 1 || i == $fr.length - 1){

                      var maxi = i-1;
                      if(i == $fr.length - 1)
                          maxi = i;

                      if(maxi == i && last < el.val() - 1){
                          var bounds = {
                            'min':first,
                            'max':$fr.eq(maxi - 1).val()
                          };

                          frames.push(bounds);
                          first = el.val();
                      }

                      var bounds = {
                        'min':first,
                        'max':$fr.eq(maxi).val()
                      };

                      frames.push(bounds);
                      first = el.val();
                  }

                  last = el.val();
              });

              var new_hotspot = {
                  'title':hottitle,
                  'desc':desc,
                  'x':xx,
                  'y':yy,
                  'z':zz,
                  'frames': frames,
                  'allFrames': frames2,
                  'extraclass': classs
              };

              hotspots[ii] = new_hotspot;

              render_hotspots_admin();

              $('#ad_spot_wrap').fadeOut(600);
          });

          $('#add_hotspot_row').click(function(e){
              e.preventDefault();

              var frames = new Array();
              var frames2 = new Array();

              var $fr = $('.tandem_360_new_frames_field:checked');
              var last = $fr.eq(0).val();
              var first = $fr.eq(0).val();

              var hottitle = $('#tandem_360_new_hot_title_field').val();
              var desc = tinyMCE.get('tandem_360_new_hot_desc_field').getContent();
              var xx = $('#tandem_360_new_hot_x_field').val();
              var yy = $('#tandem_360_new_hot_y_field').val();
              var zz = $('#tandem_360_new_hot_z_field').val();
              var classs = $('#tandem_360_new_hot_class_field').val();

              $fr.each(function(i,el){
                  el = $(el);
                  frames2.push(el.val());
                  if(last < el.val() - 1 || i == $fr.length - 1){

                      var maxi = i-1;
                      if(i == $fr.length - 1)
                          maxi = i;

                      if(maxi == i && last < el.val() - 1){
                          var bounds = {
                            'min':first,
                            'max':$fr.eq(maxi - 1).val()
                          };

                          frames.push(bounds);
                          first = el.val();
                      }

                      var bounds = {
                        'min':first,
                        'max':$fr.eq(maxi).val()
                      };

                      frames.push(bounds);
                      first = el.val();
                  }

                  last = el.val();
              });

              var new_hotspot = {
                  'title':hottitle,
                  'desc':desc,
                  'x':xx,
                  'y':yy,
                  'z':zz,
                  'frames': frames,
                  'allFrames': frames2,
                  'extraclass': classs
              };

              hotspots.push(new_hotspot);

              render_hotspots_admin();

              $('#ad_spot_wrap').fadeOut(600);
          });


    $('#close_tandem_360').click(function(e){
        e.preventDefault();
        $('#ad_spot_wrap').fadeOut(600);
    });
});


function render_hotspots_admin(){
  jQuery('#hotspots').html('');
      var html = '<table width="100%" cellpadding="10">';
      for(var i = 0; i < hotspots.length; i++){
          html += '<tr><td>'+hotspots[i].title+'</td><td class="tandem360buttons"><a href="#" onClick="edit_hotspot('+i+'); return false;" class="button button-primary">Redaguoti</a><a href="#" onClick="delete_hotspot('+i+'); return false;" class="button button-secondary">Trinti</a></td></tr>';
      }
      html += '</table>';

      jQuery('#tandem_360_alll_hotspots_field').val(JSON.stringify(hotspots));
      jQuery('#hotspots').append(html);
  }

 function delete_hotspot(i){
      hotspots.splice(i, 1);
      render_hotspots_admin();
  }

function edit_hotspot(i){
      jQuery('#tandem_360_new_hot_title_field').val(hotspots[i].title);
      tinyMCE.get('tandem_360_new_hot_desc_field').setContent(hotspots[i].desc);
      jQuery('#tandem_360_new_hot_x_field').val(hotspots[i].x);
      jQuery('#tandem_360_new_hot_y_field').val(hotspots[i].y);
      jQuery('#tandem_360_new_hot_z_field').val(hotspots[i].z);
      jQuery('#tandem_360_new_hot_class_field').val(hotspots[i].extraclass);

        jQuery('.tandem_360_new_frames_field').each(function(a,el){
            el = jQuery(el);

            var ind = hotspots[i].allFrames.indexOf(el.val());

            if(ind > -1){
               el.prop('checked', true);
            }else{
               el.prop('checked', false);
            }
        });

    jQuery('#ad_spot_wrap').fadeIn(600);
    jQuery('#add_hotspot_row').hide();
    jQuery('#save_hotspot_row').data('ii',i).show();
  }
