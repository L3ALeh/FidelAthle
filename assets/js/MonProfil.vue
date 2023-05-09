<template>
    <div class="container"> 
        <center><h1> Mes informations : </h1></center>
        <center><h3><b> {{ unUser.nom }} {{ unUser.prenom }}</b></h3></center>
        <p v-if="pseudoVisible" @dblclick="changementPseudo()"><b>Pseudonyme :</b> {{ unUser.pseudo }}</p>
        <p v-else><b>Pseudonyme :</b> <input type="text" v-model="valeurTexte" :placeholder="unUser.pseudo" @keypress.enter="changementPseudo(valeurTexte)"></p>
        <p v-if="adresseVisible" @dblclick="changementAdresse()"><b>Adresse :</b> {{ unUser.adresse }}</p>
        <p v-else><b>Adresse :</b> <input type="text" v-model="valeurTexte" :placeholder="unUser.adresse" @keypress.enter="changementAdresse(valeurTexte)"></p>
        <p v-if="emailVisible" @dblclick="changementEmail()"><b>Email :</b> {{ unUser.email }}</p>
        <p v-else><b>Email :</b> <input type="text" v-model="valeurTexte" :placeholder="unUser.email" @keypress.enter="changementEmail(valeurTexte)"></p>
        <center><button @click="ouvrirExplorateur">Ajouter un fichier</button></center>
        <input type="file" ref="fichier" style="display:none" @change="ajouterFichier"/>
        <center><button @click="valider()">Valider</button></center>
    </div>
</template>
<script> 
export default {
    data() {
        return{
            userId: null,
            unUser: [],
            pseudoVisible: true,
            adresseVisible: true,
            emailVisible: true,
            fichier: null
        }
    },
    created() {
        const appElement = document.getElementById('mon-profil')
        const userString = appElement.dataset.user
        this.userId = JSON.parse(userString)
        this.miseajour()
        setInterval(() => {
            this.miseajour()
        }, 3000);
    },
    methods: {
        valider() {
            fetch('/api/certificatMedical/' + this.fichier + '/' + this.userId)
                .then(response => response.json())
        },
        ouvrirExplorateur() {
            this.$refs.fichier.click()
        },
        ajouterFichier(event) {
            const fichier = event.target.files[0];
            console.log(fichier)
            this.fichier = fichier
        },
        miseajour() {
            fetch("/api/userProfil/" + this.userId)
                .then(response => response.json())
                .then(data => {this.unUser = data})
        },
        changementPseudo(texte = null) {
            this.pseudoVisible = !this.pseudoVisible
            console.log(this.pseudoVisible)
            if(texte != "" && texte != null) {
                if(this.pseudoVisible) {
                fetch('/api/changementValeur/pseudo/' + texte + '/' + this.userId)
                    .then(response => response.json())
                }
            }
        },
        changementAdresse(texte = null) {
            this.adresseVisible = !this.adresseVisible
            if(texte != "" && texte != null) {
                if(this.adresseVisible) {
                    fetch('/api/changementValeur/adresse/' + texte + '/' + this.userId)
                        .then(response => response.json())
                }
            }
        },
        changementEmail(texte = null) {
            this.emailVisible = !this.emailVisible
            if(texte != "" && texte != null) {
                if(this.adresseVisible) {
                    fetch('/api/changementValeur/email/' + texte + '/' + this.userId)
                        .then(response => response.json())
                }
            }
        }
    }
}
</script>