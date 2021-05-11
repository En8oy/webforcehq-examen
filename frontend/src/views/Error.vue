<template>
    <div class=pa-10>
        <h1 class="mt-15 text-center">Page Not Found</h1>
        <error></error>
        <div class="text-center">
            <router-link to="/" >
                <v-btn
                    :color="$store.state.color"
                    dark
                    x-large
                >
                    Home
                </v-btn>
            </router-link>
        </div>
    </div>
</template>
<script>
import Error from '../components/Error'
export default {
    components : {
        Error
    }
    
}
</script>