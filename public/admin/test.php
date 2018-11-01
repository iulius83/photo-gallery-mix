<?php
require_once('../../includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>

<?php include_layout_template('admin_header.php') ?>
<a href="index.php">&laquo; Back</a><br />

<?php

$user = new Photograph();
$user->filemane = "alt aparatel";
$user->type = "jpeg";
$user->size = "34325";
$user->caption = "hai sa vedem";
$user->create();

?>

<?php include_layout_template('admin_footer.php') ?>
