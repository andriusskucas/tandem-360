<?php

function display_tandem_360_object($id){
    $output = '';
    $args3 = array(
        'posts_per_page' => '1',
        'post_type'   => 'tandem_360',
        'id' => $id
      );


    $qa = new WP_Query($args3);


    if ($qa->have_posts()) {
        while ($qa->have_posts()) { $qa->the_post();

            $images = get_post_meta( $id, 'tandem_360_images_field', true );
            if($images){

                $images = str_replace("'",'"',$images);
                $images = json_decode ($images);
                $speed = get_post_meta( $id, 'tandem_360_speed_field', true );
                $onclick = get_post_meta( $id, 'tandem_360_startonclick_field', true );
                $frames = get_post_meta( $id, 'tandem_360_frames_field', true );
                $autostart = get_post_meta( $id, 'tandem_360_autostart_field', true );
                $main_rotate = get_post_meta( $id, 'tandem_360_hot_angle_field', true );

                $turnhotspots = get_post_meta( $id, 'tandem_360_turnonhotspots_field', true );

                $titles = '';
                $titlesar = array();
                $count = 0;
                foreach($images as $img){
                    if($count++ != 0) $titles .= ',';
                    $titles .= $img->image_url;
                    $titlesar[] = $img->image_url;
                }
                $hotspots = '';
                if($turnhotspots){
                    $hotspots = str_replace('"',"'",get_post_meta( $id, 'tandem_360_alll_hotspots_field', true ));
                }


                $output = '<div class="tandem-360-wrapper">
                    <img class="tandem-360-reel" id="tandem-360-'.$id.'" src="'.$images[0]->image_url.'"
                    data-images="'.$titles.'"
                    data-speed="'.$speed.'"
                    data-playonclick="'.$onclick.'"
                    data-hotspots="'.$hotspots.'"
                    data-frames="'.$frames.'"
                    data-autostart="'.$autostart.'"
                    data-mainrotate="'.$main_rotate.'"
                    data-allowhotspots="'.$turnhotspots.'"
                    data-wheelable="true"
                    alt="'.get_the_title().'" />
                </div>';


            }else{
                $output = __('Objektas nerastas','tandem');
            }

        }
     }else{
        $output = __('Objektas nerastas','tandem');
    }
    wp_reset_query();

    return $output;
}
