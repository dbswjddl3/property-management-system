<?php
include_once "./header.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/securimage/securimage.php";
?>

<h1 class="w3-border-bottom w3-border-light-grey w3-padding-16">Sign Up</h1>

<form id="form" name="form" method="post" class="needs-validation" novalidate>
    <input type="hidden" name="mode" value="insert_member"> 
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Grade</label>
        <div class="col-sm-10">
            <select class="form-control custom-select" name="grade" required>
                <option value="">---- Choose ----</option>
                <option value="cleaner">Cleaner</option>
                <option value="subcontractor">Subcontractor</option>
                <option value="director">Director</option>
                <option value="manager">Manager</option>
                <option value="supervisor">Supervisor</option>
                <option value="staff">Staff</option>
                <option value="body corp">Body Corp</option>
                <option value="safe inspector">Safe Inspector</option>
            </select>       
            <div class="invalid-feedback">
                Please choose a grade.
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">ID (E-mail)</label>
        <div class="col-sm-10">
            <input type="text" name="id" class="form-control" placeholder="Email" required> 
            <div class="invalid-feedback">
                Please input your email.
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
            <input type="password" name="password" class="form-control" placeholder="Password" required> 
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Confirm Password</label>
        <div class="col-sm-10">
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required> 
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Full Name</label>
        <div class="col-sm-10 input-group">
            <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
            <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Prefer Name</label>
        <div class="col-sm-10">
            <input type="text" name="prefer_name" class="form-control" placeholder="Prefer Name">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Phone</label>
        <div class="col-sm-10">
            <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Mobile</label>
        <div class="col-sm-10">
            <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Address</label>
        <div class="col-sm-10">
            <input type="text" name="address" class="form-control" placeholder="Address" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">TFN</label>
        <div class="col-sm-10">
            <input type="text" name="tfn" class="form-control" placeholder="TFN Number">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">TFN Address</label>
        <div class="col-sm-10">
            <input type="text" name="tfn_address" class="form-control" placeholder="TFN Address">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">ABN</label>
        <div class="col-sm-10">
            <input type="text" name="abn" class="form-control" placeholder="ABN Number">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">ABN Address</label>
        <div class="col-sm-10">
            <input type="text" name="abn_address" class="form-control" placeholder="ABN Address">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Code</label>
        <div class="col-sm-10">
            <input type="text" name="code" class="form-control" placeholder="Code">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Face Photo</label>
        <input type="hidden" class="image_face" name="image_face">
        <div class="single-file-wrapper col-sm-10">
            <div class="custom-file-container" data-upload-id="face"><label style="display:none"><a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">&times;</a></label><label class="custom-file-container__custom-file"><input type="file" class="custom-file-container__custom-file__custom-file-input" accept="*" aria-label="Choose File"><span class="form-control custom-file-container__custom-file__custom-file-control"></span></label><div class="custom-file-container__image-preview"></div></div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Photo/Scan of ID</label>
        <input type="hidden" class="image_id" name="image_id">
        <div class="single-file-wrapper col-sm-10">
            <div class="custom-file-container" data-upload-id="id"><label style="display:none"><a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">&times;</a></label><label class="custom-file-container__custom-file"><input type="file" class="custom-file-container__custom-file__custom-file-input" accept="*" aria-label="Choose File"><span class="form-control custom-file-container__custom-file__custom-file-control"></span></label><div class="custom-file-container__image-preview"></div></div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Captcha</label>
        <div class="col-sm-10">
            <fieldset class="wrapper-captcha">
                <input type="hidden" name="action" value="contact_form">
                <?php
                echo Securimage::getCaptchaHtml([
                    'input_id'   => 'contact_captcha',
                    'input_name' => 'captcha_code',
                    'image_id'   => 'contact_captcha_img',
                    'namespace'  => 'contact',
                    'input_text' => '',
                    'input_attributes' => [
                        'required' => 'required',
                        'class' => 'form-control',
                        'placeholder' => 'Type the Captcha Text'
                    ]
                ]);
                ?>
            </fieldset>
        </div>
    </div>

    <input type="button" onclick="signup()" class="w3-button w3-green w3-section w3-padding" value="Submit">
</form>

<script>
new FileUploadWithPreview('face');
new FileUploadWithPreview('id');
window.addEventListener('fileUploadWithPreview:imagesAdded', singleImageHandler);
$('.w3-bar button').hide();
</script>