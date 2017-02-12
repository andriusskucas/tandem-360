<?php

// declaring list of columns to show
add_filter("manage_edit-tandem_360_columns", "tandem_360_edit_columns");
function tandem_360_edit_columns($columns){
   $columns = array(
                    "cb" => '<input type="checkbox" />',
                    "photo" => __("Objektas",'tandem'),
                    "title" => __("Pavadinimas",'tandem'),
                    "shortcode" => __("Atvaizdavimo kodas",'tandem')

                   );

   return $columns;
}


//declaring how every column is visualised
add_action("manage_tandem_360_posts_custom_column",  "tandem_360_custom_columns");
function tandem_360_custom_columns($column){
  global $post;
  switch ($column){
     case "photo":
          $images = get_post_meta($post->ID, 'tandem_360_images_field', true);

          if($images != ''){
              $images = str_replace("'",'"',$images);
              $images = json_decode($images);
          }

         echo '<img src="'.$images[0]->image_thumb.'" style="width:150px;">';
     break;
      case "shortcode":
          echo '[tandem-360 id="'.$post->ID.'"]';
    break;
  }
}
