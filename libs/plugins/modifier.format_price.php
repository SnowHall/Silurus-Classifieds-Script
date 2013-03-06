<?php

function smarty_modifier_format_price($value) {
    global $gConfig;
    switch ($gConfig['currency']) {
        case 'USD':
            $template = '$*';
            break;
        case 'EUR':
            $template = '* &euro;';
            break;
        default:
            $result = mysql_query("SELECT `sign` FROM `Currency` WHERE `name` = '".  mysql_real_escape_string($gConfig['currency'])."' LIMIT 1");
            if ($result)
            {
              $sign = mysql_fetch_row($result);
            }
            $template = $sign[0] ? '* '.$sign[0]: '* ' . $gConfig['currency'];
    }

    $decimals = 2; $dec_point = '.'; $thousands_sep = ''; // to allow simple change, may be gone to settings?
    $price = number_format($value, $decimals, $dec_point, $thousands_sep);

    return str_replace('*', $price, $template);
}

?>
