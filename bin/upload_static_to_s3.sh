# to be moved to a more appropriate place

FILES="
common.js
bower_components/json3/lib/json3.min.js
bower_components/jquery/jquery.min.js
bower_components/jQuery-ajaxTransport-XDomainRequest/jquery.xdomainrequest.min.js
bower_components/jquery-ui/jquery-ui.min.js
bower_components/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js
bower_components/i18next/i18next.min.js
bower_components/utf8/utf8.js
bower_components/base64/base64.min.js
bower_components/pem-platform/task-pr.js
style.css
i18n/en/translation.json
raphael-min.js
i18n/fr/translation.json
i18n/en/translation.json
"
for file in $FILES
do
	aws s3 cp contestInterface/$file s3://contest-platform-contests-eu-central-1-997893130250/contestAssets/$file --acl public-read $@ --cache-control 'max-age=3600, must-revalidate'
done

# gzip -c9 translations/castor-contest.json | aws s3 cp - s3://static3.castor-informatique.fr/contestAssets/i18n/fr/castor.json --acl public-read --content-encoding 'gzip' --content-type 'application/json' --region eu-west-1 --cache-control 'max-age=43200, must-revalidate'
# i18n/fr/translation.json
# 
# gzip -c9 beaver_tasks/modules/ext/blockly/handclosed.cur | aws s3 cp - s3://static3.castor-informatique.fr/contestAssets/blockly/handclosed.cur --acl public-read --content-encoding 'gzip' --content-type 'image/x-win-bitmap' --region eu-west-1 --cache-control 'max-age=43200, must-revalidate'
# gzip -c9 beaver_tasks/modules/ext/blockly/handopen.cur | aws s3 cp - s3://static3.castor-informatique.fr/contestAssets/blockly/handopen.cur --acl public-read --content-encoding 'gzip' --content-type 'image/x-win-bitmap' --region eu-west-1 --cache-control 'max-age=43200, must-revalidate'
# gzip -c9 beaver_tasks/modules/ext/blockly/sprites.png | aws s3 cp - s3://static3.castor-informatique.fr/contestAssets/blockly/sprites.png --acl public-read --content-encoding 'gzip' --content-type 'image/png' --region eu-west-1 --cache-control 'max-age=43200, must-revalidate'