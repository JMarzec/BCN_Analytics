<?php

/* Index page for the BOB portal (Breast Now Bioinformatics) *
 * Coder: Stefano Pirro'
 * Institution: Barts Cancer Institute
 * Details: This is the main page for all the bioinformatics analysis inside the Research Portal */

// importing variables file
include('vars.php'); // from this point it's possible to use the variables present inside 'var.php' file

// Header and body sections
echo <<< EOT
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <title>BOB portal -- Breast Now Bioinformatics</title>

          <!-- CSS LINKS -->
          <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
          <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css">
          <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap4.min.css"/>
          <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css"/>
          <link rel="stylesheet" href="../styles/easy-autocomplete.css">
              <!-- SELECT2 PLUGIN -->
              <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
              <!-- CHOSEN PLUGIN -->
              <link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.css" rel="stylesheet" />

          <!-- MAIN CSS -->
          <link rel="stylesheet" type="text/css" href="../styles/datatables_additional.css">
          <link rel="stylesheet" type="text/css" href="../styles/bob.css">

          <!-- JS LINKS -->
          <!-- Loading Jquery -->
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
          <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.15/js/jquery.dataTables.js"></script>
          <script type="text/javascript" src="https://d3js.org/d3.v3.min.js"></script>

          <!-- SELECT2 PLUGIN -->
          <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.full.js"></script>
          <!-- CHOSEN PLUGIN -->
          <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.jquery.js"></script>

          <!-- PLUGINS FOR EXPORTING TABLE DATA -->
          <script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
          <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
          <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
          <script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>


          <!-- Loading personal scripts -->
          <script type="text/javascript" src="../js/jquery.dataTables.yadcf.js"></script>
          <script type="text/javascript" src="../js/jquery.easy-autocomplete.js"></script>
          <script type="text/javascript" src="../js/jquery-ui.accordion.multiple.js"></script>
          <script type="text/javascript" src="../js/jquery.scrollIntoView.js"></script>
          <script type="text/javascript" src="../js/jquery.ui.autocomplete.scroll.js"></script>
          <script type="text/javascript" src="../js/bob.js"></script>
          <script type="text/javascript" src="../js/sunburst.js"></script>
  </head>

  <body>
    <!-- LOADING DIV -->
    <div id="loading"></div>

    <!-- LOGO PORTION -->
    <div id='logo'>
      <a href='http://www.breastcancertissuebank.org' target='null'>
        <img src='../images/front_logo.svg'/>
      </a>
    </div>

    <!-- BREADCRUMB -->
    <div id="breadcrumb">
       <ul class="breadcrumb">
        <li><a href="http://www.breastcancertissuebank.org/">Main Page</a></li>
        <li><img src="../styles/images/breadcrumb-arrow.png" alt=""></li>
        <li><a href="http://bioinformatics.breastcancertissuebank.org">Bioinformatics</a></li>
        <li><img src="../styles/images/breadcrumb-arrow.png" alt=""></li>
        <li class="active">BCNTB:Analytics</li>
      </ul>
    </div>

    <!-- MAIN PART -->
    <div class="container" id="master">
      <!-- INTEST -->
      <div id="inner-head-top">
        <h1 id="head-top"> BCNTB Bioinformatics </h1>
      </div>

      <!-- NAVIGATION MENU -->
      <div id="menu">
        <span class="menu" id="right">
          <a href="http://bioinformatics.breastcancertissuebank.org/index.jsp" >Home</A>
          <a href="http://bioinformatics.breastcancertissuebank.org/martwizard/#!/import?mart=hsapiens_gene_breastCancer_config&step=2">BCNTB:Miner</a>
          <a href="http://bioinformatics.breastcancertissuebank.org:9003/bcntb_proto/pages/bob.php" >BCNTB:Analytics</a>
          <a href="http://bioinformatics.breastcancertissuebank.org/upload.jsp" >Upload Data</a>
          <a href="" class='menu_btn' id="doc" title="Read the documentation"> Documentation </a>
        </span>
      </div>

      <div class="container" id="source"></div>
    </div>

    <!-- LOADING JAVASCRIPTS -->
    <script> LoadHomePage() </script>
    <script> LoadMenuSelector() </script>
  </body>
EOT;

// Footer section
echo <<< EOT
</html>
EOT;

// Google Analytics section (filled once the website is completed)
//
//

?>
