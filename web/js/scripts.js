/**
 * Created by mohammed on 07/02/15.
 */
$(document).ready(function () {
    $('.home-search-form .dropdown-menu a').click(function (e) {
        e.preventDefault();
        $(this).closest('.input-group-btn').find('.btn .text').text($(this).html());
        $('#search_in').val($(this).attr('value'));
    });


    $("a.gallery").fancybox({
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'speedIn': 600,
        'speedOut': 200,
        'overlayShow': false,
        beforeShow: function () {
            this.maxWidth = 800;
            this.maxHeight = 500;
        }
    });

});
