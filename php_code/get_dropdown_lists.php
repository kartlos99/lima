<?php

include_once '../config.php';
session_start();
if (!isset($_SESSION['username'])){
    die("login");
}

$returnArr = [];

// masivshi mogvdis risi statusebi gvchirdeba
if (isset($_POST['status'])){
    $st_arr = $_POST['status'];

    foreach($st_arr as $objname){
        $sql = "SELECT id, `code`, `value` as va FROM `States` WHERE ObjectID = getobjid('$objname') order by SortID";
        $result = mysqli_query($conn,$sql);

        $arr = array();
        foreach($result as $row){
            $arr[] = $row;
        }
        $returnArr[$objname] = $arr;
    }
}

// am dictionary Code-ze ra itemebi gvaqvs
if (isset($_POST['dict_codes'])){
    $code_arr = $_POST['dict_codes'];

    foreach($code_arr as $code){
        $sql = "
        SELECT di.ID, di.Code, di.`ValueText` FROM `DictionariyItems` di
        LEFT JOIN Dictionaries d
        ON di.`DictionaryID` = d.ID
        WHERE d.Code = '$code'
        order by `SortID`";
        
        $result = mysqli_query($conn,$sql);
        
        $arr = array();
        foreach($result as $row){
            $arr[] = $row;
        }
        $returnArr[$code] = $arr;
    }
}

// organizaciebis chamonatvali tavisi filialebit da domainebit da Rescue Email-ebit
if (isset($_POST['org'])){
    // organizaciebi
    $sql = "SELECT
    o.id,
    OrganizationName,
    OrganizationNameEng,
    s.code
    FROM
    `Organizations` o
    LEFT JOIN `States` s 
    ON s.ID = o.stateID
    WHERE
    s.code <> 'disabled'
    ";

    $result = mysqli_query($conn,$sql);

    $arr_org = array();
    foreach($result as $row){
        $row += ['domains' => [] ];
        $row += ['branches' => [] ];
        $row += ['rmails' => [] ];
        $arr_org[] = $row;    
    }

    // filialebi
    $sql = "SELECT OrganizationID, o.id, BranchName FROM OrganizationBranches o LEFT JOIN States s ON o.StateID = s.ID WHERE s.Code = 'Active'";

    $result = mysqli_query($conn,$sql);

    $arr_br = array();
    foreach($result as $row){
        $arr_br[] = $row;    
    }

    // domainebi
    $sql = "SELECT OrganizationID, o.id, DomainName FROM Domains o LEFT JOIN States s ON o.StateID = s.ID WHERE s.Code = 'Active'";

    $result = mysqli_query($conn,$sql);

    $arr_dom = array();
    foreach($result as $row){
        $arr_dom[] = $row;    
    }

    // recovery Emails
    $sql = "SELECT OrganizationID, e.id, e.EmEmail FROM `Emails` e JOIN Types t ON e.TypeID = t.ID WHERE t.code = 'Rescue Email'";

    $result = mysqli_query($conn,$sql);

    $arr_Rmail = array();
    foreach($result as $row){
        $arr_Rmail[] = $row;    
    }

    for ($i = 0 ; $i < count($arr_org) ; $i++){
        foreach($arr_br as $br){
            if ($arr_org[$i]['id'] == $br['OrganizationID']){
                $arr_org[$i]['branches'][] = $br;
            }
        }
        foreach($arr_dom as $dom){
            if ($arr_org[$i]['id'] == $dom['OrganizationID']){
                $arr_org[$i]['domains'][] = $dom;
            }
        }
        foreach($arr_Rmail as $rm){
            if ($arr_Rmail[$i]['id'] == $rm['OrganizationID']){
                $arr_org[$i]['rmails'][] = $rm;
            }
        }
    }
    $returnArr[$_POST['org']] = $arr_org;
}

// <!--    sequrity question chamonatvali -->
if (isset($_POST['sec_qustion'])){
    $sql = "
    SELECT id, DictionaryID, Code, ValueText 
    FROM `DictionariyItems`
    WHERE DictionaryID in (SELECT ID FROM `Dictionaries` WHERE CODE LIKE 'AppleIDSequrityQuestion_') ";

    $result = mysqli_query($conn,$sql);

    $arr = array();
    foreach($result as $row){
        $arr[] = $row;
    }
    $returnArr[$_POST['sec_qustion']] = $arr;
}

echo(json_encode($returnArr));
$conn -> close();
?>