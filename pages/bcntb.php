<?php

// importing variables file
include('scripts/vars.php'); // from this point it's possible to use the variables present inside 'var.php' file

// importing variables
$iframe_directory = "$relative_root_dir/bcntb_backoffice/data/ccle/";

echo <<< EOT
  <!-- Results Section -->
   <div >
        <h4><center>Data generated using BCNTB samples will be available soon</center></h4><br>
        <p>
          Below is a <b>subset</b> of projects that have applied for specimens <i>via</i> the BCNTB.<br>
          These data will be analysed and made available from BCNTB:Analytics. As the molecular data for each sample continues to increase,
          you will be able to conduct integrative analyses, thereby gaining a multidimensional view of the samples.
        </p>
    </div>

    <table id="bcntbreturn" class="table table-bordered" cellspacing="0" width="90%">
        <!-- Table Header -->
        <thead>
            <tr>
                <th>Project No.</th>
                <th>Technology</th>
                <th>Specimen</th>
                <th>ER</th>
                <th>PR</th>
                <th>HER2</th>
                <th>PMID</th>
            </tr>
        </thead>
    </table>

    <!-- Calling Javascripts -->
    <script> LoadBcntbReturnTable() </script>
  </div>
EOT;
?>
