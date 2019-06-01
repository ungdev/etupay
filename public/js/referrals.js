$(document).ready(function() {

    $.noty.defaults.theme = 'relax';
    $.noty.defaults.type  = 'success';
    $.noty.defaults.timeout = 2000;

    $('form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $('form').attr('action'),
            method: 'POST',
            data: $('form').serialize(),
        }).done(function(res) {
            noty({ type: res.status, text: res.message });
        });
    });

});
