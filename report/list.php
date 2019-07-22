<?php 
include_once "../header.php";

$page = $_GET['page'];
if(!$page) {
    $page = 1;
}

$count = get_report_count();
$cur_num = $count - $_PAGE['list_num'] * ($page - 1) + 1; 
$list = get_report_list($page); 
?>

<h1 class="w3-border-bottom w3-border-light-grey w3-padding-16">Report List</h1>
<table class="w3-table w3-bordered w3-centered">
    <colgroup>
        <col width="10"/>
        <col width="110"/>
        <col width="*"/>
        <col width="100"/>
        <col width="170"/>
        <col width="20"/>
    </colgroup>
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Status</th>
        <th scope="col">Title</th>
        <th scope="col">Name</th>
        <th scope="col">Written Date</th>
        <th scope="col">View</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($list as $row) {
            $case_id = str_pad($row['case_id'], 3, '0', STR_PAD_LEFT);
            $case_status = $row['case_status'];
            $rowspan = count($row['reply']) + 1;
        ?> 
            <tr class="<?=$_COMMON['case_status_class'][$case_status]?>">
                <th rowspan=<?=$rowspan?>><?=$case_id?></th>
                <td rowspan=<?=$rowspan?>><?=$_COMMON['case_status'][$case_status]?></td>
                <td class="w3-left"><?=get_report_title($row, $page)?></td>
                <td><?=$row['name']?></td>
                <td><?=date('d-m-Y H:i:s', strtotime($row['register_datetime']))?></td>
                <td><?=$row['count']?></td>
            </tr>
        <?php
            foreach ($row['reply'] as $reply) { ?>
            <tr class="<?=$_COMMON['case_status_class'][$case_status]?>">
                <td class="w3-left"><?=get_report_title($reply, $page)?></td>
                <td><?=$reply['name']?></td>
                <td><?=date('d-m-Y H:i:s', strtotime($reply['register_datetime']))?></td>
                <td><?=$reply['count']?></td>
            </tr>
        <?php
            }
            $cur_num--;
        }
        ?>
    </tbody>
</table>
<div class="wrapper-button">
        <div class="wrpper-write-button">
            <a class="btn btn-success" href='form.php'>Write</a>
        </div>
        <? include "../pagination.php" ?> 
</div>

<?php
include_once "../footer.php";
?>
