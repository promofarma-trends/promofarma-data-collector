Demo App
===================
> This is a Symfony demo application to test all Mineur libraries and bundles.

## Installation
```php
git clone https://github.com/promofarma-trends/promofarma-data-collector.git
cd promofarma-data-collector
composer update
```

## Setup

### Keywords manager (CRUD)
First we need to create the Keywords database on our server.
```php
bin/console doctrine:schema:update --force
```
Then we need to index all our selected keywords in order to consume
it with our collectors.

We have a pre-built keywords list that you can index using:
```php
bin/console app:keyword-storage:index-all   
```

But you can also add new keywords to the database using the 
command line:
```php
// To add a new keyword
bin/console app:keyword-storage:add    ${keyword_name}

// To delete current keyword
bin/console app:keyword-storage:delete ${keyword-name}

// To update a keyword
bin/console app:keyword-storage:update ${old-keyword-name} ${new-keyword-name}
```

### Data collector
@todo


## Supervisord
In order to automate toe consumers process, the **promofarma-virtual-machine**
has prepared a "supervisord" installation with the execution of this process.

Running the following command, will start one instance for the Twitter and Instagram 
collectors, plus the Twitter and Instagram processors.
```shell
sudo supervisorctl reload

instagram_collector              RUNNING   pid 29061, uptime 0:15:59
instagram_consumer               RUNNING   pid 26963, uptime 0:21:46
twitter_collector                RUNNING   pid 28061, uptime 0:15:59
twitter_consumer                 RUNNING   pid 27963, uptime 0:21:46
```