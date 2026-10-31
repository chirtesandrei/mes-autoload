# Mes Autoload

Comprenez le poids des options chargées automatiquement, sans supprimer vos réglages.

- Fiche, téléchargement et empreinte SHA-256 : https://mesplugins.fr/plugins/mes-autoload/
- Toutes les extensions MesPlugins.fr : https://mesplugins.fr/plugins/

## Ce que fait l’extension

Ouvrez Outils > Mes Autoload pour afficher le volume stocké et les 50 noms d’options les plus lourds. Aucune valeur de configuration n’est affichée et aucun réglage n’est modifié.

## Limites

Un volume élevé ne prouve pas à lui seul une lenteur. Le propriétaire et l’utilité d’une option ne sont pas déduits automatiquement. Pas de nettoyage ou de modification de l’autoload.

Première version réservée aux installations WordPress simples : l’activation est refusée en multisite.

## Guide lié

[« Allowed memory size exhausted » sur WordPress](https://mesplugins.fr/guides/allowed-memory-size-exhausted-wordpress/)

## Installation

1. Téléchargez le ZIP depuis https://mesplugins.fr/plugins/mes-autoload/ et vérifiez son empreinte.
2. Dans WordPress : Extensions > Ajouter > Téléverser une extension.
3. Activez puis ouvrez Outils > Mes Autoload.

## Mises à jour

L’administration, le cron et WP-CLI consultent un manifeste fixe de mesplugins.fr, sans identifiant du site. Définir `MESPLUGINS_DISABLE_UPDATE_CHECK` à `true` dans wp-config.php désactive cette vérification. Aucune télémétrie.

## Version

0.1.0 — testée sur WordPress 7.1.4 / PHP 8.3.6. Ce dépôt contient exactement le ZIP publié (mes-autoload-0.1.0.zip, SHA-256 `841556983bb786253b9c85aaae02bdc343123f4538b422b9b9f6b48987ce09cc`).

Signaler un problème : les issues de ce dépôt, ou https://mesplugins.fr/contact/

Licence : GPL v2 ou ultérieure.
