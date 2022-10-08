# projectorl-l10

## Installation
Run ```docker-compose up -d``` command to start application. Run ```composer update``` to install dependencies in www dir 

> As both redis containers are configured to use port 6379 only one will start

Redis application files are loaded in www/src/Svystunov/Projector10/Redis directory. 

___

Application actions can be defined througb get parameters ```connector``` (values: redis and beanstalkd) and ```action```(value: read and write). 

## Test cases

RDB write: Elapsed time 6.43 sec \
RDB read: Elapsed time 226.86 sec, Data transferred: 968.24 MB

AOF write: Elapsed time 40.02 sec \
AOF read: Elapsed time 227.79 sec, Data transferred: 969.17 MB

### Redis RDB

**config:**\
appendonly yes \
save 3600 1 300 100 60 10000

##### Write case

```siege -r10 -c250 http://localhost/index.php\?connector\=redis-rdb\&action\=write```
 
Transactions:                   2500 hits \
Availability:                 100.00 % \
**Elapsed time:                  42.90 secs** \
Data transferred:               0.01 MB \
Response time:                  4.09 secs \
Transaction rate:              58.28 trans/sec \
Throughput:                     0.00 MB/sec \
Concurrency:                  238.09 \
Successful transactions:        2500 \
Failed transactions:               0 \
Longest transaction:            4.81 \
Shortest transaction:           0.11 

##### Read case

```curl -X GET http://localhost/index.php\?connector\=redis-rdb\&action\=read```

Records read: 2500, Estimated time: 1.9315559864044


### Redis AOF

**config:**\
appendonly yes \
save 3600 1 300 100 60 10000
#### Write case

```siege -r10 -c250 http://localhost/index.php\?connector\=redis-aof\&action\=write```

Transactions:                   2500 hits \
Availability:                 100.00 % \
**Elapsed time:                  42.55 secs** \
Data transferred:               0.01 MB \
Response time:                  4.03 secs \
Transaction rate:              58.75 trans/sec \
Throughput:                     0.00 MB/sec \
Concurrency:                  236.82 \
Successful transactions:        2500 \
Failed transactions:               0 \
Longest transaction:            4.60 \
Shortest transaction:           0.10 


#### Read case

```curl -X GET http://localhost/index.php\?connector\=redis-aof\&action\=read    ```

Records read: 2500, Estimated time: 1.8639781475067
 
## Beanstalkd

##### Write: 
Elapsed time 51.91 secs

```siege -r10 -c250 http://localhost/index.php\?connector\=beanstalkd\&action\=write```

Transactions:                   2500 hits \
Availability:                 100.00 % \
**Elapsed time:                  51.91 secs** \
Data transferred:               0.63 MB \
Response time:                  4.94 secs \
Transaction rate:              48.16 trans/sec \
Throughput:                     0.01 MB/sec \
Concurrency:                  237.83 \
Successful transactions:        2500 \
Failed transactions:               0 \
Longest transaction:            5.64 \
Shortest transaction:           0.12 \

##### Read:

```curl -X GET http://localhost/index.php\?connector\=beanstalkd\&action\=read```

Records read: 2500, Estimated time: 0.47448205947876 
