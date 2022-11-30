<?php
// add a WordFragment to the end of the document. DOCXPath available in Advanced and Premium licenses allows inserting WordFragments to any position

require_once '../../../classes/CreateDocx.php';

$docx = new CreateDocx();

$wordFragment = new WordFragment($docx);

// a WordFragment may include one or more contents

$imageOptions = array(
    'src' => '../../img/image.png',
    'scaling' => 50, 
    'textWrap' => 3,
);
$wordFragment->addImage($imageOptions);

$imageOptions1 = array(
    'src' => '../../img/image.png',
    'scaling' => 50, 
    'textWrap' => 3,
);
$wordFragment->addImage($imageOptions1);

$linkOptions = array(
    'url' => 'http://www.google.es', 
    'color' => '0000FF', 
    'underline' => 'single',
);
$wordFragment->addLink('link to Google', $linkOptions);

$docx->addWordFragment($wordFragment);

$docx->createDocx('example_addWordFragment_1');