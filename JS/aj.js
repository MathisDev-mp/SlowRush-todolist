function getTaches() {
    let tachesExistantes = localStorage.getItem('taches');
    let listeTaches = tachesExistantes ? JSON.parse(tachesExistantes) : [];
    if (!Array.isArray(listeTaches)) listeTaches = [];
    return listeTaches;
}

function setTaches(liste) {
    localStorage.setItem('taches', JSON.stringify(liste));
}

function validerNouvelleTache(event) {
    if (event) event.preventDefault(); 

    // 1. Récupération des valeurs
    let titre = document.getElementById('titre').value.trim();
    let description = document.getElementById('des').value.trim();
    let priorite = document.getElementById('priorite').value;
    let date = document.getElementById('date').value;
    let duree = +document.getElementById('jour').value.trim();
    let etat = document.getElementById('etat').value;

    // 2. Vérifications
    if (titre === "") { alert("Le champ 'TITRE' est vide."); return; }
    if (description === "") { alert("Le champ 'DESCRIPTION' est vide."); return; }
    if (priorite === "Veuillez choisir une Grandeur de priorité pour cette tache") { alert("Veuillez choisir une priorité valide."); return; }
    if (date === "") { alert("Le champ 'DATE' est vide."); return; }
    if (isNaN(duree) || duree <= 0) { alert("Le champ 'DURÉE' doit contenir un nombre valide."); return; }

    console.log("Données prêtes :", { titre, description, priorite, date, duree, etat });

    // 3. Création de l'objet tâche
    let nouvelleTache = {
        id: Date.now(),
        titre,
        description,
        priorite,
        date,
        duree,
        etat
    };

    // 4. Sauvegarde
    let listeTaches = getTaches();
    listeTaches.push(nouvelleTache);
    setTaches(listeTaches);

    // 5. Redirection
    window.location.href = "Slowrush.html";
}
function getTaches() {
    let tachesExistantes = localStorage.getItem('taches');
    let listeTaches = tachesExistantes ? JSON.parse(tachesExistantes) : [];
    if (!Array.isArray(listeTaches)) listeTaches = [];
    return listeTaches;
}

function setTaches(liste) {
    localStorage.setItem('taches', JSON.stringify(liste));
}

function validerNouvelleTache(event) {
    if (event) event.preventDefault(); 

    // 1. Récupération des valeurs
    let titre = document.getElementById('titre').value.trim();
    let description = document.getElementById('des').value.trim();
    let priorite = document.getElementById('priorite').value;
    let date = document.getElementById('date').value;
    let duree = +document.getElementById('jour').value.trim();
    let etat = document.getElementById('etat').value;

    // 2. Vérifications
    if (titre === "") { alert("Le champ 'TITRE' est vide."); return; }
    if (description === "") { alert("Le champ 'DESCRIPTION' est vide."); return; }
    if (priorite === "Veuillez choisir une Grandeur de priorité pour cette tache") { alert("Veuillez choisir une priorité valide."); return; }
    if (date === "") { alert("Le champ 'DATE' est vide."); return; }
    if (isNaN(duree) || duree <= 0) { alert("Le champ 'DURÉE' doit contenir un nombre valide."); return; }

    console.log("Données prêtes :", { titre, description, priorite, date, duree, etat });

    // 3. Création de l'objet tâche
    let nouvelleTache = {
        id: Date.now(),
        titre,
        description,
        priorite,
        date,
        duree,
        etat
    };

    // 4. Sauvegarde
    let listeTaches = getTaches();
    listeTaches.push(nouvelleTache);
    setTaches(listeTaches);

    // 5. Redirection
    window.location.href = "Slowrush.html";
}
