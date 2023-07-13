<?php

session_start();
include ('../include/inputfilter.php');
$filtro = new InputFilter();
$Usuario = $filtro->($_POST["Usuario"]);

echo $Usuario;
