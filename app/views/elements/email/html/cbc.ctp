<?php
/**
 * Default Html  Mail Element.
 */
?>
Dear  <?php echo $name; ?>, <br />
<?php
$content = explode("\n", $content);
foreach ($content as $line):
	echo '<p> ' . $line . "</p>\n";
endforeach;
?>
<br />
Regards, <br />
RFA (Road Fund Administration) <br />
Call us : +264 61 378950