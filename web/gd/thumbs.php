<?php


 $fh = fopen('test.txt', 'a');
 fwrite($fh, "{$_GET['i']}\n");
?>