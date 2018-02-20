# Installation

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require insidion/swagger-bundle "~2"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

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

            new Insidion\Swagger\InsidionSwaggerBundle(),
        );

        // ...
    }

    // ...
}
```

### Step 3: Enable integrated client routing (optional)
Add the following to your routing.yml:
```yaml
# You may want to put it first to avoid 
# routing confusion with your other defined routes
insidion_swagger:
    resource: "@InsidionSwaggerBundle/Resources/config/routing.yml"
    prefix:   /
```
This step is optional, but you may want to extend the controller in your own ones.
[Forwarding](https://symfony.com/doc/current/controller/forwarding.html) the controller response may be a good idea to have more control through your own controllers:
However make sure to use the good route names for a better compatibility, E.g: The integrated web-profiler toolbar.
The routes are:
- `insidion_swagger_index` Handles the Swagger UI
- `insidion_swagger_json` Handles the Swagger JSON response, used in Swagger UI

As mentioned in the [Restricting access](05-restricting-access.md) documentation, if you use your own controllers, you may use the `@Security` annotation.
Learn [here](https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/security.html) how to proceed.


