<template>
    <div class="container"> 
        <div class="panel panel-primary">
            <div class="panel-heading"><h2>Les Courses</h2></div>        
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
                    <tr v-for="laCourse in lesCourses"> 
                        <td>{{ laCourse.nomCourse }}</td>
                        <td>{{ laCourse.dateCourse }}</td>
                        <td>{{ laCourse.distanceCourse }}</td>
                        <td>{{ laCourse.prixCourse }}</td>
                        <td>{{ laCourse.typeCourse }}</td>
                        <td>{{ laCourse.niveauCourse }}</td>
                        <td><button>S'inscrire</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            lesCourses : null,
            lesIntitules : [ {lab:'Nom', classe:' ', order:0, sort:'nomCourse', id:0},
            { lab:'Date', classe:' ', order:0, sort:'dateCourse', id:1},
            { lab:'Distance', classe:' ', order:0, sort:'distanceCourse', id:2},
            { lab:'Prix', classe:' ', order:0, sort:'prixCourse', id:3},
            { lab:'Type', classe:' ', order:0, sort:'typeCourse', id:4},
            { lab:'Niveau', classe:' ', order:0, sort:'niveauCourse', id:5},
            { lab:'Inscription', classe:' ', order:0, sort:'niveauCourse', id:6} ],
        }
    },
    methods: {
        action(index) {
            const intitule = this.lesIntitules[index];
            this.lesIntitules.forEach((item, i) => {
                if (i !== index) {
                    console.log(index)
                    item.classe = '';
                    item.order = 0;
                }
            });

            if (intitule.order === 0) {
                intitule.classe = 'fa-sort-up';
                intitule.order = 1;
            } else if (intitule.order === 1) {
                intitule.classe = 'fa-sort-down';
                intitule.order = -1;
            } else if (intitule.order === -1) {
                intitule.classe = '';
                intitule.order = 0;
            }

            this.sortKey = intitule.sort;
            this.orderKey = intitule.order;

            this.lesCourses.sort((a, b) => {
                const valA = a[this.sortKey];
                const valB = b[this.sortKey];
                if (valA < valB) {
                    return -1 * this.orderKey;
                }
                if (valA > valB) {
                    return 1 * this.orderKey;
                }
                return 0;
            }); 
        },
        miseajour() {
            fetch('/api/lesCourses')
            .then(response => response.json())
            .then(data => {
                this.lesCourses = data;
            })
        }
    },
    created() {
        this.miseajour()
        setInterval(() => {
            this.miseajour();
        }, 10000)
    }
}
</script>

<style>
td{
    padding-left: 1em;
    padding-right: 1em;
    padding-bottom: 1em;
}
th{
    padding-left: 1em;
    padding-right: 1em;
}
h2{
    text-align: center;
}
</style>