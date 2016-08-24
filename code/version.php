<?php
Header("content-type: application/x-javascript");
$code_version=getenv('CODE_VERSION');
echo "document.write(\"The version of the website is: <b>" . $code_version . "</b>\")";
?>
