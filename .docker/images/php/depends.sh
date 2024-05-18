#!/bin/bash

if [ -z ${PHP_FOLDER_PROJECT} ]
then
    PHP_FOLDER_PROJECT=/usr/local/apache2/www/
fi

if [ -z ${PHP_FOLDER_TMP} ]
then
    PHP_FOLDER_TMP="/var/tmp/docker/php/"
fi

if [ -z ${VALUE_PCTR_ROUT_VERSION} ]
then
    VALUE_PCTR_ROUT_VERSION="latest"
fi

cd ${PHP_FOLDER_TMP}

curl -sL https://github.com/pctronique/pctrouting/archive/refs/tags/${VALUE_PCTR_ROUT_VERSION}.tar.gz | tar xz
cp -r pctrouting-${VALUE_PCTR_ROUT_VERSION}/project/www/src/class/pctrouting ${PHP_FOLDER_PROJECT}/src/class/
rm -rf pctrouting-${VALUE_PCTR_ROUT_VERSION}
