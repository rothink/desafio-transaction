<template>
    <v-app-bar
            :clipped-left="$vuetify.breakpoint.lgAndUp"
            app
            color="#43C86E"
            elevation="20"
    >
        <v-toolbar-title style="width: 250px;" class="ml-0 pl-4">
            <v-avatar size="50">
                <img
                        @click.stop="emitToogle()"
                        :src="getAvatarLogo()"
                        alt="logo-maria-amelia-doces"
                />
            </v-avatar>
            <v-app-bar-nav-icon
                    class="white--text"
                    @click.stop="emitToogle()"
            ></v-app-bar-nav-icon>
            <span class="hidden-sm-and-down white--text"></span>
        </v-toolbar-title>
        <div class="flex-grow-1"></div>
    </v-app-bar>
</template>

<script>
    import {mapGetters} from 'vuex';
    import logo from '~/assets/logo.jpeg';

    export default {
        name: 'Navbar',
        data: () => ({
            items: [],
            name: '',
            menu: false,
        }),
        props: ['mini'],
        computed: mapGetters({
            auth: 'auth/user',
        }),
        mounted() {
            this.name = this.auth.name;
        },
        methods: {
            async logout() {
                const {name} = this.auth;
                await this.$store.dispatch('auth/logout');
                notification.showInfoMsg(`Volte sempre, ${name}`);
                this.$router.push({name: 'login'});
            },
            getAvatarLogo() {
                return logo;
            },
            emitToogle() {
                this.$emit('toggleNavigation');
            },
        },
    };
</script>
