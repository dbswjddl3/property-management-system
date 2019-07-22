<?php
include_once "../header.php";

$parent_id = $_GET['parent_id'];
$page = $_GET['page'];
$id = $_GET["id"];

if ($id) {
    $data = get_report_detail($id);
    $mode = 'update';
    $title = 'Report Edit';
    $start_datetime = date('Y-m-d\TH:i', strtotime($data['start_datetime']));
    $end_datetime = date('Y-m-d\TH:i', strtotime($data['end_datetime']));
} else {
    $start_datetime = date('Y-m-d\TH:00');
    $end_datetime = date('Y-m-d\TH:00', strtotime('+2 hour'));

    $mode = 'insert';
    $title = 'Booking Request';
}
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
            <th>Facility</th>
            <td> 
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="facility[]" value="Entertaining Room 1" class="custom-control-input" id="room1">
                    <label class="custom-control-label" for="room1">Entertaining Room 1</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="facility[]" value="Entertaining Room 2" class="custom-control-input" id="room2">
                    <label class="custom-control-label" for="room2">Entertaining Room 2</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="facility[]" value="Cinema" class="custom-control-input" id="cinema">
                    <label class="custom-control-label" for="cinema">Cinema</label>
                </div>
            </td>
        </tr>          
        
        <tr class="wrapper-date">
            <th>Booking Date</th>
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
        <input class="btn btn-success btn-submit" type="button" onclick="submitBookingForm()" value="Submit" />
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