<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 23.04.2018
 * Time: 15:46
 */

include_once '../config.php';
session_start();
if (!isset($_SESSION['username'])){
    die("login");
}
if ($_SESSION['usertype'] != 'admin'){
    die("NO_access");
}
$currUserID = $_SESSION['userID'];
date_default_timezone_set("Asia/Tbilisi");
$dges = date("Y-m-d", time());


if(isset($_GET["sql"]) && $_GET["sql"]!=""){
    $sql = $_GET["sql"];
    $depritiatedKeys = ["drop", "insert", "update"];

    foreach($depritiatedKeys as $opation){
        if (stripos($sql, $opation) !== false){
            die('don\'t '.$opation.' anyting');
        }
    }
    
    function makeHrow($columns){
        $newRow = "<tr>";
        foreach($columns as $item){
            $newRow .= "<th>" . $item . "</th>";
        }
        return $newRow . "</tr>";    
    }
    function makerow($columns){
        $newRow = "<tr>";
        foreach($columns as $item){
            if ($item == "0000-00-00 00:00:00"){
                $item = "";
            }
            $newRow .= "<td>" . $item . "</td>";        
        }
        return $newRow . "</tr>";
    }
    
    $output = '<table bordered="3">';
    $tHead = [];
    $headNeed = true;
    
    $result = $conn->query($sql);
    
    if (!$result){
        die("SQL Error:\n" . $sql);
    }else{
        if (mysqli_num_rows($result) > 0) {
    
            foreach($result as $row){
                if($headNeed){
                    foreach($row as $kay => $item){
                        $tHead[] = $kay;
                    }
                    $output .= makeHrow($tHead);
                    $headNeed = false;
                }        
                $output .= makerow($row);
            }
        }
        
        $output .= '</table>';
        $fileName = "dataExport_" . $dges;
        
        //header("Content-Type: application/xls");
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=$fileName.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $output;
    }
    
} else{
    echo "No Query";
}

mysqli_close($conn);
?>