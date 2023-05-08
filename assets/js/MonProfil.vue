<template>
    <div class="container"> 
        <center><h1> Mes informations : </h1></center>
        <div class="container">
            <p>Nom :</p>
                <p v-if="test" @ondblclick="changementNom()">{{ unUser.nom }}</p>
                <p v-else><input type="text"></p>
                <br>
            <p>Prénom :</p>
                <p>{{ unUser.prenom }}</p>
                <br>
            <p>Pseudo :</p>
                <p>{{ unUser.pseudo }}</p>
                <br>
            <p>Adresse :</p>
                <p>{{ unUser.adresse }}</p>
                <br>
            <p>Email :</p>
                <p>{{ unUser.email }}</p>
                <br>
</div>
    </div>
</template>

<script> 
export default {
    data() {
        return{
            userId: null,
            unUser: null,
            test: true
        }
    },
    created() {
        const appElement = document.getElementById('mon-profil')
        const userString = appElement.dataset.user
        this.userId = JSON.parse(userString)
        fetch("/api/userProfil/" + this.userId)
            .then(response => response.json())
            .then(data => {this.unUser = data})
        console.log(this.unUser)
    },
    methods: {
        changementNom() {
            this.test =false;
        }
    }
}

   
</script>