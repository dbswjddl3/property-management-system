<?php
include_once "../header.php";

$parent_id = $_GET['parent_id'];
$id = $_GET['id'];
$page = $_GET['page'];

if ($id) {
    $mode = 'update';
    $title = 'Report Edit';
    $data = get_report_detail($id);
} else {
    $mode = 'insert';
    $title = 'Report Write';

    if ($parent_id) {
        $parent = get_report_detail($parent_id);
        $data = get_reply_detail($parent);
    } else {
        $data['start_date'] = date('d-m-Y');
        $data['start_time'] = date('H') + 1;
    }
    
    $data['email'] = $_SESSION['id'];
    $data['name'] = $_SESSION['name'];
}
?>

<h1 class="w3-border-bottom w3-border-light-grey w3-padding-16"><?=$title?></h1>
<form id="form" name="form" method="post" >
    <input type="hidden" name="page" value="<?=$page?>"> 
    <input type="hidden" name="mode" value="<?=$mode?>"> 
    <input type="hidden" name="id" value="<?=$id?>"> 
    <input type="hidden" name="parent_id" value="<?=$parent_id?>"> 
    <input type="hidden" name="case_id" value="<?=$data['case_id']?>"> 
    <input type="hidden" name="depth" value="<?=$data['depth']?>"> 
    <input type="hidden" name="building_id" value="<?=$_SESSION['building']?>"> 
    <input type="hidden" name="name" value="<?=$data['name']?>" readonly="readonly" />
    <input type="hidden" name="email" value="<?=$data['email']?>" readonly="readonly" /> 

    <?php 
    if ($mode === 'insert') {
        ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Status</label>
        <div class="col-sm-10">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <?php
            if (!$parent_id) { ?>
                <label class="btn btn-outline-dark active">
                    <input type="radio" name="case_status" value="I" checked /> Initial Case
                </label>
            <? } else { ?>
                <label class="btn btn-outline-dark active">
                    <input type="radio" name="case_status" value="P" checked /> Progress Case
                </label>
                <label class="btn btn-outline-dark">
                    <input type="radio" name="case_status" value="C" /> Close Case
                </label>
            <? } ?>
            </div>
        </div>
    </div>
    <? } ?>      
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Homepage</label>
        <div class="col-sm-10">
            <input type="text" name="homepage" maxlength="60" value="<?=$data['homepage']?>" placeholder="Homepage" class="form-control"> 
        </div>
    </div>
    <div class="wrapper-date form-group row">
        <label class="col-sm-2 col-form-label">Date</label>
        <div class="col-sm-10">
            <div class="wrapper-datepicker">
                <select name="start_time" class="custom-select"><?=get_time_options($data['start_time'])?></select>
                <input type="text" name="start_date" class="start_datepicker" value="<?=$data['start_date']?>">
            <? if ($parent_id) { ?>
                <span class="to_mark">~</span>
                <select name="end_time" class="custom-select"><?=get_time_options($data['end_time'])?></select>
                <input type="text" name="end_date" class="end_datepicker" value="<?=$data['end_date']?>">
            <? } ?>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Title</label>
        <div class="col-sm-10">
            <input type="text" name="subject" maxlength="180" value="<?= $data['subject'] ?>" placeholder="Title" class="form-control" > 
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Content</label>
        <div class="col-sm-10">
            <textarea name="content" style="display: none;"></textarea> 
            <div id="content"><?=$data['content']?></div>
        </div>
    </div>
    <?php 
    if(count($parent['images']) > 0) {
        $images = $parent['images']; ?>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Initial Images</label>
            <div class="col-sm-10">
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
            </div>
        </div>
    <? } ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Images</label>
        <div class="file-wrapper col-sm-10">
            <div class="custom-file-container" data-upload-id="images"><label style="display:none"><a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">&times;</a></label><label class="custom-file-container__custom-file"><input type="file" class="custom-file-container__custom-file__custom-file-input" accept="*" multiple aria-label="Choose File"><span class="form-control custom-file-container__custom-file__custom-file-control"></span></label>
                <div class="custom-file-container__image-preview">
                    <?php 
                    if ($mode === 'update') { 
                        foreach ($data['images'] as $key => $img) { ?>
                        <div class="custom-file-container__image-multi-preview" onclick="deleteImage(this)" style="background-image: url('<?=$img->path?>')">
                            <input type="hidden" name="origin_image[]" value="<?=$key?>"><span class="custom-file-container__image-multi-preview__single-image-clear"><span class="custom-file-container__image-multi-preview__single-image-clear__icon" data-upload-token="vlpkmcklgusj81cr2837qr">×</span></span>
                        </div>
                    <?php
                        }    
                    } 
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper-button">
        <button class="btn btn-primary btn-loading" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
        </button>
        <input class="btn btn-success btn-submit" type="button" onclick="submitReportForm()" value="Submit" />
        <input class="btn btn-outline-success" type="button" onclick="history.back()" value="Back" />
    </div>
</form>

<script>
new FileUploadWithPreview('images');
window.addEventListener('fileUploadWithPreview:imagesAdded', imageHandler);

$('.start_datepicker').datepicker(setting.datepicker);
$('.end_datepicker').datepicker(setting.datepicker);
$('#content').summernote(setting.summernote);

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
