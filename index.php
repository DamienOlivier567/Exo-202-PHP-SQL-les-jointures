<?php

/**
 * 1. Commencez par importer le script SQL disponible dans le dossier SQL.
 * 2. Connectez vous à la base de données blog.
 */

/**
 * 3. Sans utiliser les alias, effectuez une jointure de type INNER JOIN de manière à récupérer :
 *   - Les articles :
 *     * id
 *     * titre
 *     * contenu
 *     * le nom de la catégorie ( pas l'id, le nom en provenance de la table Categorie ).
 *
 * A l'aide d'une boucle, affichez chaque ligne du tableau de résultat.
 */

// TODO Votre code ici.
require "./Classes/DB.php";
$conn = DB::getInstance();

$join1 = $conn->prepare("
        SELECT article.id, article.title, article.content, categorie.name 
        FROM article
        INNER JOIN categorie ON category_fk = categorie.id
        ");
$join1->execute();
foreach ($join1->fetchAll() as $item){
    echo "id: ".$item["id"]."<br>";
    echo "titre: ".$item["title"]."<br>";
    echo "contenu: ".$item["content"]."<br>";
    echo "nom de la categorie: ".$item["name"]."<br>";
}
echo "<br>";
/**
 * 4. Réalisez la même chose que le point 3 en utilisant un maximum d'alias.
 */
// TODO Votre code ici.


$alias = $conn->prepare("
        SELECT ar.id AS i, ar.title AS ti, ar.content AS co, c.name AS n
        FROM article AS ar
        INNER JOIN categorie AS c on ar.category_fk = c.id
        ");

$alias->execute();
foreach ($alias->fetchAll() AS $item){
    echo "id: ".$item["i"]."<br>";
    echo "titre: ".$item["ti"]."<br>";
    echo "contenu: ".$item["co"]."<br>";
    echo "nom de la categorie: ".$item["n"]."<br>";
}
echo "<br>";


/**
 * 5. Ajoutez un utilisateur dans la table utilisateur.
 *    Ajoutez des commentaires et liez un utilisateur au commentaire.
 *    Avec un LEFT JOIN, affichez tous les commentaires et liez le nom et le prénom de l'utilisateur ayant écris le comentaire.
 */

// TODO Votre code ici.

$first = "Sorcelleur";
$last = "Droskall";
$mail = "witcher@gmail.com";
$psw = "password";

$insertUser = $conn->prepare("
        INSERT INTO utilisateur (firstName, lastName, mail, password) 
        VALUES (:first, :last, :mail, :psw)
        ");

$insertUser->bindParam(":first", $first);
$insertUser->bindParam(":last", $last);
$insertUser->bindParam(":mail", $mail);
$insertUser->bindParam(":psw", $psw);
$insertUser->execute();

$content = "Toss A Coin To Your Witcher";
$user = 1;
$article = 2;

$insertCom = $conn->prepare("
        INSERT INTO commentaire (content, user_fk, article_fk) 
        VALUES (:content, :user, :article)
        ");
$insertCom->bindParam(":content", $content);
$insertCom->bindParam(":user", $user);
$insertCom->bindParam(":article", $article);
$insertCom->execute();

$leftJoin = $conn->prepare("
        SELECT c.content, u.firstName, u.lastName
        FROM commentaire as c
        LEFT JOIN utilisateur as u ON c.user_fk = u.id  
        ");


$leftJoin->execute();
foreach ($leftJoin->fetchAll() as $item){
    echo "contenu du comentaire: ".$item["content"]."<br>";
    echo "nom: ".$first."<br>";
    echo "Prenom: ".$last."<br>";
}