# GraphicObjectTemplating TWIG Extension (zf-got-twig-extension)

This module will help you in the conception and the construction of extensions for **GraphicObjectTemplating** (*zf-graphic-object-templating*)

## Before any Installation ##

You must have install the package : *celtic34fr/zf-graphic-object-templating*, development version by the following command :

    composer.phar require celtic34fr/zf-graphic-object-templating @dev 

## Installation using Composer

After that, you install this package with :

    composer.phar require celtic34fr/zf-got-twig-extension @dev

In order to use the installed module, you need to configure your application as follows:

First, in **config/modules.config.php** file, add the following line :

    ...
    'GotTemplateExtension',
    ...

Now, all is is ordre to work. You can begin to develop your own extension by adding a new module to your project, your application.