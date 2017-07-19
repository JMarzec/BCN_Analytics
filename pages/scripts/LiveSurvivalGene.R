### HISTORY ###########################################################
# Version		Date			Coder			Comments
# 1.0           07/02/2012     	Emanuela        init
# 1.1           Dec/2013      	Ros             for BCCTB data portal
# 1.2			18/06/2015		Emanuela		tidy script, increase annotation, remove ds-specific & redundancies
# 1.3			xx/08/2015		Emanuela		adapt to avoid calling FC library and improve KM plots
# 1.4       	21/06/2017   	Stefano         adapt to be included in the new BoB portal
# 1.5			22/06/2017		Stefano			take into account multiple exp files
# 1.6			10/07/2017		Emanuela		alterations for multiple files, addition multivariate
# 1.7			17/07/2017		Ema/Stefano		finalise multivariate and add output table

################################################################################

# silent warnings
options(warn=-1)

##### Clear workspace
rm(list=ls())
##### Close any open graphics devices
graphics.off()

#===============================================================================
#    Functions
#===============================================================================

# Dichotomise expression based on median
local.dichotomise.dataset <- function(x, split_at = 99999) {
  if (split_at == 99999) { split_at = median(x, na.rm = TRUE); }
  return( as.numeric( x > split_at ) );
}


#===============================================================================
#    Load libraries
#===============================================================================
suppressMessages(library(survival))
suppressMessages(library(optparse))

#===============================================================================
#    Catching the arguments
#===============================================================================
option_list = list(
  make_option(c("-e", "--exp_file"), action="store", default=NA, type='character',
              help="File containing experimental data"),
  make_option(c("-t", "--target"), action="store", default=NA, type='character',
              help="Clinical data saved in tab-delimited format"),
  make_option(c("-p", "--genes"), action="store", default=NA, type='character',
              help="ID of genes/probe of interest"),
  make_option(c("-d", "--dir"), action="store", default=NA, type='character',
              help="Default directory"),
  make_option(c("-x", "--hexcode"), action="store", default=NA, type='character',
              help="unique_id to save temporary plots")
)

opt = parse_args(OptionParser(option_list=option_list))

expFile <- opt$exp_file
annFile <- opt$target
gene_list <- opt$genes
outFolder <- opt$dir
hexcode <- opt$hexcode


#===============================================================================
#    Main
#===============================================================================
# split exp_file string to retrieve all the identified samples
exp_files = unlist(strsplit(expFile, ","))

# isolate genes of interest, split by comma
genes = unlist(strsplit(gene_list, ","));


# EXTRACT CLINICAL, EXPRESSION & SURVIVAL COVARIATES
# read sample annotation file
annData <- read.table(annFile,sep="\t",as.is=TRUE,header=TRUE);

# subset to samples/patients for which full survival data are available
annData.slimmed <- annData[ complete.cases(annData[ , "surv.stat" ]) , ];

setwd(outFolder);

for (j in 1:length(exp_files)) {

	cat("\nThere are", length(exp_files), "expression files available for this dataset.\tLooking at expression file number", j, "\n\n")

	ef = exp_files[j]

	# read file with expression data
	expData <- read.table(ef,sep="\t",header=TRUE,row.names=1, stringsAsFactors = FALSE)

	# filter the expression data
	selected_samples <- intersect(as.character(annData$File_name),colnames(expData));
	expData.subset <- as.data.frame(t(scale(t(data.matrix(expData[,colnames(expData) %in% selected_samples])))));

	# subset expression data to selected samples
	expData.slimmed <- expData.subset[ , selected_samples ];

	# subset the annData to take into account instances in which more than one expData file is present
	annData.slimmed <-  annData.slimmed[ annData.slimmed$File_name %in% selected_samples , ]


	# EXTRACT SURVIVAL COVARIATES
	rg <- list();
	all.rgs <- NULL;
	gene.covar <- NULL;
	
	surv.stat <- as.numeric( annData.slimmed[ , "surv.stat"]);
	# extract surv time
	surv.time <- as.numeric( annData.slimmed[ , "surv.time"]);

	# FOR EACH GENE SUPPLIED BY USER CALCULATE RISK GROUPS AND APPLY UNIVARIATE MODELLING
	# calculate riskgroups (rg) for each gene
	for( gene.i in genes ) {

		rg[[gene.i]] <- local.dichotomise.dataset( as.matrix(expData.slimmed[ gene.i , ] ));

		# apply surv.model
		cox.fit <- summary( coxph( Surv(surv.time , surv.stat) ~ rg[[gene.i]]) ); 
		
		# kaplan meier input
		cox.km <- survfit(coxph(Surv(surv.time, surv.stat) ~ strata(rg[[gene.i]])));

		# PLOTTING PARAMETERS
		# specify how p-values are to be presented
		if ( cox.fit$sctest[3] < 0.001 ) {
	  		pValue <- "Log-rank P < 0.001";
		} else {
	  		pValue <- paste("Log-rank P = ", round(cox.fit$sctest[3], digits = 3), sep="");
		}

		# prepare risk table
		times <- seq(0, max(cox.km$time), by = max(cox.km$time)/6);
		risk.data <- data.frame(
			strata = summary(cox.km, times = times, extend = TRUE)$strata,
			time = summary(cox.km, times = times, extend = TRUE)$time,
			n.risk = summary(cox.km, times = times, extend = TRUE)$n.risk
		);

		risk.dataLow <- t(risk.data[1:(nrow(risk.data)/2), ]);
		risk.dataHigh <- t(risk.data[(nrow(risk.data)/2+1):nrow(risk.data), ]);


		# GENERATE KM PLOT FOR EACH GENE
		
		png(filename=paste0(hexcode,"_KMplot",j, "_", gene.i, ".png"), width = 680, height = 680, units = "px", pointsize = 18);

		plot(
			cox.km,
			mark.time=TRUE,
			col=c("darkblue", "red"),
			xlab="Time",
			ylab="Survival probability",
			main=paste("Gene: ", gene.i, sep=""),
			cex.main=1,
			#font.main=4, #italics
			lty=c(1,1), 
			lwd=2.5,
			ylim=c(0,1.15),
			xlim=c(0-min(cox.km$time)/2,max(cox.km$time)+min(cox.km$time)/2),
			xaxt="none"
		);
		axis(1, at=round(seq(0, max(cox.km$time), by = max(cox.km$time)/6), digits=2));

		# report HR value, 95% confidence intervals and p-values
		legend(
			"topright",
			legend=c(paste("HR=", round(cox.fit$conf.int[1,1], digits=2), sep=""),
			paste("95% CI (", round(cox.fit$conf.int[1,3], digits=2), "-", round(cox.fit$conf.int[1,4], digits=2), ")", sep=""), pValue),
			box.col="transparent"
		);

		# report numbers in risk groups
		legend("topleft", legend=c("Low risk", "High risk"), col=c("darkblue", "red"), lty=c(1,1), lwd=2.5, box.col="transparent");
		legend("bottom", legend="Number at risk\n\n\n\n", box.col="transparent");
		text( risk.dataLow[2,], rep(0.05, length(risk.dataLow[2,])), col="darkblue", labels= as.numeric(risk.dataLow[3,]));
		text( risk.dataHigh[2,], rep(0, length(risk.dataHigh[2,])), col="red", labels= as.numeric(risk.dataHigh[3,]));
		dev.off();
		
		
		# PREPARATION FOR MULTIVARIATE ANALYSIS
		# collate information for multivariate analyses, including risk groups and univariate covariates
		if (length(genes) == 1){
			# risk groups
			all.rgs = rg[[gene.i]];
			gene.covar <- cbind("Log-rank P"=round(cox.fit$sctest[3], digits=5), "HR"=round(cox.fit$conf.int[1,1], digits=2) );
			rownames(gene.covar) <- gene.i;
		} else {
			all.rgs = cbind(all.rgs, rg[[gene.i]]);
			gene.covar.tmp <- cbind("Log-rank P"=round(cox.fit$sctest[3], digits=5), "HR"=round(cox.fit$conf.int[1,1], digits=2) );
			rownames(gene.covar.tmp) <- gene.i;
			gene.covar <- rbind(gene.covar, gene.covar.tmp)
		}

	} #END loop taking each user-defined gene

	# MULTIVARIATE MODELLING
	multi.cox.fit <- summary( coxph( Surv(surv.time, surv.stat) ~ all.rgs) );


	# Collate p value and HR from univariate and multivariate modelling to present in a table
	multi.covar <- cbind("Log-rank P"=round(multi.cox.fit$sctest[3], digits=5), "HR"=round(multi.cox.fit$conf.int[1,1], digits=2) );
	rownames(multi.covar) <- "Multivariate";
	info.table <- rbind(gene.covar, multi.covar);
	info.table <- cbind(rownames(info.table), info.table); 

	# SAVE json FILE FOR jquery INTERACTIVE TABLE
  	json.filename = paste0(outFolder,"/",hexcode,"_multivariate",j,".json")
  	json.string.header = paste0("{\"draw\":0,\"recordsTotal\":",nrow(info.table),",\"recordsFiltered\":",nrow(info.table),",\"data\":[")
  	total.json.string = ""
  	for (k in 1:nrow(info.table)) {
   	 t = ""
    json.string.body = toString(paste0('"',as.character(info.table[k,]),'"'))
    t = paste0(t,"[")
    t = paste0(t,json.string.body)
    t = paste0(t,"],")
    total.json.string = paste0(total.json.string,t)
  }
  totalnchars.json.string.body = nchar(total.json.string)
  total.json.string = substr(total.json.string,1,totalnchars.json.string.body-1)
  json.string.footer = "]}"

  final.json.string = paste0(json.string.header, total.json.string, json.string.footer)
  cat(final.json.string, file = json.filename)

} #END loop looking at each expression file
