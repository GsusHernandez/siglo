<?php
// add a macro from an existing DOCM

require_once '../../../classes/CreateDocx.php';

$docx = new CreateDocx('docm');

$docx->addMacroFromDoc('../../files/fileMacros.docm');

$docx->createDocx('example_addMacroFromDoc_1');
// documents with macros use docm as extension
rename('example_addMacroFromDoc_1.docx', 'example_addMacroFromDoc_1.docm');