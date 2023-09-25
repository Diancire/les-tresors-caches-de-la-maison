
# Les Trésors Cachés de la Maison

![Les Trésors Cachés de la Maison](img/logo-les-tresors-caches-de-la-maison.svg)


Bienvenue sur **Les Trésors Cachés de la Maison**, un blog dédié à l'art de vivre fait maison axé principalement sur les remèdes naturels.

## Pour commencer

Cloner le repository 

https://github.com/Diancire/les-tresors-caches-de-la-maison.git

### Pré-requis

* `symfony`
* `npm`

### Installation

Renommer le `.env.sample` file to `.env`

Executez la commande 

```

symfony server:start -d

```

ou 

```

php -S localhost:8000 -t public

```

puis

```

php bin/console doctrine:migration:migrate

```


## Démarrage

- Accédez à l'application : http://localhost:8000

  
Compiler webpack 

```
npm install
npm run dev

ou 

npm run watch

```

## Fabriqué avec

* [Symfony 6.3](https://symfony.com/) 
* [Webpack symfony encore](https://symfony.com/) 
* [Faker](https://fakerphp.github.io/) 
* [VichUploaderBundle](https://github.com/dustin10/VichUploaderBundle) 
* [SymfonyCastsResetPasswordBundle](https://github.com/SymfonyCasts/reset-password-bundle) 
* [KarserRecaptcha3Bundle](https://github.com/karser/KarserRecaptcha3Bundle) 


## Mise en production

* [IONOS](https://www.ionos.fr/)

Compiler webpack 

```sh

npm run build

```


## Auteur
Auteur du projet!
* **Dianciré Diallo** _alias_ [Diancire](https://github.com/Diancire)



