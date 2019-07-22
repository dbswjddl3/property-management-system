<?php 
include_once "../header.php";
include_once "../booking/modal.php";

$page = $_GET['page'];
if(!$page) {
    $page = 1;
}

$count = get_booking_count();
$cur_num = $count - $_PAGE['list_num'] * ($page - 1); 
$list = get_booking_list($page); 
?>

<h1 class="w3-border-bottom w3-border-light-grey w3-padding-16">Booking Request</h1>
<table class="w3-table w3-bordered w3-centered">
    <colgroup>
        <col width="20px"/>
        <col width="100px"/>
        <col width="100px"/>
        <col width="200px"/>
        <col width="*"/>
        <col width="350px"/>
    </colgroup>
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Apt No</th>
        <th scope="col">Mobile</th>
        <th scope="col">Name</th>
        <th scope="col">Request Facility</th>
        <th scope="col">Booking Date</th>
        <!-- <th scope="col"></th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($list as $key => $row) {
            $facility = implode(', ', json_decode($row['facility']));
            $start_date = date('d-m-Y H:i:s', strtotime($row['start_datetime']));
            $end_date = date('d-m-Y H:i:s', strtotime($row['end_datetime']));
        ?> 
            <tr>
                <th><?=$cur_num?></th>   
                <td><?=$row['apt_no']?></td>
                <td><?=$row['mobile']?></td>
                <td><?=$row['name']?></td>
                <td><?=$facility?></td>
                <td><?="{$start_date} ~ {$end_date}"?></td>
                <!-- <td><a class="btn btn-outline-success" href='form.php?parent_seq=<?=$row['seq']?>'>Reply</a></td> -->
            </tr>
        <?php
            $cur_num--;
        }
        ?>
    </tbody>
</table>
<div class="wrapper-button">
        <div class="wrpper-write-button">
            <a class="btn btn-success" href='form.php'>Write</a>
            <!-- <button class="btn btn-success" onclick="modal()">Write</!--> 
        </div>
        <? include "../pagination.php" ?> 
</div>

<script>
function modal() {
    $('#modal-form').find('input:text').val('');
    $('#modal-form').modal('toggle');
}
</script>

<?php
include_once "../footer.php";
?>
