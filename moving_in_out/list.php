<?php 
include_once "../header.php";

$page = $_GET['page'];
if(!$page) {
    $page = 1;
}

$count = get_moving_count();
$cur_num = $count - $_PAGE['list_num'] * ($page - 1); 
$list = get_moving_list($page); 
?>

<h1 class="w3-border-bottom w3-border-light-grey w3-padding-16">Moving In/Out Request</h1>
<table class="w3-table w3-bordered w3-centered">
    <colgroup>
        <col width="20px"/>
        <col width="150px"/>
        <col width="100px"/>
        <col width="200px"/>
        <col width="100px"/>
        <col width="*"/>
    </colgroup>
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Apt No</th>
        <th scope="col">Mobile</th>
        <th scope="col">Name</th>
        <th scope="col">Type</th>
        <th scope="col">Moving Date</th>
        <!-- <th scope="col"></th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($list as $key => $row) {
            $type = 'Moving ' . ($row['moving_status'] === 'I' ? 'In' : 'Out'); 
            $start_date = date('d-m-Y H:i:s', strtotime($row['start_datetime']));
            $end_date = date('d-m-Y H:i:s', strtotime($row['end_datetime']));
        ?> 
            <tr>
                <th><?=$cur_num?></th>   
                <td><?=$row['apt_no']?></td>
                <td><?=$row['mobile']?></td>
                <td><?=$row['name']?></td>
                <td><?=$type?></td>
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
            <!-- <button class="btn btn-success" onclick="addBooking()">Write</button> -->
        </div>
        <? include "../pagination.php" ?> 
</div>

<script>
function addBooking(info) {
    // let startDate = moment(info.startStr).format('YYYY-MM-DDThh:mm');
    // let endDate = moment(info.endStr).format('YYYY-MM-DDThh:mm');

    $('#modal-form').find('input:text').val('');
    $('#modal-form').modal('toggle');
}
</script>

<?php
include_once "../footer.php";
?>
