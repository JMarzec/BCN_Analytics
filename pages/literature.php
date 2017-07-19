<?php

// importing variables file
include('scripts/vars.php'); // from this point it's possible to use the variables present inside 'var.php' file

echo <<< EOT
    <table id="main_container">
        <tr>
            <td id="left">
                <div id="filter">
                    <!-- Filter controls for the literature table -->
                    <h3>Filter</h3>
                        <table>
                            <tr>
                                <td>
                                    <div id="kw_filter">
                                      <p class="filter_desc"> Keyword </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="pubdate_filter">
                                      <p class="filter_desc"> Publication date </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="bioinfo_filter" style="width:200px">
                                      <p class="filter_desc"> Available analyses </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="curated_filter" style="width:200px">
                                      <p class="filter_desc"> Display manual curated papers </p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                </div>
                <div id="analysis_button">
                    <button class='analysis_sel run' id='run'> Start analysis </button>
                </div>
                <!-- ---------------------------------------- -->
            </td>
            <td id="right">
                <table id="papers" class="table table-bordered" cellspacing="0" width="100%">
                    <!-- Table Header -->
                    <thead>
                        <tr>
                            <th>PMID</th>
                            <th>Title</th>
                            <th>Journal</th>
                            <th>Pub. Date</th>
                        </tr>
                    </thead>
                </table>
            </td>
        </tr>
        <tr colspan=2>
            <td>

            </td>
        </tr>
    </table>

    <script> LoadPapersTable() </script>
EOT;

// MeSH filter disabled for now
/*
  <!-- MeSH term filter (disabled for now) -->
  <tr>
      <td>
          <input id="mesh_filter"/>
      </td>
  </tr>
  <!-- ------------------------- -->
*/
?>
