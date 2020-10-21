<template>
    <v-list dense>
        <v-toolbar flat class="transparent">
            <v-list class="pe-0">
                <v-list-item>
                    <v-list-item-avatar>
                        <img :src="getUserAvatar()"/>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title>
                            {{ this.user.name }}
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-toolbar>
        <v-divider/>
    </v-list>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex'
    import logo from '~/assets/logo.jpeg'

    export default {
        name: 'SideBarMenu',
        computed: {
            ...mapGetters({
                user: 'auth/user',
            }),
        },
        data: () => ({
            items: [
                {icon: 'work', text: 'Transferências', route: '/home'},
                {icon: 'work', text: 'Transferir', route: '/home'},
            ],
        }),
        methods: {
            toSite(url) {
                window.open(url, '_blank');
            },
            /**
             * Busca a foto do usuário
             * @returns {*}
             */
            getUserAvatar() {
                return logo;
            },
            /**
             * Verifica se usuário tem permissão para ver o item do menu
             * @param role
             * @returns {*|boolean}
             */
            hasPermissionInRoute(route) {
                return true;
                // let checkRoute = helper.routeToPermission(route)
                // return helper.hasPermission(checkRoute)
            },
        },
    };
</script>

<style scoped>
    .v-list .v-list-item--active .v-icon {
        color: green;
    }
</style>
