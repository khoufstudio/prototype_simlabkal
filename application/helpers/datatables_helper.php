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

function spm($spm)
{
    if (intval($spm) === 0) {
        return "Tidak ditentukan";
    }

    return "$spm hari";
}

function button_aksi_pemesanan($id)
{
    $base_url = base_url();
    $link_download_pdf = $base_url . "orders/pdf/$id";
    $list_button = <<<HTML
        <a href="$link_download_pdf" class="btn btn-block btn-danger btn-xs" style="display: inline;margin-right: 8px;">
            <i class="fa fa-file-pdf-o">
        </a>
    HTML;

    return $list_button;
}