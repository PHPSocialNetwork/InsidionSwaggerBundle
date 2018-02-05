Configuration
=============

To use this bundle, basic configuration is needed. An example configuration is as follows:

```yaml
insidion_swagger:
  # Basic bundle properties
  cache: true
  cache_service: false

  # The swagger object - Used for building your JSON definition file.
  swagger:
    produces: ['application/json', 'application/xml']
    consumes: ['application/json', 'application/xml']
    schemes: ['http', 'https']
    securityDefinitions:
      ApiTknAuth:
        type: apiKey
        in: header
        name: X-Api-Tkn
      ApiTknAuth2:
        type: apiKey
        in: header
        name: X-Api-Tkn2
    tags:
      -
        name: order
        description: A desc
        externalDocs:
          description:	"Find out more"
          url: "http://swagger.io"
      -
        name: order2
        description: A desc
      -
        name: order3
    host: "swagger-bundle.local"
    basePath: "/"
    info:
      title: 'My Awesome REST API'
      version: '0.0.1'
      termsOfService: "We don't have any... yet!"
      description: 'This is a sample server Petstore server.  You can find out more about Swagger at [http://swagger.io](http://swagger.io) or on [irc.freenode.net, #swagger](http://swagger.io/irc/).  For this sample, you can use the api key `special-key` to test the authorization filters.'
      contact:
        name: 'Mitchell Herrijgers'
        url: 'https://github.com/Morlack/InsidionSwaggerBundle'
        email: 'mitchellherrijgers@gmail.com'
      license:
        name: 'MIT'
        url: 'https://github.com/Morlack/InsidionSwaggerBundle/blob/master/LICENSE'
    externalDocs:
      description:	"Find out more on our documentation"
      url:	"http://swagger.io"
```

Above Configuration will result in the following Swagger JSON: 

```json
{
    "cache": true,
    "cache_service": false,
    "swagger": {
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
        "ApiTknAuth": {
          "type": "apiKey",
          "in": "header",
          "name": "X-Api-Tkn"
        },
        "ApiTknAuth2": {
          "type": "apiKey",
          "in": "header",
          "name": "X-Api-Tkn2"
        }
      },
      "tags": [
        {
          "name": "order",
          "description": "A desc",
          "externalDocs": {
            "description": "Find out more",
            "url": "http://swagger.io"
          }
        },
        {
          "name": "order2",
          "description": "A desc"
        },
        {
          "name": "order3"
        }
      ],
      "host": "swagger-bundle.local",
      "basePath": "/",
      "info": {
        "title": "My Awesome REST API",
        "version": "0.0.1",
        "termsOfService": "We don't have any... yet!",
        "description": "This is a sample server Petstore server.  You can find out more about Swagger at [http://swagger.io](http://swagger.io) or on [irc.freenode.net, #swagger](http://swagger.io/irc/).  For this sample, you can use the api key `special-key` to test the authorization filters.",
        "contact": {
          "name": "Mitchell Herrijgers",
          "url": "https://github.com/Morlack/InsidionSwaggerBundle",
          "email": "mitchellherrijgers@gmail.com"
        },
        "license": {
          "name": "MIT",
          "url": "https://github.com/Morlack/InsidionSwaggerBundle/blob/master/LICENSE"
        }
      },
      "externalDocs": {
        "description": "Find out more on our documentation",
        "url": "http://swagger.io"
      }
    }
  }
```

Note that the paths and definitions will be added as you configure them.  
