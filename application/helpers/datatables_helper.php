<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function status_order($tracking_number)
{

    switch ($tracking_number) {
        case '1':
            $status_tracking = "Pemesanan awal";
            break;
        case '2':
            $status_tracking = "Pemesanan diverifikasi";
            break;
        default:
            $status_tracking = "Belum ada Pemesanan";
            break;
    }
    $output = <<<HTML
        <small class="label bg-red">$status_tracking</small>
    HTML;

    return $output;
}