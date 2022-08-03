$(document).ready(function(){

    $(document).on('click', '.renovarContrato', function(){

        let id_plano = $(this).attr('data-id');

        Swal.fire({
            title: __TRANS_RENOVAR_CONTRATO_TITLE__,
            html: __TRANS_RENOVAR_CONTRATO_DESC__,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: __TRANS_RENOVAR_CONTRATO_CONFIRM__,
            cancelButtonText: __TRANS_RENOVAR_CONTRATO_CANCEL__
          }).then((result) => {
              
            if (result.isConfirmed) {

                $.ajax({
                    url: baseURL+'ajax/renovation_contract',
                    type: 'POST',
                    data: {id:id_plano},
                    dataType: 'json',

                    success: function(callback){

                        if(callback.status == 1){

                            createNotification(__TRANS_SUCESSO__, __TRANS_RENOVAR_OK__, 'check', 'success');

                        }else{
                            createNotification(__TRANS_ERRO__, __TRANS_RENOVAR_ERRO__+' '+callback.error, 'times', 'danger');
                        }

                        setTimeout(function(){
                            window.location.reload(1);
                         }, 2000);
                    },

                    error: function(message){

                        console.log(message.responseText);
                    }
                });
            }
        });

    });
});