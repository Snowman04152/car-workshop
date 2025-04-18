<?php
function toDate($param)
{
    $date = date('Y-m-d', strtotime($param)); 
    $hour = date('H:i', strtotime($param));

    $BulanIndo = array(
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    );

    $timestamp = strtotime($date);
    $tahun = date('Y', $timestamp);
    $bulan = date('n', $timestamp); 
    $tgl = date('j', $timestamp); 

    $result = $tgl . " " . $BulanIndo[$bulan - 1] . " " . $tahun;
    
    if (strtotime($param) !== strtotime(date('Y-m-d', strtotime($param)))) {
        $result .= ", " . $hour;
    }
    
    echo ($result);
}
function toIndoDate($param)
{
    $date = date('Y-m-d', strtotime($param)); 
    $hour = date('H:i', strtotime($param));

    $BulanIndo = array(
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    );

    $hariIndo = array(
        "Minggu",
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jumat",
        "Sabtu"
    );

    $timestamp = strtotime($date);
    $nama_hari = date('w', $timestamp);   
    $tahun = date('Y', $timestamp);
    $bulan = date('n', $timestamp); 
    $tgl = date('j', $timestamp); 

    if (strtotime($param) === strtotime(date('Y-m-d', strtotime($param)))) {
        $result = $hariIndo[$nama_hari] . ", " . $tgl . " " . $BulanIndo[$bulan - 1] . " " . $tahun;
    } else {
        $result = $hariIndo[$nama_hari] . ", " . $tgl . " " . $BulanIndo[$bulan - 1] . " " . $tahun . " " . $hour;
    }
    
    echo ($result);


}
function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = [
        'y' => 'Year',
        'm' => 'Month',
        'w' => 'Week',
        'd' => 'Day',
        'h' => 'Hour',
        'i' => 'Minute',
        's' => 'detik',
    ];
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v;
            if ($k == 'd') {
                $v =  $v . ' Ago';
            }
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) : 'baru saja';
}
class MaintenanceMapping
{
    public static function jenisPemeliharaan()
    {
        return [
            1 => 'Charging Accu',
            2 => 'Ganti Bumper Belakang',
            3 => 'Ganti Bumper Depan',
            4 => 'Ganti Kampas Rem',
            5 => 'Ganti Lampu Depan',
            6 => 'Ganti Minyak Rem',
            7 => 'Ganti Oli',
            8 => 'Pemeriksaan Filter Udara',
            9 => 'Pemeriksaan Kampas Rem',
            10 => 'Pemeriksaan Kelistrikan',
            11 => 'Pemeriksaan Minyak Rem',
            12 => 'Pemeriksaan Rem',
            13 => 'Pemeriksaan Suspensi',
            14 => 'Pemeriksaan Sistem Pendingin',
            15 => 'Pemeriksaan Sistem Pengapian',
            16 => 'Pemeriksaan Transmisi',
            17 => 'Perbaikan Bumper Depan',
            18 => 'Pergantian Busi',
            19 => 'Pergantian Kampas Rem',
            20 => 'Pergantian Oli',
            21 => 'Rotasi Ban',
            22 => 'Service Berkala',
            23 => 'Service Kopling',
            24 => 'Tune Up',
        ];
    }

    public static function riwayatMasalah()
    {
        return [
            0 => 'Tidak ada masalah',
            1 => 'Masalah Mesin Usia Lanjut',
        ];
    }

    public static function bulan()
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    }
}


// function toIndoDate($param)
// {
//     $date = date('Y-m-d w', strtotime($param));
//     $hour = date('H:i', strtotime($param));
//     $BulanIndo = array("Januari", "Februari", "Maret",
//         "April", "Mei", "Juni",
//         "Juli", "Agustus", "September",
//         "Oktober", "November", "Desember");
//     $hariIndo = array("Senin", "Selasa", "Rabu",
//     "Kamis", "Jumat", "Sabtu", "Minggu");
//     $tahun = substr($date, 0, 4);
//     $bulan = substr($date, 5, 2);
//     $tgl = substr($date, 8, 2);
//     $hari = substr($date, 10, 1);

//     $result = $hariIndo[(int) $hari].", ".$tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun." ".$hour;
//     echo ($result);
// }