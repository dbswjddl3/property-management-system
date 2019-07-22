var filesCount = 0;

function imageHandler(e) {
    let files = e.detail.cachedFileArray;
    let i = filesCount;
    filesCount += e.detail.addedFilesCount;
    for (i; i < filesCount; i++) {
        let file = files[i];
        let reader = new FileReader();
        
        reader.onload = function (readerEvent) {
            var image = new Image();
            image.onload = function () {
                var dataURL;
                var max_size = 500;
                var w = image.width;
                var h = image.height;
                if (w > h) {
                    if (w > max_size) {
                        h *= max_size / w;
                        w = max_size;
                    }
                }
                else {
                    if (h > max_size) {
                        w *= max_size / h;
                        h = max_size;
                    }
                }
                var canvas = document.createElement('canvas');
                canvas.width = w;
                canvas.height = h;
                canvas.getContext('2d').drawImage(image, 0, 0, w, h);
                if (file.type == "image/jpeg") {
                    dataURL = canvas.toDataURL("image/jpeg", 1.0);
                }
                else {
                    dataURL = canvas.toDataURL("image/png");
                }

                $(".file-wrapper").append(`<input type="hidden" value="${dataURL}" name="image[]" />`);
            };
            image.src = readerEvent.target.result;
        };

        reader.readAsDataURL(file);
    }
}

function singleImageHandler(e) {
    const target = e.detail.uploadId;
    let file = e.detail.cachedFileArray[0];
    let reader = new FileReader();
    reader.onload = function (readerEvent) {
        var image = new Image();
        image.onload = function () {
            var dataURL;
            var max_size = 500;
            var w = image.width;
            var h = image.height;
            if (w > h) {
                if (w > max_size) {
                    h *= max_size / w;
                    w = max_size;
                }
            }
            else {
                if (h > max_size) {
                    w *= max_size / h;
                    h = max_size;
                }
            }
            var canvas = document.createElement('canvas');
            canvas.width = w;
            canvas.height = h;
            canvas.getContext('2d').drawImage(image, 0, 0, w, h);
            if (file.type == "image/jpeg") {
                dataURL = canvas.toDataURL("image/jpeg", 1.0);
            }
            else {
                dataURL = canvas.toDataURL("image/png");
            }
            $(`.image_${target}`).val(dataURL);
        };
        image.src = readerEvent.target.result;
    }
    reader.readAsDataURL(file);
}

function deleteImage(e) {
    $(e).remove();
}

