<div class="modal fade" id="dialogUserChange" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeModalTiTle">საქმის მფლობელის შეცვლა</h5>
            </div>
            <div class="modal-body">
                <form id="userChForm">
                    <input type="hidden" id="ownerID_old" name="old_owner_id" value="0">
                    <input type="hidden" id="d1_caseID" name="caseID" value="0">

                    <table class="table table-section">
                        <tr>
                            <td>
                                <?= DrawView::simpleInput("D1", "old_owner", "არსებული მფლობელი") ?>
                            </td>
                            <td>
                                <?= DrawView::selector("D1", "ახალი მფლობელი", "new_owner", getOwners($conn, 4)) ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="form-group">
                                    <label for="commentD1" class="col-form-label">საქმის გადაწერის მიზეზი / დამატებითი ინფორმაცია</label>
                                    <textarea class="form-control" id="commentD1" name="comment_D1"></textarea>
                                </div>
                            </td>
                        </tr>
                    </table>

                </form>
            </div>
            <div class="modal-footer">
                <button id="btnDoneD1" type="button" class="btn btn-primary" data-dismiss="modal">დამახსოვრება</button>
            </div>
        </div>
    </div>
</div>