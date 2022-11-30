<?php
// replace list variables (placeholders) from an existing DOCX using WordFragments

require_once '../../../classes/CreateDocx.php';

$docx = new CreateDocxFromTemplate('../../files/TemplateList_symbols.docx');
$docx->setTemplateSymbol('${', '}');

$link = new WordFragment($docx);
$linkOptions = array('url'=> 'http://www.google.es', 
    'color' => '0000FF', 
    'underline' => 'single',
);
$link->addLink('link to Google', $linkOptions);

$image = new WordFragment($docx);
$imageOptions = array(
    'src' => '../../img/image.png',
    'scaling' => 50,
    );
$image->addImage($imageOptions);

$footnote = new WordFragment($docx);
$footnote->addFootnote(
    array(
        'textDocument' => 'here it is',
        'textFootnote' => 'This is the footnote text.',
    )
);

$items = array($link, $image, $footnote);

$docx->replaceListVariable('LISTVAR', $items);

$docx->createDocx('example_replaceListVariable_5');