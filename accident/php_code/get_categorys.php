<?php
include_once '../../config.php';
session_start();
if (!isset($_SESSION['username'])) {
    die("login");
}

$returnArr = [];

if (isset($_POST['category'])){
    // kategoriebi
    $sql = "
SELECT `ID`, `name`, `nameEng` FROM `im_category`
WHERE `isActive` = 1
ORDER BY sortID ";

    $result = mysqli_query($conn, $sql);

    $arr_category = array();
    foreach ($result as $row) {
        $row += ['sub_cat' => []];
        $arr_category[] = $row;
    }

// sub_category s
    $sql = "
SELECT `ID`, `categoryID`, `name`, `nameEng` FROM `im_subcategory`
WHERE `isActive` = 1
ORDER BY sortID ";

    $result = mysqli_query($conn, $sql);

    $arr_sub = array();
    foreach ($result as $row) {
        $arr_sub[] = $row;
    }


    for ($i = 0; $i < count($arr_category); $i++) {
        foreach ($arr_sub as $sub) {
            if ($arr_category[$i]['ID'] == $sub['categoryID']) {
                $arr_category[$i]['sub_cat'][] = $sub;
            }
        }

    }
    $returnArr['category'] = $arr_category;
}

echo(json_encode($returnArr));
$conn->close();