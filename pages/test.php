<?php

echo <<<EOT
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <title>Test</title>

          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
          <script type="text/javascript" src="../js/network.js"></script>
  </head>

  <body>  </body>
EOT;

$genes = array("RPF2", "YHIN");
// reading mentha network file
$whole_net_io = fopen("../src/mentha.txt", "r");
// removing first line
while (($whole_net = fgets($whole_net_io)) !== FALSE) {
  // splitting lines by semicomma
  $all_elements = explode(";", $whole_net);
  /* legend of the elements:
    1 -- source node Gene name
    4 -- target node Gene name
  */
  // let's search for the gene of interest inside the file
  if (in_array($all_elements,$genes)) {
    echo "found<br>";
  }
}
fclose($whole_net_io);

?>
