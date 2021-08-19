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
?>