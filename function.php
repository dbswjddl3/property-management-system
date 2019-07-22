<?php
function get_field_name($name, $key) {
    global $_COMMON;
    return $_COMMON[$name][$key];
}

function get_time_options($default = 12) {
    $selected[$default] = "selected";
    $data = "
        <option value=\"00:00\" {$selected[0]}>12:00 AM</option>
        <option value=\"01:00\" {$selected[1]}>01:00 AM</option>
        <option value=\"02:00\" {$selected[2]}>02:00 AM</option>
        <option value=\"03:00\" {$selected[3]}>03:00 AM</option>
        <option value=\"04:00\" {$selected[4]}>04:00 AM</option>
        <option value=\"05:00\" {$selected[5]}>05:00 AM</option>
        <option value=\"06:00\" {$selected[6]}>06:00 AM</option>
        <option value=\"07:00\" {$selected[7]}>07:00 AM</option>
        <option value=\"08:00\" {$selected[8]}>08:00 AM</option>
        <option value=\"09:00\" {$selected[9]}>09:00 AM</option>
        <option value=\"10:00\" {$selected[10]}>10:00 AM</option>
        <option value=\"11:00\" {$selected[11]}>11:00 AM</option>
        <option value=\"12:00\" {$selected[12]}>12:00 PM</option>
        <option value=\"13:00\" {$selected[13]}>01:00 PM</option>
        <option value=\"14:00\" {$selected[14]}>02:00 PM</option>
        <option value=\"15:00\" {$selected[15]}>03:00 PM</option>
        <option value=\"16:00\" {$selected[16]}>04:00 PM</option>
        <option value=\"17:00\" {$selected[17]}>05:00 PM</option>
        <option value=\"18:00\" {$selected[18]}>06:00 PM</option>
        <option value=\"19:00\" {$selected[19]}>07:00 PM</option>
        <option value=\"20:00\" {$selected[20]}>08:00 PM</option>
        <option value=\"21:00\" {$selected[21]}>09:00 PM</option>
        <option value=\"22:00\" {$selected[22]}>10:00 PM</option>
        <option value=\"23:00\" {$selected[23]}>11:00 PM</option>";

    return $data;
}
?>