# GTI TODO test app

## Notes

- L'installation par défaut de laravel avec MariaDB utilise MyIsam comme engine ce qui cause un problème de longueur de
  clés
    - On pourrait retirer la table vu qu'on n'en a pas besoin ici, mais le vrai fix est de switch à InnoDB comme engine.
- Les normes REST étants généralement vague su le sujet des actions, j'ai décidé de traite le reordering des items comme "conséquence naturelle" d'un PUT ou PATCH sur l'entité plutôt que de créer  une route spécifique pour l'action. (Ce que J'ai aussi déjà fait sur d'autres projets dans le passé)
  - Je suivrais vos normes à ce sujet si j'ai le rôle.
- J'ai créé le modèle Task pour représenter les points du TODO avec les options suivantes

| Option    | Effet                                                                                                                                                                                                               |
|-----------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| -c        | Crée un controlleur pour le modèle                                                                                                                                                                                  |
| --api     | Le controlleur sera créé avec les verbes défaut d'un API REST (ISSUD)                                                                                                                                               |
| -f        | Crée une classe de Factory (Pour pouvoir seeder)                                                                                                                                                                    |
| -m        | Crée une classe de migration (pour créer la table)                                                                                                                                                                  |
| -s        | Crée un seeder (Sera ici utilisé juste pour avoir quelques éléments par défaut)                                                                                                                                     |
| -R        | Crée des classes de FormRequest pour le modèle (Store & Update) <br/>Toute validation du modèle est déplacée ici                                                                                                    |
| --policy  | Controllerait les permissions d'accès au modèle.<br/>Ne sera pas utilisé pour ce projet  mais permettrait d'ajouter l'authorization dans le futur.                                                                  |
| --phpunit | Créé une classe de test en PHPUnit.<br/>Note: avec mbiance, nous n'avions pas l'opportunité de faire des tests unitaires, mais - au moins pour ce test-ci - je veux implémenter l'approche "Fail early, Fail often" |

## Composer Packages
- Ide-helper
  - Facilite l'autocomplétion dans les IDE
- roave/security-advisories
  - Protection contre failles connues de PHP

## Structure du modèle Tasks
- Champs par défaut
  - Id : identifiant
  - Timestamps : date/heure création et date/heure édition
- Champs requis minimum
  - Description (J'assume ici que VARCAR 255 est assez considéranmt que les todos seront sur une seule ligne)
  - is_done (marqueur de complétion)
  - position (pour pouvoir marquer l'ordre)
