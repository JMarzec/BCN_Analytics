<?php

// importing variables file
include('scripts/vars.php'); // from this point it's possible to use the variables present inside 'var.php' file

// importing variables
$iframe_directory = "$relative_root_dir/bcntb_backoffice/data/tcga/";

echo <<< EOT
  <!-- Results Section -->
  <div class="container" id="tcga_results">
    <ul>
      <li><a href="#pca">PCA</a></li>
      <li><a href="#expression_profiles">Gene expression</a></li>
      <li><a href="#co_expression_analysis">Correlations</a></li>
      <li><a href="#oncoprint">Mutations</a></li>
    </ul>
    <div id="pca">
      <div class='description'>
        <p class='pub_det'> Principal component analyses (PCA) transforms the data into a coordinate system and presenting it as an orthogonal projection.
            This reduces the dimensionality of the data, allowing for the global structure and key “components” of variation of the data to be viewed.
            Each point represents the orientation of a sample in the transcriptional space projected on the PCA,
            with different colours representing the biological group of the sample.
        </p>
      </div>

      <iframe class='results' scrolling='no' src='$iframe_directory/pca3d_1.html'></iframe>
      <iframe class='results' scrolling='no' src='$iframe_directory/pca2d_1.html'></iframe>
      <iframe class='results' scrolling='no' src='$iframe_directory/pca_bp_1.html'></iframe>

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
        <select id="gea_tcga_sel"> </select>
        <button id="gea_tcga_run" class="run"> Run analysis </button>
      </div>

      <!-- Loading div -->
      <div class='gea_tcga' id='gea_tcga'>
        <iframe class='results' id='gea_tcga_sel_box'></iframe>
        <iframe class='results' id='gea_tcga_sel_bar'></iframe>
      </div>

      <!-- Calling Javascripts -->
      <script>LoadGeneSelector("gea_tcga_sel", "", "", "tcga")</script>
      <script>LoadAnalysis("gea_tcga_sel","gea_tcga_run","tcga","","tcga_gene_expression","0")</script>
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
        <select multiple id="cea_tcga_sel"> </select>
        <button id="cea_tcga_run" class="run"> Run analysis </button>
      </div>

      <!-- Loading div -->
      <div class='cea_tcga' id='cea_tcga'>
        <iframe class='results' id='cea_tcga_sel_hm'></iframe>
      </div>

      <!-- Calling Javascripts -->
      <script>LoadGeneSelector("cea_tcga_sel", "", "", "tcga")</script>
      <script>LoadAnalysis("cea_tcga_sel","cea_tcga_run","tcga","","tcga_co_expression","1")</script>
    </div>

    <div id="oncoprint">
      <div class='description'>
        <p class='pub_det'>
          Description of the oncoprint
        </p>
        <br><br>
        <h4> Please select at least 2 genes of interest (max 50 genes)</h4>
        <br>
        <!-- putting gene selector -->
        <select multiple id="mut_tcga_sel"> </select>
        <button id="mut_tcga_run" class="run"> Run analysis </button>
      </div>

      <!-- Loading div -->
      <div>
        <table>
          <tr>
            <h4> Number of top-mutated genes to show: </h4><br>
            <td style="padding-right:10px;"><input type="radio" name="selector" checked onclick=LoadOncoPrint("10"); />10</td>
            <td style="padding-right:10px;"><input type="radio" name="selector" onclick=LoadOncoPrint("20"); />20</td>
            <td style="padding-right:10px;"><input type="radio" name="selector" onclick=LoadOncoPrint("30"); />30</td>
            <td style="padding-right:10px;"><input type="radio" name="selector" onclick=LoadOncoPrint("40"); />40</td>
            <td style="padding-right:10px;"><input type="radio" name="selector" onclick=LoadOncoPrint("50"); />50</td>
            <td style="padding-right:10px;"><input type="radio" name="selector" onclick=LoadOncoPrint("75"); />75</td>
            <td style="padding-right:10px;"><input type="radio" name="selector" onclick=LoadOncoPrint("100"); />100</td>
          </tr>
        </table>
      </div>
      <div id="top_mut_genes">
        <center>
          <img id="oncoprint" src="$iframe_directory/Mutations_top10.png" style="width:800px; height:auto"/>
        </center>
      </div>
      <div class='mut_tcga' id='mut_tcga'> </div>

      <!-- Calling Javascripts -->
      <script>LoadGeneSelector("mut_tcga_sel", "", "", "tcga")</script>
      <script>LoadAnalysis("mut_tcga_sel","mut_tcga_run","tcga","","tcga_mutations","1")</script>
    </div>

    <script> LoadTCGATabs() </script>
  </div>
EOT;
?>
