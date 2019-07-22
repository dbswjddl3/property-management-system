function signup() {
    if (form.checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
    }

    form.classList.add('was-validated');

    if ($('.form-control:invalid').length > 0) {
        $('.form-control:invalid')[0].focus();
        return;
    }

    $.ajax({
        type: "POST",
        url: "/db_process.php",
        dataType: "JSON",
        data: $("#form").serialize(),
        beforeSend : function(xhr, opts) {
            $(".btn-submit").hide();
            $(".btn-loading").show();
        },
        success: function(data)
        {
            console.log(data);
            // if (data.result === true) {
            //     // setTimeout(function(){ 
            //         alert('Successfully Saved!');
            //         if (document.form.page.value === 'calendar') {
            //             location.href='calendar.php';
            //         } else {
            //             location.href='list.php?page='+document.form.page.value;
            //         }
            //     // }, 500);  
            // } else {
            //     alert('An Error has occured: ' + data.error);
            // }
        },
        complete: function() {
            $(".btn-submit").show();
            $(".btn-loading").hide();
        }
    });
}

function submitReportForm(e) {
    let content = $('#content').summernote('code');

    if (!document.form.name.value) {
        alert('Please input name.');
        document.form.name.focus();
        return;
    } else if (!document.form.subject.value) {
        alert('Please input title.');
        document.form.subject.focus();
        return;
    } else if (!content.replace(/<(\/)?([a-zA-Z]*)(\s[a-zA-Z]*=[^>]*)?(\s)*(\/)?>/ig, "")) {
        alert('Please input content.');
        $('#content').summernote({focus: true});
        return;
    }

    document.form.content.value = content;
    $('#content').summernote('destroy');

    $.ajax({
        type: "POST",
        url: "./db_process.php",
        dataType: "JSON",
        data: $("#form").serialize(),
        beforeSend : function(xhr, opts) {
            $(".btn-submit").hide();
            $(".btn-loading").show();
        },
        success: function(data)
        {
            if (data.result === true) {
                let message = "Report Successfully Saved.";
                if (data.warning) {
                    message += `\n[Warning: ${data.warning}]`;
                }

                alert(message);

                if (document.form.page.value === 'calendar') {
                    location.href='calendar.php';
                } else {
                    location.href='list.php?page='+document.form.page.value;
                }
            } else {
                alert('An Error has occured: ' + data.error);
            }
        },
        complete: function() {
            $(".btn-submit").show();
            $(".btn-loading").hide();
        }
    });
} 

function getLatestReplyDetail(case_id) {
    let promise = new Promise(function (resolve, reject) {
        $.ajax({
            type: "POST",
            url: "./db_calendar.php",
            dataType: "JSON",
            data: {
                mode: 'get_latest_reply_detail',
                case_id: case_id,
            },
            success: function(data)
            {
                resolve(data);
            }
        });
    });

    return promise;
}

function deleteReport(report_id, case_id, delete_name) {
    if (confirm ("Delete the report?")) {
        $.ajax({
            type: "POST",
            url: "./db_process.php",
            dataType: "JSON",
            data: {
                mode: 'delete',
                id: report_id,
                case_id: case_id,
                delete_name: delete_name
            },
            success: function(data)
            {
                if (data.result === true) {
                    location.href='list.php';
                } else {
                    alert('An Error has occured: ' + data.error);
                }
            }
        });
    }
}

function deleteEvent() {
    if (confirm ("Delete the Event?")) {
        const seq = $("input[name=seq]").val();
        $.ajax({
            type: "POST",
            url: `./db_process.php`,
            dataType: "JSON",
            data: {
                mode: 'delete',
                seq: seq,
            },
            success: function(data)
            {
                if (data.result === true) {
                    location.reload();
                } else {
                    alert('An Error has occured: ' + data.error);
                }
            }
        });
    }
}

function submitBookingForm() {
    if (!document.form.apt_no.value) {
        alert('Please input Apt no.');
        document.form.apt_no.focus();
        return;
    } else if (!document.form.name.value) {
        alert('Please input name.');
        document.form.name.focus();
        return;
    } else if (!document.form.mobile.value) {
        alert('Please input mobile.');
        document.form.mobile.focus();
        return;
    // } else if (!document.form.start_date.value) {
    //     alert('Please input start date.');
    //     document.form.start_date.focus();
    //     return;
    // } else if (!document.form.end_date.value) {
    //     alert('Please input end date.');
    //     document.form.end_date.focus();
    //     return;
    }

    $.ajax({
        type: "POST",
        url: "./db_process.php",
        dataType: "JSON",
        data: $("#form").serialize(),
        beforeSend : function(xhr, opts) {
            $(".btn-submit").hide();
            $(".btn-loading").show();
        },
        success: function(data)
        {
            if (data.result === true) {
                alert('Successfully Saved!');

                if (document.form.modal) {
                    location.reload();
                } else {
                    location.href='list.php?page='+document.form.page.value;
                }
            } else {
                alert(data.error);
            }
        },
        complete: function() {
            $(".btn-submit").show();
            $(".btn-loading").hide();
        }
    });
} 

function submitMovingForm() {
    if (!document.form.apt_no.value) {
        alert('Please input Apt no.');
        document.form.apt_no.focus();
        return;
    } else if (!document.form.name.value) {
        alert('Please input name.');
        document.form.name.focus();
        return;
    } else if (!document.form.mobile.value) {
        alert('Please input mobile.');
        document.form.mobile.focus();
        return;
    // } else if (!document.form.start_date.value) {
    //     alert('Please input start date.');
    //     document.form.start_date.focus();
    //     return;
    // } else if (!document.form.end_date.value) {
    //     alert('Please input end date.');
    //     document.form.end_date.focus();
    //     return;
    }

    $.ajax({
        type: "POST",
        url: "./db_process.php",
        dataType: "JSON",
        data: $("#form").serialize(),
        beforeSend : function(xhr, opts) {
            $(".btn-submit").hide();
            $(".btn-loading").show();
        },
        success: function(data)
        {
            if (data.result === true) {
                alert('Successfully Saved!');

                if (document.form.modal) {
                    location.reload();
                } else {
                    location.href='list.php?page='+document.form.page.value;
                }
            } else {
                alert(data.error);
            }
        },
        complete: function() {
            $(".btn-submit").show();
            $(".btn-loading").hide();
        }
    });
} 

function modalToggle(info) {
    initModal();

    if (info.event) {
        const detail = info.event.extendedProps.detail;

        var [startDate, startTime] = getDateTime(detail.start_datetime);
        var [endDate, endTime] = getDateTime(detail.end_datetime);

        if (detail.case_status) { // Report
            if(detail.case_status === 'C') {
                return;
            }

            $('.progress-case').button('toggle').parent().show().siblings().hide();
        
            getLatestReplyDetail(detail.id).then(data => {
                setModalForm(data); 
            });
        } else { // Booking, Moving In/Out
            setModalForm(detail); 
            $('.btn-delete').show();
        }
    } else { // New Modal
        var [startDate, startTime] = getDateTime(info.startStr);
        var [endDate, endTime] = getDateTime(info.endStr);
        $('.initial-case').button('toggle').parent().show().siblings().hide();
    }
        
    $('input[name=start_date]').val(startDate);
    $('input[name=end_date]').val(endDate);
    $('select[name=start_time]').val(startTime);
    $('select[name=end_time]').val(endTime);
    $('#modal-form').modal('show');
}

function initModal() {
    $('input[name=mode]').val('insert');
    $('#modal-form').find('input:text').val('');
    $('#modal-form').find('select').val('00:00');
    $('#modal-form').find('select').val('00:00');
    $("#content").summernote('code', '');
    $('.case').removeClass('active');
    $('.btn-delete').hide();
}

function getDateTime(str) {
    const date = moment(str).format('DD-MM-YYYY');
    const time = moment(str).format('HH:00');
    return [date, time];
}

function setModalForm(data) {
    Object.keys(data).forEach(function (key) {
        const value = data[key];

        if (key === 'content') {
            $("#content").summernote('code', value);
            return;
        } else if(key === 'facility') {
            const facility = JSON.parse(value);
            for (let i = 0; i < facility.length; i++) {
                $(`input[name='facility[]'][value='${facility[i]}']`).prop('checked', true);
            }
            return;
        }

        if ($(`input[name='${key}']`).is("[type=radio]")) {
            $(`input[name='${key}'][value='${value}']`).parent().button('toggle');
        } else if ($(`select[name='${key}']`).is("select")) {
            $(`select[name='${key}']`).val(value);
        } else {
            $(`input[name='${key}']`).val(value);
        } 
    });
}

function changeEventTime(event) {
    if (!confirm("Are you sure about this change?")) {
        event.revert();
    }

    let start = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
    let end = '';
    if (event.end) {
        end = moment(event.end).format('YYYY-MM-DD HH:mm:ss');
    }

    $.ajax({
        type: "POST",
        url: "./db_calendar.php",
        dataType: "JSON",
        data: {
            mode: 'change_event',
            id: event.id,
            start: start,
            end: end,
        },
        success: function(data)
        {
            if (data.result) {
                event.extendedProps.detail.start_datetime = start;
                event.extendedProps.detail.end_datetime = end;
            }
        },
    });
}

$(document).ready(function() {
    $("#lightgallery").lightGallery(); 
});
