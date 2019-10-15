<div class="modal fade" id="dialogUserHist" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="histModalTiTle"></h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="d1_caseID" name="caseID" value="0">

                <table id="tb_user_hist" class="table-section table">
                    <thead>
                    <tr>
                        <?= headerRow(["ID", "მფლობელი", "თარიღი", "ინფორმაცია", "დამწერი"], 0, 1) ?>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button id="btnDoneD2" type="button" class="btn btn-primary" data-dismiss="modal">დახურვა</button>
            </div>
        </div>
    </div>
</div>