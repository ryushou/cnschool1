#!/bin/bash

SERVER_DIR1=/home/ubuntu/www/cos_web
EXCLUDE=${WORKSPACE}/jenkins/exclude.conf

if [ `whoami` != "jenkins" ]; then
echo "It is not jenkins user. Please run with jenkins user."
    exit
fi

echo 'deploy1 exec'
sudo -u ubuntu rsync -vrz --delete --exclude-from=${EXCLUDE} ${WORKSPACE}/ ${SERVER_DIR1} | grep -v /$
echo 'deploy1 completed!!'
