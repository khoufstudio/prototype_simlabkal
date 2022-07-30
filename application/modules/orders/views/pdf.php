<?php 

$owner = $data_order['owner'];
$orderDate= ymdtoDmy($data_order['order_date']);
$address = $data_order['address'];
$contactPerson = $data_order['contact_person'];

$output = <<<HTML
    <p>
        Nama: $owner
    </p>
    <p>
        Tanggal Order: $orderDate
    </p>
    <p>
        Tanggal Order: $orderDate
    </p>
    <p>
        Kontak Person: $contactPerson
    <p>
        Alamat: $address
    </p>
HTML;

echo $output;