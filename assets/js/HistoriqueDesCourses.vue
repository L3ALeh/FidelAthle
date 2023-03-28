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
                        <td>
                            <button> Voir Résultat </button>
                        </td>
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
            userId : null,
            lesCourses : null,
            lesIntitules : [ {lab:'Nom', classe:' ', order:0, sort:'nomCourse', id:0},
            { lab:'Date', classe:' ', order:0, sort:'dateCourse', id:1},
            { lab:'Distance', classe:' ', order:0, sort:'distanceCourse', id:2},
            { lab:'Prix', classe:' ', order:0, sort:'prixCourse', id:3},
            { lab:'Type', classe:' ', order:0, sort:'typeCourse', id:4},
            { lab:'Niveau', classe:' ', order:0, sort:'niveauCourse', id:5},
            { lab:'Inscription', classe:' ', order:0, sort:'niveauCourse', id:6} ],
            coursesInscrites : []
        }
    }
}
</script>