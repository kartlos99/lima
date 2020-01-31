<?php

include_once 'DrawView.php';
include_once 'common_functions.php';
include_once 'simple_header.php';
if (!isset($_SESSION['permissionM2']['m2history'])) {
    $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $folder . "/index.php";
    header("Location: $url");
}
$note = "შენიშვნა";
$estimateCaseID = $_GET['ID'];
$output = "";

$sql = "
SELECT hID, app.`ID`, `ApNumber`, Date(`ApDate`) AS ApDate, ifNull(o.OrganizationName, '') AS 'org', ifNull(b.BranchName, '') AS 'fil', s.value AS st, `AgreementNumber`, tm.Name AS 'model', tbr.Name AS 'brand', ttp.Name AS 'techtype', `TechModelFix`, `TechSerial`, `TechIMEI`, app.`Note`, `EstimateResult1`, `EstimateResult2`, `maxPrice`, `SysTechPrice`, `ManagerAdd`, `ClientDec`, `CorTechPrice`, `appNote`, `CEstPerson`, Date(`CEstDate`) AS CEstDate, ifNull(sc.value, '') AS 'CEstStatus', `CEstPrice`, `CEstNote`, `FEstPerson`, Date(`FEstDate`) AS FEstDate, ifNull(sf.value, '') AS 'FEstStatus', `FEstPrice`, `FEstNote`, app.`CreateDate`, app.`CreateUser`, app.`CreateUserID`, app.`ModifyDate`, app.`ModifyUser`, app.`ModifyUserID` 
FROM `tech_estimate_applications_history` app
LEFT JOIN techniques_tree tm ON app.`TechTreeID` = tm.ID
LEFT JOIN techniques_tree tbr ON tm.ParentID = tbr.ID
LEFT JOIN techniques_tree ttp ON tbr.ParentID = ttp.ID
LEFT JOIN Organizations o ON o.ID = app.`OrganizationID` 
LEFT JOIN OrganizationBranches b ON b.ID = app.`BranchID` 
LEFT JOIN States s ON s.ID = app.`ApStatus`
LEFT JOIN States sc ON sc.ID = app.`CEstStatus`
LEFT JOIN States sf ON sf.ID = app.`FEstStatus`
WHERE app.ID = $estimateCaseID
UNION
SELECT 9999999 AS hID, app.`ID`, `ApNumber`, Date(`ApDate`) AS ApDate, 
ifNull(o.OrganizationName, '') AS 'org', ifNull(b.BranchName, '') AS 'fil', s.value AS st, `AgreementNumber`, 
tm.Name AS 'model', tbr.Name AS 'brand', ttp.Name AS 'techtype', `TechModelFix`, `TechSerial`, `TechIMEI`, app.`Note`, 
`EstimateResult1`, `EstimateResult2`, `maxPrice`, `SysTechPrice`, `ManagerAdd`, `ClientDec`, `CorTechPrice`, `appNote`, 
`CEstPerson`, Date(`CEstDate`) AS CEstDate, ifNull(sc.value, '') AS 'CEstStatus', `CEstPrice`, `CEstNote`, 
`FEstPerson`, Date(`FEstDate`) AS FEstDate, ifNull(sf.value, '') AS 'FEstStatus', `FEstPrice`, `FEstNote`, 
app.`CreateDate`, app.`CreateUser`, app.`CreateUserID`, app.`ModifyDate`, app.`ModifyUser`, app.`ModifyUserID` 
FROM `tech_estimate_applications` app
LEFT JOIN techniques_tree tm ON app.`TechTreeID` = tm.ID
LEFT JOIN techniques_tree tbr ON tm.ParentID = tbr.ID
LEFT JOIN techniques_tree ttp ON tbr.ParentID = ttp.ID
LEFT JOIN Organizations o ON o.ID = app.`OrganizationID` 
LEFT JOIN OrganizationBranches b ON b.ID = app.`BranchID` 
LEFT JOIN States s ON s.ID = app.`ApStatus`
LEFT JOIN States sc ON sc.ID = app.`CEstStatus`
LEFT JOIN States sf ON sf.ID = app.`FEstStatus`
WHERE app.ID = $estimateCaseID
ORDER BY hID
";
//echo $sql;

$result = mysqli_query($conn, $sql);
$arr = array();
while ($row = mysqli_fetch_array($result)) {
    $arr[] = $row;
}

for ($i = 0; $i < count($arr); $i++) {
    $item = $arr[$i];
    $indicator = [];
    foreach ($item as $key => $val){
        $indicator[$key] = 0;
    }
    if ($i > 0){
        $preItem = $arr[$i - 1];
        foreach ($item as $key => $val){
            if ($val != $preItem[$key]){
                $indicator[$key] = 1;
            }
        }
    }
    $priceCorection = implode([$item['ManagerAdd'] == 1 ? "დამატება მენეჯერის დასტურით": "", $item['ClientDec'] == 1 ? "შემცირება კლიენტის მოთხოვნით": ""]);
    $priceCorectionIndicator = 0;
    if($indicator['ManagerAdd'] == 1 || $indicator['ClientDec'] == 1 ) $priceCorectionIndicator = 1;
    ?>
    <div class="hist-item">
        <p class="h-item-head">
            დრო: <?= $item['ModifyDate'] < "1" ? $item['CreateDate'] : $item['ModifyDate'] ?>  -
            მომხმარებელი: <?= $item['ModifyDate'] < "1" ? $item['CreateUser'] : $item['ModifyUser'] ?>
        </p>
        <table class="table-section">
            <tr>
                <td><?= DrawView::histDataUnit("ტიპი", $item['techtype'], $indicator['techtype']) ?></td>
                <td><?= DrawView::histDataUnit("მოდელი (ხელოვნური განსაზღვრა)", $item['TechModelFix'], $indicator['TechModelFix']) ?></td>
                <td><?= DrawView::histDataUnit("გასაცემი თანხა (სისტ.)", $item['SysTechPrice'], $indicator['SysTechPrice']) ?></td>
            </tr>
            <tr>
                <td><?= DrawView::histDataUnit("ბრენდი", $item['brand'], $indicator['brand']) ?></td>
                <td><?= DrawView::histDataUnit("სერიული N", $item['TechSerial'], $indicator['TechSerial']) ?></td>
                <td><?= DrawView::histDataUnit("თანხის კორექტირება", $priceCorection, $priceCorectionIndicator) ?></td>
            </tr>
            <tr>
                <td><?= DrawView::histDataUnit("მოდელი", $item['model'], $indicator['model']) ?></td>
                <td><?= DrawView::histDataUnit("IMEI კოდი", $item['TechIMEI'], $indicator['TechIMEI']) ?></td>
                <td><?= DrawView::histDataUnit("გასაცემი თანხა (კორექტირებული)", $item['CorTechPrice'] == 0 ? $item['SysTechPrice'] : $item['CorTechPrice'], $indicator['CorTechPrice']) ?></td>
            </tr>
            <tr>
                <td colspan="3"><?= DrawView::histDataUnit($note, $item['Note'], $indicator['Note']) ?></td>
            </tr>
            <tr>
                <td colspan="3"><?= DrawView::histDataUnit("შეჯამებული ინფორმაცია შეფასების შესახებ", $item['EstimateResult1'], $indicator['EstimateResult1']) ?></td>
            </tr>
        </table>
        <?= DrawView::historySubSectionRow("განაცხადი და ხელშეკრულება")?>
        <table class="table-section">
            <tr>
                <td><?= DrawView::histDataUnit("განაცხადი", $item['ApNumber'] . " " . $item['ApDate'], $indicator['ApDate']) ?></td>
                <td><?= DrawView::histDataUnit("ორგანიზაცა", $item['org'], $indicator['org']) ?></td>
                <td><?= DrawView::histDataUnit("ფილიალი", $item['fil'], $indicator['fil']) ?></td>
                <td><?= DrawView::histDataUnit("ხელშეკრულება N", $item['AgreementNumber'], $indicator['AgreementNumber']) ?></td>
                <td><?= DrawView::histDataUnit("სტატუსი", $item['st'], $indicator['st']) ?></td>
            </tr>
            <tr>
                <td colspan="4"><?= DrawView::histDataUnit("შენიშვნა განაცხადზე", $item['appNote'], $indicator['appNote']) ?></td>
            </tr>
        </table>

        <?= DrawView::historySubSectionRow("საკონტროლო შეფასება")?>
        <table class="table-section">
            <tr>
                <td><?= DrawView::histDataUnit("თარიღი", $item['CEstDate'], $indicator['CEstDate']) ?></td>
                <td><?= DrawView::histDataUnit("მომხმარებელი", $item['CEstPerson'], $indicator['CEstPerson']) ?></td>
                <td><?= DrawView::histDataUnit("საკონტროლო შეფასების შედეგი", $item['CEstStatus'], $indicator['CEstStatus']) ?></td>
                <td><?= DrawView::histDataUnit("კორექტირებული თანხა", $item['CEstPrice'], $indicator['CEstPrice']) ?></td>
            </tr>
            <tr>
                <td colspan="4"><?= DrawView::histDataUnit("შენიშვნა / კორექტირების მიზეზი", $item['CEstNote'], $indicator['CEstNote']) ?></td>
            </tr>
        </table>

        <?= DrawView::historySubSectionRow("მაღაზიაში გადატანა")?>
        <table class="table-section">
            <tr>
                <td><?= DrawView::histDataUnit("თარიღი", $item['FEstDate'], $indicator['FEstDate']) ?></td>
                <td><?= DrawView::histDataUnit("მომხმარებელი", $item['FEstPerson'], $indicator['FEstPerson']) ?></td>
                <td><?= DrawView::histDataUnit("დეტალური შეფასების შედეგი", $item['FEstStatus'], $indicator['FEstStatus']) ?></td>
                <td><?= DrawView::histDataUnit("კორექტირებული თანხა", $item['FEstPrice'], $indicator['FEstPrice']) ?></td>
            </tr>
            <tr>
                <td colspan="4"><?= DrawView::histDataUnit("შენიშვნა / კორექტირების მიზეზი", $item['FEstNote'], $indicator['FEstNote']) ?></td>
            </tr>
        </table>
    </div>
<?php } ?>

<?php include_once 'simple_footer.php'; ?>