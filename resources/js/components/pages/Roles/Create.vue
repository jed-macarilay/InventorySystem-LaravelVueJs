<template>
  <div class="pa-auto ml-0">
    <v-col cols="6">
      <v-card class="pa-4" elavation="4">
        <v-card-text>
          <v-form ref="form">
            <div>
              <label for="">Role</label>
              <v-text-field
                  type="text"
                  v-model="role"
                  placeholder="Enter User Role"
                  outlined
                  dense
                  rounded
                  :rules="[
                    v => !!v || 'User Role is required',
                  ]"
                  onkeydown="return /[a-z]/i.test(event.key)"
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
            @click="createRole"
          >
              Create
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>

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
        role: null,
        isLoading: false,
        snackbarShow: false,
        message: '',
      }
    },
    methods: {
      createRole() {
        if (this.$refs.form.validate()) {
          axios.post('/api/roles/create', {
            role: this.role
          })  
            .then(response => {
              this.snackbarShow = true
              this.message = response.data.message
              this.isLoading = false
              this.$refs.form.reset()
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