# Currency Converter

Converts 2 defined currencies.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

What things you need to install the software and how to install them

```
virtuabox
vagrant
```

### Installing

Clone this repository.

```
git clone git@github.com:robconvery/currencycalculator.git
cd currencycalculator
composer install
php artisan key:generate
vendor/bin/homestead make
``` 
Edit the Homestead.yml file
```
nano Homestead.yaml
```
Choose an ip address
```bash
ip: 192.168.33.30
...
```
Change the url
```bash
...
sites:
    -
        map: {goes here}
...
```

Construct the dev environment.

```bash
vagrant up
```

## Running the tests
From within the dev environment
```bash
vendor/bin/phpunit
```

## Deployment

CircleCI is used to run unit tests, code sniffer  and deploy code via a web hook. 


 

