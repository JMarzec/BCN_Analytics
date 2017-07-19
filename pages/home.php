<?php

echo <<< EOT
<div>
    <center>
      <table style="margin-top:40px;">
        <tr style='text-align:center'>
          <td>
            <b>Select the data source for your analysis </b>
          </td>
        </tr>
        <tr>
            <td>
                <button class="analysis_sel" id="literature"> PubMed </button>
                <button class="analysis_sel" id="tga"> The Cancer Genome Atlas </button>
                <button class="analysis_sel" id="ccle"> Cancer Cell Line Encyclopedia </button>
                <button class="analysis_sel" id="bcntb"> BCN Tissue Bank </button>
            </td>
        </tr>
      </table>
    </center>
</div>
<br><br>
<div class="container" id="main"></div>
<div class="container" id="loading"></div>
<div class="container" id="results"></div>

<div class="container" id="description">
  <center><h4> Statistics </h4></center>
  <table>
    <tr>
      <td><input type="radio" name="selector" checked="checked" onclick="LoadStatisticsSunburst('samples');"/> Sample </td>
      <td><input type="radio" name="selector" onclick="LoadStatisticsSunburst('data_type');"/> Data type </td>
      <td><input type="radio" name="selector" onclick="LoadStatisticsSunburst('samples');"/> Analysis type</td>
    </tr>
  <table>

  <div class="container" id="statistics">
</div>


<script> LoadSelector() </script>
<script> LoadStatisticsSunburst("samples") </script>
EOT;




?>
