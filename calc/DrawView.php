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

    static function selector($id = "", $title = "", $name = "", $options = [])
    {
        $id = $name . "_" . $id;
        $opt = "";
        foreach ($options as $item){
            $vv = $item['vv'];
            $vt = $item['tt'];
            $opt .= "<option value=\"$vv\">$vt</option>";
        }

        $all_comp = '
    <label for="' . $id . '">' . $title . '</label>
    <select class="form-control" id="' . $id . '" name="' . $name . '"> '. $opt .' </select>';
        return $all_comp;
    }

    static function simpleInput($id = "", $name, $title, $dataField = "", $type = "text")
    {
        $id = $name . "_" . $id;
        $view = '
        <label for="' . $id . '">' . $title . '</label>
        <input type="' . $type . '" class="form-control" id="' . $id . '" placeholder="" name="' . $name . '" data-field="'. $dataField .'" />';
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
                        <tr>
                            <td style='width: 80px'>
                        <input id=\"$id1\" type=\"radio\" name=\"$name_attr\" value=\"1\" required>
                        <label for=\"$id1\"> დიახ  </label>
                            </td>
                            <td style='width: 70px'>
                        <input id=\"$id2\" type=\"radio\" name=\"$name_attr\" value=\"0\" required>
                        <label for=\"$id2\"> არა</label>
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

    static function horizontalInput($title = "", $name, $type = "text", $list = [], $pl_holder = "GEL")
    {
        $id = $name."_id";
        $opt = "";
        foreach ($list as $item){
            $vv = $item['vv'];
            $vt = $item['tt'];
            $opt .= "<option value=\"$vv\">$vt</option>";
        }

        if ($type == "select"){
            $inputFeald = "
                <select name=\"$name\" id=\"$id\" class=\"form-control\">
                    $opt
                </select>";
        }else{
            $inputFeald = "<input id=\"$id\" type=\"$type\" class=\"form-control\" placeholder=\"$pl_holder\" name=\"$name\"/>";
        }

        $view = "
            <td class=\"toright\"><label for=\"$id\">$title</label></td>
            <td>$inputFeald</td>";

        return $view;
    }

    static function criteriaEditRow(){
        $view = "
            <td class=\"criteria-name\"></td>
            <td>
                <select name=\"impact\" class=\"form-control id_impact\">
                    <option value=\"1\">1</option>
                    <option value=\"3\">3</option>
                </select>
            </td>
            <td>
                <select name=\"impact_type\" class=\"form-control id_type\">
                    <option value=\"1\">1</option>
                    <option value=\"3\">3</option>
                </select>
            </td>
            <td>
                <input type=\"number\" class=\"form-control id_size\" placeholder=\"\" name=\"size\"/>
            </td>
            <td>
                <label><input type=\"checkbox\" name=\"is_main\" value=\"1\" onclick=\"showDetails(this)\"/> ძირ.</label>
            </td>
            <td>
                <input type=\"number\" class=\"form-control id_day\" placeholder=\"დღე\" name=\"price_competitor\"/>
            </td>
            <td>
                <input type=\"date\" class=\"form-control id_date\" placeholder=\"\" name=\"price_competitor\"/>
            </td>
            <td>
                <select name=\"status\" class=\"form-control id_status\">
                    <option value=\"1\">1</option>
                    <option value=\"3\">3</option>
                </select>
            </td>
            <td class=\"toright three-btn-width\">".self::btnsEditSaveCancel()."</td>";
        return $view;
    }
}