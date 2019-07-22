<?php
include_once "../header.php";

$page = $_GET["page"];
$id = $_GET["id"];

$data = get_report_detail($id);
count_view($id); // 조회수 증가
?>

<h1 class="w3-border-bottom w3-border-light-grey w3-padding-16"><?= get_field_name('case_status', $data['case_status']); ?></h1>
<table class="table">
    <colgroup>
        <col width="150" />
        <col width="*" />
        <col width="150" />
        <col width="250" />
    </colgroup>
    
    <tr>
        <th>WRITTEN BY</th>
        <td><?= $data['name']; ?></td>
        <th>WRITTEN DATE</th>
        <td><?= $data['register_datetime']; ?></td>
    </tr>

    <tr>
        <th>E-MAIL</th>
        <td><?= $data['email']; ?></td>
        <th>HOMEPAGE</th>
        <td colspan="3"><?= $data['homepage']; ?></td>
    </tr>

    <? if ($data['date']) { ?>
    <tr>
        <th>CASE DATE</th>
        <td colspan="3"><?= $data['date']; ?></td>
    </tr>
    <? } ?>

    <tr>
        <th>TITLE</th>
        <td colspan="3"><?= $data['subject']; ?></td>
    </tr>
    <tr>
        <th>CONTENTS</th>
        <td colspan="3"><?= $data['content']; ?></td>
    </tr>
    <?php 
    if(count($data['images']) > 0) {
        $images = $data['images']; 
        ?>
    <tr>
        <th>IMAGES</th>
        <td colspan="3">
            <? include "../image_slide.php"; ?>
        </td>
    </tr>
    <? } ?>
</table>

<div class="wrapper-button">
    <?php if (check_case_reply($id, $data['case_id']) === true) {?>
    <a class="btn btn-success" href="form.php?parent_id=<?=$id?>&page=<?=$page?>">Reply</a>
    <? } ?>
    <a class="btn btn-outline-success" href="list.php?page=<?= $page; ?>">List</a>
    <a class="btn btn-outline-success" href="form.php?id=<?=$id?>&page=<?=$page?>">Modify</a>
    <a class="btn btn-outline-danger" href="#" onclick="deleteReport('<?=$id?>', '<?=$_SESSION['name']?>')">Delete</a>
</div>

<?php
include_once "../footer.php";
?>