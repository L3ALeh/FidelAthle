<template>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>
                        <p>Classement</p>
                    </th>
                    <th>
                        <p>Coureur</p>
                    </th>
                    <th>
                        <p>Temps</p>
                    </th>
                    <th>
                        <p>Moyenne</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="c in lesCoureurs">
                    <td>
                        <p>{{ c.classement }}</p>
                    </td>
                    <td>
                        <p>{{ c.coureur }}</p>
                    </td>
                    <td>
                        <p v-if="hiddenTime.indexOf(c.id) === -1" @dblclick="changementTemps(c.id)">{{ c.temps }}</p>
                        <p v-else><input placeholder="__:__:__" v-model="text" @keypress.enter="changementTemps(c.id, text)" type="text"></p>
                    </td>
                    <td>
                        <p>{{ parseFloat(c.moyenne).toFixed(2) }} km/h</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <button :disabled="disable" style="height: 50px; margin-top: 20px; position:relative ;top:80%; left:40%;" @click="onOk()">Valider les résultats définitivement</button> 
        <ConfirmDialog></ConfirmDialog>
        <DialogWrapper />
    </div>
</template>
<script>
import { DialogWrapper } from 'vue3-promise-dialog';
export default{
    data() {
        return {
            DialogWrapper,
            lesCoureurs : [],
            courseId : null,
            hiddenTime : [],
            userId : null,
            disable : false,
            laCourse : null,
            lesPoints : [],
        }
    },
    methods: {
        async onOk() {
            this.lesCoureurs.forEach(unCoureur => {
                this.disable = unCoureur.definitif
            });
            if(!this.disable) {
                let ok = await confirm("Etes vous-sur de faire ça ?")
                var array = []
                var points = 0
                if(ok) {
                    this.lesCoureurs.forEach(unCoureur => {
                        array.push(true)
                        if(unCoureur.classement == 1) {
                            points += 10
                        }
                        else if(unCoureur.classement <= 5) {
                            points += 5
                        }
                        else if(unCoureur.classement <= 10) {
                            points += 3
                        }
                        else {
                            points += 1
                        }
                        if(this.laCourse.niveau == 1) {
                            points = points * 4
                        }
                        else if(this.laCourse.niveau == 2) {
                            points = points * 3
                        }
                        else if(this.laCourse.niveau == 3) {
                            points = points * 2
                        }
                        else {
                            points = points * 1.5
                        }
                        this.lesPoints.push(points)
                        points = 0
                    });
                    this.disable = true
                    fetch('/api/post/coureurs/' + array + '/course/' + this.courseId + '/definitif')
                        .then(response => response.json());
                    fetch('/api/ajoutPoint/' + this.lesPoints +'/course/' + this.courseId)
                        .then(response => response.json());
                }
            }
        },
        majClassement() {
            var compteur = 1
            var array = []
            this.lesCoureurs.forEach(element => {
                element.classement = compteur;
                array.push(element.classement);
                compteur += 1;
            });
            fetch('/api/post/coureurs/' + array + '/course/' + this.courseId + '/position')
                .then(response => response.json());
        },
        changementTemps(idResCourse, newTime = null) {
            this.lesCoureurs.forEach(unCoureur => {
                this.disable = unCoureur.definitif;
            });
            let date = new Date()
            let year = date.getFullYear()
            let month = (date.getMonth() + 1).toString().padStart(2, '0')
            let day = date.getDate().toString().padStart(2, '0')
            let formattedDate = `${year}-${month}-${day}`
            if(this.laCourse.date.date < formattedDate)
            {
                if(!this.disable){
                    if(!this.hiddenTime.includes(idResCourse)){
                        this.hiddenTime.push(idResCourse);
                    }
                    else{
                        this.hiddenTime.splice(this.hiddenTime.indexOf(idResCourse), 1);
                        if(newTime != null && newTime != ''){
                            fetch('/api/tempsCoureur/' + idResCourse + '/temps/' + newTime)
                                .then(response => response.json())
                        }
                        this.miseajour();
                        this.majClassement();
                    }
                }                   
            }
        },
        miseajour(){
            fetch('/api/lesCoureurs/' + this.courseId)
                .then(response => response.json())
                .then(data => { this.lesCoureurs = data;})
        }
    },
    created() {
        const appElement = document.getElementById('result-course')
        const dataString = appElement.getAttribute('data')
        this.courseId = dataString
        const userString = appElement.dataset.user
        this.userId = JSON.parse(userString)
        fetch('/api/get/course/' + this.courseId)
            .then(response => response.json())
            .then(data => { this.laCourse = data; })
        this.miseajour();
        setInterval(() => {
            this.miseajour();
        }, 2000)
    },
}
</script>