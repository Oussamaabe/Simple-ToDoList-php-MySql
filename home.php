<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDoList</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center">ToDoList</h5>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group row">
                                <label for="name_user" class="col-sm-3 col-form-label">User Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name_user" name="name_user" value="<?php if (isset($_COOKIE['user_name'])) { echo $_COOKIE['user_name']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pass" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="pass" name="pass" value="<?php if (isset($_COOKIE['pass'])) { echo $_COOKIE['pass']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <input type="submit" class="btn btn-primary" name="Valider" value="Valider">
                                    <input type="submit" class="btn btn-success" name="afficher" value="Afficher">
                                    <input type="submit" name="cacher" class="btn btn-danger" value="Cacher">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    require 'connexion.php';
    session_start();

    if (isset($_POST['Valider'])) {
        if (empty($_POST['name_user'])) {
            echo "<span style='color:red;font-weight:bold;text-align:center;'>User name EST LAISSER VIDE</span>";
        } else {
            $requete = "SELECT * FROM Users WHERE user_name = :param1 AND password = :param2";
            $resultat = $connexion->prepare($requete);
            $nom_user = $_POST['name_user'];
            $pass = $_POST['pass'];
            $Valider = $_POST['Valider'];
            $resultat->bindValue('param1', $nom_user);
            $resultat->bindValue('param2', $pass);

            if ($resultat->execute()) {
                $row = $resultat->fetch(PDO::FETCH_ASSOC);
                if (empty($row['user_name']) || empty($row['password'])) {
                    echo "<span style='color:red;font-weight:bold;text-align:center;'>N'existe Aucun user Avec Ce Password</span>";
                } else {
                    setcookie('user_name', $row['user_name']);
                    setcookie('pass', $row['password']);
                    $_SESSION['user_sess'] = $nom_user;
                    $_SESSION['pass_sess'] = $pass;
                    header('Location: ToDoListe.php');
                    exit; // Ajout d'une sortie après la redirection
                }
            } else {
                echo "ERREUR LORS DE L'EXECUTION";
            }
        }
        echo "</fieldset>"; // Il manque l'ouverture d'une balise <fieldset>
    }

    // CODE D'AFFICHAGE DES USERS POUR CONNAÎTRE LA LISTE DES USERS ET LEURS PASS
    if (isset($_POST['afficher'])) {
        $req = 'SELECT * FROM users';
        $resau = $connexion->query($req);
        if ($resau->execute()) {
            echo "<div class='container mt-4'>";
            echo "<table class='table table-striped table-bordered'>";
            echo "<thead class='thead-dark'><tr><th>User Name</th><th>Password</th></tr></thead>";
            echo "<tbody>";
            while ($rows = $resau->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>" . $rows['user_name'] . "</td>";
                echo "<td>" . $rows['password'] . "</td></tr>";
            }
            echo "</tbody></table></div>";
        } else if (isset($_POST['cacher'])) {
            echo "<style>table{visibility:hidden;}</style>";
        }
    }
    ?>
    <script src="./Bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>
