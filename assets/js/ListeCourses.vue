<template>
    <div class="container"> 
        <div class="panel panel-primary">
            <div class="panel-heading"><h2>Les Courses</h2></div>  
            <div style="max-height: 300px; overflow: auto">
                <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th v-for="intitule in lesIntitules.slice(0, sliceValue)"> {{ intitule.lab }} 
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
                        <td v-if="this.lesIntitules[6].visible==true">{{ laCourse.nomCourse }}</td>
                        <div v-else class="dropdown" @mouseover="showDropdown = true" @mouseleave="showDropdown = false">
                          <a>{{ laCourse.nomCourse }}</a>
                          <div class="dropdown-menu" v-if="showDropdown">
                            <p>Classement : {{ laCourse.position }} </p>
                            <p>Moyenne : {{ laCourse.moyenne.toFixed(2) }} km/h </p>
                            <p>Temps : {{ laCourse.temps }}</p>
                            <p>test12</p>
                          </div>
                        </div>
                        <td>{{ laCourse.dateCourse }}</td>
                        <td>{{ laCourse.distanceCourse }}</td>
                        <td>{{ laCourse.prixCourse }} €</td>
                        <td>{{ laCourse.typeCourse }}</td>
                        <td>{{ laCourse.niveauCourse }}</td>
                        <td v-if="this.lesIntitules[6].visible==true">
                            <button :disabled="coursesInscrites.indexOf(laCourse.id) !== -1 || leUser.estOrganisateur"
                            :class="{'disabled-button': coursesInscrites.indexOf(laCourse.id) !== -1}" v-on:click="inscription(laCourse.id)">
                                <span v-if="coursesInscrites.indexOf(laCourse.id) !== -1">Validée</span>
                                <span v-else>S'inscrire</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
          </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            dataString : null,
            userId : null,
            leUser : null,
            showDropdown : false,
            sliceValue : null,
            lesCourses : null,
            lesIntitules : [ {lab:'Nom', classe:' ', order:0, sort:'nomCourse', id:0, visible:true},
            { lab:'Date', classe:' ', order:0, sort:'dateCourse', id:1, visible:true},
            { lab:'Distance', classe:' ', order:0, sort:'distanceCourse', id:2, visible:true},
            { lab:'Prix', classe:' ', order:0, sort:'prixCourse', id:3, visible:true},
            { lab:'Type', classe:' ', order:0, sort:'typeCourse', id:4, visible:true},
            { lab:'Niveau', classe:' ', order:0, sort:'niveauCourse', id:5, visible:true},
            { lab:'Inscription', classe:' ', order:0, sort:'niveauCourse', id:6, visible:true} ],
            coursesInscrites : []
        }
    },
    methods: {
        inscription(indexCourse) {
            fetch("/api/inscription/" + this.userId + "/" + indexCourse, {'method':'GET'})
            .then(response => response.json())
            .then(data => {
                this.coursesInscrites.push(indexCourse);
            })
            
        },
        action(index) {
            const intitule = this.lesIntitules[index];
            this.lesIntitules.forEach((item, i) => {
                if (i !== index) {
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
            fetch('/api/lesCourses/' + this.dataString + "/" + this.userId)
            .then(response => response.json())
            .then(data => {
                this.lesCourses = data;
            })
        }
    },
    created() {
        const appElement = document.getElementById('liste-course')
        const dataString = appElement.getAttribute('data')
        this.dataString = dataString
        if(dataString == '1'){
          this.lesIntitules[6].visible = false
          this.sliceValue = 6
        }
        else{
          this.lesIntitules[6].visible = true
          this.sliceValue = 7
        }
        const userString = appElement.dataset.user
        this.userId = JSON.parse(userString)
        fetch('/api/user/' + this.userId)
          .then(response => response.json())
          .then(leUser => this.leUser = leUser)
        fetch("/api/lesCourses/participe/" + this.userId, {'method':'GET'})
        .then(response => response.json())
        .then(lesCoursesParticipeesID => {
            lesCoursesParticipeesID.forEach(laCourse => {
                this.coursesInscrites.push(laCourse.lesCoursesParticipees)
            });
        })
        this.miseajour()
        setInterval(() => {
            this.miseajour();
        }, 10000)
    }
}
</script>

<style>
.price-filter {
  display: flex;
  align-items: center;
  margin-bottom: 16px;
}

.price-filter label {
  margin-right: 16px;
}

.price-value {
  display: flex;
  justify-content: space-between;
  margin-left: 16px;
}

.price-value span {
  font-size: 12px;
  font-weight: bold;
}

input[type=range] {
  width: 100%;
  height: 10px;
  border-radius: 5px;
  background-color: #ccc;
  outline: none;
}

input[type=range]:focus {
  outline: none;
}

input[type=range]::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background-color: #4CAF50;
  cursor: pointer;
}

input[type=range]::-moz-range-thumb {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background-color: #4CAF50;
  cursor: pointer;
}

/* Style de base pour la checkbox */
input[type="checkbox"] {
  position: relative;
  width: 20px;
  height: 20px;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  outline: none;
  border: 2px solid #aaa;
  border-radius: 4px;
  cursor: pointer;
}

/* Style pour la checkbox cochée */
input[type="checkbox"]:checked::before {
  content: "\2714";
  position: absolute;
  font-size: 18px;
  color: #fff;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
/* Style de base pour la flèche du menu déroulant */
.filter-arrow {
  position: relative;
  display: inline-block;
  width: 20px;
  height: 20px;
  cursor: pointer;
}


.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1000;
  display: none;
  float: left;
  min-width: 72.5rem;
  padding: 0.5rem 0;
  margin: 0.5rem 0 0;
  font-size: 1rem;
  color: #212529;
  text-align: left;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid rgba(0,0,0,0.15);
  border-radius: 0.25rem;
}

.dropdown:hover .dropdown-menu {
  display: block;
}


/* Style pour la checkbox non cochée */
input[type="checkbox"]::before {
  content: "";
  position: absolute;
  width: 16px;
  height: 16px;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: transparent;
  border: none;
}

/* Style pour la checkbox quand elle est désactivée */
input[type="checkbox"]:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* Style pour la bordure de la checkbox */
input[type="checkbox"] + label {
  display: inline-block;
  margin-left: 8px;
  vertical-align: middle;
}
.filter {
  position: relative;
  background-color: #034892;
  color: white;
}

.dropbtn {
  font-size: 16px;
  border: none;
  outline: none;
  background-color: transparent;
  cursor: pointer;
}
/* Style pour le carré du menu déroulant */
.dropdown-content {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 9999;
  display: none;
  padding: 8px;
  border: 1px solid #ccc;
  background-color: #fff;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

/* Style pour afficher le menu déroulant au clic */
.dropdown-content.is-open {
  display: block;
}

/* Style pour le carré du menu déroulant au survol */
.dropdown-content:hover {
  border-radius: 8px;
}
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #034892;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  z-index: 1;
  padding: 8px;
  top: 20px;
  left: 0;
}

.dropdown-content label {
  display: block;
  margin-bottom: 8px;
}

.dropdown-content input[type="checkbox"] {
  margin-right: 8px;
}

.dropdown:hover .dropdown-content {
  display: block;
}

.dropdown:hover .dropbtn {
  color: #000000;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

/* Table styles */
table {
  width: 100%;
  border-collapse: collapse;
  /*max-height: 200px;
  overflow-y: scroll;*/
}

thead {
  background-color: #034892;
  color: white;
}

th, td {
  padding: 12px;
  text-align: left;
  border: 1px solid #dee2e6;
}

th a {
  color: white;
}

th a:hover {
  color: #cfe2ff;
}

tbody tr:nth-child(even) {
  background-color: #f2f2f2;
}

/* Button styles */
button {
  background-color: #034892;
  color: white;
  padding: 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: all 0.3s ease-in-out;
}

button:hover {
  background-color: #011f3e;
}

button.disabled-button {
  background-color: #90EE90;
  cursor: none;
  border-radius: 5px;
  border: 2px solid #5CC8B2;
  padding: 5px 10px;
  transition: all 0.3s ease-in-out;
}

button.disabled-button:hover {
  transform: translateY(-2px);
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

/* Heading styles */
h2 {
  text-align: center;
  font-size: 36px;
  margin-bottom: 30px;
}

.panel-heading {
  background-color: #034892;
  color: white;
  padding: 20px;
  border-radius: 5px 5px 0 0;
}

.panel {
  border-radius: 5px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}
</style>