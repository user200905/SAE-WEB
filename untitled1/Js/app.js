import TabContacts from "/js/ContactDonnées.js"


const navbar = document.getElementById('navbar');

// Fonction pour ajouter une classe 'scrolled' après défilement
window.onscroll = () => {
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
};

let map  = document.querySelector("#map")
let paths  = document.querySelectorAll(".map-- a")

let actives = function(id) {
    map.querySelectorAll(".active").forEach((obj) => {
        obj.classList.remove("active")
    })
    document.getElementById("reg-"+id).classList.add("active");
}

function findDonnees(){
    const info = map.querySelector(".active")
    for (const elmt of TabContacts){
        console.log(elmt);
        if (info.id.replace("reg-", "") === elmt.id)
            ajouterContenu(elmt);
    }
}

/**
 *
 * @param {objet} donnee
 */

function creation(type, contenu, Class) {
    let newElmt = document.createElement(type)
    if (!Class)
        newElmt.classList.add("h-map")
    newElmt.innerHTML = contenu
    return newElmt
}

function ajouterContenu(donnee){
    let v = creation("h1", donnee.region, "h-map")
    const list = document.querySelector(".list-region")
    list.append(v)
    list.append(creation("h1", "Contacter", "h-map"))
    document.querySelector("#contact").append(document.createElement("h1"))
    document.querySelector("#contact").append(document.createElement("ul"))
}

paths.forEach( (path) => {
    path.addEventListener('click', function()  {
        document.querySelector("#contact").innerHTML = "";
        findDonnees()
    })
})
paths.forEach( (path) => {
    path.addEventListener('mouseenter', function()  {
        actives(this.id.replace("reg-", ""));
    })
})

map.addEventListener("mouseover", () => {
    map.querySelectorAll(".active").forEach((obj) => {
        obj.classList.remove("active")
    })
})








