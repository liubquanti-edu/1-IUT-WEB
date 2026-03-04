let mot = window.prompt("Donner lr mot que vous voulez tester :");

let result;

if (mot.endsWith("s")) {
    result = true;
} else {
    result = false;
}

if (result == true) {
    document.write(mot + " est un mot pluriel");
} else {
    document.write(mot + " est un mot singulier");
}