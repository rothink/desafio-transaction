<template>
    <v-card elevation="20">
        <v-container fill-height fluid grid-list-xl class="pt-2">
            <v-layout justify-center wrap>
                <v-flex xs12 md12>
                    <div>
                        <v-form>
                            <v-container>
                                <v-layout row>
                                    <v-flex xs2 md2>
                                        <v-icon
                                            class="pt-5"
                                            large
                                            color="green darken-2"
                                        >
                                            face
                                        </v-icon>
                                    </v-flex>
                                    <v-flex xs10 md10>
                                        <v-select
                                            :items="users"
                                            label="Beneficiário"
                                            v-model="form.payee"
                                        ></v-select>
                                        <show-error :form-name="form" prop-name="payee"></show-error>
                                    </v-flex>
                                </v-layout>
                                <v-layout row>
                                    <v-flex xs2 md2>
                                        <v-icon
                                            class="pt-5"
                                            large
                                            color="green darken-2"
                                        >
                                            attach_money
                                        </v-icon>
                                    </v-flex>
                                    <v-flex xs10 md10>
                                        <vuetify-money
                                            v-model="form.value"
                                            :options="options"
                                            prepend-icon="face"
                                        />
                                        <show-error :form-name="form" prop-name="value"></show-error>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-form>
                    </div>
                </v-flex>
            </v-layout>
        </v-container>
        <v-container fluid grid-list-xl>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="success" block large @click="salvar">Transferir</v-btn>
            </v-card-actions>
        </v-container>
    </v-card>
</template>
<script>
import apiTransferencia from '$api/Transferencia';
import {mapGetters} from 'vuex';

export default {
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
    methods: {
        async fetchPreRequisites() {
            const {data} = await apiTransferencia.preRequisite();
            const {users} = data.preRequisite;
            this.users = users;
        },
        async salvar() {
            const {status} = await apiTransferencia.saveForm(this.form);
            if (status === true) {
                this.createForm()
                this.$emit('handle-success');
                await this.$store.dispatch('auth/fetchUser');
            }
        },
        createForm() {
            this.form = new Form({
                payer: this.auth.id, //Pagador
                payee: '', //Beneficiário
                value: 0.0, //Valor da transferência
            })
        },
    },

    mounted() {
        this.fetchPreRequisites();
        this.form.payer = this.auth.id;
    },
    computed: mapGetters({
        auth: 'auth/user',
    }),
};
</script>
