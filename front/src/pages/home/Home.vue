<template>
    <v-container>
        <v-container fluid>
            <v-row class="ma-2">
                <v-col cols="12" sm="12" xl="2" md="2">
                    <v-card class="mx-auto" outlined color="#43C86E">
                        <v-container fluid style="min-height: 300px">
                            <h3 class="text-center white--text">Carteira</h3>
                            <carteira-user/>
                        </v-container>
                    </v-card>
                </v-col>
                <v-col cols="12" sm="12" xl="8" md="8">
                    <v-card class="mx-auto" outlined color="#43C86E">
                        <v-container fluid style="min-height: 300px">
                            <h3 class="text-center  white--text">Transferências</h3>
                            <v-card elevation="3">
                                <v-data-table
                                    :headers="headersTransferencia"
                                    :items="transferencias"
                                    no-data-text="Nenhuma Transferência"
                                    :items-per-page="rowsPerPageItems"
                                >
                                    <template v-slot:item.payer="props">
                                        <v-badge
                                            v-if="auth.id === props.item.payer.id"
                                            bordered
                                            color="#43C86E"
                                            icon="face"
                                        >
                                            <strong>
                                                {{ props.item.payer.name }}
                                            </strong>
                                        </v-badge>
                                        <strong v-else>
                                            {{ props.item.payer.name }}
                                        </strong>
                                    </template>
                                    <template v-slot:item.payee="props">
                                        <v-badge
                                            v-if="auth.id === props.item.payee.id"
                                            bordered
                                            color="#43C86E"
                                            icon="face"
                                        >
                                            <strong>
                                                {{ props.item.payee.name }}
                                            </strong>
                                        </v-badge>
                                        <strong v-else>
                                            {{ props.item.payee.name }}
                                        </strong>
                                    </template>
                                    <template v-slot:item.value="props">
                                        <money
                                            style="font-weight: bold"
                                            disabled
                                            v-model="props.item.value"
                                            v-bind="money"
                                        />
                                    </template>
                                    <template v-slot:item.data_transferencia_formatted="props">
                                        <strong>
                                            {{ props.item.data_transferencia_formatted }}
                                        </strong>
                                    </template>
                                </v-data-table>
                            </v-card>
                        </v-container>
                    </v-card>
                </v-col>
                <v-col cols="12" sm="12" xl="2" md="2">
                    <v-card class="mx-auto" outlined color="#43C86E">
                        <v-container fluid style="min-height: 300px">
                            <h3 class="text-center white--text">Trasferir</h3>
                            <form-transferencia @handle-success="getTransferencias"/>
                        </v-container>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>
<script>

import {mapGetters} from 'vuex';
import {VMoney} from 'v-money';
import apiTransferencia from '$api/Transferencia';
import formTransferencia from '~/pages/transferencia/Form';
import carteiraUser from '~/pages/carteira/Index';

export default {
    components: {VMoney, formTransferencia, carteiraUser},
    data() {
        return {
            rowsPerPageItems: 15,
            transferencias: [],
            formItem: new Form({
                nome: '',
                vl_esperado: 0.0,

                grupo_id: '',
            }),
            formGrupo: new Form({
                nome: '',
                tipo_grupo: '',
            }),
            formAjuste: {
                vl_ajuste: '',
                movimentacao_id: '',
                date: '',
            },
            money: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                precision: 2,
                masked: false,
            },
            headersTransferencia: [
                {text: 'Pagador(a)', value: 'payer', sortable: false, align: 'left'},
                {text: 'Beneficiário(a)', value: 'payee', sortable: false, align: 'center'},
                {text: 'Data', value: 'data_transferencia_formatted', sortable: false, align: 'center'},
                {text: 'Valor', value: 'value', sortable: false, align: 'left'},
            ],
        };
    },
    methods: {
        async getTransferencias() {
            const {data} = await apiTransferencia.getAll();
            this.transferencias = data;
        },
    },
    async mounted() {
        await this.getTransferencias();
    },
    computed: mapGetters({
        auth: 'auth/user',
    }),
};
</script>
