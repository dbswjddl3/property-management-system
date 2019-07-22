<?php
include_once "../header.php";

$page = $_GET["page"];
$id = $_GET["id"];

$data = get_report_detail($id);
count_view($id); 
?>      

<h1 class="w3-border-bottom w3-border-light-grey w3-padding-16">Report View</h1>
<table class="table">
    <colgroup>
        <col width="150" />
        <col width="300" />
        <col width="150" />
        <col width="*" />
    </colgroup>
    <tr>
        <th>Email</th>
        <td><?= $data['email']; ?></td>
        <th>Name</th>
        <td><?= $data['name']; ?></td>
    </tr>
    <tr>
        <th>Homepage</th>
        <td ><?= $data['homepage']; ?></td>
        <th>Written Date</th>
        <td><?= $data['register_datetime']; ?></td>
    </tr>

    <? if ($data['date']) { ?>
    <tr>
        <th>Case Date</th>
        <td colspan="3"><?= $data['date']; ?></td>
    </tr>
    <? } ?>

    <tr>
        <th>Title</th>
        <td colspan="3"><?= $data['subject']; ?></td>
    </tr>
    <tr>
        <th>Content</th>
        <td colspan="3"><?= $data['content']; ?></td>
    </tr>
    <?php 
    if(count($data['images']) > 0) {
        $images = $data['images']; 
        ?>
    <tr>
        <th>Image</th>
        <td colspan="3">
            <div class="row">
                <div id="lightgallery" class="col-md-8">
                    <?php    
                    foreach ($images as $key => $value) { ?>
                        <a href="<?=$value->path?>">
                            <img src="<?=$value->path?>" class="img-fluid">
                        </a>
                    <? } ?>
                </div>
            </div>
        </td>
    </tr>
    <? } ?>
</table>

<div class="wrapper-button">
    <?php if ($data['case_status'] != 'C' && check_case_reply($id, $data['case_id']) === true) {?>
    <a class="btn btn-success" href="form.php?parent_id=<?=$id?>&page=<?=$page?>">Reply</a>
    <? } ?>
    <a class="btn btn-outline-success" href="list.php?page=<?= $page; ?>">List</a>
    <a class="btn btn-outline-success" href="form.php?id=<?=$id?>&page=<?=$page?>">Modify</a>
    <a class="btn btn-outline-danger" href="#" onclick="deleteReport('<?=$id?>', '<?=$data['case_id']?>', '<?=$_SESSION['name']?>')">Delete</a>
</div>

<?php
include_once "../footer.php";
?>