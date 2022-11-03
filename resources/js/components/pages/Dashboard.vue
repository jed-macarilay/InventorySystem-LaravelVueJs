<template>
  <div>
    <v-toolbar color="rgba(0,0,0,0)" flat class="mt-n4">
      <v-btn-toggle v-model="toggle_exclusive" tile group color="#49D9A0" >
        <v-btn text>
          <v-icon>fa fa-arrow-left</v-icon>
        </v-btn>
        <v-btn text>
          <v-icon>fa fa-arrow-right</v-icon>
        </v-btn>
      </v-btn-toggle>
    </v-toolbar>
    <v-item-group mandatory class="mt-n4">
      <v-container>
        <v-row justify="start" class="space">
        <v-col
          cols="12"
          md="2"
        >
          <v-item v-slot="{ active, toggle }" > 
           <v-card
              :color="active ? '#49D9A0' : 'white'"
              class="d-flex align-center rounded-xl"
              dark
              height="200"
              @click="toggle"
              
            >
              <v-row>
                <v-col cols="12" sm="12">
                  <v-list-item three-line  class="mt-10">
                    <v-list-item-content>
                      <div class="mb-4">
                       
                          <v-icon  x-large :color="active ? 'white' : '#49D9A0'">fa fa-archive</v-icon>
                       
                      </div>
                      <v-list-item-subtitle :class="active ? 'white--text' : 'black--text'">Inventory</v-list-item-subtitle>
                      <v-list-item-title class="headline mb-1" :class="active ? 'white--text' : 'black--text'">
                        <strong>52</strong>
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
          <v-item v-slot="{ active, toggle }">
            <v-card
              :color="active ? '#49D9A0' : 'white'"
              class="d-flex align-center rounded-xl"
              dark
              height="200"
              @click="toggle"
            >
              <v-row>
                <v-col cols="12" sm="12">
                  <v-list-item three-line  class="mt-10">
                    <v-list-item-content>
                      <div class="mb-4">
                       
                          <v-icon  x-large :color="active ? 'white' : '#49D9A0'">fa fa-truck</v-icon>
                       
                      </div>
                      <v-list-item-subtitle :class="active ? 'white--text' : 'black--text'">Truck Tracking</v-list-item-subtitle>
                      <v-list-item-title class="headline mb-1" :class="active ? 'white--text' : 'black--text'">
                        <strong>12</strong>
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
      }
    },
  }
</script>

<style>
  .space{
    margin-left: 0;
    margin-right: -100px;
  }
</style>