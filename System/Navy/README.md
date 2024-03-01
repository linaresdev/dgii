# Navy
Libreria de navegacion.

### Instalación 

Instalar via [Composer](http://getcomposer.org/).

Ejecutar desde la terminal

    composer require linaresdev/navy

ServiceProvider

    Malla\Navy\Provider\ServiceProvider::class

Facade
    
    "Nav" => Malla\Navy\Facade\Nav::class,

- [Agregar menu](#save)

#### Save

Guardar menu desde un arreglo

```php
Nav::save([
    "group"     => "Public Nav 0",
    "tag"       => "users-nav-profile",
    "route"     => "profiler*",
    "filters"   => [],
    "skin"      => \Malla\Template\BS5::class,
    "items"     => [],
]);
```
Guardar desde una clase.

```php
Nav::save(new \Malla\Admin\UserNav);
// OR
Nav::save(\Malla\Admin\UserNav::class);
```

Guardar desde un closure

```php
Nav::save(function($nav) {

    $nav->add("group", "Area nav 0");
    $nav->add("tag", "users-profile");
    $nav->add("route", "admin/users*");

    $nav->addFilters("style", [
        ":node0" => "nav flex-column"
    ]);

    $nav->addItem([
        "icon"   => "mdi mdi-account",
        "label"  => "words.users",
        "url"    => "profiler/usrID"
    ]);
});

```

Guardar desde un JSON

```php
Nav::save(
    '{
        "group":"Area nav 0",
        "tag":"users-profile",
        "route":"admin\/users*",
        "filters":{
            "style":{":node0":"nav flex-column"},
            "label":{"dress":{":label":"<span class=\"toggle-text\"> :label <\/span>"}},
            "url":{"match":{"usrID":1}}
        },
        "items":[{
            "icon":"mdi mdi-account",
            "label":"words.users",
            "url":"profiler\/usrID"
        }]
    }'
);
```

### UPDATE
Actualizar un item de menu conociendo su indice

```php
Nav::whereRoute("admin/users*", function($nav){
    ## Agregar un nuevo item
    $nav->addItem($itemData=[]);

    ## Actualizar un item
    $nav->updateItem($index=0, $itemData=[]);

    ## Restringir un item demenu por su indice
    $nav->rejectItem(2);
});
```

## VIEW
Agragar un menu monitor por consulta

    {!! Nav::route() !!}

Agregar un grupo de route menu

    {!! Nav::groupRoute("admin-nav-0") !!}