let chaine = window.prompt("Entrez une chaîne a inverser :");

let inverse = "";

for (let i = chaine.length - 1; i >= 0; i--) {
    inverse += chaine[i];
}

document.write("La chaîne inversée est : " + inverse);