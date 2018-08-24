jQuery(function ($) {
    $grid = '';

    $(window).on('load', function () {
        $grid = $('.grid').masonry({
            // options
            itemSelector: '.grid-item',
            columnWidth: 10
        });
    });


    $('.load-more-photos').on('click', function (e) {
        e.preventDefault();
        var next_max_id = $(this).data('next');
        //console.log(next_max_id); return;
        $.ajax({
            type: 'POST',
            url: wenInsta.ajaxUrl,
            data: {action: 'wen_get_more_photos', next_max_id: next_max_id},
            beforeSend: function () {

            },
            success: function (response) {
                $items = $(response.items);
                $('.load-more-photos').data('next', response.next_max_id);
                $grid.append($items);
                setTimeout(function () {
                    $grid.masonry('appended', $items);
                }, 800);

            },
            error: function (MLHttpRequest, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    });

});
