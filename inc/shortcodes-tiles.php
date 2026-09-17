<?php

function tile_func($atts, $content = null) {
  $attributes = shortcode_atts( array(
      'id' => '',
      'ids' => '',
      'columns' => '',
  ), $atts);

  $selected_ids = $attributes['ids'] ? $attributes['ids'] : $attributes['id'];
  $tilecols = '';

if($selected_ids) {
      $ids = explode(',', $selected_ids);
      $tiles_acf = get_field('tiles');
      $tiles = array();
      foreach($ids as $id) {
          $id = (int) trim($id) - 1;
          if(isset($tiles_acf[$id])) {
              $tiles[] = $tiles_acf[$id];
          }
      }
} else {
    $tiles = get_field('tiles', get_the_ID());
}

if (!is_array($tiles)) {
  $tiles = array();
}

$columns_attr = trim((string) $attributes['columns']);

if ($columns_attr !== '') {
  $tilecols = " cols-" . esc_attr($columns_attr);
} elseif (count($tiles) === 2) {
  $tilecols = ' cols-2';
}

  $output = '<div class="tiles-container' . $tilecols . '">';
      if($tiles) {
          foreach($tiles as $tile) {
            $tile_link = '';
            $tile_target = '';
            $tile_rel = '';

            if (!empty($tile['link'])) {
              if (is_array($tile['link'])) {
                if (!empty($tile['link']['url'])) {
                  $tile_link = $tile['link']['url'];
                }
                if (!empty($tile['link']['target'])) {
                  $tile_target = $tile['link']['target'];
                }
              } else {
                $tile_link = $tile['link'];
              }
            }

            if ($tile_target === '_blank') {
              $tile_rel = ' rel="noopener noreferrer"';
            }

            $output .= "<div class='page-tile'>";
              if($tile_link) {
                $output .= '<a class="tile-link" href="' . esc_url($tile_link) . '"' . ($tile_target ? ' target="' . esc_attr($tile_target) . '"' : '') . $tile_rel . '>';
              } else {
                $output .= '<div class="tile-link tile-link--static">';
              }

                if($tile['image']) {
                  $image = $tile['image'];
                  $output .= '<div class="image-wrap"><img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" /></div>';
                }

                $output .= '<div class="content-wrap">';

                  $output .= "<p class='title'>" . esc_html($tile['title']) . "</p>";

                  if($tile['subtext']) {
                    $output .= "<div class='body'>" . wp_kses_post($tile['subtext']) . "</div>";
                  }

                $output .= "</div>";

                if($tile_link) {
                  $output .= '</a>';
                } else {
                  $output .= '</div>';
                }

                $output .= "</div>";

          }
      }
      
  $output .= '</div>';
  return $output;
}
add_shortcode('tiles', 'tile_func');

?>