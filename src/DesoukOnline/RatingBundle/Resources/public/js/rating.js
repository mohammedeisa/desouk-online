$(document).ready(function () {
    $(".ratings_stars").on({
        mouseenter: function () {
            $(this).prevAll().andSelf().addClass('glyphicon-star');
            $(this).prevAll().andSelf().removeClass('glyphicon-star-empty');
        },
        mouseleave: function () {
            $(this).prevAll().andSelf().each(function () {
                if (!$(this).hasClass('permanent-star')) {
                    $(this).removeClass('glyphicon-star');
                    $(this).addClass('glyphicon-star-empty');
                }
            });
        }
    });

//send ajax request to rate.php
    $('.ratings_stars').bind('click', function () {
        var id = $(this).parent().attr("id");
        var num = $(this).attr("class");
        $.ajax({
            url: Routing.generate('desouk_online_vote'),
            cache: 0,
            type: 'POST',
            dataType: "html",
            data: {id: id, stars: num},
            success: function (result) {
                document.getElementById(id).innerHTML = result;
            }
        });
    });
    $('.permanent-star').mouseout(function () {
        $(this).prevAll().andSelf().addClass('glyphicon-star');
        $(this).prevAll().andSelf().removeClass('glyphicon-star-empty');
    });
});

        
