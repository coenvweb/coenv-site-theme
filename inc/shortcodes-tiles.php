<?php

function tile_func($atts, $content = null) {
  $attributes = shortcode_atts( array(
      'ids' => '',
      'columns' => '3',
  ), $atts);

if($attributes['ids']) {
  $tiles = array($tiles[$attributes['ids']]);
      $ids = explode(',', $attributes['ids']);
      $tiles_acf = get_field('tiles');
      $tiles = array();
      foreach($ids as $id) {
          $id = $id - 1;
          if($tiles_acf[$id]) {
              $tiles[] = $tiles_acf[$id];
          }
      }
} else {
    $tiles = get_field('tiles', get_the_ID());
  }

  $output = '<div class="tiles-container cols-' . esc_attr($attributes['columns']) . '">';
      if($tiles)  {
          foreach($tiles as $tile) {

            $output .= "<div class='page-tile'>";
              if($tile['link']) {
                $output .= '<a class="tile-link" href="'.$tile['link'].'" >';
              }

                if($tile['image']) {
                  $image = $tile['image'];
                  $output .= '<div class="image-wrap"><img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" /></div>';
                }

                $output .= '<div class="content-wrap">';

                  $output .= "<h3 class='title'>".$tile['title']."</h3>";

                  if($tile['subtext']) {
                    $output .= "<div class='body'>".$tile['subtext']."</div>";
                  }

                $output .= "</div>";

                if($tile['link']) {
                  $output .= '</a>';
                }

                $output .= "</div>";

          }
      }
      
  $output .= '</div>';
  return $output;
}
add_shortcode('tiles', 'tile_func');

?>