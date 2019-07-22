<?php
include_once "../header.php";

$start_date = date('d-m-Y');
$start_time = date('H') + 1;
?>

<!-- Modal -->
<div id="modal-form" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Case Report</h4>
            </div>
            <div class="modal-body">
                <form id="form" name="form" method="post" >
                    <input type="hidden" name="mode" value="insert"> 
                    <input type="hidden" name="page" value="calendar"> 
                    <input type="hidden" name="name" value="<?=$_SESSION['name']?>">
                    <input type="hidden" name="email" value="<?=$_SESSION['id']?>"> 
                    <input type="hidden" name="id"> 
                    <input type="hidden" name="case_id"> 
                    <input type="hidden" name="parent_id"> 
                    <input type="hidden" name="depth"> 
                    <input type="hidden" name="building_id" value="<?=$_SESSION['building']?>"> 

                    <div class="form-group">
                        <label class="col-form-label">Status</label>
                        <div>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="case btn btn-outline-dark initial-case">
                                    <input type="radio" name="case_status" value="I" /> Initial Case
                                </label>
                            </div>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="case btn btn-outline-dark progress-case">
                                    <input type="radio" name="case_status" value="P" /> Progress Case
                                </label>
                                <label class="case btn btn-outline-dark close-case">
                                    <input type="radio" name="case_status" value="C" /> Close Case
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Homepage</label>
                        <div>
                            <input type="text" name="homepage" maxlength="60" value="<?=$data['homepage']?>" placeholder="Homepage"> 
                        </div>
                    </div>
                    <div class="wrapper-date form-group">
                        <label class="col-form-label">Date</label>
                        <div>
                            <div class="wrapper-datepicker">
                                <select name="start_time" class="custom-select"><?=get_time_options($start_time)?></select>
                                <input type="text" name="start_date" class="start_datepicker" value="<?=$start_date?>">
                            <? if ($parent_id) { ?>
                                <span class="to_mark">~</span>
                                <select name="end_time" class="custom-select"><?=get_time_options($end_time)?></select>
                                <input type="text" name="end_date" class="end_datepicker" value="<?=$end_date?>">
                            <? } ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Title</label>
                        <div>
                            <input type="text" name="subject" maxlength="180" value="<?= $data['subject'] ?>" placeholder="Title"> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Content</label>
                        <div>
                            <textarea name="content" style="display: none;"></textarea> 
                            <div id="content"><?=$data['content']?></div>
                        </div>
                    </div>
                    <?php 
                    if(count($parent['images']) > 0) {
                        $images = $parent['images']; ?>
                    <div class="form-group">
                        <label class="col-form-label">Initial Images</label>
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
                    <? } ?>
                    <div class="form-group">
                        <label class="col-form-label">Images</label>
                        <div class="file-wrapper">
                            <div class="custom-file-container" data-upload-id="images"><label style="display:none"><a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">&times;</a></label><label class="custom-file-container__custom-file"><input type="file" class="custom-file-container__custom-file__custom-file-input" accept="*" multiple aria-label="Choose File"><span class="custom-file-container__custom-file__custom-file-control"></span></label>
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
                </form>
            </div>
            <div class="modal-footer">
                <div class="wrapper-button">
                    <button class="btn btn-primary btn-loading" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <input class="btn btn-success btn-submit" type="button" onclick="submitReportForm()" value="Submit" />
                    <input class="btn btn-outline-success" type="button" data-dismiss="modal" value="Close" />
                </div>
            </div>
        </div>
    </div>
</div>

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