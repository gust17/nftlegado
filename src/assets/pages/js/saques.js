$(document).ready(function(){

    $("[name^='valor_']").maskMoney({allowNegative: true, thousands:'', decimal:'.', affixesStay: false});

    $(document).on('click', '.select_account', function(){
        
        let account = $(this).attr('data-account');

        $('[name="conta"]').val(account);
        $('[name="submit"]').removeAttr('disabled');
    });

    $('.countdown').each(function(){

        let _this = this;
        let data_final = $(_this).attr('data-final');

        $(_this).countdown(data_final, function(event) {
            $(this).html(event.strftime('%D '+__TRANS_DIAS__+' %H:%M:%S'));
        });
    });
});