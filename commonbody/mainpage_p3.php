
<!-- Appl IDs panel - f13       ******************     -->

<div id="pan_f13" class="panel panel-primary">
    <div class="panel-heading">
        <table id="table_p1_header" class="pan-header">
            <tr>
                <td class="pan-header-left">Apple IDs</td>
                <td class="pan-header-right"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></td>
            </tr>
        </table>
    </div>

    <div class="panel-body">

        <form id="form_13" method="post">
        <table class="inputs">
            <tr>
                <td>
                    <label for="sel_organization_f13">ორგანიზაცია</label>
                    <select class="form-control" id="sel_organization_f13" name="organization">
                        <option value="">აირჩიეთ...</option>
                    </select>
                </td>
                <td>
                    <label for="sel_branch_f13">ფილიალი</label>
                    <select class="form-control" id="sel_branch_f13" name="branch" disabled>
                        <option value="">აირჩიეთ...</option>
                    </select>
                </td>
                <td>
                    <label for="applID_f13">Appl ID</label>
                    <input type="text" class="form-control" id="applID_f13" placeholder="" name="applid">
                </td>
                <td>
                    <label for="sel_status_f13">სტატუსი</label>
                    <select class="form-control" id="sel_status_f13" name="status">
                        <option value="">აირჩიეთ...</option>
                    </select>
                </td>
                <td class="albuttom">
                    <button id="btn_search_f13" type="submit" class="btn btn-primary">ძებნა</button>
                </td>
            </tr>
        </table>
            <input id="f13_pageN" type="hidden" name="pageN" value="0" />
        </form>

        <p class="info">ძიების შედეგი</p>
        <table id="table_f13" class="datatable"></table>

        <nav aria-label="Page navigation">
            <ul id="f13_ul" class="pagination"></ul>
        </nav>

    </div>
</div>