# This Makefile is based on the one for installing the D.O.G. project
# home page at Alioth
#
# Use it as:
#   make USER=your-forjarediris-username
#
# Written by Rafael Laboissiere <rafael@debian.org>
# Modified by Rafa Rodriguez Galván <rafael.rodriguez@uca.es>
# Modified by Manuel Palomo Duarte <manuel.palomo@uca.es>
#
# $Id: Makefile 223 2005-06-09 01:25:15Z rafael $

USER = assessmediawiki
HOST = forja.rediris.es
DIR = /htdocs
HTMLS = index.html publicaciones.html
# OTHERS = header1.png spain.gif united_kingdom.gif
# PAPERS = $(shell ls papers/*.pdf)
# ICONS = # $(shell ls icons/*.png)
# CSS   =  style.css
TARGETFILES = $(HTMLS) $(ICONS) $(CSS) $(OTHERS)

all: $(TARGETFILES)

upload: $(TARGETFILES)
	@echo -n "Subiendo ficheros a la página web..."
	@scp -q $(TARGETFILES) $(USER)@$(HOST):$(DIR)
#	@scp -q $(PAPERS) $(USER)@$(HOST):$(DIR)/papers
	@echo done

%.html: %.rst
	rst2html --no-toc-backlinks --stylesheet=$(CSS) $< $@ 

svn-ci:
	svn ci -m "Cambios en la página web"
	svn up

ls:
	ssh  $(USER)@$(HOST) ls $(DIR)

clean:
#	rm -f index.html 

.PHONY: upload svn-ci ls clean
