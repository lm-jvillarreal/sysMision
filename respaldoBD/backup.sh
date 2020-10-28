#!/bin/bash

USER="root"
PASSWORD="sebastian"
DATABASE="sysadmision_prueba"
FINAL_OUTPUT=`date +%Y%m%d`_$DATABASE.sql
mysqldump --user=$USER --password=$PASSWORD $DATABASE > $FINAL_OUTPUT
gzip $FINAL_OUTPUT
