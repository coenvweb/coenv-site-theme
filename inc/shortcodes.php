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

// column (grid) shortcode
function my_column($params,$content=null){
  extract(shortcode_atts(array(
      'type' => '',
      'link' => ''
  ), $params));
  $prefix = null; $suffix = null;
  if(!empty($link)){
    $output =  '<a href="' . $link . '" class="column '.$type.'">' . do_shortcode($content) . '</a>';
  } else {
    $output =  '<div class="column '.$type.'">' . do_shortcode($content) . '</div>';
  }
  return $output;
}
add_shortcode("column", "my_column");


// inline right sidebar shortcode - start
function uwenvironment_inline_sidebar_start() {
  $output = "<div class=\"sidebar-right-inline\">";
  return $output;
}
add_shortcode("sidebar-start", "uwenvironment_inline_sidebar_start");

// sidebar item - start
function uwenvironment_inline_sidebar_item_start() {
  $output = "<div class=\"sidebar-inline-item\">";
  return $output;

}
add_shortcode("sidebar-item-start", "uwenvironment_inline_sidebar_item_start");

// sidebar item - end
function uwenvironment_inline_sidebar_item_end() {

  $output = "</div>";
  return $output;

}
add_shortcode("sidebar-item-end", "uwenvironment_inline_sidebar_item_end");


// inline right sidebar shortcode - end
function uwenvironment_inline_sidebar_end() {
  $output = "</div>";
  return $output;

}
add_shortcode("sidebar-end", "uwenvironment_inline_sidebar_end");

function uwenvironment_datawrapper_embed( $atts = array() ) {
  $a = shortcode_atts( array(
      'dwid' => null,
      'dwtitle' => null,
      'dwwidth' => '600',
      'dwheight' => '781',  // default height if not provided
      'dwcharttype' => 'Donut Graph'
  ), $atts );

  // Check for required attributes
  if ( !$a['dwid'] ) {
      return 'Error: Missing data wrapper ID (dwid).';
  }

  // Sanitize inputs
  $a['dwid'] = sanitize_text_field( $a['dwid'] );
  $a['dwtitle'] = sanitize_text_field( $a['dwtitle'] );
  $a['dwcharttype'] = sanitize_text_field( $a['dwcharttype'] );
  $a['dwwidth'] = intval( $a['dwwidth'] );  // Ensure width is an integer
  $a['dwheight'] = intval( $a['dwheight'] ); // Ensure height is an integer

  // Generate iframe output
 
  $output = '<iframe id="datawrapper-chart-' . $a['dwid'] . '" style="border: none;" src="https://datawrapper.dwcdn.net/' . $a['dwid'] . '/1/" frameborder="0" scrolling="no" aria-label="' . esc_attr( $a['dwcharttype'] ) . '" data-external="1" alt="' .  esc_attr( $a['dwcharttype'] ) . '" width="' .  esc_attr( $a['dwwidth'] ) . '" height="' . esc_attr( $a['dwheight'] ) . '"></iframe>';


return $output;
}
add_shortcode('datawrap', 'uwenvironment_datawrapper_embed');