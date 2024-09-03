<?
if(isset($_POST['author'])){$author = $_POST['author'];}else{$author = '';}
if(isset($_POST['email'])){$email = $_POST['email'];}else{$email = '';}
if(isset($_POST['comment'])){$comment = $_POST['comment'];}else{$comment = '';}
if(isset($_POST['id'])){$id = $_POST['id'];}else{$id = '';}

require_once('../captcha/recaptchalib.php');

$publickey = "6LeXiwgAAAAAAMSacs18kLhfKv143gT64OW10p9f";
$privatekey = "6LeXiwgAAAAAAKgszevTNaJnaWlA6DbDnE4ILOoP";

$resp = null;
$error = null;

# was there a reCAPTCHA response?
if ($_POST["recaptcha_response_field"]) {
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);

        if ($resp->is_valid) {


require_once('../posting_comment.php');


        } else {
                print('<script>window.location.replace("index.php?nav=news&id='.$id.'&message=captcha");</script>');
                $error = $resp->error;
        }
}


?>