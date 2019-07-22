<!-- Modal -->
<div id="modal-form" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Moving</h4>
        </div>
        <div class="modal-body">
            <form id="form" name="form" method="post" >
                <input type="hidden" name="mode" value="insert"> 
                <input type="hidden" name="modal" value="true"> 
                <input type="hidden" name="seq"> 
                <input type="hidden" name="building_id" value="<?=$_SESSION['building']?>"> 
                
                <table class="w3-table w3-small">
                    <colgroup>
                        <col width="80">
                        <col width="*">
                    </colgroup>

                    <tr>
                        <th>Apt No</th>
                        <td>
                            <input type="text" name="apt_no" maxlength="50" />
                        </td>
                    </tr>

                    <tr>
                        <th>Name</th>
                        <td>
                            <input type="text" name="name" maxlength="20" />
                        </td>
                    </tr>
            
                    <tr>
                        <th>Mobile</th>
                        <td> 
                            <input type="text" name="mobile" maxlength="20" /> 
                        </td>
                    </tr>

                    <tr>
                        <th>Moving</th>
                        <td> 
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-dark active">
                                    <input type="radio" name="moving_status" value="I" checked /> In
                                </label>
                                <label class="btn btn-outline-dark">
                                    <input type="radio" name="moving_status" value="O" /> Out
                                </label>
                            </div>
                        </td>
                    </tr>          

                    <tr class="wrapper-date">
                        <th>Start</th>
                        <td> 
                            <div class="wrapper-datepicker">
                                <select name="start_time" class="custom-select"><?=get_time_options($start_time)?></select>
                                <input type="text" name="start_date" class="start_datepicker">
                            </div>
                        </td>
                    </tr>

                    <tr class="wrapper-date">
                        <th>End</th>
                        <td> 
                            <div class="wrapper-datepicker">
                                <select name="end_time" class="custom-select"><?=get_time_options($end_time)?></select>
                                <input type="text" name="end_date" class="end_datepicker">
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="modal-footer">
            <div class="wrapper-button">
                <button class="btn btn-primary btn-loading" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <input class="btn btn-success btn-submit" type="button" onclick="submitMovingForm()" value="Submit" />
                <input class="btn btn-danger btn-delete" type="button" onclick="deleteEvent('moving_in_out')" value="Delete">
                <!-- <input class="btn btn-outline-success" type="button" data-dismiss="modal" value="Close" /> -->
            </div>
        </div>
        </div>
    </div>
</div>

<script>
    $('.start_datepicker').datepicker(setting.datepicker);
    $('.end_datepicker').datepicker(setting.datepicker);
</script>