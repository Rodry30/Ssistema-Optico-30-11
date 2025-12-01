<?php
include_once("./securityModule/formAutenticarUsuario.php");
$objNuevoFormLogin = new formAutenticarUsuario();
$objNuevoFormLogin -> formAutenticarUsuarioShow();
?>