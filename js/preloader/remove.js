$(function () {

    // sprawdzamy czy plik cookie jest już zapisany w przeglądarce 
    if (jQuery.cookie('webyourself_preloaded') != '1') {

        // jeśli nie

        // tutaj wstawiamy kod naszego preloadera oraz animację
        $('html').addClass('js');
        $(window).load(function () {
            setTimeout(
                function () {
                    $("#loader-wrapper").fadeOut();
                }, 500);
        });


        // a także zapisujemy plik cookie
        $.cookie('webyourself_preloaded', '1', {expires: 2});

    } else {

        // jeśli plik cookie jest już zapisany

        // chowamy warstwę z preloaderem
        $('#preloader').fadeOut();
    }
});