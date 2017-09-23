Promofarma Data Collector
===================

## Installation
```shell
git clone https://github.com/promofarma-trends/promofarma-data-collector.git
cd promofarma-data-collector
composer update
```

## Setup

### Keywords manager (CRUD)
First we need to create the Keywords database on our server.
```shell
bin/console doctrine:schema:update --force
```
Then we need to index all our selected keywords in order to consume
it with our collectors.

We have a pre-built keywords list that you can index using:
```shell
bin/console app:keyword-storage:index-all   
```

But you can also add new keywords to the database using the 
command line:
```shell
# To add a new keyword
bin/console app:keyword-storage:add    ${keyword_name}

# To delete current keyword
bin/console app:keyword-storage:delete ${keyword-name}

# To update a keyword
bin/console app:keyword-storage:update ${old-keyword-name} ${new-keyword-name}
```

### Data collector
The data collection process has two steps. The first one, is the collector itself,
It takes the keywords from our Keywords database and extracts the data from the 
Social Network  related to this keywords. Then sends the data collected to a 
Redis queue to be processed in the future.

We are using an external library called Mineur, so the commands related to the
collectors will be under the "mineur" namespace. 

This commands will start the collectors.
```shell
# Twitter collector
php bin/console mineur:twitter-stream:consume

# Instagram collector
php bin/console mineur:instagram-parser:enqueue
```

From the other side of the Redis queue, a worker will take this data to 
process and normalize it. From its native composition to a normalized 
object that can be understandable within our system. 
The commands to start the queue listeners will be the following:
```shell
# Twitter normalizer
php bin/console mineur:twitter-stream:enqueue

# Instagram normalier
php bin/console mineur:instagram-parser:consume
```

Finally this workers will send the processed data to an external Amazon SQS queue.


## Supervisord
In order to automate toe consumers process, the **promofarma-virtual-machine**
has prepared a "supervisord" installation with the execution of this process.

Running the following command, will start one instance for the Twitter and Instagram 
collectors, plus the Twitter and Instagram processors.

```shell
sudo supervisorctl reload
# Restarted supervisord

sudo supervisorctl status
# instagram_collector          RUNNING   pid 29061, uptime 0:15:59
# instagram_consumer           RUNNING   pid 26963, uptime 0:21:46
# twitter_collector            RUNNING   pid 28061, uptime 0:15:59
# twitter_consumer             RUNNING   pid 27963, uptime 0:21:46

sudo supervisorctl stop ${process_name}
# ${process_name}: stopped
```