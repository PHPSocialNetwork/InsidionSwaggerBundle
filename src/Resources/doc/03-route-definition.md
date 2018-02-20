# Route definitions

Looking for the reference? Scroll down. We will explore the abilities of this bundle by example.

### Basic (but detailed) routing configuration
Consider this piece of PHP code:

```php
<?php
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Insidion\SwaggerBundle\Annotation\Swagger;
use Insidion\SwaggerBundle\Annotation\SwaggerResult;
use Insidion\SwaggerBundle\Annotation\SwaggerParameter;

class OrdersController extends AbstractController
{
    /**
     * Note that those annotations can be shortened for more readability  
     * @Swagger(
     *     showInDocs=true, 
     *     operationId="homepage_post", 
     *     tags={"order"}, 
     *     security={{"ApiTknAuth"={}}, {"ApiTknAuth2"={}}}, 
     *     consumes={"application/json"}, 
     *     produces={"application/json"}, 
     *     description="A description", 
     *     summary="A summary",
     *     deprecated=false
     * )
     * @SwaggerResult(
     *     status="200", 
     *     description="Shows the order",
     *     schema="#Order", 
     *     description="A description"
     * )
     * @SwaggerResult(
     *     status="404", 
     *     description="This order does not exist", 
     *     description="A description"
     * )
     * @SwaggerParameter(
     *     name="id", 
     *     required=true, 
     *     description="Stupid ID", 
     *     schema="integer",
     *     in="body",
     *     isArray="body"
     * )
     * @SwaggerParameter(
     *     name="id2", 
     *     required=false, 
     *     description="Stupid ID", 
     *     schema="integer",
     *     in="body",
     *     isArray="body"
     * )
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction($id, $id2 = null)
    {
        return new \Symfony\Component\HttpFoundation\Response('Hello boi !');
    }
}

```

The following conclusions can be made:

* It contains several @Swagger annotation, that we will read to this later
* The imports are specified to avoid any misunderstanding
* It does not make uses the FOSRestBundle. This is not necessary for this bundle to work.

We will get into each Annotation in details. Currently, these three exist:

* @Swagger (Mandatory)
* @SwaggerResult (Mandatory)
* @SwaggerParameter (optional)

Each of these plays an important role in creating a swagger.json definition your API testers or users can easily work with.
Not that, since these are annotations directly on the code, it is easily maintainable and readable. 

### @Swagger

@Swagger plays the vital role; without this annotation, the route will never show up in your swagger.json. You usually start by putting this on your action, and then adding other annotations.

The @Swagger annotation can have the following fields:

| Property | Default Value | Description |
|:---------|:--------------|:------------|
| showInDocs | true | Whether to process this action and show it in the swagger.json. |
| operationId | null | REQUIRED - Name of the action (Must be a human readable name). |
| description | null | Describes what this action does. |
| summary | null | Describes shortly what this action does. |
| tags | null | Array of tags applying to this action. Makes the SwaggerUI easier to navigate |
| consumes | ['application/json'] | MIME-types this action can consume |
| produces | ['application/json'] | MIME-types this action can produce |
| deprecated | false | Whether to deprecate this action or not |
| security | null | Implement a security directive as configured in config.yml, e.g: `security={{"ApiTknAuth"={}}, {"ApiTknAuth2"={}}}` |

### @SwaggerParameter

The @SwaggerAnnotation specifies a parameter in your call. This can be one in your path (such as /orders/{id}) or one in the POST body of the HTTP request.
Even though you can specify it further, every path parameter without a preceding underscore will be added. You can further specify, as in the example above, linked by name.
If a parameter is not in a route and specified in an annotation it is expected to be of type body. 

| Property | Default Value | Description |
|:---------|:--------------|:------------|
| name | null | key of the parameter. In above example it would be 'id'. |
| description | null | A description of the parameter. Why does it matter in this call? |
| required | true | Whether the parameter is required for the call to work or not. |
| isArray | false | Whether the parameter is an array of multiple objects. |
| in | string | A string that describe the location of the parameter. Can be one of `['path', 'query', 'header', 'cookie']` |
| schema | string | Here you can define the type of parameter. It can be a simple type or a schema. Read more about schemas in [04-schemas.md](04-schemas.md). |

### @SwaggerResult

An HTTP call can yield multiple response types. Such as 200, 201, 204, 500, and so on. Here you can define the type of response. 

| Property | Default Value | Description |
|:---------|:--------------|:------------|
| status | 200 | Status code returned with this response. Should be unique. |
| description | null | Description of the response. |
| schema | string | Here you can define the type of response. It can be a simple type or a schema. Read more about schemas in [04-schemas.md](04-schemas.md). |
| isArray | false | Whether the response is an array of multiple objects. |