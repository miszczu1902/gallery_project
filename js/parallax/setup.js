setTimeout(function () {
    $(document).ready(function () {
        $('*[data-animate]').addClass('hide').each(function () {
            $(this).viewportChecker({
                classToAdd: 'show animated ' + $(this).data('animate'),
                classToRemove: 'hide',
                offset: '10%'
            });
        });

    });
}, 700);
