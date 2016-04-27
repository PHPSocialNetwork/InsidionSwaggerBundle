# Insidion Swagger Bundle


Integrate the power of [swagger.io](https://swagger.io) in your Symfony 3 application. 

If you have not hear about swagger yet, I suggest you take a look at it. It defined a service contract for your REST API. It also provides you with a built-in web interface to execute request with provided example models.

However, writing one yourself can becom tedious, and thus I introduce this bundle!

## Features

* Annotation-based REST API definition - Make your code self-documented
* Integrated Swagger UI. Visit <your_site>/swagger/ to use it. - Makes testing easier. 
* Definition generated is fully compliant with the swagger standard
* Only generate your swagger.json on startup - Caching (enabled by default)

## To be Implemented

I currently have plans to implement these features in the future:

* Security settings
* FOSRestBundle Versioning integration

Have another suggestion? Send me an e-mail at mitchellherrijgers@gmail.com

## More documentation

I won't leave you in the dark to figure out how the bundle works. You can find documentation in the [Resources/doc](https://github.com/Morlack/InsidionSwaggerBundle/tree/master/src/Resources/doc) folder.

