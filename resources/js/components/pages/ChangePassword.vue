<template>
    <div>
        <v-toolbar flat class="mt-n5">
                <v-toolbar-title>Change Password</v-toolbar-title>
        </v-toolbar>
        <v-row>
            <v-col cols="12" md="5">
              <v-card class="pa-4">
                  <v-card-title>Profile</v-card-title>
                  <v-card-text>
                      <v-form ref="form">
                          <div>
                            <label for="">Email</label>
                            <v-text-field
                                v-model="auth.email"
                                outlined
                                dense
                                rounded
                                disabled
                            ></v-text-field>
                          </div>
                          <div>
                            <label for="">Name</label>
                            <v-text-field
                                v-model="auth.name"
                                outlined
                                dense
                                rounded
                                disabled
                            ></v-text-field>
                          </div>
                          <div>
                            <label for="">Role</label>
                            <v-text-field
                                v-model="auth.user_type"
                                outlined
                                dense
                                rounded
                                disabled
                            ></v-text-field>
                          </div>
                      </v-form>
                  </v-card-text>
              </v-card>
          </v-col>
          <v-col cols="12" md="7">
              <v-card class="pa-4">
                  <v-card-title>Change Password</v-card-title>
                  <v-card-text>
                      <v-form ref="form">
                          <div>
                            <label for="">Current Password</label>
                            <v-text-field
                                v-model="user.password"
                                type="password"
                                placeholder="Enter your Password"
                                outlined
                                dense
                                rounded
                                :rules="passwordRule"
                                required
                            ></v-text-field>
                          </div>
                          <v-divider></v-divider>
                          <div>
                            <label for="">New Password</label>
                            <v-text-field
                                v-model="user.new_password"
                                type="password"
                                placeholder="Enter your Password"
                                outlined
                                dense
                                rounded
                                :rules="newPasswordRule"
                                required
                            ></v-text-field>
                          </div>
                          <div>
                            <label for="">Confirm Password</label>
                            <v-text-field
                                type="password"
                                placeholder="Enter your Password"
                                outlined
                                dense
                                rounded
                                :rules="confirmPasswordRules"
                                required
                            ></v-text-field>
                          </div>
                          <v-divider></v-divider>
                          <v-card-actions>
                            <v-btn
                              :loading="isLoading"
                              color="#49D9A0"
                              text
                              @click="updatePassword"
                            >
                                Submit
                            </v-btn>
                          </v-card-actions>
                      </v-form>
                  </v-card-text>
              </v-card>
          </v-col>
        </v-row>
        <snackbar 
          :show="snackbarShow"
          :message="message"
        />
   </div>
</template>

<script>
import Snackbar from '../templates/Snackbar.vue'

export default {
  props: {
    auth: {
      type: Object,
      required: true
    },
  },
  components: {
    Snackbar,
  },
  data() {
    return {
      user: {},
      snackbarShow: false,
      message: '',
      isLoading: false,
      passwordRule: [
        (value) => !!value || 'Please type password.',
        (value) => (value && value.length >= 6) || 'minimum 6 characters',
      ],
      newPasswordRule: [
        (value) => !!value || 'Please type new password.',
        (value) => (value && value.length >= 6) || 'minimum 6 characters',
      ],
      confirmPasswordRules: [
        (value) => !!value || 'type confirm password',
        (value) => value === this.user.new_password || 'The password confirmation does not match.',
      ],
    }
  },
  methods: {
    updatePassword() {
      if (this.$refs.form.validate()) {
        if (confirm('Are you sure you want to change password?')) {
          axios.put(`/api/change-password/${this.auth.id}`, this.user)
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
}
</script>