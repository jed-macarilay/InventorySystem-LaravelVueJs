<template>
    <v-navigation-drawer 
        v-model="drawer"
        app
        color="white"
        mini-variant
        mini-variant-width="80"
    >
        <v-avatar
            class="d-block text-center mx-auto mt-4"
            size="40"
        >
            <v-icon
                color="#49D9A0"
                large
            >
                fa fa-home
            </v-icon>
        </v-avatar>
        <v-divider></v-divider>
         <v-list
            flat
            class="mt-5"
         >
            <v-list-item-group v-model="selectedItem">
                <v-list-item
                    v-for="(item, i) in items"
                    :key="i"
                    active-class="border"
                    :ripple="false"
                >
                    <v-icon v-text="item.icon"></v-icon>
                </v-list-item>
            </v-list-item-group>
         </v-list>
    </v-navigation-drawer>
</template>

<script>
    export default {
        data() {
            return {
                selectedItem: 0,
                drawer: null,
                items: [
                    { icon: 'fa fa-plus', },
                    { icon: 'fa fa-th-large', },
                    { icon: 'fa fa-align-center', },
                    { icon: 'fa fa-trello', },
                    { icon: 'fa fa-line-chart', },
                ],
            }
        }
    }
</script>

<style>
    .border {
        margin-left: 12px;
        margin-right: 12px;
        background: #49D9A0;
        border-radius: 50%;
        text-decoration: none;
    }

    .v-list-item-group .v-list-item--active {
        color: white !important;
    }
</style>