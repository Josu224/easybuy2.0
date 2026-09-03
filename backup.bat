@echo off
echo Backing up database...
mysqldump -u root easy_buy_new > backup.sql
echo Backup complete! File saved as backup.sql
pause