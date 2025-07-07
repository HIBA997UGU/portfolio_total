<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des livres empruntés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .filter-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .action-buttons {
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Gestion des livres empruntés</span>
        </div>
    </nav>
    <div class="container">
        <a class="btn btn-primary mb-3" href="new.php">Nouvel emprunt</a>
        
        <div class="filter-section">
            <h5>Filtrer les emprunts</h5>
            <div class="row">
                <div class="col-md-4">
                    <label for="filterLivre" class="form-label">Livre</label>
                    <input type="text" class="form-control" id="filterLivre" placeholder="Filtrer par livre...">
                </div>
                <div class="col-md-4">
                    <label for="filterEmprunteur" class="form-label">Emprunteur</label>
                    <input type="text" class="form-control" id="filterEmprunteur" placeholder="Filtrer par emprunteur...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Livre</th>
                        <th>Emprunteur</th>
                        <th>Date d'emprunt</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
        </div>
    </div>

    <script>
        var products = [];

        $(document).ready(function() {
            loadData();
            
            // Setup filter events
            $('#filterLivre, #filterEmprunteur').on('keyup', function() {
                filterProducts();
            });
        });

        function loadData() {
            $.ajax({
                url: 'http://localhost/Hiba-CrudJson/getData.php',
                type: 'GET',
                dataType: 'text',
                success: function(data) {
                    try {
                        products = JSON.parse(data);
                        displayProducts(products);
                    } catch (e) {
                        console.error("Erreur de parsing JSON :", e);
                    }
                },
                error: function(error) {
                    console.error('Erreur lors de la récupération des données:', error);
                }
            });
        }

        function displayProducts(productsToDisplay) {
            tbody = document.getElementById("tbody");
            tbody.innerHTML = '';
            
            if (productsToDisplay.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center">Aucun emprunt trouvé</td></tr>';
                return;
            }

            for (product of productsToDisplay) {
                tr = document.createElement('tr');
                
                td = document.createElement('td');
                td.textContent = product.id;
                tr.appendChild(td);
                
                td = document.createElement('td');
                td.textContent = product.livre;
                tr.appendChild(td);
                
                td = document.createElement('td');
                td.textContent = product.emprunteur;
                tr.appendChild(td);
                
                td = document.createElement('td');
                td.textContent = product.date;
                tr.appendChild(td);
                
                td = document.createElement('td');
                td.className = 'action-buttons';
                td.innerHTML = `<button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})">Supprimer</button>
                                <a href="edit.php?id=${product.id}" class="btn btn-primary btn-sm">Modifier</a>`;
                tr.appendChild(td);
                
                tbody.appendChild(tr);
            }
        }

        function filterProducts() {
            const livreFilter = $('#filterLivre').val().toLowerCase();
            const emprunteurFilter = $('#filterEmprunteur').val().toLowerCase();
            
            const filtered = products.filter(product => {
                return product.livre.toLowerCase().includes(livreFilter) && 
                       product.emprunteur.toLowerCase().includes(emprunteurFilter);
            });
            
            displayProducts(filtered);
        }

        function deleteProduct(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cet emprunt ?")) {
                filtered_products = products.filter(product => product.id != id);
                $.ajax({
                    url: 'http://localhost/Hiba-CrudJson/setData.php',
                    type: 'POST',
                    data: {
                        data: JSON.stringify(filtered_products)
                    },
                    success: function(response) {
                        loadData();
                    },
                    error: function(error) {
                        console.error('Erreur lors de la suppression du produit:', error);
                    }
                });
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>