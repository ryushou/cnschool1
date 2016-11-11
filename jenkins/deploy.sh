#!/bin/bash

SERVER_DIR1=/home/ubuntu/www/gts_cos
SERVER_DIR2=/home/ubuntu/www/gts_yiwu
EXCLUDE=${WORKSPACE}/jenkins/exclude.conf

if [ `whoami` != "jenkins" ]; then
echo "It is not jenkins user. Please run with jenkins user."
    exit
fi

echo 'deploy1 exec'
sudo -u ubuntu rsync -vrz --delete --exclude-from=${EXCLUDE} ${WORKSPACE}/ ${SERVER_DIR1} | grep -v /$
echo 'deploy1 completed!!'

echo 'deploy2 exec'
sudo -u ubuntu rsync -vrz --delete --exclude-from=${EXCLUDE} ${WORKSPACE}/ ${SERVER_DIR2} | grep -v /$
echo 'deploy2 completed!!'
