// --- Fonctions de base pour la gestion des tâches ---
async function getTaches() {
    try {
        const response = await fetch("../PHP/aJ.php");
        if (!response.ok) throw new Error("Erreur réseau : " + response.status);
        return await response.json();
    } catch (error) {
        console.error("Erreur lors de la récupération des tâches :", error);
        return [];
    }
}

async function setTaches(liste) {
    console.warn("setTaches() n'est plus utilisé. Les tâches sont gérées via PHP/MySQL.");
}

// --- 1. Affichage des tâches ---
async function afficherTaches() {
    let corpsTableau = document.getElementById('tache');
    corpsTableau.innerHTML = "<tr><td colspan='7' style='text-align:center;'>Chargement...</td></tr>";

    try {
        const listeTaches = await getTaches();

        if (listeTaches.length === 0) {
            corpsTableau.innerHTML = "<tr><td colspan='7' style='text-align:center;'>Aucune tâche pour le moment.</td></tr>";
            return;
        }

        corpsTableau.innerHTML = "";
        for (let tache of listeTaches) {
            const estTerminee = tache.terminee || tache.etat === "TERMINER";
            let ligne = document.createElement('tr');
            ligne.innerHTML = `
                <td>${tache.titre || ''}</td>
                <td>${tache.description || ''}</td>
                <td>${tache.priorite || ''}</td>
                <td>${tache.date || ''}</td>
                <td>${tache.duree || ''}</td>
                <td>${tache.etat || ''}</td>
                <td>
                    <button onclick="toggleTerminee(${tache.id}, ${estTerminee ? 1 : 0})" style="background:${estTerminee ? '#4CAF50' : '#f44336'}; color:white;">
                        ${estTerminee ? "✅ Terminée" : "❌ Non terminée"}
                    </button>
                    <button onclick="modifierTache(${tache.id})">Modifier</button>
                    <button onclick="supprimerTache(${tache.id})">Supprimer</button>
                </td>
            `;
            corpsTableau.appendChild(ligne);
        }
    } catch (error) {
        console.error("Erreur :", error);
        corpsTableau.innerHTML = "<tr><td colspan='7' style='text-align:center; color:red;'>Erreur de chargement des tâches.</td></tr>";
    }
}

// --- 2. Supprimer une tâche ---
async function supprimerTache(idAEffacer) {
    if (!confirm("Voulez-vous vraiment supprimer cette tâche ?")) return;

    try {
        const response = await fetch("../PHP/delete_task.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${idAEffacer}`
        });
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.erreur || "Erreur inconnue");
        }
        afficherTaches();
    } catch (error) {
        console.error("Erreur :", error);
        alert("Erreur lors de la suppression : " + error.message);
    }
}

// --- 3. Modifier une tâche ---
async function modifierTache(idAModifier) {
    try {
        // Récupérer la tâche actuelle
        const response = await fetch(`../PHP/get_task.php?id=${idAModifier}`);
        if (!response.ok) throw new Error("Erreur de récupération");
        const tache = await response.json();

        // Demander les nouvelles valeurs (avec valeurs par défaut)
        let nouveauTitre = prompt("Modifier le titre :", tache.titre);
        if (nouveauTitre === null) return; // Annulé
        if (nouveauTitre.trim() === "") nouveauTitre = tache.titre;

        let nouvelleDescription = prompt("Modifier la description :", tache.description);
        if (nouvelleDescription === null) return;
        if (nouvelleDescription.trim() === "") nouvelleDescription = tache.description;

        let nouvellePriorite = prompt("Modifier la priorité (Faible importance/priorité moyenne/Primordiale/Capitale) :", tache.priorite);
        if (nouvellePriorite === null) return;
        if (nouvellePriorite.trim() === "") nouvellePriorite = tache.priorite;

        let nouvelleDate = prompt("Modifier la date (YYYY-MM-DD) :", tache.date);
        if (nouvelleDate === null) return;
        if (nouvelleDate.trim() === "") nouvelleDate = tache.date;

        let nouvelleDuree = prompt("Modifier la durée (en jours) :", tache.duree);
        if (nouvelleDuree === null) return;
        if (nouvelleDuree.trim() === "") nouvelleDuree = tache.duree;

        let nouvelEtat = prompt("Modifier l'état (COMMENCE/EN COURS/TERMINER) :", tache.etat);
        if (nouvelEtat === null) return;
        if (nouvelEtat.trim() === "") nouvelEtat = tache.etat;

        // Envoyer les modifications
        const formData = new URLSearchParams();
        formData.append('id', idAModifier);
        formData.append('titre', nouveauTitre);
        formData.append('description', nouvelleDescription);
        formData.append('priorite', nouvellePriorite);
        formData.append('date', nouvelleDate);
        formData.append('duree', nouvelleDuree);
        formData.append('etat', nouvelEtat);

        const updateResponse = await fetch("../PHP/update_task.php", {
            method: "POST",
            body: formData
        });

        if (!updateResponse.ok) {
            const errorData = await updateResponse.json();
            throw new Error(errorData.erreur || "Erreur de modification");
        }
        afficherTaches();
    } catch (error) {
        console.error("Erreur :", error);
        alert("Erreur lors de la modification : " + error.message);
    }
}

// --- 4. Basculer le statut "terminée" ---
async function toggleTerminee(id, estTerminee) {
    try {
        const response = await fetch("../PHP/toggle_task.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${id}`
        });
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.erreur || "Erreur inconnue");
        }
        afficherTaches();
    } catch (error) {
        console.error("Erreur :", error);
        alert("Erreur lors de la mise à jour du statut : " + error.message);
    }
}

// --- 5. Tri par date (bubble sort) ---
async function trid() {
    try {
        const listeTaches = await getTaches();
        let n = listeTaches.length;
        let change;

        do {
            change = false;
            for (let i = 0; i < n - 1; i++) {
                if (new Date(listeTaches[i].date) > new Date(listeTaches[i + 1].date)) {
                    let temp = listeTaches[i];
                    listeTaches[i] = listeTaches[i + 1];
                    listeTaches[i + 1] = temp;
                    change = true;
                }
            }
            n--;
        } while (change);

        afficherTachesAvecListe(listeTaches);
    } catch (error) {
        console.error("Erreur :", error);
        alert("Erreur lors du tri par date.");
    }
}

// --- 6. Tri par titre (selection sort) ---
async function trit() {
    try {
        const listeTaches = await getTaches();
        let n = listeTaches.length;

        for (let i = 0; i < n - 1; i++) {
            let minId = i;
            for (let j = i + 1; j < n; j++) {
                if (listeTaches[j].titre.toLowerCase() < listeTaches[minId].titre.toLowerCase()) {
                    minId = j;
                }
            }
            if (minId !== i) {
                let temp = listeTaches[i];
                listeTaches[i] = listeTaches[minId];
                listeTaches[minId] = temp;
            }
        }

        afficherTachesAvecListe(listeTaches);
    } catch (error) {
        console.error("Erreur :", error);
        alert("Erreur lors du tri par titre.");
    }
}

// --- Fonction utilitaire pour afficher une liste de tâches ---
function afficherTachesAvecListe(listeTaches) {
    let corpsTableau = document.getElementById('tache');
    corpsTableau.innerHTML = "";

    if (listeTaches.length === 0) {
        corpsTableau.innerHTML = "<tr><td colspan='7' style='text-align:center;'>Aucune tâche.</td></tr>";
        return;
    }

    for (let tache of listeTaches) {
        const estTerminee = tache.terminee || tache.etat === "TERMINER";
        let ligne = document.createElement('tr');
        ligne.innerHTML = `
            <td>${tache.titre || ''}</td>
            <td>${tache.description || ''}</td>
            <td>${tache.priorite || ''}</td>
            <td>${tache.date || ''}</td>
            <td>${tache.duree || ''}</td>
            <td>${tache.etat || ''}</td>
            <td>
                <button onclick="toggleTerminee(${tache.id}, ${estTerminee ? 1 : 0})" style="background:${estTerminee ? '#4CAF50' : '#f44336'}; color:white;">
                    ${estTerminee ? "✅ Terminée" : "❌ Non terminée"}
                </button>
                <button onclick="modifierTache(${tache.id})">Modifier</button>
                <button onclick="supprimerTache(${tache.id})">Supprimer</button>
            </td>
        `;
        corpsTableau.appendChild(ligne);
    }
}

// --- 7. Sauvegarde (désormais inutile avec MySQL, mais gardée pour compatibilité) ---
function sauvegarderDonnees() {
    alert("✅ Les données sont automatiquement sauvegardées dans la base de données.");
}

// --- Chargement initial ---
window.onload = function() {
    afficherTaches();
};