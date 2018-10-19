<?php
include_once '../header.php';
?>

<div id="pan_f11" class="panel panel-primary">
    <div class="panel-heading">
        <table id="table_p1_header" class="pan-header">
            <tr>
                <td class="pan-header-left">ხელშეკრულება და ხელშეკრულების პროექტები</td>
                <td class="pan-header-right"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></td>
            </tr>
        </table>
    </div>

    <div class="panel-body">
        <form id="form_11" method="post">
        <table class="inputs">
            <tr>
                <td>
                    <label for="agrN_f11">ხელშეკრულების პროექტის N</label>
                    <input type="text" class="form-control" id="agrN_f11" placeholder="" name="agrN">
                </td>
                <td class="albuttom">
                    <button id="btn_search_f11" type="submit" class="btn btn-primary">ძებნა</button>
                    <a id="f11_reset" class="btn btn-primary btn-sm">გასუფთავება</a>
                </td>
            </tr>
        </table>
            <input id="f11_pageN" type="hidden" name="pageN" value="0" />
        </form>

        <p class="info">ძიების შედეგი (იძებნება MAX 20 ჩანაწერი)</p>
        <table id="table_f11" class="datatable"></table>

        <nav aria-label="Page navigation">
            <ul id="f11_ul" class="pagination"></ul>
        </nav>

    </div>
</div>

<?php
include_once '../footer.php';
?>