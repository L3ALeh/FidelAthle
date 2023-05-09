<template>
    <div class="container"> 
        <p> Vos points : {{ totalPoints }}</p>
        <div class="panel panel-primary">
            <div class="panel-heading"><h2>Les Récompenses</h2></div>        
                <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th v-for="intitule in lesIntitules"> {{ intitule.lab }}
                            <a href="#" v-on:click="action(intitule.id)">
                                <span v-if="intitule.order === 0" class="fa fa-fw fa-sort"></span>
                                <span v-else-if="intitule.order === 1" class="fa fa-fw fa-sort-up sort-asc"></span>
                                <span v-else class="fa fa-fw fa-sort-down sort-desc"></span>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="laRecompense in lesRecompenses"> 
                        <td>{{ laRecompense.label }}</td>
                        <td>{{ laRecompense.valeur }} €</td>
                        <td>{{ laRecompense.valeurPoints }}</td>
                        <td>
                            <button v-if="totalPoints >= laRecompense.valeurPoints" @mouseover="recompenseImage(laRecompense.image, laRecompense.label)" @click="() => { TogglePopup('buttonTrigger'); ajoutRecompense(laRecompense.id) }">Obtenir</button>
                            <button v-else disabled>Pas assez de points</button>
                            <Popup v-if="popupTriggers.buttonTrigger" :imageRec="recImage" :label="label" :TogglePopup="() => TogglePopup('buttonTrigger')">
                            </Popup>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'
import Popup from './components/popup.vue'
export default {
    components: {
        Popup,
    },
    setup () {
        const popupTriggers = ref({
            buttonTrigger: false
        });
        const TogglePopup = (trigger) => {
            popupTriggers.value[trigger] = !popupTriggers.value[trigger]
        }
        return {
            popupTriggers,
            TogglePopup
        }
    },
    data() {
        return {
            userId : null,
            totalPoints : null,
            lesRecompenses : null,
            recImage: null,
            label: null,
            srcRoute: String,
            lesIntitules : [ {lab:'Label', classe:' ', order:0, sort:'Label', id:0},
            { lab:'Valeur', classe:' ', order:0, sort:'Prix', id:1},
            {lab:'Valeur Points', classe:' ', order:0,sort:'Valeur', id:2}, 
            {lab:'Obtenir', classe:' ', order:0,sort:'Valeur', id:3}]
        }
    },
    methods: {
        ajoutRecompense(idRecompense) {
            fetch('/api/ajoutRecompense/' + idRecompense + '/' +this.userId)
                .then(response => response.json())
        },
        recompenseImage(rec, lab) {
            this.label = lab
            this.recImage = rec
        },
        miseajour() {
            fetch('/api/lesRecompenses')
                .then(response => response.json())
                .then(data => { this.lesRecompenses = data; })
            fetch('/api/recuppoints/' + this.userId)
                .then(response => response.json())
                .then( lesPoints => this.totalPoints = lesPoints)
        }
    },
    created() {
        const appElement = document.getElementById('liste-recompenses')
        const userString = appElement.dataset.user
        this.userId = JSON.parse(userString)

        this.miseajour()
        setInterval(() => {
            this.miseajour();
        }, 10000)
    }
}
</script>

<style>
button:disabled:hover{
    cursor: not-allowed;
}
</style>