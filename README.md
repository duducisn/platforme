# Plateforme de Gestion des Étudiants

Cette plateforme permet de gérer les étudiants, leurs notes et leurs filières. Elle est construite en PHP et fonctionne avec XAMPP.

## Fonctionnalités

- Gestion des utilisateurs (administrateurs et étudiants)
- Ajout, modification et suppression de filières, matières, et notes
- Affichage des résultats des étudiants par matière et par filière
- Connexion et gestion des sessions

## Installation

1. Clonez ce dépôt sur votre machine locale :

    ```bash
    git clone https://github.com/duducisn/platforme.git
    ```

2. Installez XAMPP si ce n'est pas déjà fait, puis placez ce projet dans le dossier `htdocs` de XAMPP.

3. Importez la base de données `uvs_etudiant.sql` dans votre gestionnaire de base de données (phpMyAdmin ou autre).

4. Configurez le fichier `.env` (si nécessaire) avec les informations de votre base de données.

5. Démarrez Apache et MySQL dans XAMPP et accédez à `http://localhost/platforme` dans votre navigateur.

## Technologies

- PHP
- MySQL
- XAMPP

## Contribuer

1. Fork ce dépôt.
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/nouvelle-fonctionnalite`).
3. Effectuez vos changements et ajoutez-les (`git add .`).
4. Commitez vos changements (`git commit -m 'Ajout d'une nouvelle fonctionnalité'`).
5. Poussez votre branche (`git push origin feature/nouvelle-fonctionnalite`).
6. Ouvrez une pull request.

## License

Ce projet est sous la licence MIT - voir le fichier [LICENSE](LICENSE) pour plus de détails.
