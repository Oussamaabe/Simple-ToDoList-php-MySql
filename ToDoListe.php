
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDoList</title>
    <link rel="stylesheet" href="./Bootstrap/bootstrap.min.css">
    <style>
        .title {
            background-color: black;
            color: white;
            text-align: center;
            
            
        }
        .dec a {
            color: #fff;
            text-decoration: none;
        }
        
        .dec a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
              <div class="title">
                  <h1 class="text-center mb-4">ToDoList</h1>
              </div>
                <form method="post" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="TaskTitle" class="form-control" placeholder="Task Title">
                        <div  class="input-group-append">
                            <input type="submit" name="addTask" value="Add" class="btn btn-primary">
                            <?php  
echo "<button class='btn btn-danger'><a href='deconexion.php' onclick='return confirm(\"VOULEZ-VOUS VRAIMENT DECONNECTER DE CETTE PAGE ?\");' class='text-white text-decoration-none'>Déconnexion</a></button>"; 
?>

                        </div>
                    </div>
                </form>

                <?php
    require 'connexion.php';
    session_start();

    // Vérification de la session
    if (empty($_SESSION['user_sess']) || empty($_SESSION['pass_sess'])) {
        header('Location:home.php');
        exit;
    }

    // Vérification de l'ajout de tâche
    if (isset($_POST['addTask'])) {
        if (empty($_POST['TaskTitle'])) {
            echo "<div class='errorTitle'><span >Veuillez entrer une tâche avant de cliquer sur le bouton</span></div>";
        } else {
            // Insertion de la tâche dans la base de données
            $req = 'INSERT INTO todo (title) VALUES (:param1)';
            $resau = $connexion->prepare($req);
            $title_task = $_POST['TaskTitle'];
            $resau->bindValue(':param1', $title_task);
            if ($resau->execute()) {
                echo '<span class="spn1">Insertion réussie</span>';
                // Rechargement de la page pour afficher les nouvelles tâches
                echo "<script>window.location.replace('ToDoListe.php');</script>";
                exit;
            }
        }
    }

    // Vérification de la suppression ou du toggle de tâche
    if (isset($_POST['action']) && isset($_POST['taskId'])) {
        $taskId = $_POST['taskId'];
        if ($_POST['action'] === 'delete') {
            $reqDelete = 'DELETE FROM todo WHERE id = :taskId';
            $resDelete = $connexion->prepare($reqDelete);
            $resDelete->bindValue(':taskId', $taskId);
            if ($resDelete->execute()) {
                // Rechargement de la page pour afficher les tâches mises à jour après la suppression
                echo "<script>window.location.replace('ToDoListe.php');</script>";
                exit;
            }
        } elseif ($_POST['action'] === 'toggle') {
            $reqToggle = 'UPDATE todo SET done = NOT done WHERE id = :taskId';
            $resToggle = $connexion->prepare($reqToggle);
            $resToggle->bindValue(':taskId', $taskId);
            if ($resToggle->execute()) {
                // Rechargement de la page pour afficher les tâches mises à jour après le toggle
                echo "<script>window.location.replace('ToDoListe.php');</script>";
                exit;
            }
        }
    }

    // Récupération des tâches depuis la base de données
    $reqTasks = 'SELECT * FROM todo';
    $resTasks = $connexion->query($reqTasks);
    $taches = $resTasks->fetchAll(PDO::FETCH_ASSOC);
    ?>


                <!-- Affichage des tâches -->
                <div name="Affichage">
                    <ul class="list-group">
                        <?php
                        // Afficher les tâches récupérées de la base de données
                        if (isset($taches)) {
                            foreach ($taches as $tache) {
                                $taskClass = $tache['done'] ? 'list-group-item-success' : 'list-group-item-warning';
                                $status = $tache['done'] ? 'Done' : 'Not Done';
                                echo "<li class='list-group-item $taskClass d-flex justify-content-between align-items-center'>" . htmlspecialchars($tache['title']) .
                                    "<form method='post' name='btns'>                      
                                        <input type='hidden' name='taskId' value='" . $tache['id'] . "'>
                                        <button type='submit' name='action' value='toggle' class='btn btn-secondary'>$status</button>
                                        <button type='submit' name='action' value='delete' class='btn btn-danger'>X</button>
                                    </form></li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script src="./Bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>



