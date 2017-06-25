jQuery(document).ready(function($) {

             //wrapper
    $(".nav-menu .search-field").click(function() {
        if ($(this).siblings('p').hasClass('mycontent')) {
            return;
        }else{
        $(".mycontent").remove();
        }
        if ($(this).siblings('p').hasClass('mycontent')) {
            return;
            } else {
            $('<p class=\"mycontent\"></p>').insertAfter(this);
        }
        $(this).attr('autocomplete', 'off');
        });

    function myAjaxFunction() {             //event

        var query = $(this).val();

      jQuery.ajax({
            type : 'post',
            //dataType: 'json',
            url : my_ajax_obj.ajax_url,
            data : {
                _ajax_nonce: my_ajax_obj.nonce,
                action : 'my_load_search_results',
                query : query
            },
            beforeSend: function() {
            },
            success :
                function(response) {
                if (response == "0") {
                    return;
                } else {
                $(".mycontent").html(response);
            }
        }
        });
        return false;
    }

    $(".nav-menu .search-field").focus(myAjaxFunction);
    $(".nav-menu .search-field").keyup(myAjaxFunction);

    $(".nav-menu .search-field").keyup(myfunction);


        function myfunction() {
        var query = $(this).val();
        if ($(this).val().length == 0) {
            $(".mycontent").css("display", "none");
            console.log(query);
        } else {
            $(".mycontent").css("display", "inline-block");
        }

        $(this).focus(function() {
                $(".mycontent").css("display", "block");
            });
    }
});
