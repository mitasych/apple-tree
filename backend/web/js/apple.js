$(document).ready(function () {

    let eatModalId = '#eatModal';
        let appleGridWrapper = '#apples-wrapper'

    $(document).on('click', '.eat-btn', function (e) {
        e.preventDefault();

        let url = $(this).attr('href');

        $.ajax({
            url: url,
            dataType: 'html',
            success: function (html) {
                $(eatModalId).find('.modal-body').html(html);
                $(eatModalId).modal('show');
            }
        });

        return false;
    })

    $(document).on('click', eatModalId + ' button[type=submit]', function (e) {
        e.preventDefault();

        let eatForm = $(this).parents('form');

        $.ajax({
            type: eatForm.attr('method'),
            url: eatForm.attr('action'),
            data: eatForm.serialize(),
            dataType: 'html',
            success: function (html) {
                if (html == 'success') {
                    $(eatModalId).modal('hide');
                    $.pjax.reload({container: appleGridWrapper});
                }
                else {
                    $(eatModalId).find('.modal-body').html(html);
                }
            }
        });

        return false;
    })

    $(document).on('click', '.fall-btn', function (e) {
        e.preventDefault();

        let url = $(this).attr('href');

        $.ajax({
            url: url,
            dataType: 'json',
            success: function (response) {
                $.pjax.reload({container: appleGridWrapper});
            }
        });

        return false;
    })

    $(eatModalId).on('hidden.bs.modal', function (e) {
        $(this).find('.modal-body').empty();
    })

    setInterval(function(){
        $.pjax.reload({container: appleGridWrapper});
    }, 30000);
});