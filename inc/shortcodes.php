<?php
function uwenvironment_trumba_embed( $atts = array() ) {
    $a = shortcode_atts( array(
        'webname' => 'coenveventscalendar',
        'spudtype' => 'main',
        'url' => null,
        'teaserbase' => null,
        'varSpud' => null
    ), $atts );

    if (isset($trumba['varSpud'])) {
        $varSpud = 'var spud = ' . $trumba['varSpud'];
    } else {
        $varSpud = null;
    };
   
    $output = 
      '<div>
        <p style="display: none;"><script type="text/javascript" src="https://www.trumba.com/scripts/spuds.js"></script></p>
        <script type="text/javascript">
          $Trumba.addSpud({
          webName: "\" . ' . $a['webname'] . '",
          spudType : "chooser" });
        ]]></script>
      </div>
      <script type="text/javascript">
        var originalDocumentTitle = document.title;
        function onFetched() {
        // getEventSummary will return an object on event detail and null on calendar view.
        var eventSummary = spud.getEventSummary();
        if (eventSummary) {
          document.title = originalDocumentTitle + ": " + eventSummary.description;
        } else {
        document.title = originalDocumentTitle;}}
          var spudId =$Trumba.addSpud({
          webName:"' . $a['webname'] . '",
          spudType:"' . $a['spudtype'] . '",
          url:{headinglevel: 3}
        });
        var spud = $Trumba.Spuds.controller.getSpudById(spudId);
        spud.container.addEventListener("onFetched", onFetched);
        </script>

        <noscript>Your browser must support JavaScript to view this content.
        Please enable JavaScript in your browser settings then try again.</noscript>';
    return $output;
}
add_shortcode('trumba','uwenvironment_trumba_embed');


function tile_func($atts, $content = null) {
  $attributes = shortcode_atts( array(
      'ids' => '', 
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
    $tiles = get_field('tiles');
  }

  $output = '<div class="tiles-container">';
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

                if($links) {
                  $output .= '</a>';
                }

                $output .= "</div>";

          }
      }
      if(count($tiles) >= 2) {
          $output .= "<div style='clear:both'></div>";
      }
  $output .= '</div>';
  return $output;
}
add_shortcode('tiles', 'tile_func');

?>