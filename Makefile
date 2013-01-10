ASSETS = ./web/assets

#
# BUILD TWITTER BOOTSTRAP
#

bootstrap:
	lessc ./src/twitter/bootstrap/less/bootstrap.less > ${ASSETS}/css/bootstrap.css