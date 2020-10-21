<template>
    <v-card elevation="20">
        <v-container fill-height fluid grid-list-xl class="pt-2">
            <v-layout justify-center wrap>
                <v-flex xs12 md12>
                    <div>
                        <v-form>
                            <v-container>
                                <v-layout row>
                                    <v-flex
                                        md12
                                        class="justify-content-between"
                                        style="min-height: 250px"
                                    >
                                        <h1 class="text-center pt-16 pl-5">
                                            <money
                                                style="font-weight: bold"
                                                disabled
                                                v-model="auth.carteira"
                                                v-bind="options"
                                            />
                                        </h1>
                                        <v-icon
                                            class="pt-5 text-center justify-center justify-content-end"
                                            x-large
                                            color="green darken-2"
                                        >
                                            account_balance_wallet
                                        </v-icon>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-form>
                    </div>
                </v-flex>
            </v-layout>
        </v-container>
    </v-card>
</template>
<script>

import {mapGetters} from 'vuex';
import {VMoney} from 'v-money';

export default {
    components: {VMoney},
    data: () => ({
        options: {
            locale: 'pt-BR',
            prefix: 'R$',
            suffix: '',
            length: 11,
            precision: 2,
        },
        users: [],
        done: false,
        id: '',
        form: new Form({
            payer: '', //Pagador
            payee: '', //Beneficiário
            value: '', //Valor da transferência
        }),
    }),
    computed: mapGetters({
        auth: 'auth/user',
    }),
};
</script>
