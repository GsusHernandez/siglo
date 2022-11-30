<?php
// add a text applying styles

require_once '../../../classes/CreateDocx.php';

$docx = new CreateDocx();
$text = 'Hola Emma';

$paragraphOptions = array(
    'bold' => true,
    'font' => 'Arial'
);

$docx->addText($text, $paragraphOptions);


$docx->createDocx('example_addText_1');