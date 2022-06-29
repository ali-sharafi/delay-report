# <p align="center">Delay Reporter</p>

## Introduction

A package for reporting a delivery delay. when an order is saved by a specific delivery time, if after the delivery time, the order didn't deliver then the client could submit a delay report. his delay is put into the phpredis queue to process by the agent's part with the FIFO approach.

this package uses Laravel sail for development and the instruction for launching the project described below.
## Documentation

### Supported Versions

| PHP Version | Laravel Version |
|---- |----|
| 8.1 | 9.*

### Installation

Install composer dependencies:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

Configure App:

```bash
cp .env.example .env
```
Add this to .env file:

```bash
FORWARD_DB_PORT=3307
APP_PORT=8000
```
And replace this:
```bash
REDIS_HOST=127.0.0.1
DB_USERNAME=root
DB_PASSWORD=
```
To:

```bash
REDIS_HOST=redis
DB_USERNAME=sail
DB_PASSWORD=password
```

Run Application:

```bash
./vendor/bin/sail up -d
```

Generate application key:
```bash
./vendor/bin/sail artisan key:generate
```

Run migration files:

```bash
./vendor/bin/sail artisan migrate --seed
```
## Tests

```bash
./vendor/bin/sail test
```