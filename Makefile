ASSETS = ./web/assets

#
# BUILD TWITTER BOOTSTRAP
#

bootstrap:
	lessc ./src/twitter/bootstrap/less/bootstrap-responsive.less > ${ASSETS}/css/bootstrap-responsive.css
	lessc ./src/twitter/bootstrap/less/bootstrap.less > ${ASSETS}/css/bootstrap.css

post:
	./app/console gen:mdhtml app/posts/${SLUG}/post.md > app/posts/${SLUG}/post.php