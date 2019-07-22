<?php
function sendMail($text = "", $subject = "", $attachments = array()) {
    if(!$text) {
        return false;
    }

    $email = implode(", ", [
        'john.js.nam@gmail.com',
        '24webapplication@gmail.com',
        '24appdevelopment@gmail.com',
    ]);

    $headers   = array();
    $headers[] = "From: john.js.nam@gmail.com";
    $headers[] = "Reply-To: john.js.nam@gmail.com";
    $headers[] = "Subject: {$subject}";
    $headers[] = "X-Mailer: PHP/".phpversion();
    $headers[] = "MIME-Version: 1.0";

    if(!empty($attachments)) {
        $boundary = md5(time());
        $headers[] = "Content-type: multipart/mixed;boundary=\"".$boundary."\"";
        // Have attachment, different content type and boundary required.
    } else {
        $headers[] = "Content-type: text/html; charset=UTF-8";
    }

    $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>CAPS Consortium</title>
            <style>table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }</style>
        </head>
        <body style="font-family: arial;" width="100%">
            [text]
        </body>
    </html>';

    $generated = date('jS M Y H:i:s');
    $subject = ($subject ? $subject : 'Default Subject');
    $message = $html;

    $message = str_replace("[text]", $text, $message);

    if(!empty($attachments)) {
        $output   = array();
        $output[] = "--".$boundary;
        $output[] = "Content-type: text/html; charset=\"utf-8\"";
        $output[] = "Content-Transfer-Encoding: 8bit";
        $output[] = "";
        $output[] = $message;
        $output[] = "";
        foreach($attachments as $attachment) {
            $output[] = "--".$boundary;
            $output[] = "Content-Type: ".$attachment['type']."; name=\"".$attachment['name']."\";";
            if(isset($attachment['encoding'])) {
                $output[] = "Content-Transfer-Encoding: " . $attachment['encoding'];
            }
            $output[] = "Content-Disposition: attachment;";
            $output[] = "";
            $output[] = $attachment['data'];
            $output[] = "";
        }
        $result = mail($email, $subject, implode("\r\n", $output), implode("\r\n", $headers));
    } else {
        $result = mail($email, $subject, $message, implode("\r\n", $headers));
    }

    return $result;
}

?>