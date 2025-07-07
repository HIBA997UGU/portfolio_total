<?php
// Récupère la chaîne JSON envoyée
$dataJson = isset($_POST['data']) ? $_POST['data'] : '[]';

// Décode en tableau PHP
$dataArray = json_decode($dataJson, true);

// Optionnel : vérifier que le décodage s'est bien passé
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo "Erreur JSON : " . json_last_error_msg();
    exit;
}

// Réencode proprement pour l'enregistrement
$jsonData = json_encode($dataArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// Écriture dans le fichier
file_put_contents('data.json', $jsonData);

header('Content-Type: application/json');
echo json_encode(['message' => 'Données sauvegardées avec succès']);