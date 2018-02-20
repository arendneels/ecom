<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS. "header.php"); ?>
<?php include(TEMPLATE_FRONT . DS. "top_nav.php"); ?>
<h1>MERCI VOOR DE AANKOOP</h1>

<?php
        proces_transaction();
?>
<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>