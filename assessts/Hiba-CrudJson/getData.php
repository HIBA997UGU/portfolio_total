<?php
function afficherJsonBrut($cheminFichier)
{
    if (file_exists($cheminFichier)) {
        header('Content-Type: application/json');
        echo file_get_contents($cheminFichier);
    } else {
        header('Content-Type: text/plain');
        echo "Fichier introuvable.";
    }
}

// Appel de la fonction
afficherJsonBrut('data.json');