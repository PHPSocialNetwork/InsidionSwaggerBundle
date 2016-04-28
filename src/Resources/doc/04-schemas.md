# Schema Integration

For the users of the API to understand which model the server will return or will require as input you can define schemas.
Schemas are a definition that is quite complex. For example, take the following schema:

```json
{
  "type": "object",
  "required": [
    "name"
  ],
  "properties": {
    "name": {
      "type": "string"
    },
    "quantity": {
      "type": "integer",
      "format": "int32",
      "minimum": 0
    }
  }
}
```

For this to be defined solely in annotations will require a lot of tedious for. Instead, I have chosen a different approach in this bundle.

## Adding a schema
A schema can be defined in the _app/swagger/schemas/_ directory. Here you can create json files like _Order.json_. In this file, you can define the JSON for this schema, such as the JSON above.
As soon as you define this, the bundle will recognize that you have a model called _Order_ and adds it to the definition section of the Swagger JSON.

## Using a schema
Just defining is not enough for it to show up in your calls. There are 2 places a schema can be used:

* @SwaggerParameter(schema="#Order")
* @SwaggerResult(schema="#Order")

As you can see in the examples above, a schema is referenced by #<NAME>. After you do this, the Schema will be added to the call and be viewable inside the tool. 