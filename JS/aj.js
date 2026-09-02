function validerNouvelleTache(event) {
    if (event) event.preventDefault();

    // 1. Récupération des valeurs
    const titre = document.getElementById('titre').value.trim();
    const description = document.getElementById('des').value.trim();
    const priorite = document.getElementById('priorite').value.trim();
    const date = document.getElementById('date').value;
    const duree = +document.getElementById('jour').value.trim();
    const etat = document.getElementById('etat').value;

    // 2. Vérifications
    if (titre === "") { alert("Le champ 'TITRE' est vide."); return; }
    if (description === "") { alert("Le champ 'DESCRIPTION' est vide."); return; }
    if (priorite === "") {
        alert("Veuillez choisir une priorité valide.");
        return;
    }
    if (date === "") { alert("Le champ 'DATE' est vide."); return; }
    if (isNaN(duree) || duree <= 0) {
        alert("Le champ 'DURÉE' doit contenir un nombre valide supérieur à 0.");
        return;
    }
    if (!etat) { alert("Veuillez choisir un état."); return; }

    // 3. Tout est valide -> on soumet réellement le formulaire vers ../PHP/db.php
    event.target.form.submit();
}
