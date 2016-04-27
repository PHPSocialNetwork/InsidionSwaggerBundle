Configuration
=============

To use this bundle, basic configuration is needed. An example configuration is as follows:

```yaml
insidion_swagger:
  # Basic bundle properties
  cache: true
  
  # The swagger object - Used for building your JSON definition file.
  swagger:
    produces: ['application/json', 'application/xml']
    consumes: ['application/json', 'application/xml']
    schemes: ['http', 'https']
    info:
      title: 'My Awesome REST API'                                                  #REQUIRED
      version: '0.0.1'                                                              #REQUIRED
      termsOfService: "We don't have any... yet!"
      description: 'This rest API serves as the last hope for human kind'
      contact:
        name: 'Mitchell Herrijgers'
        url: 'https://github.com/Morlack/InsidionSwaggerBundle'
        email: 'mitchellherrijgers@gmail.com'
      license:
        name: 'MIT'
        url: 'https://github.com/Morlack/InsidionSwaggerBundle/blob/master/LICENSE'

```

Above Configration will result in the following Swagger JSON: 

```json
{
  "produces": [
    "application\/json",
    "application\/xml"
  ],
  "consumes": [
    "application\/json",
    "application\/xml"
  ],
  "schemes": [
    "http",
    "https"
  ],
  "info": {
    "title": "My Awesome REST API",
    "version": "0.0.1",
    "termsOfService": "We don't have any... yet!",
    "description": "This rest API serves as the last hope for human kind",
    "contact": {
      "name": "Mitchell Herrijgers",
      "url": "https:\/\/github.com\/Morlack\/InsidionSwaggerBundle",
      "email": "mitchellherrijgers@gmail.com"
    },
    "license": {
      "name": "MIT",
      "url": "https:\/\/github.com\/Morlack\/InsidionSwaggerBundle\/blob\/master\/LICENSE"
    }
  },
  "swagger": "2.0",
  "paths": {},
  "definitions": {}
}
```

Note that the paths and definitions will be added as you configure them.  
