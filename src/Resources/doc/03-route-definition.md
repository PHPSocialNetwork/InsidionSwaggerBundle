# Route definitions

Looking for the reference? Scroll down. We will explore the abilities of this bundle by example.

## Basic routing
Consider this piece of PHP code:

```php
class OrdersController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Swagger(showInDocs=true, operationId="orderShow", tags={"order", "show"})
     * @SwaggerResult(status="200", description="Shows the order", schema="#Order")
     * @SwaggerResult(status="404", description="This order does not exist")
     * @SwaggerParameter(name="id", required=true, description="Stupid ID", schema="integer")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction($id)
    {
        // Action implementation
    }
}

```

The following conclusions can be made:

* It uses the FOSRestBundle. However, that is not necessary for this bundle to work.
* It contains several @Swagger annotation, we will get to this later
* The imports are missing to give a better picture

We will get into each Annotation in details. Currently, these three exist:

* @Swagger
* @SwaggerResult
* @SwaggerParameter

Each of these plays an important role in creating a swagger.json definition your API testers or users can easily work with.
Not that, since these are annotations directly on the code, it is easily maintainable and readable. 

## @Swagger

@Swagger plays the vital role; without this annotation, the route will never show up in your swagger.json. You usually start by putting this on your action, and then adding other annotations.

The @Swagger annotation can have the following fields:

| Property | Default Value | Description |
|:---------|:--------------|:------------|
| showInDocs | true | Whether to process this action and show it in the swagger.json. |
| operationId | null | REQUIRED - Name of the action (Must be a human readable name). |
| description | "" | Describes what this action does. |
| tags | null | Array of tags applying to this action. Makes the SwaggerUI easier to navigate |
| consumes | ['application/json'] | MIME-types this action can consume |
| produces | ['application/json'] | MIME-types this action can procude |

## @SwaggerParameter

The @SwaggerAnnotation specifies a parameter in your call. This can be one in your path (such as /orders/{id}) or one in the POST body of the HTTP request.
Even though you can specify it further, every path parameter without a preceding underscore will be added. You can further specify, as in the example above, linked by name.
If a parameter is not in a route and specified in an annotation, then it's type is defined as ```in``` property with fallback to body if not specified'. 

| Property | Default Value | Description |
|:---------|:--------------|:------------|
| name | null | key of the parameter. In above example it would be 'id'. |
| description | "" | A description of the parameter. Why does it matter in this call? |
| in | null | Place where the parameter is used. For route parameter default (and only valid) value is ```path```. For non-route parameter valid options are: ```body``` (default), ```query```, ```header```, ```formData```  |
| required | true | Whether the parameter is required for the call to work or not. |
| isArray | false | Whether the parameter is an array of multiple objects. |
| schema | "string" | Here you can define the type of parameter. It can be a simple type or a schema. Read more about schemas in 04-schemas.md. |

## @SwaggerResult

An HTTP call can yield multiple response types. Such as 200, 201, 204, 500, and so on. Here you can define the type of response. 

| Property | Default Value | Description |
|:---------|:--------------|:------------|
| status | 200 | Status code returned with this response. Should be unique. |
| description | "" | Description of the response. |
| schema | "string" | Here you can define the type of response. It can be a simple type or a schema. Read more about schemas in 04-schemas.md. |
| isArray | false | Whether the response is an array of multiple objects. |