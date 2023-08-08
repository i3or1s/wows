# wows
```
composer install
#Create database
#Change copy .env u .env.local and add your database parameters
bin/console doc:mig:mig -n
#Download vehicles
bin/console wows:download-wiki-vehicles
#Download players
bin/console wows:download-players
#Download player statistics
bin/console wows:download-player-vehicles-played       
  
```
