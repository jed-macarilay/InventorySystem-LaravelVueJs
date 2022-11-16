<template>
    <div class="pa-4">
        <v-toolbar flat class="mt-n5">
            <v-toolbar-title>
              User
            </v-toolbar-title>
        </v-toolbar>
        <v-row>
            <v-col md="4">
                <v-card class="pa-4" elavation="4">
                    <v-card-text>
                      <v-form ref="form">
                        <div>
                          <label for="">Name</label>
                          <v-text-field
                              v-model="user.name"
                              placeholder="Enter User Name"
                              outlined
                              dense
                              rounded
                              :rules="nameRule"
                          ></v-text-field>
                        </div>
                        <div>
                          <label for="">Email</label>
                          <v-text-field
                              v-model="user.email"
                              type="email"
                              placeholder="Enter User Email"
                              outlined
                              dense
                              rounded
                              :rules="emailRule"
                          ></v-text-field>
                        </div>
                        <div>
                          <label for="">User Type</label>
                          <v-select
                              v-model="user.user_type"
                              placeholder="Please select User type"
                              outlined
                              dense
                              rounded
                              :items="type"
                          ></v-select>
                        </div>
                        <div>
                          <label for="">Password</label>
                          <v-text-field
                              v-model="user.password"
                              type="password"
                              placeholder="Enter User Password"
                              outlined
                              dense
                              rounded
                              :rules="passwordRule"
                          ></v-text-field>
                        </div>
                      </v-form>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                      <v-btn
                        :loading="isLoading"
                        color="#49D9A0"
                        text
                        @click="addUser"
                      >
                          Create
                      </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col md="8">
              <v-data-table
                  :headers="headers"
                  :items="users"
                  :items-per-page="5"
                  class="elevation-1"
              ></v-data-table>
            </v-col>
        </v-row>

        <snackbar 
          :show="snackbarShow"
          :message="message"
        />
    </div>
</template>

<script>
  import Snackbar from '../../templates/Snackbar.vue'

  export default {
    components: {
      Snackbar,
    },
    data () {
      return {
        headers: [
          {
            text: 'ID #',
            align: 'start',
            sortable: false,
            value: 'id',
          },
          { text: 'Name', value: 'name' },
          { text: 'Email', value: 'email' },
          { text: 'User Type', value: 'user_type' },
          { text: 'Date Created', value: 'created_at' },
          { text: 'Last Update', value: 'updated_at' },
        ],
        users: [],
        user: {},
        isLoading: false,
        snackbarShow: false,
        message: '',
        nameRule: [
          v => !!v || 'User name is required',
        ],
        emailRule: [
          v => !!v || 'User email is required',
          v => /.+@.+/.test(v) || 'E-mail must be valid',
        ],
        passwordRule: [
          v => !!v || 'Password is required',
        ],
        type: [
          'Cashier',
          'Driver',
        ],
      }
    },
    mounted() {
      this.fetchUsers()
    },
    methods: {
      fetchUsers() {
        axios.get('/api/users')
          .then(response => {
            this.users = response.data.data
          })
          .catch(error => {
              this.snackbarShow = true
              this.message = error.response.data.message
              this.isLoading = false
          })
      },
      addUser() {
        if (this.$refs.form.validate()) {
          axios.post(`/api/create/new_user`, this.user)
            .then(response => {
                this.snackbarShow = true
                this.message = response.data.message
                this.isLoading = false
                this.$refs.form.reset()
                this.fetchUsers
            })
            .catch(error => {
                this.snackbarShow = true
                this.message = error.response.data.message
                this.isLoading = false
            })
        }
      }
    },
  }
</script>