<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    function dmyToymd($tgl, $separator = "/")
    {
        $tgl = trim($tgl);
        $xreturn_ = '';

        if ($tgl != '' AND $tgl != '00-00-0000') {

            if (strpos($tgl, "-")) {
                $pcs = explode("-", $tgl);
            } else if (strpos($tgl, "/")) {
                $pcs = explode("/", $tgl);
            }
            $xreturn_ = $pcs[2] . $separator . $pcs[1] . $separator . $pcs[0];
        } 
        return $xreturn_;
    }

    function dmyTomdy($tgl)
    {
        $tgl = trim($tgl);
        $xreturn_ = '';
        if ($tgl != '' AND $tgl != '00-00-0000') {

            if (strpos($tgl, "-")) {
                $pcs = explode("-", $tgl);
            } else if (strpos($tgl, "/")) {
                $pcs = explode("/", $tgl);
            }
            $xreturn_ = $pcs[1] . "/" . $pcs[0] . "/" . $pcs[2];
        } 
        return $xreturn_;
    }

    function ymdtoDmy($tgl)
    {
        $xreturn_ = '';
        if (trim($tgl) != '' AND $tgl != '0000-00-00') {

            if (strpos($tgl, "-")) {
                $pcs = explode("-", $tgl);
            } else if (strpos($tgl, "/")) {
                $pcs = explode("/", $tgl);
            }
            $xreturn_ = $pcs[2] . "/" . $pcs[1] . "/" . $pcs[0];
        } 
        return $xreturn_;
    }

    function tglIndo($tgl)
    {
    	// 11 Desember 2019
    	$bulan[1] = 'Januari';
    	$bulan[2] = 'Februari';
    	$bulan[3] = 'Maret';
    	$bulan[4] = 'April';
    	$bulan[5] = 'Mei';
    	$bulan[6] = 'Juni';
    	$bulan[7] = 'Juli';
    	$bulan[8] = 'Agustus';
    	$bulan[9] = 'September';
    	$bulan[10] = 'Oktober';
    	$bulan[11] = 'November';
    	$bulan[12] = 'Desember';

    	$xreturn_ = '';
        if (trim($tgl) != '' AND $tgl != '00-00-0000') {

            if (strpos($tgl, "-")) {
                $pcs = explode("-", $tgl);
            } else if (strpos($tgl, "/")) {
                $pcs = explode("/", $tgl);
            }
            $xreturn_ = $pcs[2] . " " . $bulan[(int) $pcs[1]] . " " . $pcs[0];
        } 
        return $xreturn_;
    }

    function rupiahToInt($val)
    {
        try {
            $result = str_replace(".", "", substr($val, 4));
        } catch (Exception $exception) {
            return "";
        }

        return $result;
    }

    function intToRupiah($val)
    {
        $val = (int) $val;
        $result = ($val) ? "Rp. " . number_format($val,0,',','.') : "Rp. 0";
        return $result;
    }

    function dd($value='')
    {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";
        die();
    }

    /**
     * change dd/mm/yyyy to yyyy-mm-dd
    */
    function parse_date_db($date) : ?string
    {
        if ($date) {
            $result_date_temp = explode("/", $date);
            $result_date = $result_date_temp[2] . "-" . $result_date_temp[1] . "-" . $result_date_temp[0];
        } else {
            $result_date = null;
        }

        return $result_date;
    }

    /*
      Change yyyy-mm-dd H:i:s to dd-mm-yyyy H:i:s
     */
    function ymdHisTodmyHis($tgl_full, $separator = "/")
    {
        $tgl_array = explode(" ", $tgl_full);
        $tgl = $tgl_array[0];

        $xreturn_ = '';
        if (trim($tgl) != '' AND $tgl != '00-00-0000') {

            if (strpos($tgl, "-")) {
                $pcs = explode("-", $tgl);
            } else if (strpos($tgl, "/")) {
                $pcs = explode("/", $tgl);
            }
            $xreturn_ = $pcs[2] . $separator . $pcs[1] . $separator . $pcs[0] . " " . $tgl_array[1];
        } 
        return $xreturn_;
    }

    function rest_count($debt_rest, $total_debt): string
    {
        $total_rest = 0;
        if (!is_null($debt_rest)) {
            $total_rest = $debt_rest;
        } else {
            $total_rest = $total_debt;
        }
          
        return intToRupiah($total_rest);
    }

    function validation($data, $validation_rules, $form_validation)
    {
        $form_validation->set_data($data);

        if (is_array($validation_rules)) {
            $form_validation->set_rules($validation_rules);

            if ($form_validation->run() == FALSE) {
                throw new Exception(strip_tags(validation_errors()));
            }
        } else {
            if ($form_validation->run($validation_rules) == FALSE) {
                throw new Exception(strip_tags(validation_errors()));
            }

        }
    }
?>
