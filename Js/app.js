import TabContacts from "/js/ContactDonnées.js"
import * as d3 from "https://cdn.jsdelivr.net/npm/d3@7/+esm";


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
        if (info.id.replace("reg-", "") === elmt.id)
            ajouterContenu(elmt);
    }
}

/**
 *
 * @param {objet} donnee
 */

const width = window.innerWidth;
const height = window.innerHeight;


function creation(type, contenu, Class) {
    let newElmt = document.createElement(type)
    if (Class !== undefined)
        newElmt.classList.add(Class)
    if (contenu !== undefined)
        newElmt.innerHTML = contenu
    return newElmt
}

function ajouterContenu(donnee){
    let v = creation("h1", donnee.region, "h-map")
    v.style.textAlign = "left"
    const list = document.querySelector(".list-region")
    console.log(list)
    list.append(v)
    v = creation("h1", "Contacter :", "h-map")
    v.style.textAlign = "left"
    v.style.marginBottom ="2%"
    v.style.fontSize ="1.4em"
    list.append(v)
    list.append(creation("ul"))
    if (donnee.contacts !== undefined){
        for (const info of donnee.contacts){
            Object.keys(info).forEach(key => {
                list.querySelector("ul").append(creation("li", info[key], "s-contact"))
            })
        }
    }
    else {
        list.querySelector("ul").append(creation("li", donnee.name, "s-contact"))
        list.querySelector("ul").append(creation("li", donnee.email, "s-contact"))
        list.querySelector("ul").append(creation("li", donnee.mobile, "s-contact"))
    }
}

paths.forEach( (path) => {
    path.addEventListener('click', function()  {
        document.querySelector(".list-region").innerHTML = "";
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








