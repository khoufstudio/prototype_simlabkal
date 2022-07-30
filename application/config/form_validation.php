<?php

$config = array(
    'keuangan' => array(
        array(
            'field' => 'finance_type',
            'label' => 'Tipe',
            'rules' => 'required'
        ),
        array(
            'field' => 'name_income_expense',
            'label' => 'Nama Pemasukan Pengeluaran',
            'rules' => 'required'
        ),
        array(
            'field' => 'total',
            'label' => 'total',
            'rules' => 'required'
        ),
    ),
    'pembelian' => array(
        array(
            'field' => 'supplier',
            'label' => 'Supplier',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s wajib isi'
            )
        ),
        array(
            'field' => 'products[]',
            'label' => 'Barang',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s wajib isi'
            ),
        ),
    ),
    'penjualan' => array(
        array(
            'field' => 'products[]',
            'label' => 'Barang',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s wajib isi'
            ),
        ),
    )
);

