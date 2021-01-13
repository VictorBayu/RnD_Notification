<?php
$koneksi = mysqli_connect("localhost", "root", "", "pal_test");
// if (mysqli_connect_errno()) {
//     echo "Failed to connect to MySQL: " + mysqli_connect_error();
//     exit();
// }
function query($query)
{
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
