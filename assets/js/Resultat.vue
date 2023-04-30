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
                    <td v-for="i in lesCoureurs.length" :key="i">
                        <p>{{ i }}</p>
                    </td>
                    <td>
                        <p>{{ c.coureur }}</p>
                    </td>
                    <td>
                        <p v-if="hiddenTime==false" @dblclick="changementTemps()">{{ c.temps }}</p>
                        <p v-else><input placeholder="__:__:__" v-model="text" @keypress.enter="changementTemps(text, c.id)" type="text"></p>
                    </td>
                    <td>
                        <p>{{ c.moyenne }} km/h</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import Draggable from 'draggable';
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
            fetch('/api/lesCoureurs/' + this.courseId)
                .then(response => response.json())
                .then(data => { this.lesCoureurs = data; })
        },
        changementTemps(newTime = null, idResCourse= null) {
            if(this.hiddenTime == false){
                this.hiddenTime = true;
            }
            else{
                this.hiddenTime = false;
                if(newTime != null && newTime != ''){
                    fetch('/api/tempsCoureur/' + idResCourse + '/temps/' + newTime)
                        .then(response => response.json())
                }
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
    //mounted() {
    //    const sortable = new Draggable.Sortable(this.$el.querySelector('tbody'), {
    //        draggable: 'tr',
    //        delay: 200,
    //        animation: 150
    //    })
    //}

}
</script>