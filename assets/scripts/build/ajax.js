//career Ajax Filtering
jQuery(function($)
{
    //Load posts on document ready
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
            
        } else {
            $(this).addClass('selected');
        }
        
        $(this).change();
    });
    
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
        console.log(sortValue);
        return sortValue;
    }
    
    $('.filter-crumbs .selected').live('click', function(){
        var crumbVal = $(this).val();
        var preClass = '.term_id_';
        crumbVal = preClass+crumbVal;
        $(crumbVal).removeClass('selected');
        ajax_get_posts();
    });
 
    //If input is changed, load posts
    $('.ajax-filters, .filter-crumbs').change( function(){
        ajax_get_posts(); //Load Posts
    });
 
    //Find Selected careers
    function getSelectedcareers()
    {
        var careers = []; //Setup empty array
 
        $(".ajax-filters li .selected").each(function() {
            var val = $(this).val();
            careers.push(val); //Push value onto array
        });
        console.log(careers);
        return careers; //Return all of the selected careers in an array
    }
 
    //Fire ajax request when typing in search
    $('#career-search input.text-search').live('keyup', function(e){
        if( e.keyCode == 27 )
        {
            $(this).val(''); //If 'escape' was pressed, clear value
        }
 
        ajax_get_posts(); //Load Posts
    });
 
    $('#submit-search').live('click', function(e){
        e.preventDefault();
        ajax_get_posts(); //Load Posts
    });
 
    //Get Search Form Values
    function getSearchValue()
    {
        var searchValue = $('#career-search input.text-search').val(); //Get search form text input value
        return searchValue;
    }
 
    //If pagination is clicked, load correct posts
    $('.career-filter-navigation a').live('click', function(e){
        e.preventDefault();
 
        var url = $(this).attr('href'); //Grab the URL destination as a string
        var paged = url.split('&paged='); //Split the string at the occurance of &paged=
 
        ajax_get_posts(paged[1]); //Load Posts (feed in paged value)
    });
 
    //Main ajax function
    function ajax_get_posts(paged)
    {
        var paged_value = paged; //Store the paged value if it's being sent through when the function is called
        var ajax_url = ajax_career_params.ajax_url; //Get ajax url (added through wp_localize_script)
 
        $.ajax({
            type: 'GET',
            url: ajax_career_params.ajax_url,
            data: {
                action: 'careers_filter',
                careers: getSelectedcareers, //Get array of values from previous function
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
            },
            error: function()
            {
                                //If an ajax error has occured, do something here...
                $("#results").html('<p>There has been an error</p>');
            }
        });
    }
 
});
