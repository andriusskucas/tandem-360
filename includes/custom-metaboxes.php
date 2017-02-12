<?php

// declaring all metaboxes for tandem 360 plugin
add_action( 'add_meta_boxes', 'add_tandem_360_metaboxes' );
function add_tandem_360_metaboxes() {

    add_meta_box('tandem_360_shortcode_box', __('Objekto atvaizdavimas puslapyje','tandem'), 'tandem_360_shortcode_box', 'tandem_360', 'normal', 'default');

    add_meta_box('tandem_360_images_options', __('Objekto atvaizdavimo nustatymai','tandem'), 'tandem_360_images_options', 'tandem_360', 'normal', 'default');
	add_meta_box('tandem_360_images', __('Objekto nuotraukos','tandem'), 'tandem_360_images', 'tandem_360', 'normal', 'default');
    add_meta_box('tandem_360_hotspots', __('Objekto Interaktyvūs taškai','tandem'), 'tandem_360_hotspots', 'tandem_360', 'normal', 'default');
}

function tandem_360_shortcode_box(){
    global $post;
    $images = get_post_meta($post->ID, 'tandem_360_images_field', true);

    if(!$images){
        _e('Norėdami atvaizduoti objektą Puslapyje pirma įkelkite objekto nuotraukas.','tandem');
        return;
    }

    echo __('Norėdami atvaizduoti objektą puslapyje, jo turinyje įdėkite:','tandem').' ';
    echo '[tandem-360 id="'.$post->ID.'"]';
}



function tandem_360_images_options() {
	global $post;

	// Get the location data if its already been entered
	$autoStart = get_post_meta($post->ID, 'tandem_360_autostart_field', true);
    $startOnClick = get_post_meta($post->ID, 'tandem_360_startonclick_field', true);
    $frames = get_post_meta($post->ID, 'tandem_360_frames_field', true);
    $speed = get_post_meta($post->ID, 'tandem_360_speed_field', true);

    // Declaring defoult values
    if(!$frames) $frames = 40;
    if(!$speed) $speed = 0.5;

	// Echo out the field

    echo '<p><label><input type="checkbox" name="tandem_360_autostart_field" value="1" '.($autoStart?'checked':'').'>'.__('Paleisti automatiškai','tandem').'</label><br></p>';
    echo '<p><label><input type="checkbox" name="tandem_360_startonclick_field" value="1"'.($startOnClick?'checked':'').'>'.__('Užkrauti paspaudus ant nuotraukos','tandem').'</label><br></p>';
    echo '<p>'.__('Kadrų skaičius','tandem').'<br><input type="number" name="tandem_360_frames_field" id="tandem_360_frames_field" value="' . $frames  . '" class="widefat" /></p>';
    echo '<p>'.__('Greitis','tandem').'<br><input type="number" step = "0.1" name="tandem_360_speed_field" id="tandem_360_speed_field" value="' . $speed  . '" class="widefat" /></p>';

}

// function to display object images selection field
function tandem_360_images() {
	global $post;

	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="tandem_360_images_noncename" id="tandem_360_images_noncename" value="' .wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	// Get the location data if its already been entered
	$images = get_post_meta($post->ID, 'tandem_360_images_field', true);
	$images = str_replace('"',"'",$images);
	// Echo out the field
	echo '<input type="hidden" name="tandem_360_images_field" id="tandem_360_images_field" value="' . $images  . '" class="widefat" />';
    ?>
        <div id="selected_360_images">
            <?php

            if($images){
                $images = str_replace("'",'"',$images);
                $images = json_decode ($images);
                foreach($images as $image){
                    echo '<img src="'.$image->image_thumb.'" style="margin:10px;"/>';
                }
            }
            ?>
        </div>
    <?php
    echo '<a href="#" id="add_btnn" class="button button-primary button-large" >+ '.__('Pasirinlti nuotraukas','tandem').'</a>';
}


function tandem_360_hotspots(){
    global $post;
    $frames = get_post_meta($post->ID, 'tandem_360_frames_field', true);
    $images = get_post_meta($post->ID, 'tandem_360_images_field', true);
    // only continue if frames and images variables are set
    if(!$frames || !$images){
        _e('Norėdami pridėti aktyvius taškus pirmiausia pridėkite nuotraukas įveskite ir nurodykite kadrų skaičių ir išsaugokite.');
        return;
    }

    // get variables
    $turnOnHotsposts = get_post_meta($post->ID, 'tandem_360_turnonhotspots_field', true);
    $hotAngle = get_post_meta($post->ID, 'tandem_360_hot_angle_field', true);
    $alll_hotspots = get_post_meta($post->ID, 'tandem_360_alll_hotspots_field', true);

    // set defaults for variables
    if(!$hotAngle) $hotAngle = -9;

    echo '<p><label><input type="checkbox" name="tandem_360_turnonhotspots_field" value="1" '.($turnOnHotsposts?'checked':'').'>'.__('Įjungti aktyvius taškus','tandem').'</label><br></p>';

    echo '<p>'.__('Plokštumos kampas','tandem').'<br><input type="number" name="tandem_360_hot_angle_field" min="-360" max="360" id="tandem_360_hot_angle_field" value="' . $hotAngle  . '" class="widefat" /></p>';

    $alll_hotspots = str_replace('"',"'",$alll_hotspots);
    echo '<p>'.__('Aktyvių taškų kodas:','tandem').'<input type="text" class="widefat" name="tandem_360_alll_hotspots_field" id="tandem_360_alll_hotspots_field" value="' . $alll_hotspots  . '" /></p>';
    ?>

    <h2 class="hndle"><?php _e('Aktyvūs taškai','tandem') ?></h2>
    <div id="hotspots">
        <?php
            if($alll_hotspots){
                $alll_hotspots = str_replace("'",'"',$alll_hotspots);
                $alll_hotspots = json_decode($alll_hotspots);
                echo '<table width="100%" cellpadding="10">';
                $count = 0;
                foreach($alll_hotspots as $hotspot){
                        echo '<tr><td>'.$hotspot->title.'</td><td class="tandem360buttons"><a href="#" onClick="edit_hotspot('.$count.'); return false;" class="button button-primary">Redaguoti</a><a href="#" onClick="delete_hotspot('.$count++.'); return false;" class="button button-secondary">Trinti</a></td></tr>';
                }
                echo '</table>';
            }
        ?>
    </div>
    <?php
         echo '<a href="#" id="add_hotspot" class="button button-primary button-large" >
                + '.__('Pridėti aktyvų tašką','tandem').'
                </a>';
    ?>
    <div id="ad_spot_wrap">
        <div class="hot_inner">
           <a href="#" id="close_tandem_360">+</a>
            <?php
                echo '<p>'.__('Pavadinimas','tandem').'<br><input type="text" name="tandem_360_new_hot_title_field" id="tandem_360_new_hot_title_field" value="" class="widefat" /></p>';
                $settings = array(
                            'textarea_name' => 'labuka',
                            'editor_class' => 'reel'
                         );
                wp_editor('', 'tandem_360_new_hot_desc_field', $settings );

                echo '<p>'.__('X pozicija:','tandem').'<br><input type="text" name="tandem_360_new_hot_x_field" id="tandem_360_new_hot_x_field" value="" class="widefat" /></p>';

                echo '<p>'.__('Y pozicija:','tandem').'<br><input type="text" name="tandem_360_new_hot_y_field" id="tandem_360_new_hot_y_field" value="" class="widefat" /></p>';

                echo '<p>'.__('Z pozicija:','tandem').'<br><input type="text" name="tandem_360_new_hot_z_field" id="tandem_360_new_hot_z_field" value="" class="widefat" /></p>';

                echo '<p>'.__('Papildoma CSS klasė:','tandem').'<br><input type="text" name="tandem_360_new_hot_class_field" id="tandem_360_new_hot_class_field" value="" class="widefat" /></p>';


                echo '<p>';
                    for($i = 1; $i <= get_post_meta($post->ID, 'tandem_360_frames_field', true); $i++)
                        echo '<label class="tandem_360_new_frames_field_label"><input class="tandem_360_new_frames_field" name="tandem_360_new_frames_field[]" type="checkbox" value="'.$i.'" />'.$i.'</label>';
                echo '</p>';


                echo '<a href="#" id="add_hotspot_row" class="button button-primary button-large" >
                '.__('Pridėti','tandem').'
                </a>';

                echo '<a href="#" id="save_hotspot_row" class="button button-primary button-large" style="display:none;" >
                '.__('Saugoti','tandem').'
                </a>';
            ?>
        </div>
    </div>
    <script type="text/javascript">
        <?php
            if($alll_hotspots){
                echo 'var hotspots = '.json_encode($alll_hotspots).';';
            }else{
                echo 'var hotspots = new Array();';
            }
        ?>
    </script>
    <?php
}



function add_tandem_360_metaboxes_save($post_id, $post) {

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['tandem_360_images_noncename'], plugin_basename(__FILE__) )) {
	   return $post->ID;
	}

	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;

	$tandem_360_meta['tandem_360_images_field'] = $_POST['tandem_360_images_field'];
    $tandem_360_meta['tandem_360_autostart_field'] = $_POST['tandem_360_autostart_field'];
    $tandem_360_meta['tandem_360_startonclick_field'] = $_POST['tandem_360_startonclick_field'];
    $tandem_360_meta['tandem_360_frames_field'] = $_POST['tandem_360_frames_field'];
    $tandem_360_meta['tandem_360_speed_field'] = $_POST['tandem_360_speed_field'];
    $tandem_360_meta['tandem_360_alll_hotspots_field'] = $_POST['tandem_360_alll_hotspots_field'];

    $tandem_360_meta['tandem_360_hot_angle_field'] = $_POST['tandem_360_hot_angle_field'];
    $tandem_360_meta['tandem_360_turnonhotspots_field'] = $_POST['tandem_360_turnonhotspots_field'];


	foreach ($tandem_360_meta as $key => $value) { // Cycle through the $events_meta array!
		if( $post->post_type == 'revision' ) return; // Don't store custom data twice
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}

}

add_action('save_post', 'add_tandem_360_metaboxes_save', 1, 2); // save the custom fields
