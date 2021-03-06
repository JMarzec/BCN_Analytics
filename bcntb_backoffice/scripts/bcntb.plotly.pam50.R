### bcntb.plotly.pam50.R ###
### DESCRIPTION ########################################################
# This script dinamically creates PAM50 barplots from report file
# generated by the bcntb.pam50.R script

### HISTORY ###########################################################
# Version		Date					Coder						Comments
# 1.0			2017/06/05			Stefano					starting from the scratch

### PARAMETERS #######################################################
current_dir <- getwd()
suppressMessages(library(optparse))
suppressMessages(library(plotly))

##### COMMAND LINE PARAMETERS ###############################################
### Here we take advantage of Optparse to manage arguments####
### Creating list of arguments ###
option_list = list(
  make_option(c("-r", "--report"), action="store", default=NA, type='character',
              help="File containing pam50 report (bcntb.pam50.R)"),
  make_option(c("-d", "--dir"), action="store", default=NA, type='character',
              help="Default directory for output")
)

opt = parse_args(OptionParser(option_list=option_list))

# reading pam50 report file
pam50 <- read.table(opt$report, sep = "\t", header = TRUE, stringsAsFactors = FALSE)

# calculating frequency of different molecular subtypes
pam50.freq <- as.data.frame(table(pam50$subtype))
# calculating the total number of samples into the report
total = sum(pam50.freq$Freq)

# generating the Plotly barplot
pam50_plot <- plot_ly(pam50.freq,
        x = pam50.freq$Var1,
        y = pam50.freq$Freq,
        type = 'bar',

        ### defining bar colors ####
        # rgba(255,51,51,0.3) --> red
        # rgba(0,0,204,0.3) --> blue
        # rgba(102,204,0,0.3) --> light green
        # rgba(0,102,0,0.3) --> dark green
        # rgba(204,0,102,0.3) --> dark pink

        marker = list(color = c('rgba(255,51,51,0.3)', 'rgba(0,0,204,0.3)',
                                'rgba(102,204,0,0.3)', 'rgba(0,102,0,0.3)',
                                'rgba(204,0,102,0.3)'),
                      # defining bar line colors (same as bar colors but different opacity)
                      line = list(color = c('rgba(255,51,51,1)', 'rgba(0,0,204,1)',
                                            'rgba(102,204,0,1)', 'rgba(0,102,0,1)',
                                            'rgba(204,0,102,1)'), width = 1.5)),
        # adding percentage in the hover label text
        text = paste(round((pam50.freq$Freq/total)*100, digits = 2),'%'),
        textpositionsrc = 'center',
        width = '800px'
) %>%
layout(yaxis = list(title = 'Frequency'),
       xaxis = list(title = 'Subtypes'),
      barmode = 'group',
      title = 'Molecular classification',
      showlegend = FALSE
)

## defining plot file name
pam50_filename = paste(opt$dir,"pam50.html",sep = "/")

## saving generated plot into web page
htmlwidgets::saveWidget(pam50_plot, pam50_filename)
