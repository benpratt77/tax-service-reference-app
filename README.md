# Silex based reference implementation of a Tax Service integration

This is a very simple reference application based on the PHP Silex microframework, that demonstrates how to process a request from the BigCommerce Tax Service integration and return a valid response.
It is designed to quickly deploy to Heroku and let you get started on your development with minimal ramp-up.

## Requirements

Check composer.json but in general:

- PHP >=7

- composer

- xdebug (for development/debugging)

## Running locally

```
    $ git clone ...
    $ composer install
    $ COMPOSER_PROCESS_TIMEOUT=0 composer run-script run
```

Then, browse to http://localhost:9999

**Note** To enable xdebug support replace `run` with `devrun` (see composer.json 'scripts' sections for details)

In case ```COMPOSER_PROCESS_TIMEOUT=0 composer run``` doesn't work then execute ```php -S localhost:9999 -t web```
 
## Running on Heroku

[![Deploy to Heroku](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy)

Or do the manual thing...

```
    $ heroku login -i
    $ heroku create
    $ git push heroku master
    $ heroku open
```
 
**Note** Some additional setup may be required ([Setting up Heroku + PHP](https://devcenter.heroku.com/articles/getting-started-with-php))



## Sample app contents

The default landing page contains an overview of how to trigger various Tax responses from the sample app.


- `TaxServiceProvider.php` registers (within the DI container) the API controller and service (below) for the BC sample responses provided

- `TaxAPIController.php` the basic API controller with minimal validation and error handling to pass POST requests to an API service

- `StubbedTaxAPIService.php` the basic API service that returns a response.

- `SimpleAPIServiceInterface.php` a simple interface that you can extend from to build to your own tax service (just change the provider above to instantiate your new service instead of the stubbed one)

## Updates

- By default this tax provider will apply BRUTAL TAX of 50%.
- Applying tax code as `SPLITTAX` to the product will apply tax with its two sub components i.e. COUNTY TAX and STATE TAX.
- Whereas, tax code as `SPLITTAX1` will apply tax with its three sub components i.e. COUNTY TAX, STATE TAX and BRUTAL TAX.
  
- We can now simulate a breakage with SampleTax, by passing in `breakDatTax` as the customers taxability_code.
- We can now have zero tax for a customer by passing in `TaxEvasion` as the customers taxability_code.
- We can now have zero tax apply to a product by passing in `yeah-nah` to the items tax_class->code.
## Disclaimer

This is just one way to implement your service integration, there is no restriction on how you structure your application or what framework you use. 
Feel free to pick what parts, if any, from this repo to use in your own development.
