# Cinemateka Schedule WebApp

One page schedule app built with Laravel 5 and VueJS.

## Documentation



### File structure

```yaml
app:                    # **Laravel 5 backend layer**
    Console:            # **Artisan CLI commands**
    Events:             # **Backend events**
    Exceptions:         # **Errors handling**
    Http:               # **HTTP kernel, routes**
        Controllers:    # **Responses to user (load page)**
        Middleware:     # **Meddling into the livecycle (reject on auth failed)**
        Requests:       # **Requests from user (handle form)**
    Jobs:               # **Jobs queue control**
    Listeners:          # **Listen about events**
    Models:             # **Entities and relations therebetween**
    Policies:           # **Access rules**
    Providers:          # **Broadcast data**
bootstrap:              
config:                 # **Laravel 5 config**
database:               # **Data storage configuration**
    factories:          # **Seeding process description**
    migrations:         # **Creating tables**
    seeds:              # **Creating rows in tables**
public:                 # **Compiled frontend** *Webserver root*
resources:              # **Frontend view layer**
    assets:
        admin:          # **Admin sources**
        components:     # **VueJS components partials**
        fonts:          # **Webfonts**
        images:         # **Graphic files**
        js:             # **Javascripts**
        sass:           # **SASS**
        views:          # **VueJS components router views**
    lang:               # **Translations**
    views:              # **Laravel Blade views**
storage:                # **Backups, cache, logs**
tests:                  # **Test environment**
```

## License

[MIT license](http://opensource.org/licenses/MIT).
