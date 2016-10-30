#!/bin/bash

set -e

VERSION=`date +%Y-%m-%dT%H%M%S`
FILE=$VERSION.zip

git archive HEAD -o $FILE
zip $FILE -ur commonFramework --exclude "*.git*" -q
zip $FILE -ur dbv --exclude "*.git*" -q
zip $FILE -ur ext/pi-google-maps-api --exclude "*.git*" -q

S3KEY="contest-platform/$FILE"
BUCKET="elasticbeanstalk-eu-central-1-997893130250"
aws s3 cp $FILE s3://$BUCKET/$S3KEY $@

aws elasticbeanstalk create-application-version --application-name contest-platform  --region eu-central-1 --version-label $VERSION --source-bundle S3Bucket=$BUCKET,S3Key=$S3KEY $@ 
rm $FILE

eb deploy contestplatform --version $VERSION $@