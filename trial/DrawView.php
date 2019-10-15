<?php
/**
 * Created by PhpStorm.
 * User: natub
 * Date: 7/14/2019
 * Time: 10:57 PM
 */

class DrawView
{

    static function selectorWithBtn($id = "", $title = "", $name, $dataNN)
    {
        $div_id = $id . "_btns_div";
        $id = $name . "_" . $id;

        $name_and_btns = "<table style=\"width: 100%\">
                        <tbody>
                        <tr>
                            <td style=\"width: min-content\">
                                <label for=\"$id\">$title</label>
                            </td>
                            <td>
                                <div id=\"$div_id\" class=\"toright\">
                                    <i class=\"fas fa-plus fa-2x btn\"></i>
                                    <i class=\"fas fa-edit fa-2x btn\"></i>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>";

        $selector = "
    <select class=\"form-control\" id=\"$id\" name=\"$name\" data-nn=\"$dataNN\">
    </select>";
        return $name_and_btns . $selector;
    }

    static function selector($id = "", $title = "", $name = "", $options = [], $form = null)
    {
        $cssClass = "";
        $all_comp = "";
        $id = $name . "_" . $id;
        $form_attr = $form == null ? "" : "form=\"$form\"";
        if ($title != ""){
            $all_comp = '<label for="' . $id . '">' . $title . '</label>';
            $cssClass = "form-control";
        }
        $all_comp .= '<select class="'. $cssClass.'" id="' . $id . '" name="' . $name . '" '. $form_attr .'> '. self::formingOption($options) .' </select>';
        return $all_comp;
    }

    static function doubleDateInput($id = "", $name, $title, $dataField = "", $type = "text", $form = null)
    {
        $name1 = $name . "_from";
        $name2 = $name . "_to";
        $id1 = $name1 . "_" . $id ;
        $id2 = $name2 . "_" . $id ;
        $form_attr = $form == null ? "" : "form=\"$form\"";
        $view = '<label for="' . $id . '">' . $title . '</label>
                <table class="table-section">
                    <tr>
                        <td>
                            <input type="' . $type . '" class="form-control" id="' . $id1 . '" name="' . $name1 . '" data-field="'. $dataField .'" '. $form_attr .'>
                        </td>
                        <td>
                            <input type="' . $type . '" class="form-control" id="' . $id2 . '" name="' . $name2 . '" data-field="'. $dataField .'" '. $form_attr .'>
                        </td>
                    </tr>
                </table>';
//        $view = '
//        <label for="' . $id . '">' . $title . '</label>
//        <input type="' . $type . '" class="form-control" id="' . $id . '" placeholder="" name="' . $name . '" data-field="'. $dataField .'" '. $form_attr .'/>';
        return $view;
    }

    static function simpleInput($id = "", $name, $title, $dataField = "", $type = "text", $form = null)
    {
        $id = $name . "_" . $id;
        $form_attr = $form == null ? "" : "form=\"$form\"";
        $view = '
        <label for="' . $id . '">' . $title . '</label>
        <input type="' . $type . '" class="form-control" id="' . $id . '" placeholder="" name="' . $name . '" data-field="'. $dataField .'" '. $form_attr .'/>';
        return $view;
    }

    static function simpleCheckbox($id = "", $name, $title, $dataField = "", $type = "text")
    {
        $id = $name . "_" . $id;
        $view = '
        <input type="' . $type . '" id="' . $id . '" placeholder="" name="' . $name . '" data-field="'. $dataField .'" />
        <label for="' . $id . '">' . $title . '</label>';
        return $view;
    }

    static function btnsBackCancel()
    {
        $view =
            '<div>
                <i class="fas fa-arrow-alt-circle-left fa-2x btn "></i>
                <i class="fas fa-times fa-2x btn "></i>
            </div>';
        return $view;
    }

    static function btnsEditSaveCancel()
    {
        $view =
            '<div>
                <i class="fas fa-edit fa-2x btn"></i>
                <i class="fas fa-check fa-2x btn"></i>
                <i class="fas fa-times fa-2x btn"></i>
            </div>';
        return $view;
    }

    static function radioGroupRow($title = "", $name_attr)
    {
        $id1 = $name_attr . "_1";
        $id2 = $name_attr . "_2";
        $view = "
                        <tr data-id='0' data-answ='0'>
                            <td style='width: 80px'>
                        <label><input class='answ1' type='radio' name=\"$name_attr\" value=\"1\" required onclick='answer1()'> დიახ  </label>
                            </td>
                            <td style='width: 70px'>
                        <label><input class='answ2' type='radio' name=\"$name_attr\" value=\"0\" required onclick='answer2(this)'> არა</label>
                            </td>
                            <td  style='width: auto'>
                        <span>$title</span>
                            </td>
                        </tr>";
        return $view;
    }

    static function titleRow($left_title = "", $right_title = "", $sync_btn = false, $end_btns = false)
    {
        $syncBtn = $sync_btn ? "<td style=\"width: 1%\"><i class=\"fas fa-sync-alt fa-2x btn\"></td>" : "";

        if ($end_btns) {
            $endContent = self::btnsEditSaveCancel();
        } else {
            $endContent = "<label>$right_title <span class=\"red-in-title\"></span></label>";
        }

        $view =
            "<table class=\"title-table\">
                        <tbody>
                        <tr>
                            $syncBtn
                            <td>
                                <label>$left_title</label>
                            </td>
                            <td>
                                <div class=\"toright\">
                                    $endContent
                                </div>
                            </td>
                        </tr>
                        </tbody>
    </table>";

        return $view;
    }

    static function horizontalInput($title = "", $name, $type = "text", $list = [], $pl_holder = "₾")
    {
        $id = $name."_id";

        if ($type == "select"){
            $inputFeald = "
                <select name=\"$name\" id=\"$id\" class=\"form-control\">". self::formingOption($list) ."</select>";
        }else{
            $inputFeald = "<input id=\"$id\" type=\"$type\" class=\"form-control\" placeholder=\"$pl_holder\" name=\"$name\"/>";
        }

        $view = "
            <td><label for=\"$id\">$title</label></td>
            <td>$inputFeald</td>";

        return $view;
    }

    function formingOption($dataList){
        $opt = "";
        foreach ($dataList as $item){
            $vv = $item['vv'];
            $vt = $item['tt'];
            if (isset($item['code'])){
                $vc = $item['code'];
                $opt .= "<option value=\"$vv\" data-code=\"$vc\">$vt</option>";
            }else{
                $opt .= "<option value=\"$vv\">$vt</option>";
            }
        }
        return $opt;
    }

    static function criteriaEditRow($impactList, $impactTypeList, $statesList){
        $formControl = "form-control";
//        $formControl = "";
        $view = "
            <td class=\"crit-name\"></td>
            <td>
                <select name=\"impact\" class=\"$formControl id_impact\">" . self::formingOption($impactList) . "</select>
            </td>
            <td>
                <select name=\"impact_type\" class=\"$formControl id_type\">" . self::formingOption($impactTypeList) . "</select>
            </td>
            <td class=\"toright three-btn-width\">
                <input type=\"number\" class=\"$formControl id_size\" placeholder=\"\" name=\"size\"/>
            </td>
            <td>
                <label><input class=\"chk-box\" type=\"checkbox\" name=\"is_main\" value=\"1\" onclick=\"showDetails(this)\"/> ძირ.</label>
            </td>
            <td class=\"two-btn-width\">
                <input type=\"number\" class=\"$formControl id_day\" placeholder=\"დღე\" name=\"rev_day\" style=\"width: 75px\"/>
            </td>
            <td>
                <input type=\"date\" class=\"$formControl id_date\" placeholder=\"\" name=\"rev_date\"/>
            </td>
            <td>
                <select name=\"status\" class=\"$formControl id_status\">" . self::formingOption($statesList) . "</select>
            </td>
            <td class=\"toright three-btn-width\">".self::btnsEditSaveCancel()."</td>";
        return $view;
    }

    static function subTitle($title){
        $view = "<div class=\"subtitle\">
                    <span>$title</span>
                </div>";

        return $view;
    }
}