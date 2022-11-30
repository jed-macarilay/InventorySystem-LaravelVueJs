<template>
    <v-navigation-drawer 
        v-model="drawer"
        app
        color="white"
        mini-variant
        mini-variant-width="80"
    >
        <v-list flat class="mt-5">
            <v-list-item-group v-model="selectedItem">
                <v-list-item
                    active-class="border"
                    class="mb-5"
                    href="/"
                >
                    <v-tooltip right>
                        <template #activator="{ on }">
                            <v-icon v-on="on">fa fa-dashboard</v-icon>
                        </template>
                        <span>Dashboard</span>
                    </v-tooltip>
                </v-list-item>
                <v-list-item
                    active-class="border"
                    class="mb-5"
                    href="/sales"
                >
                    <v-tooltip right>
                        <template #activator="{ on }">
                            <v-icon v-on="on">fa fa-bar-chart</v-icon>
                        </template>
                        <span>Sales</span>
                    </v-tooltip>
                </v-list-item>
                <v-list-item
                    active-class="border"
                    class="mb-5"
                    href="/inventory"
                >
                    <v-tooltip right>
                        <template #activator="{ on }">
                            <v-icon v-on="on">fa fa-archive</v-icon>
                        </template>
                        <span>Inventory</span>
                    </v-tooltip>
                </v-list-item>
                <v-list-item
                    active-class="border"
                    class="mb-5"
                    href="/vehicle"
                >
                    <v-tooltip right>
                        <template #activator="{ on }">
                            <v-icon v-on="on">fa fa-truck</v-icon>
                        </template>
                        <span>Vehicles</span>
                    </v-tooltip>
                </v-list-item>
                <v-list-item
                    v-show="auth === 'admin'"
                    active-class="border"
                    class="mb-5"
                    href="/user/create"
                >
                    <v-tooltip right>
                        <template #activator="{ on }">
                            <v-icon v-on="on">fa fa-user</v-icon>
                        </template>
                        <span>All Users</span>
                    </v-tooltip>
                </v-list-item>
                <v-list-item
                    active-class="border"
                    class="mb-5"
                    href="/change-password"
                >
                    <v-tooltip right>
                        <template #activator="{ on }">
                            <v-icon v-on="on">fa fa-cog</v-icon>
                        </template>
                        <span>Setting</span>
                    </v-tooltip>
                </v-list-item>
            </v-list-item-group>
        </v-list>
         <div style="position: absolute; bottom: 20px; margin-left: auto; margin-right: auto; left: 0; right: 0; text-align: center;">
            <v-btn
                icon
                :ripple="false"
                @click="logout"
            >
                <v-tooltip right>
                    <template #activator="{ on }">
                        <v-icon v-on="on">fa fa-sign-out</v-icon>
                    </template>
                    <span>Logout</span>
                </v-tooltip>
            </v-btn>
            <!-- <br />
            <v-avatar color="red">
                <span class="white--text text-h5">CJ</span>
            </v-avatar> -->
         </div>
    </v-navigation-drawer>
</template>

<script>
    export default {
        name: "Sidebar",
        props: {
            currentLink: {
              type: String,
              default: '/',
              required: false,
            },
            auth: {
                type: String,
                required: true,
            }
        },
        data() {
            return {
                selectedItem: 0,
                drawer: null,
                items: [
                    { 
                        icon: 'fa fa-dashboard',
                        link: '/',
                        text: 'Dashboard',
                    },
                    { 
                        icon: 'fa fa-archive',
                        link: '/inventory',
                        text: 'Inventory',
                    },
                    { 
                        icon: 'fa fa-truck', 
                        link: '/truck-tracking',
                        text: 'Truck Tracking',
                    },
                ],
            }
        },
        mounted() {
          this.getCurrentLink(this.currentLink)
        },
        methods: {
          getCurrentLink(link) {
            if (link === 'sales') {
              this.selectedItem = 1
            } else if (link === 'inventory' || link === 'inventory/create' || link === 'inventory/edit') {
              this.selectedItem = 2
            } else if (link === 'vehicle' || link === 'vehicle/create' || link === 'vehicle/edit') {
              this.selectedItem = 3
            } else if (link === 'user/create') {
              this.selectedItem = 4
            } else if (link === 'change-password') {
              this.selectedItem = 5
            } else {
              this.selectedItem = 0
            }
          },
          logout() {
            if (confirm("Are you sure you want to logout?")) {
                axios.get('/logout')
                    .then(response => {
                      console.log(response.status === 200);
                      if(response.status === 200) {
                        window.location.href = '/'
                      }      
                    })
                    .catch(error => console.log(error))
            }
          },
        },
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