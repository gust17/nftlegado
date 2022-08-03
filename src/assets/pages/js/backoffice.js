$(document).ready(function(){

    if(typeof $('.modal-aviso')[0] !== undefined){
        
        $('.modal-aviso').modal('show');
    }

    $(document).on('click', '.copiarLink', function(){

        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($('#linkIndicacao').val()).select();
        document.execCommand("copy");
        $temp.remove();

        // Swal.fire('Copiado!', 'Link de indicação copiado com sucesso!', 'success');

        createNotification(__TRANS_LINK_COPIED_TITLE__, __TRANS_LINK_COPIED__, '', 'success');

    });

    if(paymentBusinessDay == 1){
        var daysINeed = [1,2,3,4,5];
    }else{
        var daysINeed = [0,1,2,3,4,5,6];
    }

    function isThisInFuture(targetDayNum) {
        
    const todayNum = moment().isoWeekday();  

    if (todayNum <= targetDayNum) { 
        return moment().isoWeekday(targetDayNum);
    }
    return false;
    }

    function findNextInstanceInDaysArray(daysArray) {
        
        const tests = daysINeed.map(isThisInFuture);

        const thisWeek = tests.find((sample) => {return sample instanceof moment});

        return thisWeek || moment().add(1, 'weeks').isoWeekday(daysINeed[0]);
    }
    let nextDayMoment = findNextInstanceInDaysArray(daysINeed);

    let newDateConfig = nextDayMoment.format("YYYY/MM/DD") + ' '+horaRendimento; 

    $("#proximo_rendimento")
    .countdown(newDateConfig, function(event) {

    let configTime  = '<div class="text-white pr-3 pl-3">';
        configTime += '<small class="m-0 text-white" style="display:inline; color:white;">%D dia(s) </small>';
        configTime += '<small class="m-0 text-white" style="display:inline; color:white;">%Hh</small>';
        configTime += '<small class="m-0 text-white" style="display:inline; color:white;">%Mm</small>';
        configTime += '<small class="m-0 text-white" style="display:inline; color:white;">%Ss</small>';
        configTime += '</div>';

        $(this).html(
            event.strftime(configTime)
        );
    });

    // var tour = new Tour({
    //     name: 'TourLocalHost1',
    //     template: "<div class='popover tour'>\
    //     <div class='arrow'></div>\
    //     <h3 class='popover-title'></h3>\
    //     <div class='popover-content'></div>\
    //     <div class='popover-navigation'>\
    //       <button class='btn btn-default' data-role='prev'>"+__TRANS_TOUR_ANTER__+"</button>\
    //       <button class='btn btn-default' data-role='next'>"+__TRANS_TOUR_PROX__+"</button>\
    //       <button class='btn btn-default' data-role='end'>"+__TRANS_TOUR_ENCERRAR__+"</button>\
    //     </div>\
    //     </div>",
    //     steps: [
    //     {
    //       element: ".menuTour",
    //       title: __TRANS_TOUR_MENU_NAVEGACAO_TITLE__,
    //       content: __TRANS_TOUR_MENU_NAVEGACAO_CONTENT__,
    //       placement: 'right',
    //       backdrop: true
    //     },
    //     {
    //       element: ".notificacaoTour",
    //       title: __TRANS_TOUR_MINHAS_NOTIFICACOES_TITLE__,
    //       content: __TRANS_TOUR_MINHAS_NOTIFICACOES_CONTENT__,
    //       placement: 'bottom',
    //       backdrop: true
    //     },
    //     {
    //       element: ".copiarLink",
    //       title: __TRANS_TOUR_LINK_INDICACAO_TITLE__,
    //       content: __TRANS_TOUR_LINK_INDICACAO_CONTENT__,
    //       placement: 'bottom',
    //       backdrop: true
    //     },
    //     {
    //       element: ".proximoRendimento",
    //       title: __TRANS_TOUR_PROXIMO_RENDIMENTO_TITLE__,
    //       content: __TRANS_TOUR_PROXIMO_RENDIMENTO_CONTENT__,
    //       placement: 'left',
    //       backdrop: true
    //     },
    //     {
    //       element: ".saldoRendimento",
    //       title: __TRANS_TOUR_SALDO_RENDIMENTO_TITLE__,
    //       content: __TRANS_TOUR_SALDO_RENDIMENTO_CONTENT__,
    //       placement: 'top',
    //       backdrop: true
    //     },
    //     {
    //       element: ".saldoRede",
    //       title: __TRANS_TOUR_SALDO_REDE_TITLE__,
    //       content: __TRANS_TOUR_SALDO_REDE_CONTENT__,
    //       placement: 'top',
    //       backdrop: true
    //     }
    //   ]});
      
    //   tour.init();
    //   tour.start();
});