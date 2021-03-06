<?php

// importing variables file
include('scripts/vars.php'); // from this point it's possible to use the variables present inside 'var.php' file

// importing variables
$iframe_directory = "$relative_root_dir/bcntb_backoffice/data/ccle/";

echo <<< EOT
  <!-- Results Section -->
    <table id="ccle" class="table table-bordered" cellspacing="0" width="100%">
        <!-- Table Header -->
        <thead>
            <tr>
                <th>Name</th>
                <th>Target</th>
                <th>Type</th>
                <th>Gender</th>
                <th>Ethnicity</th>
                <th>Age</th>
                <th>ER</th>
                <th>PR</th>
                <th>HER2</th>
            </tr>
        </thead>
    </table>

  <div class="container" id="ccle_results">
    <ul>
      <li><a href="#pca">PCA</a></li>
      <li><a href="#expression_profiles">Gene expression</a></li>
      <li><a href="#co_expression_analysis">Correlations</a></li>
      <li><a href="#expression_layering">Data integration</a></li>
      <li><a href="#copy_number_alterations">Copy number alterations</a></li>
    </ul>
    <div id="pca">
      <div class='description'>
        <p class='pub_det'> Principal component analyses (PCA) transforms the data into a coordinate system and presenting it as an orthogonal projection.
            This reduces the dimensionality of the data, allowing for the global structure and key “components” of variation of the data to be viewed.
            Each point represents the orientation of a sample in the transcriptional space projected on the PCA,
            with different colours representing the biological group of the sample.
        </p>
      </div>

      <iframe class='results' scrolling='no' src='$iframe_directory/pca3d_1.html' onload='resizeIframe(this)'></iframe>
      <iframe class='results' scrolling='no' src='$iframe_directory/pca2d_1.html' onload='resizeIframe(this)'></iframe>
      <iframe class='results' scrolling='no' src='$iframe_directory/pca_bp_1.html' onload='resizeIframe(this)'></iframe>
    </div>

    <div id="expression_profiles">
      <div class='description'>
        <p class='pub_det'>
          The expression profile of selected gene(s) across comparative groups are presented as both summarised and a
          sample views (boxplots and barplots, respectively).
        </p>
        <br><br>
        <h4> Please select a gene of interest </h4>
        <br>
        <!-- putting gene selector -->
        <select id="gea_ccle_sel"> </select>
        <button id="gea_ccle_run" class="run"> Run analysis </button>
      </div>

      <!-- Loading div -->
      <div class='gea_ccle' id='gea_ccle'>
        <iframe class='results' id='gea_ccle_sel_box' onload='resizeIframe(this)'></iframe>
        <iframe class='results' id='gea_ccle_sel_bar' onload='resizeIframe(this)'></iframe>
      </div>

      <!-- Calling Javascripts -->
      <script>LoadGeneSelector("gea_ccle_sel", "", "", "ccle")</script>
      <script>LoadAnalysis("gea_ccle_sel","gea_ccle_run","ccle","","ccle_gene_expression","1")</script>
    </div>

    <div id="co_expression_analysis">
      <div class='description'>
        <p class='pub_det'>
          We offer users the opportunity to identify genes that are co-expressed with their gene(s) of interest.
          This value is calculated using the Pearson Product Moment Correlation Coefficient (PMCC) value.
          Correlations for the genes specified by the user are presented in a heatmap.
        </p>
        <br><br>
        <h4> Please select at least 2 genes of interest (max 50 genes)</h4>
        <br>
        <!-- putting gene selector -->
        <select multiple id="cea_ccle_sel"> </select>
        <button id="cea_ccle_run" class="run"> Run analysis </button>
      </div>

      <!-- Loading div -->
      <div class='cea_ccle' id='cea_ccle'>
        <iframe class='results' id='cea_ccle_sel_hm'></iframe>
      </div>

      <!-- Calling Javascripts -->
      <script>LoadGeneSelector("cea_ccle_sel", "", "", "ccle")</script>
      <script>LoadAnalysis("cea_ccle_sel","cea_ccle_run","ccle","","ccle_co_expression","1")</script>
    </div>

    <div id="expression_layering">
      <div class='description'>
        <p class='pub_det'>
          This analytical module allows to integrate and visualise discrete genetic events,
          such as DNA copy-number alterations (CNAs) and mutations,
          or relative linear copy-number values with continuous mRNA abundance
          data for user-defined gene.
        </p>
        <br><br>
        <h4> Please select a gene of interest</h4>
        <br>
        <!-- putting gene selector -->
        <select id="el_ccle_sel"> </select>
        <button id="el_ccle_run" class="run"> Run analysis </button>
      </div>

      <!-- Loading div -->
      <div class='el_ccle' id='el_ccle'>
        <iframe class='results' id='el_ccle_sel_boxel' onload='resizeIframe(this)'></iframe>
        <iframe class='results' id='el_ccle_sel_el' onload='resizeIframe(this)'></iframe>
        <iframe class='results' id='el_ccle_sel_boxel_mut' onload='resizeIframe(this)'></iframe>
        <iframe class='results' id='el_ccle_sel_el_mut' onload='resizeIframe(this)'></iframe>
      </div>

      <!-- Calling Javascripts -->
      <script>LoadGeneSelector("el_ccle_sel", "", "", "ccle")</script>
      <script>LoadAnalysis("el_ccle_sel","el_ccle_run","ccle","","ccle_expression_layering","1")</script>
    </div>

    <div id="copy_number_alterations">
      <div class='description'>
        <p class='pub_det'>
          An overview of DNA copy number alterations (CNA) are presented as frequency plots.
          From here, you can view the CNA specific to the dataset selected and the biological groups available.
        </p>
        <br><br>
        <h4> Please select at least 2 genes of interest (max 20 genes)</h4>
        <br>
        <!-- putting gene selector -->
        <select multiple id="cna_ccle_sel"> </select>
        <button id="cna_ccle_run" class="run"> Run analysis </button>
      </div>
      <!-- Loading div -->
      <div class='cna_ccle' id='cna_ccle'>
        <iframe class='results' id='cna_hm' onload='resizeIframe(this)'></iframe>
        <iframe class='results' id='cna_1' src='$iframe_directory/frequency_plot_1_1.html' onload='resizeIframe(this)'></iframe>
        <iframe class='results' id='cna_2' src='$iframe_directory/frequency_plot_1_2.html' onload='resizeIframe(this)'></iframe>
        <iframe class='results' id='cna_3' src='$iframe_directory/frequency_plot_1_3.html' onload='resizeIframe(this)'></iframe>
        <iframe class='results' id='cna_4' src='$iframe_directory/frequency_plot_1_4.html' onload='resizeIframe(this)'></iframe>
      </div>

      <!-- Calling Javascripts -->
      <script>LoadGeneSelector("cna_ccle_sel", "", "", "ccle_cnv")</script>
      <script>LoadAnalysis("cna_ccle_sel","cna_ccle_run","ccle","","ccle_cn_alterations","1")</script>
    </div>
  </div>
  <script> LoadCCLETable() </script>
  <script> LoadCCLETabs() </script>
EOT;
?>
