<?php

function connectDB(): PDO {
    $localhost = "localhost";
    $user = "root";
    $password = "root";
    $database = "dauphineexam";
    return new PDO("mysql:host=$localhost;dbname=$database", $user, $password);
}

function configPdo(PDO $pdo) {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}

function getAllNews(PDO $pdo) {
    $response = $pdo->query("SELECT * FROM annonce ORDER BY id DESC");
    return $response->fetchAll();
}

function deleteNews(PDO $pdo, $title) {
    $stmt = $pdo->prepare("DELETE FROM annonce WHERE titre = :title");
    $stmt->bindParam(':title', $title);
    $stmt->execute();
//    $stmt->execute(
//        [
//            ":titre" => $title
//        ]
//    );
    return $stmt->rowCount();
}

function addNews(PDO $pdo, $title, $author, $content, $imageUrl) {
    $stmt = $pdo->prepare("INSERT INTO annonce 
    (imageUrl, contenu, titre, auteur, datePublication)
    VALUES (:imageUrl, :contenu, :titre, :auteur, :datePublication)");
    $datePublication = date('Y-m-d H:i:s');
    $stmt->bindParam(':imageUrl', $imageUrl);
    $stmt->bindParam(':contenu', $content);
    $stmt->bindParam(':titre', $title);
    $stmt->bindParam(':auteur', $author);
    $stmt->bindParam(':datePublication', $datePublication);
    $stmt->execute();

    return $stmt->rowCount();
}