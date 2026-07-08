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
    if (priorite === "Veuillez choisir une Grandeur de priorité pour cette tache") {
        alert("Veuillez choisir une priorité valide.");
        return;
    }
    if (date === "") { alert("Le champ 'DATE' est vide."); return; }
    if (isNaN(duree) || duree <= 0) {
        alert("Le champ 'DURÉE' doit contenir un nombre valide.");
        return;
    }

    event.target.form.submit();
}