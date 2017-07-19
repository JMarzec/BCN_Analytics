<?php

echo <<< EOT


<div id='doc_acc'>
  <h3>Background</h3>
    <div class="doc">
      <p class='doc'>
        Currently, the publicly-available data sources accessed by BCNTB:Analytics are The Cancer Genome Atlas (TCGA), the Gene Expression Omnibus (GEO)
        and the Cancer Cell Line Encyclopedia (CCLE). You can conduct exploratory and interpretive analyses of transcriptomic, sequencing, genomic and mutation
        data obtained from both tissues and cell lines.
        <br><br>
        BCNTB:Analytics comprises comprehensive analytical modalities from which you can conduct principal component analyses; estimate the tumour purity
        of samples; call molecular subtypes/receptor status, view the expression of gene(s) of interest across different biological conditions;
        conduct correlation analyses; visualise copy number aberrations; and investigate mutational profiles. Furthermore, the ability to conduct network analysis and integrate
        multidimensional data, is also available. These extended analyses are crucial in understanding not only the different alterations
        but also the relationships between them.
        <br><br>
        Key figures are presented in an interactive and downloadable format. These are dynamic, allowing you to zoom in/out, focus on areas of interest, visualise the
        annotation of data points, and exclude or include samples in pre-defined biological groups.
      </p>
    </div>
    <h3>Define your analysis</h3>
      <div class="doc">
        <p class='doc'>
          An overview of the data types and analyses available in BCNTB: Analytics is available from the homepage.
          You are presented with four tabs, representing the four data sources available currently.<br>
          <br><b>PubMed:</b> An automated data selection and retrieval system has been implemented. Publications of interest are identified from PubMed.
          Gene Expression Omnibus or ArrayExpress identifiers are used to establish computational links between the literature and any associated data.
          If data is available in the public domain, the system accesses the repository and downloads the relevant data files.
          These are fed into the relevant analytical pipelines and made available from the PubMed tab.<br>
          <b>The Cancer Genome Atlas (TCGA):</b> The TCGA consortium is dedicated to the systematic study of alterations in a variety of human cancers.
          It has made publicly available DNA copy number, mRNA expression, methylation and mutation data, alongside its associated clinical data
          for a range of cancer types/subtypes. Currently, mRNA expression and mutation data are available for analysis, with genomic data to follow shortly.<br>
          <b>Cancer Cell Line Encyclopedia (CCLE):</b> DNA copy number, mRNA expression and mutation data for breast cancer cell lines are available from this tab.<br>
          <b>BCN Tissue Bank:</b> From this tab, data returned to the BCNTB will be available for mining and analysis. As the molecular data for the samples continues to increase,
          you will be able to conduct integrative analyses, thereby gaining a multidimensional understanding of the samples, their alterations and the relationships underlying them.
          <br><br>
          Once you have selected a source, you will be directed to a page from which you will be able to conduct exploratory, investigative and extended analyses.
        </p>
      </div>
  <h3>Principal component analysis</h3>
    <div class="doc">
      <p class='doc'>
        <b>Principal component analyses (PCA)</b> allow you to visualise the global structure of the data and identify key “components” of variation.
        <br><br>
        For each dataset, scatterplots representing <b>(A)</b> the first two and <b>(B)</b> the first three principal components of the data are presented.
        In this instance, the dataset represents inflammatory breast cancer (IBC) subtypes.
        Each data point represents the orientation of a single sample in the transcriptomic space projected on the PCA, with different colours
        indicating the biological group to which each sample belongs. The percentage values in brackets on each axis indicate the amount of variance
        in the data explained by the corresponding principal component. <b>(C)</b> The global variability of the data can also be assessed from the histogram.
        Here, you can identify the fraction of total variance (y-axis) attributed to each principal component (x-axis).
      </p>
      <br><br>
      <center> <img class="doc" src="../images/doc/pca.png"> </center>
    </div>
  <h3>Estimates of tumour purity</h3>
    <div class="doc">
      <p class='doc'>
        Cancer samples frequently contain a small proportion of infiltrating stromal and immune cells that may not only confound the
        tumour signal in molecular analyses but may also have a role in tumourigenesis and progression. We apply an algorithm that
        uses gene expression data to calculate <b>stromal score</b>, <b>immune score</b> and <b>estimate score</b>, and infer <b>tumour purity</b> from these values.
        <br><br>
        (<b>A</b>) A three-dimensional scatterplot displaying the stromal score, immune score and estimate score for each sample is provided.
        (<b>B</b>) The tumour purity estimates (percentages) for each sample are provided in a dynamic table that can be filtered by key words
        or tumour purity values.

        <center> <img class="doc" src="../images/doc/estimates.png"> </center>
      </p>
    </div>
  <h3>Molecular classification of samples</h3>
    <div class="doc">
      <p class='doc'>
        Two analyses are available from the <i>Molecular classification</i> tab.
        <br><br>
        The first analysis assigns each sample to a <b>molecular subtype</b>. Seminal studies that applied microarray-based technologies
        to breast cancer were able to identify five molecular subtypes —oestrogen receptor positive subtypes (Luminal A and Luminal B)
        and oestrogen receptor negative subtypes (Basal-like, Her2-enriched and Normal breast-like).
        We apply the PAM50 single sample predictor model that was developed as a result of these studies to each dataset.
        PAM50 assigns samples into intrinsic tumour types, with distinct transcriptomic signatures,
        based on the expression of key breast cancer-specific genes.
        <br><br>
        The second analysis applies Gaussian finite mixture modelling to the expression data to assign each sample a <b>molecular
        receptor status</b> for oestrogen (ER), progesterone (PR) and Her2. Subsequently, the triple negative samples are identified
        and highlighted.
        <br><br>
        <b>(A)</b> An overview of molecular subtype calls for tumour samples is presented as a barchart. <b>(B)</b> The molecular receptor
        status for ER, PR and Her2, as well as triple negative samples, are presented as stacked barcharts.

        <center> <img class="doc" src="../images/doc/pam50.png"> </center>
      </p>
    </div>
  <h3>Gene expression plots</h3>
    <div class="doc">
      <p class='doc'>
        From this tab, you can view how the <b>expression</b> of your gene(s) of interest varies across different biological conditions.
        To provide a comprehensive overview of expression values across the biological groups, results are presented as both
        summarised and a sample views (box-and whisker plot and barplot, respectively).
        <br><br>
        Here, we show examples of results obtained using the CCLE dataset. (<b>A</b>) From the box-and-whisker plot, can view if, and how,
        the expression of your gene of interest varies across the different biological groups. (<b>B</b>) To facilitate the understanding
        of any differences, a barplot in which the expression values of individual samples (bars) is also provided.
        The samples are clustered by biological group and ordered within each group by expression value.

        <center> <img class="doc" src="../images/doc/gene_expression.png"> </center>
      </p>
    </div>
  <h3>Correlation analysis</h3>
    <div class="doc">
      <p class='doc'>
        Pairwise <b>correlations</b> of your genes of interest are conducted.
        <br><br>
        For each comparison, the Pearson Product Moment Correlation Coefficient (PMCC) and p-value is calculated and presented in a heatmap.
        The colour of each cell represents the correlation coefficient for each comparison.
        The correlation value calculated for each pairwise comparison can be viewed by hovering over the cells.

        <center> <img class="doc" src="../images/doc/correlations.png"> </center>
      </p>
    </div>
  <h3>Survival analysis</h3>
    <div class="doc">
      <p class='doc'>
        From the <i>survival</i> tab, you can conduct univariate and multivariate analyses.<br><br>
        <b>Univariate:</b> You can visualise the relationship between survival and (i) <i>molecular subtype</i> and (ii) <i>gene(s)</i> of interest.
        A univariate model is applied to the survival data and samples are assigned to risk groups based on the median expression value for the gene of interest.<br>
        <b>Multivariate:</b> You can also model the effect of multiple variables (genes of interest) simultaneously.
        <br><br>
        Kaplan Meier plots are generated to view (<b>A</b>) the differences in survival across the molecular subtypes and (<b>B</b>) the relationship
        between survival and a gene(s) of interest.

        <center> <img class="doc" src="../images/doc/survival.png"> </center>
      </p>
    </div>
    <h3>Identification of frequently mutated genes</h3>
      <div class="doc">
        <p class='doc'>
          Advances in sequencing technologies allow for the systematic characterisation of <b>mutations</b> in breast cancer.
          From the <i>Mutations</i> tab, you can view a summary of the top mutated genes in breast cancer or the mutational status of your gene(s) of interest.
          <br><br>
          MuTect2 is applied to call somatic single nucleotide variants from matched tumour-normal samples and isolate the top mutated genes.
          <b>(A)</b> The top mutation events are presented as a heatmap, with barplots indicating the number of <b>(B)</b> mutations per sample
          and <b>(C)</b> type of mutations per gene also generated. <b>(D)</b> The clinical covariates associated with each sample can
          be visualised below the heatmap.

          <center> <img class="doc" src="../images/doc/oncoprint.png"> </center>
        </p>
      </div>
  <h3>Data integration</h3>
    <div class="doc">
      <p class='doc'>
        For instances in which multiple technologies have been applied to the same sample/patient, you have the opportunity to integrate the different types of data,
        allowing for the visual exploration of the relationship between them.
        <br> <br>
        Once a gene of interest has been specified, you will be presented with up to four plots. The number of results generated is dependent on the data that is available.
        If information about gene expression and copy number alterations is available, (<b>A</b>) a scatterplot of expression values (y-axis) against copy
        number values (x-axis) and (<b>B</b>) a box-and-whisker plot displaying the expression values (y-axis) of samples within categorised copy number
        alterations (x-axis) are generated. For these plots, the biological group of each sample is indicated by the colour of the data point.
        If mutational information is also available, an additional (<b>C</b>) scatterplot and (<b>D</b>) box-and-whisker plot is generated, where the mutational
        status of each sample is indicated by the colour of the data point.

        <center> <img class="doc" src="../images/doc/mut.png"> </center>
      </p>
    </div>
    
  <h3>Gene networks</h3