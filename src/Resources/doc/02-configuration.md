# Configuration

To use this bundle, basic configuration is needed. 
A configuration sample is as follows:

```yaml
insidion_swagger:
  # Basic bundle properties
  cache: false
  cache_service: 'app.cache.psr6.service' # Optional, you can specify a psr6 cache service

  # The swagger object - Used for building your JSON definition file.
  swagger:
    produces: ['application/json', 'application/xml'] # At least one mandatory
    consumes: ['application/json', 'application/xml'] # At least one mandatory
    schemes: ['http', 'https']
    securityDefinitions:
      ApiTknAuth: # Optional depending your needs, the custom security definition that can be used in controller 'security' annotations
        type: apiKey
        in: header
        name: X-Api-Tkn
    tags: # Optional, you may want to describe the tags used in controller 'tags' annotations
      -
        name: aTagName # Mandatory
        description: A description # Optional but recommended
        externalDocs: # Optional
          description:	"Find out more"
          url: "http://swagger.io"

    host: "swagger-bundle.local" # Optional but recommended for better swagger compatibility
    basePath: "/" # Optional
    info: # Mandatory
      title: 'My Awesome REST API' # Mandatory
      version: '0.0.1' # Mandatory
      termsOfService: "We don't have any... yet!" # Optional but recommended
      description: 'This is a sample server Petstore server.  You can find out more about Swagger at [http://swagger.io](http://swagger.io) or on [irc.freenode.net, #swagger](http://swagger.io/irc/).  For this sample, you can use the api key `special-key` to test the authorization filters.' # Optional but recommended
      contact: # Mandatory
        name: 'Geolim4'
        url: 'https://github.com/PHPSocialNetwork/InsidionSwaggerBundle'
        email: 'mitchellherrijgers@gmail.com'
      license: # Mandatory
        name: 'MIT'
        url: 'https://github.com/PHPSocialNetwork/InsidionSwaggerBundle/blob/master/LICENSE'
    externalDocs: # Optional
      description:	"Find out more on our documentation"
      url:	"http://swagger.io"
```

Above Configuration will results in the following Swagger JSON: 

```json
{
  "produces": [
    "application/json",
    "application/xml"
  ],
  "consumes": [
    "application/json",
    "application/xml"
  ],
  "schemes": [
    "http",
    "https"
  ],
  "securityDefinitions": {
    "ApiTknAuth": null,
    "type": "apiKey",
    "in": "header",
    "name": "X-Api-Tkn"
  },
  "tags": [
    {
      "name": "aTagName",
      "description": "A description",
      "externalDocs": {
        "description": "Find out more",
        "url": "http://swagger.io"
      }
    }
  ],
  "host": "swagger-bundle.local",
  "basePath": "/",
  "info": {
    "title": "My Awesome REST API",
    "version": "0.0.1",
    "termsOfService": "We don't have any... yet!",
    "description": "This is a sample server Petstore server.  You can find out more about Swagger at [http://swagger.io](http://swagger.io) or on [irc.freenode.net, #swagger](http://swagger.io/irc/).  For this sample, you can use the api key `special-key` to test the authorization filters.",
    "contact": null,
    "name": "MIT",
    "url": "https://github.com/PHPSocialNetwork/InsidionSwaggerBundle/blob/master/LICENSE",
    "email": "mitchellherrijgers@gmail.com",
    "license": null
  },
  "externalDocs": {
    "description": "Find out more on our documentation",
    "url": "http://swagger.io"
  }
}
```

Note that the paths and definitions will be added as you configure them.  
