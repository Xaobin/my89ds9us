<script>
    export default {
        props: ['stll', 'title', 'details'],
        computed: {
            estilo() {
                return 'alert alert-'+this.stll
            }
        }
    }
</script>

<template>
    <div :class="estilo" role="alert">
        {{title}}
        <hr>
        <!--span v-if="details.data.msg">{{details.data.msg}}</span>
        <span v-if="details.data.id">{{'Register ID: ' + details.data.id}}</span -->
         <span v-if="details.msg">{{details.msg}}</span>
        <!--span v-if="details.data.id">{{'Register ID: ' + details.data.id}}</span -->
        <span v-if="details.data">-- {{details.data}} --</span>
        <br>
        <ul v-if="details.dbdatas"> 
        <li v-for="e, key in details.dbdatas" :key="key">{{ e[0] }}</li>
        </ul>
    </div>
</template>


