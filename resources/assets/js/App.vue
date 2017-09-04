<template>
    <main>
        <header class="container-fluid">
            <nav-bar></nav-bar>
        </header>
        <section style="margin-top: 100px;">
            <div class="flash flash_error" v-if="flash.error">
                {{flash.error}}
            </div>
            <div class="flash flash_success" v-if="flash.success">
                {{flash.success}}
            </div>
            <router-view></router-view>
        </section>
    </main>
</template>

<script>
    import Flash from './helpers/flash';

    import NavBar from './components/NavBar.vue';

    export default {
        data() {
            return {
                flash: Flash.state
            }
        },
        components: {
            NavBar
        }
    }
</script>