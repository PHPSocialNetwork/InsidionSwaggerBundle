# Insidion Swagger Bundle
## !! V2 CURRENTLY IN DEVELOPMENT, STAR THE REPO TO STAY TUNED !!

 ## Why would you need that bundle ?
 
Integrate the power of [swagger.io](https://swagger.io) in your Symfony 3 application. 

If you have not hear about swagger yet, we suggest you take a look at it. It defines a service contract for your REST API. 

It also provides you with a built-in web interface to execute request with provided example models.

However, writing one yourself can become tedious, and thus we introduce this bundle!

## Current features

- Annotation-based REST API definition - Make your code self-documented
- Integrated Swagger UI
  - Visit <your_site>/swagger/ to use it 
  - Feel free to use your own route by checking out the **Doc* folder
- Makes testing easier. 
- Definition generated is fully compliant with the swagger standards
- Only generate your swagger.json on startup by configuring the cache
  - The bundle also support a custom Psr6 cache service for handling the cache 
- Security settings
- Tags definitions
- Summary/Description available for route and parameters definitions

## More documentation

We won't leave you in the dark to figure out how the bundle works. 

You can find documentation in the [Resources/doc](https://github.com/PHPSocialNetwork/InsidionSwaggerBundle/tree/master/src/Resources/doc) folder.

