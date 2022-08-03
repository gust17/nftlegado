<?php
function ListaBancos(){

    $bancos = array(
        '001'=>'Banco do Brasil',
        '033'=>'Banco Santander',
        '077'=>'Banco Inter',
        '104'=>'Caixa Econômica Federal',
        '212'=>'Banco Original',
        '237'=>'Banco Bradesco',
        '260'=>'Nu Pagammentos (Nubank)',
        '341'=>'Banco Itaú',
        '422'=>'Banco Safra',
        '655'=>'Banco Votorantim',
        '655'=>'Neon Pagamentos',
        '748'=>'Sicredi',
        '756'=>'Bancoob'
    );

    return $bancos;
}

function BancoID($id){

    $bancos = ListaBancos();

    foreach($bancos as $codigo=>$nome){

        if($codigo == $id){

            return $nome;
        }
    }
}