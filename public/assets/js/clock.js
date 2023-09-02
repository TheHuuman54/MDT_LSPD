function updateClock() {
    const now = new Date();

    // Heure
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const timeString = `${hours}:${minutes}:${seconds}`;
    document.getElementById('clock').textContent = timeString;

    // Date
    const day = String(now.getDate()).padStart(2, '0');
    const month = String(now.getMonth() + 1).padStart(2, '0'); // Les mois commencent à 0 (janvier = 0)
    const year = now.getFullYear();
    const dateString = `${day}/${month}/${year}`;
    document.getElementById('date').textContent = dateString;
}

// Mettre à jour l'horloge toutes les secondes
setInterval(updateClock, 1000);