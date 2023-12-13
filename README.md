# fulll-test

Premièrement je tiens à dire que j'ai été très frustré par cet exercice.
Je ne suis pas encore familier avec le DDD et le CQRS (surtout) dans la pratique.
J'ai donc cherché sur internet quelle devait être mon approche mais je n'ai pas réussi à trouver d'implémentation qui me convienne à 100% donc j'ai surtout essayé de répondre à la demande.

Ensuite j'ai aussi laissé de côté des règles métier qui me paraissaient évidentes car elles ne faisaient pas parti de l'énoncé et je voulais éviter de surcharger le code.


Enfin voici mes réponses pour le step 3 :

Pour assurer la qualité du code je fais en général confiance à PHPStorm dont le système de mise en surbrillance des points d'attentions et des erreurs est de plus en plus performant.
Je comprend bien que ça peut ne pas être suffisant lorsque l'équipe et les projets grossissent et dans ce cas je partirai d'instinct sur des vérifications via github/gitlab
(au moment des push ou plus régulier et global) car c'est un outil qui est déjà utilisé et très puissant.
Si ce n'est pas encore suffisant, une rapide recherche sur internet m'a permis d'en découvrir plusieurs qui ont l'air prometteurs.


Pour la mise en place d'un système de CI/CD les actions nécessaires vont surtout être : 
 * déterminer s'il y a ou non des actions préliminaires (vérification du code, jeux de tests, préparation de l'environnement, compilation)
 * identifier les différents environnements et leurs spécificités (dev ou prod, différentes variables d'environnement, des secrets, etc.)
 * trouver le moyen le plus pertinent d'envoyer d'envoyer le code ou l'application
 * déterminer s'il y a des actions à faire après le déploiement
 * et enfin avoir un bon système de monitoring pour s'assurer que tout va bien