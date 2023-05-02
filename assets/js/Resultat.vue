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
                    <td>
                        <p>{{ index + 1 }}</p>
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
    </div>
</template>
<script>
export default{
    data() {
        return {
            lesCoureurs : null,
            courseId : null,
            hiddenTime : [],
            userId : null
        }
    },
    methods: {
        majClassement() {

        },
        miseajour() {
            fetch('/api/lesCoureurs/' + this.courseId)
                .then(response => response.json())
                .then(data => { this.lesCoureurs = data; })
        },
        changementTemps(idResCourse, newTime = null) {
            if(!this.hiddenTime.includes(idResCourse)){
                this.hiddenTime.push(idResCourse);
            }
            else{
                this.hiddenTime.splice(this.hiddenTime.indexOf(idResCourse), 1);
                if(newTime != null && newTime != ''){
                    fetch('/api/tempsCoureur/' + idResCourse + '/temps/' + newTime)
                        .then(response => response.json())
                }
                this.majClassement();
            }
        }
    },
    created() {
        const appElement = document.getElementById('result-course')
        const dataString = appElement.getAttribute('data')
        this.courseId = dataString
        const userString = appElement.dataset.user
        this.userId = JSON.parse(userString)
        this.miseajour()
        setInterval(() => {
            this.miseajour();
        }, 10000)
    },
}
</script>