<?php

include_once 'header.php';

include_once '../commonbody/param_page_p1.php';

if ($_SESSION['M2UT'] == 'administrator') : ?>

<p>რამდენი დღით ადრე გვაცნობოს კრიტერიუმის ვადის გასვლა</p>
<div class="paraminput" >
    <div class="input-group">
        <input id="criteriaExpirePeriod" type="number" name="criteriaExpirePeriod" value="10" class="form-control" />
        <span class="input-group-addon">დღე</span>
    </div>
    <div>
        <button id="btnSaveNotinyPerion" class="btn btn-sm btn-default paraminput">შენახვა</button>
    </div>
</div>

<?php endif;

include_once 'footer.php';