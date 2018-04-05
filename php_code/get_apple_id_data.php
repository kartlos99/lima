<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';

$orgID = 0;

$id = $_GET['id'];
if ($id == 0){
    $orgID = $_GET['orgid'];

    $sql = "
SELECT
  *
FROM
  `ApplID`
WHERE
  `OrganizationID` = $orgID AND ID NOT IN(
SELECT
  `ApplIDID`
FROM
  ApplIDFix af
      LEFT JOIN States s
      ON af.stateID = s.id
WHERE s.code = 'active'
)
";

    $result = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);
    $arr = [];
    if ($count > 0){

        foreach($result as $row){
            $arr[] = $row;
        }
        $num = rand(1,$count);

        $id = $arr[$num-1]['ID'];

    }else{
       // echo "ar moidzebna tavisufali applID!";
    }


}

if ($id != 0){

        $sql = "
    SELECT a.*, e.EmEmailPass FROM `ApplID` a JOIN Emails e
    ON a.`AplAccountEmailID` = e.ID
    WHERE a.ID = $id
        ";

    $result = mysqli_query($conn,$sql);

    $arr = array();
    foreach($result as $row){
        $arr[] = $row;
    }

    echo(json_encode($arr));
}

$conn -> close();
?>