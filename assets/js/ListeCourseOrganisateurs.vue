<template>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>
                        <p>Nom</p>
                    </th>
                    <th>
                        <p>Date</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="c in lesCourses" @mouseenter="selectCourse(c.id)" @mouseleave="switchCourse()" >
                    <th>
                        <p>{{ c.nomCourse }}</p>
                    </th>
                    <th>
                        <p>{{ c.dateCourse }}</p>
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
            lesCourses : null,
            userId : null,
            hoverTimeoutId : null,
            courseId : null,
            url : null
        }
    },
    created() {
    const appElement = document.getElementById('liste-course-organisee')
    const userString = appElement.dataset.user
    this.userId = JSON.parse(userString)
  
    fetch('/api/coursesOrganisees/' + this.userId)
        .then(response => response.json())
        .then(data => {
        this.lesCourses = data;
        });
    },
    methods: {
        selectCourse(idCourse){
            this.courseId = idCourse;
            this.hoverTimeoutId = setTimeout(this.consoleTest, 3000);
        },
        switchCourse(){
            clearTimeout(this.hoverTimeoutId);
            this.hoverTimeoutId = null;
        },
        consoleTest(){
            window.location.href = '/api/coursesOrganisees/' + this.userId + '/course/' + this.courseId;
        }
    }
}
</script>
<style>

tbody th:hover{
    animation-name: number_cursor;
    animation-duration: 4s;
}

@keyframes number_cursor {
    0% {
        cursor: url('../images/chiffre-3-removebg-preview.png') 50 20, wait;
        
    }
    33% {
        cursor: url('../images/chiffre-2-removebg-preview.png') 50 20, wait;
    }
    34% {
        cursor: url('../images/chiffre-1-removebg-preview.png') 50 20, wait;
    }
    100% {
        cursor: url('../images/chiffre-1-removebg-preview.png') 50 20, wait;
        
    }
}
</style>