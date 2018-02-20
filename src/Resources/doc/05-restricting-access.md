# Restricting access

You may want to enforce a restricted access to the Swagger UI.
This can be done in different ways, but we'll only mention the easiest one.

### Setting up the role hierarchy
First would like to define a custom role that can access to the swagger UI:
```yaml
# config/packages/security.yaml
security:
    # ...
    role_hierarchy:
        ROLE_SWAGGER:       ROLE_USER
```

### Setting up access control
Then you have to setup the access control to define the allowed role:
```yaml
# config/packages/security.yaml
security:
    # ...
    access_control:
        # ...
        - { path: ^/swagger, roles: ROLE_SWAGGER }
```
If you do not use the controller provided with this bundle, this step is optional, you can replace it with a custom controller `@Security` annotation.
Learn [here](https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/security.html) how to proceed.

### Setting up the firewall
You now have to setup the active firewall that will handle authentication for swagger UI.
```yaml
# config/packages/security.yaml
security:
    # ...
    firewalls:
        # ...
        swagger:
            pattern: ^/swagger
            http_basic: ~
            provider: in_memory
```
Note that the authentication default provider will be a **Basic HTTP** authentication using the **http_basic** option.
You can replace it by your own, E.g: **fos_user**
The `swagger` firewall may have to be put before the others to avoid firewall rules confusion for wildcard-style firewalls. 

### Setting up the users
If you do not (want to) make use of third party authenticator provider, you can provide an **in_memory** one:
```yaml
# config/packages/security.yaml
security:
    # ...
    providers:
        in_memory:
            memory:
                users:
                    swagger: # The username
                        # If you want to avoid to set a plaintext password
                        # here's how to manually encode a password
                        # https://symfony.com/doc/current/security/password_encoding.html
                        password: AComplexPassword
                        roles: 'ROLE_SWAGGER'
```

That's all, your Swagger UI is now password-protected :)