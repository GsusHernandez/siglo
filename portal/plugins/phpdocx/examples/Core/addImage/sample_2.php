<?php
// add images changing text wraps around them

require_once '../../../classes/CreateDocx.php';

$docx = new CreateDocx();

$text = '';

$runs = array();
$runs[] = $image;

$image = new WordFragment($docx);

$options = array(
    'src' => '../../img/image.jpg',
    'scaling' => 40,
    'spacingTop' => 0,
    'spacingBottom' => 0,
    'spacingLeft' => 20,
    'spacingRight' => 0,
    'float' => 'left',
);
$image->addImage($options);

$runs[] = array('text' => '  ');

$options = array(
    'src' => '../../img/image.png',
    'scaling' => 40,
    'spacingTop' => 0,
    'spacingBottom' => 0,
    'spacingLeft' => 20,
    'spacingRight' => 0,
    'float' => 'left',
);
$image->addImage($options);

$runs[] = $image;
$docx->addText($runs);

$docx->createDocx('example_addImage_2');