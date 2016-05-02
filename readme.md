Kunstmaan Bundle Tag Groups
===========================

KunstmaanTagGroupBundle enables you to organize tags in groups and easy filter tags by group and taggable entity.
 
Instalation
-----------

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require syzygypl/kunstmaan-tag-group-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.


Step 2: Enable the Bundle
---------------------------
Enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Szg\KunstmaanTagGroupBundle\KunstmaanTagGroupBundle(),
        );

        // ...
    }

    // ...
}
```

Install assets
```
app/console assets:install
```

Update database schema
```
app/console doctrine:schema:update
```

Add routes in `app/config/routing.yml`:
```
KunstmaanTagGroupBundle:
    resource: "@KunstmaanTagGroupBundle/Resources/config/routing.yml"
```

Usage
-----
1. Go to admin panel ```Modules/Tags Groups```
2. Create group with name and unique `internalName`
3. Add tags to groups
4. Get filtered taggable object tags from group by internalName:

```jinja
{% set tags = page|tag_group('internalName') %}
{% if tags|length %}
    <ul>
        {% for tag in tags %}
            <li>{{ tag.name }}</li>
        {% endfor %}
    </ul>
{% endif %}
```

or use the public service:

```php
<?php
$tagGroupService = $this->get('szg_kunstmaantaggroupbundle.tag_group.manager');
$group = $tagGroupService->getGroupByName('internalName');
$tags = $tagGroupService->filterByGroup($taggable, $group)
```
