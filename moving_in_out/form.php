<?php
include_once "../header.php";

$parent_id = $_GET['parent_id'];
$page = $_GET['page'];
$id = $_GET["id"];

if ($id) {
    $data = get_report_detail($id);
    $mode = 'update';
    $start_datetime = date('Y-m-d\TH:i', strtotime($data['start_datetime']));
    $end_datetime = date('Y-m-d\TH:i', strtotime($data['end_datetime']));
} else {
    $start_datetime = date('Y-m-d\TH:00');
    $end_datetime = date('Y-m-d\TH:00', strtotime('+2 hour'));

    $mode = 'insert';
}

$title = 'Moving In/Out Request';
?>

<h1 class="w3-border-bottom w3-border-light-grey w3-padding-16"><?=$title?></h1>
<form id="form" name="form" method="post" >
    <input type="hidden" name="mode" value="insert"> 
    <input type="hidden" name="page" value="<?=$page?>"> 
    <input type="hidden" name="building_id" value="<?=$_SESSION['building']?>"> 
    
    <table class="table">
        <colgroup>
            <col width="80">
            <col width="*">
        </colgroup>

        <tr>
            <th>Apt No</th>
            <td>
                <input type="text" name="apt_no" maxlength="50" value="<?=$data['apt_no']?>" />
            </td>
        </tr>

        <tr>
            <th>Name</th>
            <td>
                <input type="text" name="name" maxlength="20" value="<?=$data['name']?>" />
            </td>
        </tr>

        <tr>
            <th>Mobile</th>
            <td> 
                <input type="text" name="mobile" maxlength="20" value="<?=$data['mobile']?>" /> 
            </td>
        </tr>

        <tr>
            <th>Type</th>
            <td> 
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-dark active">
                        <input type="radio" name="moving_status" value="I" checked /> Move In
                    </label>
                    <label class="btn btn-outline-dark">
                        <input type="radio" name="moving_status" value="O" /> Move Out
                    </label>
                </div>
            </td>
        </tr>          
        
        <tr class="wrapper-date">
            <th>Moving Date</th>
            <td> 
                <input type="datetime-local" name="start_datetime" value="<?=$start_datetime?>" min="<?=$start_datetime?>" /> ~ 
                <input type="datetime-local" name="end_datetime" value="<?=$end_datetime?>" min="<?=$start_datetime?>" />
            </td>
        </tr>
    </table>

    <div class="wrapper-button">
        <button class="btn btn-primary btn-loading" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
        </button>
        <input class="btn btn-success btn-submit" type="button" onclick="submitMovingForm()" value="Submit" />
        <input class="btn btn-outline-success" type="button" onclick="history.back()" value="Back" />
    </div>
</form>

<script>
$(document).ready(function() {
    $("input[type=radio][name=case_status]").change(function() {
        if ($(this).val() === 'C') {
            $(".wrapper-date").hide();
        } else {
            $(".wrapper-date").show();
        }
    })
});
</script>

<?php
include_once "../footer.php";
?>