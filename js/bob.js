/* Javascript methods for the Tissue Finder 2.0 *
 * Coder: Stefano Pirro'
 * Institution: Barts Cancer Institute
 * Details: all the javascript behaviours of the BOB portal, are included here. */

// loading frame
var loading = "<center>\
                <h2>Loading results, please wait...</h2>\
                <img src='../images/loading.svg' alt='Loading'>\
              </center>";

// webiste for loading iframe
var iframe_url = "http://bioinformatics.breastcancertissuebank.org:9003/bcntb_proto//bcntb_backoffice/tmp/";
var tcga_iframe_url = "http://bioinformatics.breastcancertissuebank.org:9003/bcntb_proto//bcntb_backoffice/data/tcga/";


function LoadHomePage() {
  $("#source.container").load("home.php");
  $("#source.container").show();
  //console.log("LoadHomePage");
}

function LoadSelector() {
	$(".analysis_sel").button();
    $(".analysis_sel").click(function() {
        var clickedId = $(this).attr("id");
        //$("#main.container").hide();
        //$("#main.container").empty(); // emptying all the items inside the div
        $("#results.container").empty(); // emptying all the items inside the div
        $("#main.container").load(""+clickedId+".php", function(){
          $("div#description.container").hide("slow");
          $("#main.container").show();
        });
    });
}

function LoadMenuSelector() {
  $("a.menu_btn").click(function(event) {
    $("#source.container").hide();
    var clickedId = $(this).attr("id");
    var text = $("#source.container").load(""+clickedId+".php");
    $("#source.container").html();
    $("#source.container").show();
    event.preventDefault();
  });
}

function LoadScoreSlider(el_name) {
  $( "div#"+el_name+"" ).slider({
      range: true,
      step: 0.1,
      min: 0,
      max: 1,
      values: [ 0.4, 0.8],
      slide: function( event, ui ) {
        $( "#min_thr_label" ).val( "" + ui.values[ 0 ] + "");
        $( "#max_thr_label" ).val( "" + ui.values[ 1 ] + "");
      }
  });
  // initilizing values on load
  $( "#min_thr_label" ).val(""+$("div#"+el_name+"").slider("values",0)+"");
  $( "#max_thr_label" ).val(""+$("div#"+el_name+"").slider("values",1)+"");
}

function LoadPapersTable() {

		// hiding results frame
		$("#analysis_container").hide();
		// hiding analysis_button
		$("#analysis_button").hide();

		// INITIALISING DATA TABLE //
		var papersTable = $('#papers').DataTable( {
      dom: 'Bfrtip',
      buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
      ],
			"order": [[ 4, "asc" ]],
			"processing": false,
			"serverSide": false,
			"ajax": {
				"url":"scripts/server_processing_literature.php",
				"type":"post"
			},
			"columnDefs": [
            {
                "targets": [ 6 ],
                "visible": false
            },
            {
                "targets": [ 5 ],
                "visible": false
            },
            {
                "targets": [ 4 ],
                "visible": false
            }
			]
		});

    yadcf.init(papersTable, [{
      column_number: 3,
      filter_type: "range_date",
      date_format: "yy-mm-dd",
      filter_container_id: "pubdate_filter",
      filter_plugin_options: {
        changeMonth: true,
        changeYear: true
      }
    },
    {
      column_number: 1,
      filter_type: "text",
      filter_container_id: "kw_filter",
    },
    {
      column_number: 5,
      filter_type: 'multi_select_custom_func',
      custom_func: cumulative,
      select_type: 'chosen',
      text_data_delimiter: ',',
      filter_container_id: 'bioinfo_filter',
    },
    {
      column_number: 6,
      filter_type: 'multi_select',
      select_type: 'chosen',
      filter_container_id: 'curated_filter',
    }]);

	// highlight selected rows
	$('#papers tbody').on( 'click', 'tr', function () {
		$("#analysis_button").show();
		if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
		}
		else {
				papersTable.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
		}
	});

		// FILTERING SECTION //

		// autocomplete on MeSH terms
		var options = {
			url: "scripts/RetrieveMeshTerms.php",
			getValue: "Keyword",
			list: {
				match: {
					enabled: true
				},
				onClickEvent: function() {
					var selectedID = $("#mesh_filter").getSelectedItemData().ID;
					papersTable.fnClearTable();
					$.ajax( {
						url:"scripts/FilterData.php?mesh_id="+selectedID+"",
						type:"get",
						dataType:"json",
						beforeSend: function()
						{
							$('#right.literature').hide('slow');
						},
						success: function(data) {
							// showing resulting table
							$('#right.literature').show('slow');
							// now we fill the table again with new filtered values
							papersTable.fnAddData(data['data']);
						}
					});
				}
			},
			template: {
				type: "description",
				fields: {
					description: "Occurrences"
				}
			}
		};

		$("#mesh_filter").easyAutocomplete(options);

    $("#run").button();
			$("#run").click(function(e) {
        var PMID = $('table#papers tr.selected').children().eq(0).text();
        $("div#loading").html(loading);
        $("div#loading").show();
        $("#results.container").load("scripts/loading_results.php?pmid="+PMID+"", function() {
          $("#results.container").show();
          scrollSmoothToBottom();
          $("div#loading").hide();
        });
		});

		$("#filter").accordion({
			 heightStyle: "content",
			 multiple: true,
			 collapsible: true
		});
}

function LoadCCLETable() {

		// hiding results frame
		$("#analysis_container").hide();
		// hiding analysis_button
		$("#analysis_button").hide();

		// INITIALISING DATA TABLE //
		var ccleTable = $('table#ccle').DataTable( {
      dom: 'Bfrtip',
      buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
      ],
			"order": [[ 4, "asc" ]],
			"processing": true,
			"serverSide": false,
			"ajax": {
				"url":"scripts/server_processing_ccle.php",
				"type":"post"
			}
		});
}

// Ema added to try and create BCNTB data return table
function LoadBcntbReturnTable() {

		// hiding results frame
		$("#analysis_container").hide();
		// hiding analysis_button
		$("#analysis_button").hide();

		// INITIALISING DATA TABLE //
		var LoadbcntbreturnTable = $('table#bcntbreturn').DataTable( {
      dom: 'Bfrtip',
      buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
      ],
			"order": [[ 0, "asc" ]],
			"processing": true,
			"serverSide": false,
			"ajax": {
				"url":"scripts/server_processing_bcntbReturn.php",
				"type":"post"
			}
		});
}

// function to Load Tabs
function LoadResultTabs(cont) {
  $("#tabs_s"+cont+"").tabs();
}

function LoadCCLETabs() {
  $("#ccle_results.container").tabs();
}

function LoadTCGATabs() {
  $("#tcga_results.container").tabs();
}


// function to load MultiGeneSelector
// this function takes as input the name of html element to call,
// the array express id and PMID id (to call the right expression matrix)
function LoadGeneSelector(el_name, ae, pmid, type_analysis) {

  $.fn.select2.defaults.set("theme", "classic");
  $.fn.select2.defaults.set("ajax--cache", false);

  // we decided to implement an ajax-based search
  $( "#"+el_name+"" ).select2({
    width:'50%',
    ajax: {
      url: "scripts/RetrieveGeneList.php?ae="+ae+"&pmid="+pmid+"&type_analysis="+type_analysis+"",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          q: params.term, // search term
        };
      },
      processResults: function (data, params) {
        return {
          results: data
        };
        var q = '';
      },
      cache: false
    }
  });
}

// this function launch the Rscript to create the expression profile plot for the selected gene
// the function takes three parameter
// -- el_name: html element to call
// -- ae: array_express id
// -- pmid : pubmed id
// Please note, for security reasons, the launch of Rscript and all system commands are delegated to
// a php function ("LaunchCommand.php")
function LoadAnalysis(genebox, el_name, ae, pmid, type_analysis, cont) {
  var random_code = Math.random().toString(36).substring(7);
  if (type_analysis == "gene_expression") {
    $("#"+el_name+"").click(function() {
      var gene = $("#"+genebox+"").val();

      // launching ajax call to retrieve the expression plot for the selected gene
      $.ajax( {
        url:"scripts/LaunchCommand.php?TypeAnalysis="+type_analysis+"&ArrayExpressCode="+ae+"&PMID="+pmid+"&Genes="+gene+"&rc="+random_code+"",
        type:"get",
        beforeSend: function()
        {
          $("div#loading").html(loading);
          $("div#loading").show();
        },
        success: function(data) {
          $("div#loading").hide();
            // loading iframes inside the results box, then showing the box
            $("iframe#"+genebox+"_box.results").attr("src", ""+iframe_url+random_code+"_box.html");
            $("iframe#"+genebox+"_bar.results").attr("src", ""+iframe_url+random_code+"_bar.html");
            $("div.expression_profile_container").show();
        }
      });
    });
  } else if (type_analysis == "co_expression") {
    $("#"+el_name+"").click(function() {
      var genes = $("#"+genebox+"").val();
      // checking the length of the uploaded genes
      if (genes.length > 2 && genes.length <= 50) {
        var genes_string = genes.join(",");

        // launching ajax call to retrieve the expression plot for the selected gene
        $.ajax( {
          url:"scripts/LaunchCommand.php?TypeAnalysis="+type_analysis+"&ArrayExpressCode="+ae+"&PMID="+pmid+"&Genes="+genes_string+"&rc="+random_code+"",
          type:"get",
          beforeSend: function()
          {
            $("div#loading").html(loading);
            $("div#loading").show();
          },
          success: function(data) {
            $("div#loading").hide();
            $("iframe#"+genebox+"_hm.results").attr("src", ""+iframe_url+random_code+"_corr_heatmap"+cont+".html");
            $(".coexpression_container").show();
          }
        });
      } else {
        alert("Please select at least 2 genes (max 50)");
        return false
      }
    });
  } else if (type_analysis == "survival") {
    $("#"+el_name+"").click(function() {
      var gene = $("#"+genebox+"").val();

      // checking the length of the uploaded genes
      if (gene.length > 0 && gene.length < 4) {
        // launching ajax call to retrieve the expression plot for the selected gene
        $.ajax( {
          url:"scripts/LaunchCommand.php?TypeAnalysis="+type_analysis+"&ArrayExpressCode="+ae+"&PMID="+pmid+"&Genes="+gene+"&rc="+random_code+"",
          type:"get",
          beforeSend: function()
          {
            $("div#loading").html(loading);
            $("div#loading").show();
          },
          success: function(data) {
            // loading survival table
            var table = $('table#survival_details').DataTable( {
              dom: 'Bfrtip',
              buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
              ],
              "processing": false,
              "serverSide": false,
              "destroy": true,
              "ajax": {
                "url": ""+iframe_url+random_code+"_multivariate1.json", // we visualize the first network as default
              }
            });

            // remove all the images inside the div
            $('div.survival_container > center').remove();
            // append the new images
            $.each( gene, function( index, sg) {
              $(".survival_container").append("<center><img src='"+iframe_url+random_code+"_KMplot"+cont+"_"+sg+".png'></center>");
            });
            $(".survival_container").show();
            $("div#loading").hide();
          }
        });
      } else {
        alert("Please select a maximum number of 3 genes");
        return false
      }
    });
  } else if (type_analysis == "gene_network") {
    $("#"+el_name+"").click(function() {
      // getting genes of interest
      var genes = $("#"+genebox+"").val();
      var genes_string = genes.join(",");

      // getting min and max score thresolds
      var min_thr = $("input#min_thr_label").val();
      var max_thr = $("input#max_thr_label").val();

      // launching ajax call to retrieve the expression plot for the selected gene
      $.ajax( {
        url:"scripts/LaunchCommand.php?TypeAnalysis="+type_analysis+"&ArrayExpressCode="+ae+"&PMID="+pmid+"&Genes="+genes+"&rc="+random_code+"&min_thr="+min_thr+"&max_thr="+max_thr+"",
        type:"get",
        beforeSend: function()
        {
          $("div#loading").html(loading);
          $("div#loading").show();
        },
        success: function(data) {
          $("div#loading").hide();
          $("input#random_code").val(random_code);
          $("iframe#network_container.results").attr("src", ""+iframe_url+random_code+"_network"+cont+".html");
          var table = $('table#network_details').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5'
            ],
            "processing": false,
            "serverSide": false,
            "destroy": true,
            "ajax": {
              "url": ""+iframe_url+random_code+"_network0.json", // we visualize the first network as default
            }
          });
          $(".network_container").show();
        }
      });
    });
  } else if (type_analysis == "ccle_gene_expression") {
    $("#"+el_name+"").click(function() {
      var gene = $("#"+genebox+"").val();
      // launching ajax call to retrieve the expression plot for the selected gene
      $.ajax( {
        url:"scripts/LaunchCommand.php?TypeAnalysis="+type_analysis+"&Genes="+gene+"&rc="+random_code+"",
        type:"get",
        beforeSend: function()
        {
          $("div#loading").html(loading);
          $("div#loading").show();
        },
        success: function(data) {
          $("iframe#"+genebox+"_box.results").attr("src", ""+iframe_url+random_code+"_box.html");
          $("iframe#"+genebox+"_bar.results").attr("src", ""+iframe_url+random_code+"_bar.html");
          $(".gea_ccle").show();
          $("div#loading").hide();
        }
      });
    });
  } else if (type_analysis == "ccle_co_expression") {
    $("#"+el_name+"").click(function() {
      var genes = $("#"+genebox+"").val();

      // checking the length of the uploaded genes
      if (genes.length > 2 && genes.length <= 50) {
        var genes_string = genes.join(",");

        // launching ajax call to retrieve the expression plot for the selected gene
        $.ajax( {
          url:"scripts/LaunchCommand.php?TypeAnalysis="+type_analysis+"&Genes="+genes_string+"&rc="+random_code+"",
          type:"get",
          beforeSend: function()
          {
            $("div#loading").html(loading);
            $("div#loading").show();
          },
          success: function(data) {
            $("iframe#"+genebox+"_hm.results").attr("src", ""+iframe_url+random_code+"_corr_heatmap"+cont+".html");
            $(".cea_ccle").show();
            $("div#loading").hide();
          }
        });
      } else {
        alert("Please select at least 2 genes (max 50)");
        return false
      }
    });
  } else if (type_analysis == "ccle_expression_layering") {
    $("#"+el_name+"").click(function() {
      var gene = $("#"+genebox+"").val();
      // launching ajax call to retrieve the expression plot for the selected gene
      $.ajax( {
        url:"scripts/LaunchCommand.php?TypeAnalysis="+type_analysis+"&Genes="+gene+"&rc="+random_code+"",
        type:"get",
        beforeSend: function()
        {
          $("div#loading").html(loading);
          $("div#loading").show();
        },
        success: function(data) {
          $("iframe#"+genebox+"_boxel.results").attr("src", ""+iframe_url+random_code+"_mRNA_vs_CN_boxplot.html");
          $("iframe#"+genebox+"_el.results").attr("src", ""+iframe_url+random_code+"_mRNA_vs_CN_plot.html");
          $("iframe#"+genebox+"_boxel_mut.results").attr("src", ""+iframe_url+random_code+"_mRNA_vs_CN_mut_boxplot.html");
          $("iframe#"+genebox+"_el_mut.results").attr("src", ""+iframe_url+random_code+"_mRNA_vs_CN_mut_plot.html");
          $(".el_ccle").show();
          $("div#loading").hide();
        }
      });
    });
  } else if (type_analysis == "ccle_cn_alterations") {
    $("#"+el_name+"").click(function() {
      var gene = $("#"+genebox+"").val();
      // launching ajax call to retrieve the expression plot for the selected gene
      $.ajax( {
        url:"scripts/LaunchCommand.php?TypeAnalysis="+type_analysis+"&Genes="+gene+"&rc="+random_code+"",
        type:"get",
        beforeSend: function()
        {
          $("div#loading").html(loading);
          $("div#loading").show();
        },
        success: function(data) {
          $("iframe#cna_hm").attr("src", ""+iframe_url+random_code+"_hm.html");
          $("div#loading").hide();
        }
      });
    });
  } else if (type_analysis == "tcga_gene_expression") {
    $("#"+el_name+"").click(function() {
      var gene = $("#"+genebox+"").val();
      // launching ajax call to retrieve the expression plot for the selected gene
      $.ajax( {
        url:"scripts/LaunchCommand.php?TypeAnalysis="+type_analysis+"&Genes="+gene+"&rc="+random_code+"",
        type:"get",
        beforeSend: function()
        {
          $("div#loading").html(loading);
          $("div#loading").show();
        },
        success: function(data) {
          $("iframe#"+genebox+"_box.results").attr("src", ""+iframe_url+random_code+"_box.html");
          $("iframe#"+genebox+"_bar.results").attr("src", ""+iframe_url+random_code+"_bar.html");
          $(".gea_tcga").show();
          $("div#loading").hide();
        }
      });
    });
  } else if (type_analysis == "tcga_co_expression") {
    $("#"+el_name+"").click(function() {
      var genes = $("#"+genebox+"").val();

      // checking the length of the uploaded genes
      if (genes.length > 2 && genes.length <= 50) {
        var genes_string = genes.join(",");

        // launching ajax call to retrieve the expression plot for the selected gene
        $.ajax( {
          url:"scripts/LaunchCommand.php?TypeAnalysis="+type_analysis+"&Genes="+genes_string+"&rc="+random_code+"",
          type:"get",
          beforeSend: function()
          {
            $("div#loading").html(loading);
            $("div#loading").show();
          },
          success: function(data) {
            $("iframe#"+genebox+"_hm.results").attr("src", ""+iframe_url+random_code+"_corr_heatmap"+cont+".html");
            $(".cea_tcga").show();
            $("div#loading").hide();
          }
        });
      } else {
        alert("Please select at least 2 genes (max 50)");
        return false
      }
    });
  } else if (type_analysis == "tcga_mutations") {
    $("#"+el_name+"").click(function() {
      var genes = $("#"+genebox+"").val();

      // checking the length of the uploaded genes
      if (genes.length > 2 && genes.length <= 50) {
        var genes_string = genes.join(",");

        // launching ajax call to retrieve the expression plot for the selected gene
        $.ajax( {
          url:"scripts/LaunchCommand.php?TypeAnalysis="+type_analysis+"&Genes="+genes_string+"&rc="+random_code+"",
          type:"get",
          beforeSend: function()
          {
            $("div#loading").html(loading);
            $("div#loading").show();
          },
          success: function(data) {
            $(".mut_tcga").append("src", ""+iframe_url+random_code+"_corr_heatmap"+cont+".html");
            $(".mut_tcga").show();
            $("div#loading").hide();
          }
        });
      } else {
        alert("Please select at least 2 genes (max 50)");
        return false
      }
    });
  }
}

// this function load the Tumor purity data table to visualise samples and
// giving the possibility to filter according to the tumor purity Estimate score
function LoadDetailDataTable(el_name, type) {
  if (type == "Estimate") {
    var EstimateTable = $("#"+el_name+"").DataTable({
      dom: 'Bfrtip',
      buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
      ]
    });
    yadcf.init(EstimateTable, [{
      column_number: 2,
      filter_type: "range_number_slider",
    }]);
  } else {
    $("#"+el_name+"").DataTable({
        dom: 'Bfrtip',
        buttons: [
              'copyHtml5',
              'excelHtml5',
              'csvHtml5',
              'pdfHtml5'
        ]
    });
  }
}

// Function for cumulative_filtering in analysis
function cumulative(filterVal, columnVal) {
	if (filterVal === null) {
  	return true;
  }
	if (filterVal){
		var found;
		var myElement;
		var foundTout = 0;
		var nbElemSelected = filterVal.length;

      for (i=0; i<nbElemSelected; i++)
      {
          myElement = filterVal[i];
          switch (myElement) {
            case "Gene expression":found = columnVal.search(/Gene expression/g);
            break;
            case "Correlations":found = columnVal.search(/Correlations/g);
            break;
            case "Molecular classification":found = columnVal.search(/Molecular classification/g);
            break;
            case "PCA":found = columnVal.search(/PCA/g);
            break;
            case "Receptor status":found = columnVal.search(/Receptor status/g);
            break;
            case "Survival analysis":found = columnVal.search(/Survival analysis/g);
            break;
            case "Tumour purity":found = columnVal.search(/Tumour purity/g);
            break;
            case "Gene networks":found = columnVal.search(/Gene networks/g);
            break;
          } //close switch
          if (found !== -1) {foundTout++;}
      } // close for
      if (foundTout == filterVal.length) {return true;}
      else {return false;}
	} //close if(filterVal)
} //close myCustomFilterFunction()

// function for scrolling page to the bottom
function scrollSmoothToBottom (id) {
  var div = document.getElementById(id);
  $('body').animate({
    scrollTop: document.body.scrollHeight
  }, 1000);
}

// function for loading the documentation accordion
function LoadDocAcc() {
  $("#doc_acc").accordion({
    heightStyle: "content"
  });
}

// function for loading the results accordion
function LoadResultAcc() {
  $("#res_acc").accordion({
    heightStyle: "content",
    active: false,
    collapsible: true
  });
}

// function to adjust the size of the results iframe according to the content
function resizeIframe(obj){
  obj.style.height = 0;
  obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}

function LoadNetworkGraph(index) {
  var random_code = $("input#random_code").val();
  $("iframe#network_container.results").attr("src", ""+iframe_url+random_code+"_network"+index+".html");
  $('table#network_details').DataTable().ajax.url(""+iframe_url+random_code+"_network"+index+".json").load();
}

function LoadOncoPrint(number_genes) {
  // remove all the images inside the div
  $('div#top_mut_genes > center').remove();
  // append the new images
  $("div#top_mut_genes").append("<center><img src='"+tcga_iframe_url+"Mutations_top"+number_genes+".png' style='width:800px; height:auto'></center>");
}
