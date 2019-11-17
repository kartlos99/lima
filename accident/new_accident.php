<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 10/3/19
 * Time: 3:43 PM
 */
include_once 'DrawView.php';
include_once 'common_functions.php';
include_once 'header.php';
$id_simple = "id";
$note = "შენიშვნა";
$caseForm = "caseform";
$required = "required";
?>

    <table class="title-table">
        <tbody>
        <tr>

            <td>
                <label>ინციდენტი</label>
            </td>
            <td>
                <div class="toright">
                    <div class="inline-div">
                        <span id="caseN" class="red-in-title">case N</span>
                    </div>
                    <div class="inline-div">
                        <span>მფლობელი</span> <br/>
                        <span id="currOwner">user</span>
                    </div>
                    <div class="inline-div">
                        <span>დაწერის თარიღი</span> <br/>
                        <input type="date" id="get_started_date_id" name="get_started_date" form="caseform">
                    </div>
                    <div class="inline-div">
                        <i id="btnUserCh" class="fas fa-users btn"></i>
                        <i id="btnUserHist" class="fas fa-history btn"></i>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <form id="accident_form" action="">
        <input type="hidden" id="caseID" name="caseID" value="0">
        <input type="hidden" id="ownerID" name="ownerID" value="0">
        <input type="hidden" id="userID" name="userID" value="<?= $_SESSION['userID'] ?>">


        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <?= DrawView::selector($id_simple, "ტიპი", "TypeID", getDictionariyItems($conn, 'im_type'), $required) ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "კრიტიკულობა", "PriorityID", getDictionariyItems($conn, 'im_priority'), $required) ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "სტატუსი", "StatusID", getDictionariyItems($conn, 'im_status'), $required) ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "მფლობელი პირი", "OwnerID", getOwners($conn, 3)) ?>
                </td>
                <!--                <td>-->
                <!--                    <button class="btn"><i class="fas fa-history"></i></button>-->
                <!--                </td>-->
            </tr>
            </tbody>
        </table>
        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <?= DrawView::selector($id_simple, "ორგანიზაცა", "organization", [], $required) ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ფილიალი", "filial") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "AgrNumber", "ხელშეკრულება N") ?>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="table-section">
            <tr>
                <td>
                    <?= DrawView::simpleInput($id_simple, "FactDate", "დაფიქსირების დრო", "", "date", $required) ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "FactDateTime", " ", "", "time") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "აღმომჩენი პირი", "DiscovererID", getPersons($conn, 'founder'), $required) ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "DiscoveryDate", "აღმოჩენის დრო", "", "date", $required) ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "DiscoveryDateTime", " ", "", "time") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "დამრღვევი პირის დამატება", "guiltyPersonID", getPersons($conn, 'violator')) ?>
                </td>
                <td>
                    <button id="addGuiltyPerson" class="btn"><i class="fas fa-plus"></i></button>
                </td>
            </tr>
        </table>
        <table class="table-section">
            <tr>
                <td>
                    <table class="table-section">
                        <tr>
                            <td>
                                <?= DrawView::selector($id_simple, "კატეგორია", "CategoryID", [], $required) ?>
                            </td>
                            <td>
                                <?= DrawView::simpleInput($id_simple, "CategoryOther", "სხვა კატეგორია") ?>
                            </td>
                        </tr>
                    </table>
                    <table class="table-section">
                        <tr>
                            <td>
                                <?= DrawView::selector($id_simple, "ქვე კატეგორია", "SubCategoryID", [], $required) ?>
                            </td>
                            <td>
                                <?= DrawView::simpleInput($id_simple, "SubCategoryOther", "სხვა ქვე კატეგორია") ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 280px">
                    <div id="divGuiltyPersons" class="kriterias-box"><ul></ul></div>
                </td>
            </tr>
        </table>

        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <div>
                        <label class="required" for="accident_description_<?= $id_simple ?>">ინციდენტის აღწერა</label>
                    </div>
                    <div>
                        <textarea name="RequetsDescription" id="accident_description_<?= $id_simple ?>" rows="7"
                                  required></textarea>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <?= DrawView::titleRow("ინციდენტის მოგვარება") ?>

        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <?= DrawView::selector($id_simple, "შემსრულებელი პირი", "SolverID", getDictionariyItems($conn, 'exec_status'), $caseForm) ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "DurationDeys", "ხანგრძლივობა (დღე, საათი)", "", "number") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "DurationHours", "", "", "number") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "SolveDate", "აღმოფხვრის დრო", "", "date") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "SolveDateTime", " ", "", "time") ?>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <div>
                        <label class="" for="solv_description_<?= $id_simple ?>">ინციდენტის მოგვარების აღწერა</label>
                    </div>
                    <div>
                        <textarea name="SolvDescription" id="solv_description_<?= $id_simple ?>" rows="7"></textarea>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <?= DrawView::titleRow("დამატებითი პარამეტრები") ?>
        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <?= DrawView::simpleCheckbox($id_simple, "NotInStatistics", "არ მონაწილეობს სტატისტიკაში", "", "checkbox") ?>
                </td>
                <td class="toright">
                    <button id="btnSave" class="btn"><b>დამახსოვრება</b></button>
                </td>
            </tr>
            </tbody>
        </table>

    </form>

    <br/>
    <table class="table-section">
        <tbody>
        <tr>
            <td>
                <div>
                    <label class="" for="case_note_<?= $id_simple ?>">შენიშვნები და სხვა ინფორმაცია</label>
                </div>
                <div>
                    <textarea name="Comment" id="case_note_<?= $id_simple ?>" rows="3"></textarea>
                </div>
            </td>
            <td style="padding: 6px">
                <button class="btn"><i class="fas fa-plus"></i></button>
            </td>
        </tr>
        </tbody>
    </table>

    <table id="tb_comment_list" class="table-section table">
        <thead>
        <tr>
            <?= headerRow(["ID", "შენიშვნა", "მომხმარებელი", "თარიღი"], 0, 1) ?>
        </tr>
        </thead>
        <tbody></tbody>
    </table>


<?php
include_once 'userChangeModal.php';
include_once 'userHistModal.php';
include_once 'footer.php';
?>