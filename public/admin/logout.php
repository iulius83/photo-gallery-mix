<?php

require_once("../../includes/initialize.php");

$session->logout($user);
redirect_to("login.php");

?>
