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
        <v-list dense class="mt-5">
            <v-list-item-group
                v-model="selectedItem"
            >
                <v-list-item
                    v-for="(item, i) in items"
                    :key="i"
                    active-class="border"
                    class="mb-5"
                >
                    <v-icon v-text="item.icon"></v-icon>
                </v-list-item>
            </v-list-item-group>
            </v-list>
         <div style="position: absolute; bottom: 20px; margin-left: auto; margin-right: auto; left: 0; right: 0; text-align: center;">
            <v-btn
                icon
                :ripple="false"
            >
                <v-badge
                    bordered
                    overlap
                    color="red"
                    dot
                >
                    <v-icon>fa fa-bell</v-icon>
                </v-badge>
            </v-btn>
            <br />
            <v-avatar color="red">
                <span class="white--text text-h5">CJ</span>
            </v-avatar>
         </div>
    </v-navigation-drawer>
</template>

<script>
    export default {
        data() {
            return {
                selectedItem: 0,
                drawer: null,
                items: [
                    { icon: 'fa fa-dashboard', },
                    { icon: 'fa fa-archive', },
                    { icon: 'fa fa-truck', },
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