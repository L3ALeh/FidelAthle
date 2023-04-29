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
                <tr v-for="(c, index) in lesCoureurs">
                    <th v-for="i in len(lesCoureurs)" :key="i">
                        <p>{{ i }}</p>
                    </th>
                    <th>
                        <p>{{ c.coureur }}</p>
                    </th>
                    <th>
                        <p v-if="hiddenTime=false" @ondblclick="changementTemps()">{{ c.temps }}</p>
                        <p v-else><input placeholder="__:__:__" v-model="text" @keypress.enter="changementTemps(text, c.id)" type="text"></p>
                    </th>
                    <th>
                        <p>{{ c.moyenne }} km/h</p>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default{
    data() {
        return {
            lesCoureurs : null,
            courseId : null,
            hiddenTime : false,
            userId : null
        }
    },
    methods: {
        miseajour() {
            fetch('/api/lesCoureurs/', this.courseId)
                .then(response => response.json())
                .then(data => { this.lesCoureurs = data; })
        },
        changementTemps(newTime = null, idCoureur = null) {
            if(this.hiddenTime == false){
                this.hiddenTime = true;
            }
            else{
                this.hiddenTime = false;
                if(newTime != null && newTime != ''){
                    fetch('/api/tempsCoureur/' + idCoureur + '/temps/' + newTime + '/course/' + this.courseId)
                        .then(response => response.json())
                }
            }
            
        }
    },
    created() {
        const appElement = document.getElementById('liste-course')
        const dataString = appElement.getAttribute('data')
        this.courseId = dataString
        const userString = appElement.dataset.user
        this.userId = JSON.parse(userString)
        this.miseajour()
        setInterval(() => {
            this.miseajour();
        }, 10000)
    }

}
</script>