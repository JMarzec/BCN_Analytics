<?php

/* Index page for the BOB portal (Breast Now Bioinformatics) *
 * Coder: Stefano Pirro'
 * Institution: Barts Cancer Institute
 * Details: This is the main page for all the bioinformatics analysis inside the Research Portal */

// importing variables file
include('vars.php'); // from this point it's possible to use the variables present inside 'var.php' file

// https://cdn.datatables.net/v/ju/pdfmake-0.1.27/dt-1.10.15/af-2.2.0/b-1.3.1/b-colvis-1.3.1/b-flash-1.3.1/b-html5-1.3.1/b-print-1.3.1/cr-1.3.3/fc-3.2.2/fh-3.1.2/kt-2.2.1/r-2.1.1/rg-1.0.0/rr-1.2.0/sc-1.4.2/se-1.2.2/datatables.min.css"/>

// Header and body sections
echo <<< EOT
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>BOB portal -- Breast Now Bioinformatics</title>

            <!-- CSS LINKS -->
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.15/css/jquery.dataTables.css"/>
            <link rel="stylesheet" href="../styles/easy-autocomplete.css">
                <!-- SELECT2 PLUGIN -->
                <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

            <link rel="stylesheet" type="text/css" href="../styles/bob.css">
            	<!-- style sheets -->
            <link rel="stylesheet" media="screen" href="../styles/prime.css" />    
            <link rel="stylesheet" type="text/css" href="../styles/extra.css" />
            <link rel="stylesheet" media="screen, print" href="../styles/default.css" />
            <link rel="stylesheet" media="screen, print" href="../styles/skin.css" />
            <link rel="stylesheet" media="screen, print" href="../styles/bootstrap.css" />
            <link rel="stylesheet" type="text/css" href="../styles/lib/studyList_style.css" />


            <!-- JS LINKS -->
            <!-- Loading Jquery -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.15/js/jquery.dataTables.js"></script>

            <!-- SELECT2 PLUGIN -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>

            <!-- Loading personal scripts -->
            <script type="text/javascript" src="../js/jquery.dataTables.yadcf.js"></script>
            <script type="text/javascript" src="../js/jquery.easy-autocomplete.js"></script>
            <script type="text/javascript" src="../js/jquery-ui.accordion.multiple.js"></script>
            <script type="text/javascript" src="../js/jquery.scrollIntoView.js"></script>
            <script type="text/javascript" src="../js/jquery.ui.autocomplete.scroll.js"></script>
            <script type="text/javascript" src="../js/bob.js"></script>
    </head>

    <body>

<div class="page-height">
      <header>
        <div class="container">
          <div class="row">
            <div class="col-md-4" style='width:50%'><a href="http://www.breastcancertissuebank.org"><img src="../images/logo.png" alt=""></a><span class="logo-text">Tissue Bank</span></div>
            
	    <div class="col-md-8">

            </div>
	    
          </div>
        </div>
      </header>

      <!-- Breadcrumb -->
      
      <section class="bg-white-alpha90 breadcrumb-wrapper">
        <div class="container">
           <ol class="breadcrumb">
            <li><a href="http://www.breastcancertissuebank.org/">Main Page</a></li>
            <li><img src="../images/breadcrumb-arrow.png" alt=""></li>
            <li><a href="http://bioinformatics.breastcancertissuebank.org">Bioinformatics</a></li>
            <li><img src="../images/breadcrumb-arrow.png" alt=""></li>
            <li class="active">BCNTB:Analytics</li>
          </ol>        
        </div>
      </section>
	
            <section class="container">
        <div class="row">
          <div class="left-section bottom-radius-none">
            <div class="inner-head-top">
              <h1>BIOINFORMATICS PORTAL</h1>
            </div> 
              <div class="bio-title"> <span class="right">
              <span class="db-navbar">
              <a href="http://bioinformatics.breastcancertissuebank.org/index.jsp" >Home</A>
              <a href="http://bioinformatics.breastcancertissuebank.org/martwizard/#!/import?mart=hsapiens_gene_breastCancer_config&step=2">BCNTB:Miner</a>
              <a href="http://bioinformatics.breastcancertissuebank.org:9003/bcntb_proto/pages/bob.php" >BCNTB:Analytics</A>      
              <a href="http://bioinformatics.breastcancertissuebank.org/upload.jsp" >Upload Data</A>     
              <a href="http://bioinformatics.breastcancertissuebank.org/help.jsp" >HELP</a> </span></span>
              </div>
               
        <!-- ---------------------- -->
        <!-- NAVIGATION MENU -->
        
        <div class="container" id="source"> </div>
      </section>
        <!-- ---------------------------------------- -->
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
