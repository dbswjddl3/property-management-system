<div class="w3-container">
    <div class="w3-row-padding" style="margin:0 -16px">
    <?php
    foreach ($images as $key => $value) { 
        ?>
        <div class="w3-col s4">
            <img src="<?=$value->path?>" style="width:100%;cursor:pointer"
            onclick="openModal();currentDiv(<?=$key+1?>)" class="w3-hover-shadow">
        </div>
    <? } ?>
    </div>

    <div id="modal" class="w3-modal w3-black">
    <span class="w3-text-white w3-xxlarge w3-hover-text-grey w3-container w3-display-topright" onclick="closeModal()" style="cursor:pointer">×</span>
    <div class="w3-modal-content">

    <div class="w3-content" style="max-width:1200px">
    <?php
    foreach ($images as $key => $value) { ?>
        <img class="mySlides" src="<?=$value->path?>" style="width:100%">
    <? } ?>
        <div class="w3-row w3-black w3-center">
            <div class="w3-display-container">
            <p id="caption"></p>
            <span class="w3-display-left w3-btn" onclick="plusDivs(-1)">❮</span>
            <span class="w3-display-right w3-btn" onclick="plusDivs(1)">❯</span>
            </div>
            <?php
            foreach ($images as $key => $value) { 
                $no = $key + 1;
                $value->name = "Image {$no}";?>
            <div class="w3-col s4">
                <img class="demo w3-opacity w3-hover-opacity-off" src="<?=$value->path?>" style="width:100%" onclick="currentDiv(<?=$key+1?>)" alt="<?=$value->name?>">
            </div>
            <? } ?>
        </div> <!-- End row -->
    </div> <!-- End w3-content -->
    
    </div> <!-- End modal content -->
    </div> <!-- End modal -->

</div>

<script>
    $(function() {
        var slideIndex = 1;
        showDivs(slideIndex);
    });
</script>