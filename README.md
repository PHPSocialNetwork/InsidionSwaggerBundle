# Insidion Swagger Bundle
## :warning: THE V2 IS CURRENTLY IN DEVELOPMENT, IT IS NOT INTENDED YET FOR PRODUCTION USE :warning:

### Why would you need that bundle ?
 
You need it because it integrate the power of [swagger.io](https://swagger.io) in your Symfony 3 application. 

If you have not hear about swagger yet, we suggest you take a look at it. It defines a service contract for your REST API. 

### Why should I define a service contract for my Symfony REST API ?

- Don't you love well-done and documented work ? 
- Don't you hate writing redundant PDF/Excel to explain all your REST api endpoints ?
- Don't you prefer documenting you code in the same time than you write it ?

Fall for it, you wont be disappointed !

### What's your bundle provides exactly ?

It provides you a pretty built-in web interface to execute REST requests with provided example models.

The built-in web interface allows you to test most of HTTP REST methods (DELETE, PATCH, etc), with custom headers/parameters/cookies.

Writing one yourself can becoming tedious, thus we introduced this bundle!

### Current features

- Annotation-based REST API definition - Make your code self-documented
- Integrated Swagger UI
  - Visit <your_site>/swagger/ to use it 
  - Feel free to use your own route by checking out the **[Resources/doc](src/Resources/doc)** folder
- Makes testing easier. 
- Only generate your swagger.json on startup by configuring the cache
  - The bundle also support a custom Psr6 cache service for handling the cache 
- Definition generated is fully compliant with the swagger standards
- Security settings
- Tags definitions
- Deprecation highlighting
- Summary/Description available for route and parameters definitions
- Models definitions for a better contract specification

### More documentation
We won't leave you in the dark to figure out how the bundle works. 

You can find documentation in the [Resources/doc](https://github.com/PHPSocialNetwork/InsidionSwaggerBundle/tree/master/src/Resources/doc) folder.

### Helping / Contributing
Found an issue ?
[Feel free to report it](https://github.com/PHPSocialNetwork/InsidionSwaggerBundle/issues/new).

Got an idea that improved your experience ?
[Send us a pull request](https://github.com/PHPSocialNetwork/InsidionSwaggerBundle/compare).

Having a feedback ?
[Send us a message](mailto:team@phpfastcache.com), seriously, we'd love to hear from you !

Thanks for giving us a try :blue_heart:

