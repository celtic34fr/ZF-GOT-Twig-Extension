# GraphicObjectTemplating TWIG Extension (zf-got-twig-extension)

Ce module vous aidera dans la conception et la réalisation d'extensions pour **GraphicObjectTemplating** (*zf-graphic-object-templating*)

## Avant toute installation ##

Vous devez avoiir installé le paquet : $celtic34fr/zf-graphic-object-templating*, version de développement avec la commande suivante :

    composer.phar require celtic34fr/zf-graphic-object-templating @dev 

## Installation avec Composer

Après cela, vous pouvez installer le paquet avec :

    composer.phar require celtic34fr/zf-got-twig-extension @dev

Afin de rendre fonctionnel le module installé, vous devez configurer votre application comme suit :

En premier, dans le fichier **config/modules.config.php**, ajoutez la ligne suivante :

    ...
    'GotTemplateExtension',
    ...

Maintenant, tout est en ordre pour fonctionner. Vous pouvez commencer à développer votre propre extension en ajoutant un nouveau module à votre projet, votre application.
