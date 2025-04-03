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