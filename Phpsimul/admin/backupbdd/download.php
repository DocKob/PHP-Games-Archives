<?php

$sFile = rawurldecode($_GET['file']);
if (ereg("^([0-9a-zA-Z_\-\.]+)\.sql(\.gz)?$", $sFile))
{
	header("Content-type: application/force-download");
	header("Content-Disposition: attachment; filename=".$sFile);
	if (($iFileSize = filesize('dumps/'.$sFile)))
	{
		header("Content-Length: {$iFileSize}");
	}
	readfile('dumps/'.$sFile);
}

?>
