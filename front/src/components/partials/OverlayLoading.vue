<template>
    <v-row justify="center">
        <v-col cols="12">
            <v-row align="center">
                <v-overlay
                    absolute="true"
                    opacity="0.90"
                    z-index="5"
                    :value="show"
                >
                    <v-progress-circular indeterminate size="64"></v-progress-circular>
                </v-overlay>
            </v-row>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        props: {
            show: {
                default: false
            }
        },
        data: () => ({
            show: false
        })
    }
</script>
