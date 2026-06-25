
// Au chargement
window.onload = function() {
    afficherTaches();
};

// --- 1. Affichage ---
function afficherTaches() {
    let corpsTableau = document.getElementById('tache');
    corpsTableau.innerHTML = "";
     fetch("get_tasks.php")
        .then(response => response.json())
        .then(listeTaches => {

    let listeTaches = getTaches();
    console.log("listeTaches =", listeTaches);

    if (listeTaches.length === 0) {
        corpsTableau.innerHTML = "<tr><td colspan='7' style='text-align:center;'>Aucune tâche pour le moment.</td></tr>";
        return;
    }

    for (let tache of listeTaches) {
        let ligne = document.createElement('tr');
        ligne.innerHTML = `
            <td>${tache.titre}</td>
            <td>${tache.description}</td>
            <td>${tache.priorite}</td>
            <td>${tache.date}</td>
            <td>${tache.duree}</td>
            <td>${tache.etat}</td>
            <td>
                <button onclick="modifierTache(${tache.id})">Modifier</button>
                <button onclick="supprimerTache(${tache.id})">Supprimer</button>
            </td>
        `;
        corpsTableau.appendChild(ligne);
    }
}

// --- 2. Supprimer / Modifier ---
function supprimerTache(idAEffacer) {
    let listeTaches = getTaches();
    let listeMiseAJour = listeTaches.filter(tache => tache.id !== idAEffacer);
    setTaches(listeMiseAJour);
    afficherTaches();
}

function modifierTache(idAModifier) {
    let listeTaches = getTaches();
    let tache = listeTaches.find(t => t.id === idAModifier);

    if (tache) {
        let nouveauTitre = prompt("Modifier le titre :", tache.titre);
        if (nouveauTitre && nouveauTitre.trim() !== "") {
            tache.titre = nouveauTitre.trim();
            setTaches(listeTaches);
            afficherTaches();
        }
    }
}

// --- 3. Tri par date ---
function trid() {
    let listeTaches = getTaches();
    let n = listeTaches.length;
    let change;

    do {
        change = false;
        for (let i = 0; i < n - 1; i++) {
            if (listeTaches[i].date > listeTaches[i + 1].date) {
                let temp = listeTaches[i];
                listeTaches[i] = listeTaches[i + 1];
                listeTaches[i + 1] = temp;
                change = true;
            }
        }
        n--;
    } while (change);

    setTaches(listeTaches);
    afficherTaches();
}

// --- 4. Tri par titre ---
function trit() {
    let listeTaches = getTaches();
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

    setTaches(listeTaches);
    afficherTaches();
}

