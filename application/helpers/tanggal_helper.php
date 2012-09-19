<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


// format ulang dari tahun-bulan-tanggal jam:menit:detik (2012-12-30 12:30:40) menjadi tanggal bulan tahun jam:menit:detik (30 12 2012 12:30:40)
function format_waktu($tgl) {
    $time = explode(' ', $tgl);
    $thn_bln = explode('-', $time[0]);

    $date = $thn_bln[2] . '-' . $thn_bln[1] . '-' . $thn_bln[0] . ' ' . $time[1];
    return $date;
}

// format ulang dari tahun-bulan-tanggal(2012-12-30) menjadi tanggal/bulan/tahun (30 12 2012)
function format_tanggal($tgl) {
    $thn_bln = explode('-', $tgl);
    $date = $thn_bln[2] . ' ' . $thn_bln[1] . ' ' . $thn_bln[0];
    return $date;
}


// format ulang dari tahun-bulan-tanggal(2012-12-30) menjadi tanggal/bulan/tahun (30/12/2012)
function format_edit_surat($tgl) {
    $thn_bln = explode('-', $tgl);
    $date = $thn_bln[2] . '/' . $thn_bln[1] . '/' . $thn_bln[0];
    return $date;
}

function format_indo_strip($tgl) {
    $thn_bln = explode('/', $tgl);
    $date = $thn_bln[2] . '-' . $thn_bln[1] . '-' . $thn_bln[0];
    return $date;
}


// format ulang dari tahun-bulan-tanggal(2012-12-30) menjadi tanggal namabulan tahun (12 agustus 2012)
function format_indo($tgl) {
    $thn_bln = explode('-', $tgl);

    switch ($thn_bln[1]) {
        case '01':
            $thn_bln[1] = 'Januari';
            break;
        case '02':
            $thn_bln[1] = 'Februari';
            break;
        case '03':
            $thn_bln[1] = 'Maret';
            break;
        case '04':
            $thn_bln[1] = 'April';
            break;
        case '05':
            $thn_bln[1] = 'Mei';
            break;
        case '06':
            $thn_bln[1] = 'Juni';
            break;
        case '07':
            $thn_bln[1] = 'Juli';
            break;
        case '08':
            $thn_bln[1] = 'Agustus';
            break;
        case '09':
            $thn_bln[1] = 'September';
            break;
        case '10':
            $thn_bln[1] = 'Oktober';
            break;
        case '11':
            $thn_bln[1] = 'November';
            break;
        case '12':
            $thn_bln[1] = 'Desember';
            break;
        default:
            $thn_bln[1] = 'Ada sesuatu';
            break;
    }

    $date = $thn_bln[2] . ' ' . $thn_bln[1] . ' ' . $thn_bln[0];

    return $date;
}


// format ulang dari tahun-bulan-tanggal jam:menit:detik (2012-12-30 12:30:40) menjadi tanggal bulan tahun jam:menit:detik (30 Desember 2012 12:30:40)
function format_indo_full($tgl) {
    $time = explode(' ', $tgl);
    $thn_bln = explode('-', $time[0]);

    switch ($thn_bln[1]) {
        case '01':
            $thn_bln[1] = 'Januari';
            break;
        case '02':
            $thn_bln[1] = 'Februari';
            break;
        case '03':
            $thn_bln[1] = 'Maret';
            break;
        case '04':
            $thn_bln[1] = 'April';
            break;
        case '05':
            $thn_bln[1] = 'Mei';
            break;
        case '06':
            $thn_bln[1] = 'Juni';
            break;
        case '07':
            $thn_bln[1] = 'Juli';
            break;
        case '08':
            $thn_bln[1] = 'Agustus';
            break;
        case '09':
            $thn_bln[1] = 'September';
            break;
        case '10':
            $thn_bln[1] = 'Oktober';
            break;
        case '11':
            $thn_bln[1] = 'November';
            break;
        case '12':
            $thn_bln[1] = 'Desember';
            break;
        default:
            $thn_bln[1] = 'Ada sesuatu';
            break;
    }

    $date = $thn_bln[2] . ' ' . $thn_bln[1] . ' ' . $thn_bln[0] . ' ' . $time[1];
    return $date;
}


// tuk header laporan

// format ulang dari tahun-bulan-tanggal(2012-12-30) menjadi tanggal bulan tahun (30 Desember 2012)
function format_indo_laporan($tgl) {
    $thn_bln = explode('/', $tgl);

    switch ($thn_bln[1]) {
        case '01':
            $thn_bln[1] = 'Januari';
            break;
        case '02':
            $thn_bln[1] = 'Februari';
            break;
        case '03':
            $thn_bln[1] = 'Maret';
            break;
        case '04':
            $thn_bln[1] = 'April';
            break;
        case '05':
            $thn_bln[1] = 'Mei';
            break;
        case '06':
            $thn_bln[1] = 'Juni';
            break;
        case '07':
            $thn_bln[1] = 'Juli';
            break;
        case '08':
            $thn_bln[1] = 'Agustus';
            break;
        case '09':
            $thn_bln[1] = 'September';
            break;
        case '10':
            $thn_bln[1] = 'Oktober';
            break;
        case '11':
            $thn_bln[1] = 'November';
            break;
        case '12':
            $thn_bln[1] = 'Desember';
            break;
        default:
            $thn_bln[1] = 'Ada sesuatu';
            break;
    }

    $date = $thn_bln[0] . ' ' . $thn_bln[1] . ' ' . $thn_bln[2];

    return $date;
}


function format_indo_laporanstrip($tgl) {
    $thn_bln = explode('-', $tgl);

    switch ($thn_bln[1]) {
        case '01':
            $thn_bln[1] = 'Januari';
            break;
        case '02':
            $thn_bln[1] = 'Februari';
            break;
        case '03':
            $thn_bln[1] = 'Maret';
            break;
        case '04':
            $thn_bln[1] = 'April';
            break;
        case '05':
            $thn_bln[1] = 'Mei';
            break;
        case '06':
            $thn_bln[1] = 'Juni';
            break;
        case '07':
            $thn_bln[1] = 'Juli';
            break;
        case '08':
            $thn_bln[1] = 'Agustus';
            break;
        case '09':
            $thn_bln[1] = 'September';
            break;
        case '10':
            $thn_bln[1] = 'Oktober';
            break;
        case '11':
            $thn_bln[1] = 'November';
            break;
        case '12':
            $thn_bln[1] = 'Desember';
            break;
        default:
            $thn_bln[1] = 'Ada sesuatu';
            break;
    }

    $date = $thn_bln[2] . ' ' . $thn_bln[1] . ' ' . $thn_bln[0];

    return $date;
}

