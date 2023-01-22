<template>
    <div class="pa-auto ml-0">
        <v-toolbar flat class="mt-n5">
            <v-toolbar-title>
              Add User
            </v-toolbar-title>
        </v-toolbar>
        <v-row>
            <v-col cols="12" md="4">
                <v-card class="pa-4" elavation="4">
                    <v-card-text>
                      <v-form ref="form">
                        <div>
                          <label for="">Name</label>
                          <v-text-field
                              type="text"
                              v-model="user.name"
                              placeholder="Enter User Name"
                              outlined
                              dense
                              rounded
                              :rules="nameRule"
                              onkeydown="return /[a-z]/i.test(event.key)"
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
                          <label for="">User Role</label>
                          <v-select
                              v-model="user.user_type"
                              placeholder="Please select User Role"
                              outlined
                              dense
                              rounded
                              :items="roles"
                              item-text="role"
                              item-value="role"
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
                        color="#218c74"
                        text
                        @click="addUser"
                      >
                          Create
                      </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col cols="12" md="8">
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
        roles: [],
      }
    },
    mounted() {
      this.fetchUsers()
      this.fetchRoles()
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
      fetchRoles() {
        axios.get(`/api/roles`)
          .then(response => {
            this.roles = response.data.data
          })
          .catch(error => console.log(error.response.data.message))
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