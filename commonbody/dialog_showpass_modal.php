<div class="modal fade" id="dialog1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">პაროლის ნახვის მიზეზი</h5>            
            </div>
            <div class="modal-body">
                <form id="send_reason_from">
                    <?php
                        $sql = "
                        SELECT di.ID, di.Code, di.`ValueText` FROM `DictionariyItems` di
                        LEFT JOIN Dictionaries d
                        ON di.`DictionaryID` = d.ID
                        WHERE d.Code = 'pass_show_reasons'
                        order by `SortID` ";
                        
                        $result = mysqli_query($conn,$sql);
                        
                        foreach($result as $row){
                            echo '<input id="' . $row['Code'] . '" type="radio" name="answer" value="' . $row['ValueText'] . '"> <label for="' . $row['Code'] . '"> ' . $row['ValueText'] . '</label><br>';
                        }
                    ?>
                    <input id="sxvaRB" type="radio" name="answer" value="" checked="checked"> <label for="sxvaRB"> სხვა</label> <br>
                    
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">დაასაბუთეთ ნახვის საჭიროება:</label>
                        <textarea class="form-control" id="message-text" name="text_other"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">დახურვა</button>
                <button id="btndone" type="button" class="btn btn-primary" data-dismiss="modal" disabled>გაგზავნა</button>
            </div>
        </div>
    </div>
</div>