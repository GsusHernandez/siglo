<?php
// encode to UTF8 the contents

require_once '../../../classes/CreateDocx.php';

$docx = new CreateDocx();

$docx->setEncodeUTF8();

$docx->createDocx('example_setEncodeUTF8_1');