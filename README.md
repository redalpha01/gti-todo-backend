# GTI TODO test app

## Notes

- L'installation par défaut de laravel avec MariaDB utilise MyIsam comme engine ce qui cause un problème de longueur de
  clés
    - On pourrait retirer la table vu qu'on n'en a pas besoin ici, mais le vrai fix est de switch à InnoDB comme engine.
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

