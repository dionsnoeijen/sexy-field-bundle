[![Build Status](https://travis-ci.org/dionsnoeijen/sexy-field-bundle.svg?branch=master)](https://travis-ci.org/dionsnoeijen/sexy-field-bundle)

# SexyField Installation

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require tardigrades/sexy-field-bundle "~1"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Tardigrades\Bundle\SexyFieldBundle(),
        );

        // ...
    }

    // ...
}
```

Step 3: Execute doctrine schema command to generate database structure
----------------------------------------------------------------------

If you want, enable caching.
----------------------------

1: Add this to your config.yml, this will prevent doctrine migrations to remove the table that will be created in the next step.

    doctrine:
      dbal:
        schema_filter: ~^(?!cache_items)~

2: Then run: `bin/console sf:ensure-cache` to create the caching table in the database

3: And add this service to your services.yml . The second argument (true) is used to enable or disable caching. You can make a variable for this.

    Tardigrades\SectionField\Service\DefaultCache:
        public: false
        arguments:
          - '@Symfony\Component\Cache\Adapter\TagAwareAdapter'
          - true
