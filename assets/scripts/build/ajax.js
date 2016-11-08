//career Ajax Filtering
jQuery(function($)
{
    //Load posts on document ready
    careers_get_posts();
 
    //If list item is clicked, trigger input change and add css class
    $('#career-filter li').live('click', function(){
        var input = $(this).find('input');
 
                //Check if clear all was clicked
        if ( $(this).attr('class') == 'clear-all' )
        {
            $('#career-filter li').removeClass('selected').find('input').prop('checked',false); //Clear settings
            careers_get_posts(); //Load Posts
        }
        else if (input.is(':checked'))
        {
            input.prop('checked', false);
            $(this).removeClass('selected');
        } else {
            input.prop('checked', true);
            $(this).addClass('selected');
        }
 
        input.trigger("change");
    });
 
    //If input is changed, load posts
    $('#career-filter input').live('change', function(){
        careers_get_posts(); //Load Posts
    });
 
    //Find Selected careers
    function getSelectedcareers()
    {
        var careers = []; //Setup empty array
 
        $("#career-filter li input:checked").each(function() {
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
 
        careers_get_posts(); //Load Posts
    });
 
    $('#submit-search').live('click', function(e){
        e.preventDefault();
        careers_get_posts(); //Load Posts
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
 
        careers_get_posts(paged[1]); //Load Posts (feed in paged value)
    });
 
    //Main ajax function
    function careers_get_posts(paged)
    {
        var paged_value = paged; //Store the paged value if it's being sent through when the function is called
        var ajax_url = ajax_career_params.ajax_url; //Get ajax url (added through wp_localize_script)
 
        $.ajax({
            type: 'GET',
            url: ajax_career_params.ajax_url,
            data: {
                action: 'careers_filter',
                careers: getSelectedcareers, //Get array of values from previous function
                search: getSearchValue(), //Retrieve search value using function
                paged: paged_value //If paged value is being sent through with function call, store here
            },
            beforeSend: function ()
            {
                //You could show a loader here
            },
            success: function(data)
            {
                //Hide loader here
                $('#career-results').html(data);
            },
            error: function()
            {
                                //If an ajax error has occured, do something here...
                $("#career-results").html('<p>There has been an error</p>');
            }
        });
    }
 
});
