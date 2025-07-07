<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier un emprunt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: 500;
        }
    </style>
</head>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');
    products = []
    productToEdit = {}
    $(document).ready(() => {
        $.ajax({
            url: 'http://localhost/Hiba-CrudJson/getData.php',
            type: 'GET',
            dataType: 'text',
            success: function(data) {
                try {
                    products = JSON.parse(data);
                    productToEdit = products.find(product => product.id == id);
                    document.getElementById("livre").value = productToEdit.livre;
                    document.getElementById("emprunteur").value = productToEdit.emprunteur;
                    document.getElementById("date").value = productToEdit.date;
                } catch (e) {
                    console.error("Erreur de parsing JSON :", e);
                }
            },
            error: function(error) {
                console.error('Erreur lors de la récupération des données:', error);
            }
        });
    });

    function handleSubmit(event) {
        event.preventDefault();
        var livre = document.getElementById("livre").value;
        var emprunteur = document.getElementById("emprunteur").value;
        var date = document.getElementById("date").value;

        // Validation
        if (livre == '') {
            alert("Le champ livre est obligatoire");
            return false;
        } else if (livre.length < 3) {
            alert("Le titre du livre doit contenir au moins 3 caractères");
            return false;
        }

        if (emprunteur == '') {
            alert("Le champ emprunteur est obligatoire");
            return false;
        }

        if (date == '') {
            alert("Le champ date est obligatoire");
            return false;
        } else if (!isValidDate(date)) {
            alert("Le format de date doit être AAAA-MM-JJ");
            return false;
        }

        productToEdit.livre = livre;
        productToEdit.emprunteur = emprunteur;
        productToEdit.date = date;

        $.ajax({
            url: 'http://localhost/Hiba-CrudJson/setData.php',
            type: 'POST',
            dataType: 'json',
            data: {
                data: JSON.stringify(products)
            },
            success: function(data) {
                window.location.href = '/Hiba-CrudJson/';
            },
            error: function(error) {
                console.error('Erreur lors de la modification de l\'emprunt:', error);
            }
        });
    }

    function isValidDate(dateString) {
        var regEx = /^\d{4}-\d{2}-\d{2}$/;
        if(!dateString.match(regEx)) return false;
        var d = new Date(dateString);
        return !isNaN(d.getTime());
    }
</script>

<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Gestion des livres empruntés</span>
        </div>
    </nav>
    <div class="container">
        <div class="card col-8 mx-auto mt-5 bg-light">
            <div class="card-body">
                <h3 class="card-title">Modifier un emprunt</h3>
                <form onsubmit="handleSubmit(event)">
                    <div class="mb-3">
                        <label for="livre" class="form-label">Livre*</label>
                        <input type="text" class="form-control" id="livre" required>
                        <div class="form-text">Minimum 3 caractères</div>
                    </div>
                    <div class="mb-3">
                        <label for="emprunteur" class="form-label">Emprunteur*</label>
                        <input type="text" class="form-control" id="emprunteur" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date d'emprunt*</label>
                        <input type="date" class="form-control" id="date" required>
                        <div class="form-text">Format: AAAA-MM-JJ</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a type="button" href="/Hiba-CrudJson" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>