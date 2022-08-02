<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function status_order($tracking_number)
{
    switch ($tracking_number) {
        case '1':
            $status_tracking = "Pemesanan awal";
            break;
        case '2':
            $status_tracking = "Proses Dokumen";
            break;
        case '3':
            $status_tracking = "Konfirmasi Bayar";
            break;
        case '4':
            $status_tracking = "Sertifikat Selesai";
            break;
        default:
            $status_tracking = "Belum ada Pemesanan";
            break;
    }
    $output = <<<HTML
        <small class="label bg-primary">$status_tracking</small>
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
    $link_update = $base_url . "orders/update/$id";
    $link_edit = $base_url . "orders/edit/$id";
    $list_button = <<<HTML
        <a href="$link_download_pdf" class="btn btn-block btn-danger btn-xs" style="display: inline;margin-right: 8px;padding: 3px;" title="download pdf">
            <i class="fa fa-file-pdf-o"></i>
        </a>
        <a href="$link_update" class="btn btn-xs btn-success item-edit" title="update status">
            <i class="fa fa-edit"></i>
        </a>
        <a href="$link_edit" class="btn btn-xs btn-primary" title="edit pemesanan">
            <i class="fa fa-edit"></i>
        </a>
    HTML;

    return $list_button;
}

function button_aksi_kalibrasi($id)
{
    $base_url = base_url();
    $link_edit = $base_url . "calibrations/edit/$id";
    $list_button = <<<HTML
        <a href="$link_edit" class="btn btn-xs btn-primary item-edit">
            <i class="fa fa-edit"></i>
        </a>
    HTML;

    return $list_button;
}