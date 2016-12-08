 if ( $('body').hasClass('page-template-careers') ) { //only run on careers template page

//Universal Ajax Filtering
jQuery(function($)
{
    //Load posts on document ready
    var ignore_scroll = false;
    var count = 2;
    
    ajax_get_posts();
 
    //If list item is clicked, trigger input change and add css class
    $('.ajax-filters .button').live('click', function(){
        var input = $(this).find('input'); //Check if clear all was clicked
        if ( $(this).attr('class') == 'clear-all' )
        {
            $('.ajax-filters .button').removeClass('selected').find('input').prop('checked',false); //Clear settings
            ajax_get_posts(); //Load Posts
        }
        else if ($(this).hasClass('selected') )
        {
            $(this).removeClass('selected');
            count = 2;
            
        } else {
            $(this).addClass('selected');
        }
        
        $(this).change();
    });
    
    // sort your posts and if clicked, make selection selected
    $('.sorter ul li').live('click', function(){
        if (!$(this).hasClass('selected') ) {
            $('.sorter ul li').removeClass('selected');
            $(this).addClass('selected');
            ajax_get_posts();
        }
        
        $(this).change();
    });
    
    //Get Search Form Values
    function getSortValue()
    {
        var sortValue = $('.sorter .selected').data('value'); //Get sorter button value
        return sortValue;
    }
    
    // show breadcrumbs for filtered terms and allow them to be removed by clicking to unselect
    $('.filter-crumbs .selected').live('click', function(){
        var crumbVal = $(this).val();
        var preClass = '.term_id_';
        crumbVal = preClass+crumbVal;
        $(crumbVal).removeClass('selected');
        count = 2;
        ajax_get_posts();
    });
 
    //If input is changed, load posts
    $('.ajax-filters, .filter-crumbs').change( function(){
        count = 2;
        ajax_get_posts(); //Load Posts
    });
 
    //Find Selected terms
    function getSelectedterms()
    {
        var terms = []; //Setup empty array
 
        $(".ajax-filters li .selected").each(function() {
            var val = $(this).val();
            terms.push(val); //Push value onto array
        });
        return terms; //Return all of the selected terms in an array
    }
 
    //Fire ajax request when typing in search
    $('#post-search input.text-search').live('keyup', function(e){
        if( e.keyCode == 27 )
        {
            $(this).val(''); //If 'escape' was pressed, clear value
        }
        count = 2;
        ajax_get_posts(); //Load Posts
    });
    
    // when search filter breadcrumb is clicked on, clear the searchbox
    $('.filter-crumbs .search-filter').live('click', function(){
        $('.search-filter').remove();
        $('#post-search input.text-search').val('');
        count = 2;
        ajax_get_posts();
    });

    $('#submit-search').live('click', function(e){
        e.preventDefault();
        count = 2;
        ajax_get_posts(); //Load Posts
    });
 
    //Get Search Form Values
    function getSearchValue()
    {
        var searchValue = $('#post-search input.text-search').val(); //Get search form text input value
        return searchValue;
    }
 
    //If pagination is clicked, load correct posts
    //$('.pagination a').live('click', function(e){
      //  e.preventDefault();
 
        //var url = $(this).attr('href'); //Grab the URL destination as a string
        //var paged = url.split('&paged='); //Split the string at the occurance of &paged=
 
        //ajax_get_posts(paged[1]); //Load Posts (feed in paged value)
    //});
 
    //Main ajax function
    function ajax_get_posts(paged, infinite)
    {
        var paged_value = paged; //Store the paged value if it's being sent through when the function is called
        var ajax_url = ajax_params.ajax_url; //Get ajax url (added through wp_localize_script)
        var action = $('#results').data('action'); //get wordpress php function for posts - e.g. career-action
        
        if(infinite) {
            $.ajax({
                  url: ajax_params.ajax_url,
                  type:'GET',
                  data: {
                    action: action,
                    terms: getSelectedterms, //Get array of values from previous function
                    search: getSearchValue, //Retrieve search value using function
                    paged: paged_value, //If paged value is being sent through with function call, store here
                    sorter: getSortValue
                  },
                beforeSend: function ()
                {
                    //You could show a loader here
                    $("#results").append('<p class="status">Loading additional results...</p>');
                },
                  success: function(data){
                      $('.status').remove();
                      $("#results").append(data);    // This will be the div where our content will be loaded
                      if (data) ignore_scroll = false;
                  }
              });
            } else {
            
            if (count > 2 ) {
                count = 2;
            }
 
            $.ajax({

                type: 'GET',
                url: ajax_params.ajax_url,
                data: {
                    action: action,
                    terms: getSelectedterms, //Get array of values from previous function
                    search: getSearchValue, //Retrieve search value using function
                    paged: paged_value, //If paged value is being sent through with function call, store here
                    sorter: getSortValue
                },
                beforeSend: function ()
                {
                    //You could show a loader here
                    $("#results").html('<p class="status">Loading results...</p>');
                },
                success: function(data)
                {
                    //Hide loader here
                    $('#results').html(data);
                    if(data == '') {
                        $("#results").html('<p class="status">No results found.</p>');
                    }
                    var total = $('#counter').data('page-count');
                    $(window).scroll(function(){
                        if(ignore_scroll == false && (($('#results').offset().top + $('#results').height()) < ($(window).height() + $(window).scrollTop()))) {
                            if (count > total){
                                return false;
                            }else {
                                ignore_scroll = true;
                                ajax_get_posts(count, true)
                            }
                           count++;
                        }
                    });

                },
                error: function()
                {
                                    //If an ajax error has occured, do something here...
                    $("#results").html('<p>There has been an error</p>');
                }
            });
        };
    }
    
   
});
};
