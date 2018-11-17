<p>მომხმარებლის პაროლის მოქმედების ვადა</p>
<div class=" paraminput" >
    <div class="input-group">
        <input id="userpassduration" type="number" name="userpassduration" value="30" class="form-control" />  
        <span class="input-group-addon" id="basic-addon2">დღე</span>
    </div>
    <div>
        <button id="btn_saveuserpass" class="btn btn-sm btn-default paraminput">შენახვა</button>
    </div>
</div>

<p>ApplID-ის რეზერვაციის ვადა</p>
<div class=" paraminput" >
    <div class="input-group">
        <input id="applReservPeriod" type="number" name="applReservPeriod" value="60" class="form-control" />  
        <span class="input-group-addon">დღე</span>
    </div>
    <div>
        <button id="btn_savereservperion" class="btn btn-sm btn-default paraminput">შენახვა</button>
    </div>
</div>

<p>ცვლები</p>
<div id='cvlebi' class=" paraminput" >
    <table>
        <tr>
            <td>
                    <span>I ცვლა (დან - მდე)</span>
            </td><td>
                    <input id="inp_cvla0" type="number" name="applReservPeriod" value="0" min="0" max="23" class="form-control" /> 
            </td><td>
                    <input id="inp_cvla1" type="number" name="applReservPeriod" value="0" min="0" max="23" class="form-control" />
            </td>     
        </tr>
        <tr>
            <td>
                    <span>II ცვლა (დან - მდე)</span>
            </td><td>
                    <input id="inp_cvla2" type="number" name="applReservPeriod" value="0" min="0" max="23" class="form-control" />
            </td><td>
                    <input id="inp_cvla3" type="number" name="applReservPeriod" value="0" min="0" max="23" class="form-control" />
            </td>     
        </tr>
    </table>        
    <div>
        <button id="btn_save_cvlebi" class="btn btn-sm btn-default paraminput">შენახვა</button>
    </div>
</div>