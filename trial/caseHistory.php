<?php

include_once 'DrawView.php';
include_once 'common_functions.php';
include_once 'simple_header.php';
//include_once '../config.php';
if (!isset($_SESSION['permissionM2']['m2history'])) {
    $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $folder . "/index.php";
    header("Location: $url");
}

$note = "შენიშვნა";
$caseID = $_GET['ID'];
//$caseID = 5366;
$output = "";

$case_sql = "
SELECT per_own.UserName AS owner, 
	di_st.ValueText AS case_status,
    di_stg.ValueText AS case_stage,
    di_inst.ValueText AS case_instance,
    di_loantype.ValueText AS loanType,
    ifNull(o.OrganizationName, '') AS 'org', 
    ifNull(b.BranchName, '') AS 'fil',
    di_ex_res.ValueText AS ExecResult,
    di_dut_res.ValueText AS DutyResult,
	cs.* 
from (
    SELECT 999999 AS hID, p.* FROM pcm_aplication p
	UNION
	SELECT ph.* FROM pcm_aplication_history ph) cs
LEFT JOIN personmapping per_own ON cs.OwnerID = per_own.ID
LEFT JOIN DictionariyItems di_st ON di_st.ID = cs.StatusID
LEFT JOIN DictionariyItems di_stg ON di_stg.ID = cs.StageID
LEFT JOIN DictionariyItems di_inst ON di_inst.ID = cs.`InstanceID`
LEFT JOIN DictionariyItems di_loantype ON di_loantype.ID = cs.`AgrLoanType`
LEFT JOIN DictionariyItems di_ex_res ON di_ex_res.ID = cs.`ExecResultID`
LEFT JOIN DictionariyItems di_dut_res ON di_dut_res.ID = cs.`DutyResultID`
LEFT JOIN Organizations o on o.ID = cs.AgrOrgID
LEFT JOIN organizationbranches b on b.ID = cs.AgrOrgBranchID

WHERE cs.ID = $caseID
ORDER BY hid
";

$instance_sql = "
SELECT 
	di_jtype.ValueText AS JudicialentityType,
    di_jname.ValueText AS Judicialentity,
    di_cur1.ValueText AS ClaimCur,
    di_send1.ValueText AS sentRes1,
    di_send2.ValueText AS sentRes2,
    di_dec_type.ValueText AS CourtDecType,
    di_cur2.ValueText AS decCur,
	i.* 
from (
    SELECT 999999 AS hID, p.* FROM pcm_aplication_instances p
	UNION
	SELECT ph.* FROM pcm_aplication_instances_history ph) i
	LEFT JOIN DictionariyItems di_jtype ON di_jtype.ID = i.`JudicialentityTypeID`
	LEFT JOIN DictionariyItems di_jname ON di_jname.ID = i.`JudicialentityD`
    LEFT JOIN DictionariyItems di_cur1 ON di_cur1.ID = i.`ClaimCurID`
    LEFT JOIN DictionariyItems di_send1 ON di_send1.ID = i.`CltoPerFirstSentResult`
    LEFT JOIN DictionariyItems di_send2 ON di_send2.ID = i.`CltoPerSecondSentResult`
    LEFT JOIN DictionariyItems di_dec_type ON di_dec_type.ID = i.`CourtDecTypeID`
    LEFT JOIN DictionariyItems di_cur2 ON di_cur2.ID = i.`CourtDecResCurID`

WHERE i.caseID = $caseID
ORDER BY i.typesID, hID
";

$result_cs = mysqli_query($conn, $case_sql);
$result_inst = mysqli_query($conn, $instance_sql);

$arrC = [];
$arrI = [];
foreach ($result_cs as $row) {
    $arrC[] = $row;
}

foreach ($result_inst as $row) {
    $arrI[] = $row;
}
$sepInstArr = [];
foreach ($arrI as $iRow) {
    $sepInstArr[$iRow['TypesID']][] = $iRow;
}

$arrOut = [];

foreach ($arrC as $cKey => $cRow) {
    $caseDate = $cRow['UpdateDate'] < '1' ? $cRow['CreateDate'] : $cRow['UpdateDate'];
    $arrOut[$cKey] = $cRow;
    $subArr = [];

    for ($x = 1; $x <= 3; $x++) {
        if (isset($sepInstArr[$x])) {
            foreach ($sepInstArr[$x] as $key => $iRow) {
                $instanceDate = $sepInstArr[$x][$key]['UpdateDate'] < '1' ? $sepInstArr[$x][$key]['CreateDate'] : $sepInstArr[$x][$key]['UpdateDate'];
                if ($instanceDate <= $caseDate && !isset($sepInstArr[$x][$key]['used'])) {
                    $sepInstArr[$x][$key]['used'] = 1;
                    $subArr[] = $sepInstArr[$x][$key];
                }
            }
        }
    }

    $arrOut[$cKey]['instances'] = $subArr;
}

for ($i = 0; $i < count($arrOut); $i++) {
    $item = $arrOut[$i];
    $instances = $item['instances'];

    $indicator = [];
    foreach ($item as $key => $val) {
        $indicator[$key] = 0;
    }
    if ($i > 0) {
        $preItem = $arrOut[$i - 1];
        foreach ($item as $key => $val) {
            if ($val != $preItem[$key]) {
                $indicator[$key] = 1;
            }
        }
    }
    $priceCorectionIndicator = 0;
    ?>
    <div class="hist-item">
        <p class="h-item-head">
            დრო: <?= $item['UpdateDate'] < "1" ? $item['CreateDate'] : $item['UpdateDate'] ?> -
            მომხმარებელი: <?= $item['UpdateDate'] < "1" ? $item['CreateUser'] : $item['UpdateUser'] ?>
        </p>
        <table class="table-section">
            <tr>
                <td><?= DrawView::histDataUnit("საქმის N", $item['ID'], $indicator['ID']) ?></td>
                <td><?= DrawView::histDataUnit("მფლობელი", $item['owner'], $indicator['owner']) ?></td>
                <td><?= DrawView::histDataUnit("დაწერის თარიღი", $item['OwnDate'], $indicator['OwnDate']) ?></td>
            </tr>
            <tr>
                <td><?= DrawView::histDataUnit("სტატუსი", $item['case_status'], $indicator['case_status']) ?></td>
                <td><?= DrawView::histDataUnit("ეტაპი", $item['case_stage'], $indicator['case_stage']) ?></td>
                <td><?= DrawView::histDataUnit("ინსტანცია", $item['case_instance']) ?></td>
                <td><?= DrawView::histDataUnit("მიღება", $item['ReceiveDate'], $indicator['ReceiveDate']) ?></td>
                <td><?= DrawView::histDataUnit("განაწილება", $item['DistrDate'], $indicator['DistrDate']) ?></td>
                <td><?= DrawView::histDataUnit("დასრულება", $item['CloseDate'], $priceCorectionIndicator) ?></td>
            </tr>
            <tr>
                <td><?= DrawView::histDataUnit("ხელშეკრულება N", $item['AgrNumber'], $indicator['AgrNumber']) ?></td>
                <td><?= DrawView::histDataUnit("გაფორმების თარიღი", $item['AgrDate'], $indicator['AgrDate']) ?></td>
                <td><?= DrawView::histDataUnit("სესხის ტიპი", $item['loanType'], $indicator['loanType']) ?></td>
                <td><?= DrawView::histDataUnit("ორგანიზაცა", $item['org'], $indicator['org']) ?></td>
                <td><?= DrawView::histDataUnit("ფილიალი", $item['fil'], $indicator['fil']) ?></td>

                <!--                <td>-->
                <?//= DrawView::histDataUnit("გასაცემი თანხა (კორექტირებული)", $item['CorTechPrice'] == 0 ? $item['SysTechPrice'] : $item['CorTechPrice'], $indicator['CorTechPrice']) ?><!--</td>-->
            </tr>
            <tr>
                <td><?= DrawView::histDataUnit("მსესხებელი (სახელი გვარი)", $item['DebFirstName'] . " " . $item['DebLastName'], $indicator['DebFirstName']) ?></td>
                <td><?= DrawView::histDataUnit("მსესხებლის პირადი N", $item['DebPrivateNumber'], $indicator['DebPrivateNumber']) ?></td>
                <td><?= DrawView::histDataUnit("მსესხებლის მისამართი", $item['DebAddress'], $indicator['DebAddress']) ?></td>
            </tr>
        </table>
        <?= DrawView::historySubSectionRow("სააღსრულებლო პროცესი") ?>
        <table class="table-section">
            <tr>
                <td><?= DrawView::histDataUnit("მოთხოვნა", $item['ExecReqDate'], $indicator['ExecReqDate']) ?></td>
                <td><?= DrawView::histDataUnit("მიღება", $item['ExecGetDate'], $indicator['ExecGetDate']) ?></td>
                <td><?= DrawView::histDataUnit("იძ. აღსრულების დაწყება", $item['ExecProcessDate'], $indicator['ExecProcessDate']) ?></td>
                <td><?= DrawView::histDataUnit("შედეგი", $item['ExecResult'], $indicator['ExecResult']) ?></td>
                <td><?= DrawView::histDataUnit("ჩამორიცხული თანხა", $item['ExecMoney'], $indicator['ExecMoney']) ?></td>
            </tr>
        </table>
        <?= DrawView::historySubSectionRow("ბაჟის დაბრუნების პროცესი") ?>
        <table class="table-section">
            <tr>
                <td><?= DrawView::histDataUnit("მოთხოვნა", $item['DutyReqDate'], $indicator['DutyReqDate']) ?></td>
                <td><?= DrawView::histDataUnit("მიღება", $item['DutyGetDate'], $indicator['DutyGetDate']) ?></td>
                <td><?= DrawView::histDataUnit("შედეგი", $item['DutyResult'], $indicator['DutyResult']) ?></td>
                <td><?= DrawView::histDataUnit("დაბრუნებული ბაჟი", $item['DutyMoney'], $indicator['DutyMoney']) ?></td>
            </tr>
        </table>
        <?= DrawView::historySubSectionRow("მორიგება საქმეზე") ?>
        <table class="table-section">
            <tr>
                <td><?= DrawView::histDataUnit("დაწყება", $item['SettStartDate'], $indicator['SettStartDate']) ?></td>
                <td><?= DrawView::histDataUnit("მორიგების თარიღი", $item['SettDate'], $indicator['SettDate']) ?></td>
                <td><?= DrawView::histDataUnit("თანხა ჯამურად", $item['Settbase'], $indicator['Settbase']) ?></td>
                <td><?= DrawView::histDataUnit("დამატებითი ინფორმაცია", $item['caseNote'], $indicator['caseNote']) ?></td>
            </tr>
        </table>

        <?php
        for ($ii = 0; $ii < count($instances); $ii++) {
            $instItem = $instances[$ii];
            $indicatorSbItem = [];
            foreach ($instItem as $key => $val) {
                $indicatorSbItem[$key] = 0;
            }
            $instN = $instItem['TypesID'];
            $preIndex = -1;
            foreach ($sepInstArr[$instN] as $kk => $vv){
                if ($vv['hID'] == $instItem['hID'])
                    break;
                $preIndex = $kk;
            }
            if ($preIndex >= 0){
                foreach ($sepInstArr[$instN][$preIndex] as $pKey => $pVal){
                    if ($pVal != $instItem[$pKey]) {
                        $indicatorSbItem[$pKey] = 1;
                    }
                }
            }

            $requestedAmountSum = $instItem['Claimbase'] + $instItem['ClaimPercent'] + $instItem['ClaimPenalty'] + $instItem['ClaimCost'];
            $requestedAmountSumIndicator = max($indicatorSbItem['Claimbase'] , $indicatorSbItem['ClaimPercent'] , $indicatorSbItem['ClaimPenalty'] , $indicatorSbItem['ClaimCost']);

            ?>
            <div class="hist-inst-item">
                <table class="table-section">
                    <tr>
                        <td><?= DrawView::histDataUnit("განსჯადი უწყების ტიპი", $instItem['JudicialentityType'], $indicatorSbItem['JudicialentityType']) ?></td>
                        <td><?= DrawView::histDataUnit("განსჯადი უწყების დასახელება", $instItem['Judicialentity'], $indicatorSbItem['Judicialentity']) ?></td>
                        <td>
                            <p class="h-subitem-head">
                                ინსტანცია: <b> <?= $instN ?>   </b>
                                დრო: <?= $instItem['UpdateDate'] < "1" ? $instItem['CreateDate'] : $instItem['UpdateDate'] ?> -
                                მომხმარებელი: <?= $instItem['UpdateDate'] < "1" ? $instItem['CreateUser'] : $instItem['UpdateUser'] ?>
                            </p>
                        </td>
                    </tr>
                </table>
                <?= DrawView::historySubSectionRow("სასარჩელო მოთხოვნა") ?>
                <table class="table-section">
                    <tr>
                        <td><?= DrawView::histDataUnit("ვალუტა", $instItem['ClaimCur'], $indicatorSbItem['ClaimCur']) ?></td>
                        <td><?= DrawView::histDataUnit("ძირი", $instItem['Claimbase'], $indicatorSbItem['Claimbase']) ?></td>
                        <td><?= DrawView::histDataUnit("%", $instItem['ClaimPercent'], $indicatorSbItem['ClaimPercent']) ?></td>
                        <td><?= DrawView::histDataUnit("პირგასამტეხლო", $instItem['ClaimPenalty'], $indicatorSbItem['ClaimPenalty']) ?></td>
                        <td><?= DrawView::histDataUnit("ხარჯები", $instItem['ClaimCost'], $indicatorSbItem['ClaimCost']) ?></td>
                        <td><?= DrawView::histDataUnit("ბაჟი", $instItem['ClaimDuty'], $indicatorSbItem['ClaimDuty']) ?></td>
                        <td><?= DrawView::histDataUnit("თანხა ჯამურად", $requestedAmountSum, $requestedAmountSumIndicator) ?></td>
                    </tr>
                </table>
                <?= DrawView::historySubSectionRow("სასამართლოსთვის სარჩელის ჩაბარება") ?>
                <table class="table-section">
                    <tr>
                        <td><?= DrawView::histDataUnit("ჩაბარების თარიღი", $instItem['ClaimdeliveryDate'], $indicatorSbItem['ClaimdeliveryDate']) ?></td>
                        <td><?= DrawView::histDataUnit("ელ.კოდები მომხმარებლის სახელი", $instItem['ClaimSysUserName'], $indicatorSbItem['ClaimSysUserName']) ?></td>
                        <td><?= DrawView::histDataUnit("ელ.კოდები პაროლი", $instItem['ClaimSysPassword'], $indicatorSbItem['ClaimSysPassword']) ?></td>
                        <td><?= DrawView::histDataUnit("მიღების თარიღი", $instItem['ClaimProceeedDate'], $indicatorSbItem['ClaimProceeedDate']) ?></td>
                        <td><?= DrawView::histDataUnit("მოსამართლე (სახ. გვარი)", $instItem['ClaimJudgeName'], $indicatorSbItem['ClaimJudgeName']) ?></td>
                        <td><?= DrawView::histDataUnit("თანაშემწე (სახ. გვარი)", $instItem['ClaimJudgeAssistant'], $indicatorSbItem['ClaimJudgeAssistant']) ?></td>
                        <td><?= DrawView::histDataUnit("საკონტაქტო ინფორმაცია", $instItem['ClaimJudgePhone'], $indicatorSbItem['ClaimJudgePhone']) ?></td>
                    </tr>
                </table>
                <?= DrawView::historySubSectionRow("მხარისათვის სარჩელის ჩაბარება") ?>
                <table class="table-section">
                    <tr>
                        <td><?= DrawView::histDataUnit("ჩაბარების თარიღი", $instItem['CltoPerDeliveryDate'], $indicatorSbItem['CltoPerDeliveryDate']) ?></td>
                        <td><?= DrawView::histDataUnit("I გაგზავნის თარიღი", $instItem['CltoPerFirstSentDate'], $indicatorSbItem['CltoPerFirstSentDate']) ?></td>
                        <td><?= DrawView::histDataUnit("I გაგზავნის შედეგი", $instItem['sentRes1'], $indicatorSbItem['sentRes1']) ?></td>
                        <td><?= DrawView::histDataUnit("II გაგზავნის თარიღი", $instItem['CltoPerSecondSentDate'], $indicatorSbItem['CltoPerSecondSentDate']) ?></td>
                        <td><?= DrawView::histDataUnit("II გაგზავნის შედეგი", $instItem['sentRes2'], $indicatorSbItem['sentRes2']) ?></td>
                        <td><?= DrawView::histDataUnit("ჩაბარების შესახებ სასამართლოსთვის შეტყობინების თარიღი", $instItem['CltoPerDeliveryToCourtDate'], $indicatorSbItem['CltoPerDeliveryToCourtDate']) ?></td>
                        <td><?= DrawView::histDataUnit("საჯარო წესით ჩაბარების შუამდგომლობის თარიღი", $instItem['CltoPerPublicDeliveryReqDate'], $indicatorSbItem['CltoPerPublicDeliveryReqDate']) ?></td>
                    </tr>
                </table>
                <?= DrawView::historySubSectionRow("______") ?>
                <table class="table-section">
                    <tr>
                        <td><?= DrawView::histDataUnit("შესაგებლის წარმოდგენის თარიღი", $instItem['ClaimContPresDate'], $indicatorSbItem['ClaimContPresDate']) ?></td>
                        <td><?= DrawView::histDataUnit("სხდომის ჩანიშვნის თარიღი", $instItem['CourtProcessPreDate'], $indicatorSbItem['CourtProcessPreDate']) ?></td>
                        <td><?= DrawView::histDataUnit("სხდომის თარიღი", $instItem['CourtProcessDate'], $indicatorSbItem['CourtProcessDate']) ?></td>
                    </tr>
                </table>
                <?= DrawView::historySubSectionRow("სასამართლო გადაწყვეტილება") ?>
                <table class="table-section">
                    <tr>
                        <td><?= DrawView::histDataUnit("გადაწყვეტილების ტიპი", $instItem['CourtDecType'], $indicatorSbItem['CourtDecType']) ?></td>
                        <td><?= DrawView::histDataUnit("გადაწყ. მიღების თარიღი", $instItem['CourtDecDate'], $indicatorSbItem['CourtDecDate']) ?></td>
                        <td><?= DrawView::histDataUnit("გადაწყ. ძალაში შესვლის თარიღი", $instItem['CourtDecActDate'], $indicatorSbItem['CourtDecActDate']) ?></td>
                        <td><?= DrawView::histDataUnit("ვალუტა", $instItem['decCur'], $indicatorSbItem['decCur']) ?></td>
                        <td><?= DrawView::histDataUnit("ძირი", $instItem['CourtDecResBase'], $indicatorSbItem['CourtDecResBase']) ?></td>
                        <td><?= DrawView::histDataUnit("%", $instItem['CourtDecResPercent'], $indicatorSbItem['CourtDecResPercent']) ?></td>
                        <td><?= DrawView::histDataUnit("პირგასამტეხლო", $instItem['CourtDecResPenalty'], $indicatorSbItem['CourtDecResPenalty']) ?></td>
                        <td><?= DrawView::histDataUnit("ხარჯები", $instItem['CourtDecResCost'], $indicatorSbItem['CourtDecResCost']) ?></td>
                    </tr>
                    <tr>
                        <td colspan="8"><?= DrawView::histDataUnit("დამატებითი ინფორმაცია", $instItem['Notice'], $indicatorSbItem['Notice']) ?></td>
                    </tr>
                </table>
            </div>
            <?php
        }
        ?>
    </div>

    <?php
}

include_once 'simple_footer.php'; ?>