<?php
    function formatUang($uang){
        $convertFormat="Rp ".number_format($uang,0);
        return $convertFormat;
    } 

    function tgl_indo($tanggal){
        $bulan = array (
            0 =>'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
        );
        $pecahkan = explode('/', $tanggal);
        return $pecahkan[1] . ' ' . $bulan[ (int)$pecahkan[0] ] . ' ' . $pecahkan[2];
    }
?>