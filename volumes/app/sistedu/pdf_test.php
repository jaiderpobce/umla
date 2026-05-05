<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

# Incluir autoload
require "vendor/Smalot/pdfparser/alt_autoload.php-dist";

$parseador = new \Smalot\PdfParser\Parser();
$nombreDocumento = "pdf/NAC_500510858367_22744961.pdf";
$documento = $parseador->parseFile($nombreDocumento);

$texto = $documento->getText();
echo "<pre>";
echo $texto;
echo "</pre>";
