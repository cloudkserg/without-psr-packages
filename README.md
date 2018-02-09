# INSTALL

1) Change parameters as needed in config/config.php

2) Create rights 777 on catalogues
runtime/

3) Install dependencies 
php need install php-redis on system

4) Run dev server
cd public;  php -S 127.0.0.1:3002 -t .

5) In cron execute script night_worker.php every day on 00:00:01

crontab -e
1 0 * * * php /home/user/project/night_worker.php

# RUN

GET /?format=[json, csv] - get top countries in view as 
event, country, count

POST / as json example: [event: like, country: RU]

#DESCRIBE

1) save all parameters in redis datatable

2) in redis have three tables
total:event:country - counter for all dates
last:event:country - counter for only 7 days (7 changed in config/config.php)
counter:country:event:date - counter for only this date

3) every night script night_worker.php
decrement count from last:event:country equal to counter:country:event:date
for date more than 7 days before (7 changed in config/config.php)

4) on post system increment three counter in redis
total, last, counter 
(3 write operations)

5) on get system 
- get for each event 5 countries with most total counters (5 changed in config/config.php)
(3 get operations for 3 events)
- get for this 5 countries last counters 
(1 mget operation)

 
