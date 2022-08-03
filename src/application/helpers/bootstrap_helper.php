<?php
function alerts($message, $type = 'success'){

    return '<div class="alert alert-'.$type.' text-center">'.$message.'</div>';
}

function badge($message, $type = 'success'){

    return '<span class="badge badge-'.$type.' text-center">'.$message.'</span>';
}