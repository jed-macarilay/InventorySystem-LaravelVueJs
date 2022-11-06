<template>
    <div>
      <v-toolbar flat class="mt-n5">
        <v-toolbar-title>Inventory</v-toolbar-title>
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
                      <v-list-item 
                        three-line  
                        class="mt-10"
                        href="/inventory/create"
                      >
                        <v-list-item-content>
                          <div class="mb-4">
                              <v-icon  x-large :color="active ? 'white' : '#49D9A0'">fa fa-plus-square</v-icon>
                          </div>
                          <v-list-item-subtitle :class="active ? 'white--text' : 'black--text'">Add new item</v-list-item-subtitle>
                          <v-list-item-title class="headline mb-1" :class="active ? 'white--text' : 'black--text'">
                            <strong>100</strong>
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
      <v-divider></v-divider>
      <v-data-table
        :headers="headers"
        :items="desserts"
        :items-per-page="5"
        class="elevation-1 mt-10 ml-5"
      ></v-data-table>
    </div>
  </template>
  
  <script>
    export default {
      name: "Inventory",
      data () {
        return {
          toggle_exclusive: 1,
          headers: [
            {
              text: 'Dessert (100g serving)',
              align: 'start',
              sortable: false,
              value: 'name',
            },
            { text: 'Calories', value: 'calories' },
            { text: 'Fat (g)', value: 'fat' },
            { text: 'Carbs (g)', value: 'carbs' },
            { text: 'Protein (g)', value: 'protein' },
            { text: 'Iron (%)', value: 'iron' },
          ],
          desserts: [
            {
              name: 'Frozen Yogurt',
              calories: 159,
              fat: 6.0,
              carbs: 24,
              protein: 4.0,
              iron: '1%',
            },
            {
              name: 'Ice cream sandwich',
              calories: 237,
              fat: 9.0,
              carbs: 37,
              protein: 4.3,
              iron: '1%',
            },
            {
              name: 'Eclair',
              calories: 262,
              fat: 16.0,
              carbs: 23,
              protein: 6.0,
              iron: '7%',
            },
            {
              name: 'Cupcake',
              calories: 305,
              fat: 3.7,
              carbs: 67,
              protein: 4.3,
              iron: '8%',
            },
            {
              name: 'Gingerbread',
              calories: 356,
              fat: 16.0,
              carbs: 49,
              protein: 3.9,
              iron: '16%',
            },
            {
              name: 'Jelly bean',
              calories: 375,
              fat: 0.0,
              carbs: 94,
              protein: 0.0,
              iron: '0%',
            },
            {
              name: 'Lollipop',
              calories: 392,
              fat: 0.2,
              carbs: 98,
              protein: 0,
              iron: '2%',
            },
            {
              name: 'Honeycomb',
              calories: 408,
              fat: 3.2,
              carbs: 87,
              protein: 6.5,
              iron: '45%',
            },
            {
              name: 'Donut',
              calories: 452,
              fat: 25.0,
              carbs: 51,
              protein: 4.9,
              iron: '22%',
            },
            {
              name: 'KitKat',
              calories: 518,
              fat: 26.0,
              carbs: 65,
              protein: 7,
              iron: '6%',
            },
          ],
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