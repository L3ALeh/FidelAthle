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
                <tr>
                    <th>
                        
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
            courseId : null
        }
    },
    methods: {
        miseajour() {
            fetch('/api/lesCoureurs/', this.courseId)
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