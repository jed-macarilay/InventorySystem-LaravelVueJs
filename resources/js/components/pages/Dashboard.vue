<template>
  <div>
    <v-toolbar flat class="mt-n5">
      <v-toolbar-title>Overview</v-toolbar-title>
   </v-toolbar>
    <v-item-group mandatory class="mt-n4">
      <v-container>
        <v-row justify="start" class="space">
          <v-col
            cols="4"
            md="2"
          >
            <v-item>
            <v-card
                color="#49D9A0"
                class="d-flex align-center rounded-xl"
                dark
                height="200"
              >
                <v-row>
                  <v-col cols="12" sm="12">
                    <v-list-item 
                      three-line  
                      class="mt-10"
                      href="/inventory"
                    >
                      <v-list-item-content>
                        <div class="mb-4">
                            <v-icon  x-large color="white">fa fa-archive</v-icon>
                        </div>
                        <v-list-item-subtitle class="white--text">Inventory</v-list-item-subtitle>
                        <v-list-item-title class="headline mb-1 white--text">
                          <strong>{{ counts.inventory_count }}</strong>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-col>
                </v-row>
              </v-card>
            </v-item>
          </v-col>
          <v-col
            cols="12"
            md="2"
          >
            <v-item>
              <v-card
                color="#49D9A0"
                class="d-flex align-center rounded-xl"
                dark
                height="200"
                href="/vehicle"
              >
                <v-row>
                  <v-col cols="12" sm="12">
                    <v-list-item three-line  class="mt-10">
                      <v-list-item-content>
                        <div class="mb-4">
                        
                            <v-icon  x-large color="white">fa fa-truck</v-icon>
                        
                        </div>
                        <v-list-item-subtitle class="white--text">Total Vehicle</v-list-item-subtitle>
                        <v-list-item-title class="headline mb-1 white--text">
                          <strong>{{ counts.vehicle_count }}</strong>
                        </v-list-item-title>
                        
                      </v-list-item-content>
                    </v-list-item>
                  </v-col>
                </v-row>
                
              </v-card>
            </v-item>
          </v-col>
          <v-col
            cols="12"
            md="2"
          >
            <v-item> 
            <v-card
              color="#49D9A0"
              class="d-flex align-center rounded-xl"
              dark
              height="200"
            >
                <v-row>
                  <v-col cols="12" sm="12">
                    <v-list-item 
                      three-line  
                      class="mt-10"
                      href="/sales"
                    >
                      <v-list-item-content>
                        <div class="mb-4">
                            <v-icon  x-large color="white">fa fa-truck</v-icon>
                        </div>
                        <v-list-item-subtitle class="white--text">Shipping now</v-list-item-subtitle>
                        <v-list-item-title class="headline mb-1 white--text">
                          <strong>{{ counts.shipping_count }}</strong>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-col>
                </v-row>
              </v-card>
            </v-item>
          </v-col>
          <v-col
            cols="12"
            md="2"
          >
            <v-item> 
            <v-card
              color="#49D9A0"
              class="d-flex align-center rounded-xl"
              dark
              height="200"
            >
                <v-row>
                  <v-col cols="12" sm="12">
                    <v-list-item 
                      three-line  
                      class="mt-10"
                      href="/user/create"
                    >
                      <v-list-item-content>
                        <div class="mb-4">
                            <v-icon  x-large color="white">fa fa-users</v-icon>
                        </div>
                        <v-list-item-subtitle class="white--text">Total Users</v-list-item-subtitle>
                        <v-list-item-title class="headline mb-1 white--text">
                          <strong>{{ counts.user_count }}</strong>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-col>
                </v-row>
              </v-card>
            </v-item>
          </v-col>
        </v-row>
      </v-container>
    </v-item-group>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        toggle_exclusive: 1,
        counts: [],
      }
    },
    mounted() {
      this.fetchCountAll()
    },
    methods: {
      fetchCountAll() {
        axios.get('/api/view/all')
          .then(response => {
            this.counts = response.data
          })
          .catch(error => console.log(error))
      },
    },
  }
</script>

<style>
  .space{
    margin-left: 0;
    margin-right: -100px;
  }
</style>