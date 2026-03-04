let premiere = window.prompt("Entrez un nombre :");
let deuxieme = window.prompt("Entrez un nombre :");

let resultat;

if (premiere == deuxieme) {
    resultat = true;
} else {
    resultat = false;
}

document.write(premiere + " et " + deuxieme + " de meme type? " + resultat);