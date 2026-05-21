<div class="container mt-5">
<?php
var_dump($discussion);
?>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Messages privés</h3>
    </div>

    <!-- Barre de recherche -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <input 
                type="text" 
                class="form-control" 
                placeholder="Rechercher une personne..."
            >
        </div>
    </div>

    <!-- Liste des utilisateurs -->
    <div class="row g-4">
        <?php
        foreach ($users as $key => $user) {            
        ?>
                <!-- Utilisateur 1 -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex align-items-center">

                    <!-- Avatar -->
                    <div class="me-3">
                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center">
                            <img src="/img/<?= htmlspecialchars($user["photoProfile"]) ?>" alt="Photo de profil" class="rounded-circle object-fit-cover img-fluid" style="width: 50px; height: 50px;">
                        </div>
                    </div>

                    <!-- Infos -->
                    <div class="flex-grow-1">
                        <h6 class="mb-0"><?= $user["pseudo"]?></h6>
                    </div>

                    <!-- Action -->
                    <div>
                        <form action=<?= "/discussion/perso/".$discussion."/" . $user["idUtilisateur"]?> method="post">
                        <input type="hidden" name="user" value=<?= $user["idUtilisateur"]?>>
                        <button type="submit" class="btn btn-outline-primary btn-sm"> Ajouter</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>