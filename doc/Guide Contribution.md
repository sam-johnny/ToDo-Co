# Contribution Guide

Comment contribuer au projet :

1. Réaliser un fork du répertoire Github du projet
```
https://github.com/sam-johnny/ToDo-Co.git
```
2. Cloner localement de votre fork
```
git clone https://github.com/VotrePseudo/ToDo-Co.git
```
3. Installer le projet et ses dépendances [voir instructions](../README.md)

4. Créer une branche
```
git checkout -b <branche>
```
5. Effectuer vos modifications

6. Push la branch sur votre fork
```
git push origin <branche>
```
6. Ouvrir une pull request sur le répertoire Github du projet

# Processus de qualité

Lancer les tests avec génération d'un rapport de code coverage :
```
php bin/phpunit --coverage-html docs/code-coverage
```