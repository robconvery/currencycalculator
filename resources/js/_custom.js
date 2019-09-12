var receiveTimer;

$( document ).ready(function() {

    function getCurrency(ele)
    {
        clearInterval(receiveTimer);

        let id = $(ele).attr('id');

        /*$('#message').html('Please wait...')*/

        switch(id) {

            case 'currency_value_b':

                var mcode = '#currency_select_b option:selected'
                var mvalue = '#currency_value_b'
                var scode = '#currency_select_a option:selected'
                var svalue = '#currency_value_a'
                break;

            default:

                var mcode = '#currency_select_a option:selected'
                var mvalue = '#currency_value_a'
                var scode = '#currency_select_b option:selected'
                var svalue = '#currency_value_b'

        }

        $.ajax({
            type: "POST",
            url: '/calculate',
            data: {
                _token: function(){
                    return $('meta[name="csrf-token"]').attr('content')
                },
                currency_select_a: function(){
                    return $(mcode).val()
                },
                currency_value_a: function(){
                    return $(mvalue).val()
                },
                currency_select_b: function(){
                    return $(scode).val()
                },
                currency_value_b: function(){
                    return $(svalue).val()
                }
            },
            success: function(response) {

                $(mvalue).val(response.master_value);
                $(svalue).val(response.secondary_value);

                let a = $('#currency_value_a').val() + ' ' +  $('#currency_select_a option:selected').text() + ' equals ';

                let b =  $('#currency_value_b').val() + ' ' +  $('#currency_select_b option:selected').text()

                $('#message-a').html(document.createTextNode(a));
                $('#message-b').html(document.createTextNode(b));
            }
        });
    }

    $('.currency-select').change(function(e){
        e.stopPropagation();
        e.preventDefault();
        let self = this;
        receiveTimer = setInterval(getCurrency(self), 3000);
    });

    $('.currency-value').on('change blur', function(e){
        e.stopPropagation();
        e.preventDefault();
        let self = this;
        receiveTimer = setInterval(getCurrency(self), 3000);
    });

    /*console.info('READY');*/

});
