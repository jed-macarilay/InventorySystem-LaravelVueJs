<template>
    <div class="pa-4">
        <v-col cols="12" md="7">
            <v-card elevation="1">
                <v-card-title>Notifications</v-card-title>
                <v-card-text class="pa-2">
                    <v-list>
                      <template v-for="(item, index) in notifications">
                        <v-divider :key="index"></v-divider>
                        <v-list-item :key="item.data">
                            <v-list-item-content>
                              <v-list-item-subtitle v-html="item.data"></v-list-item-subtitle>
                              <span>Date: {{ item.created_at }}</span>
                            </v-list-item-content>
                        </v-list-item>
                      </template>
                    </v-list>
                </v-card-text>
            </v-card>
        </v-col>
    </div>
</template>

<script>
export default {
  data() {
    return {
      notifications: [],
    }
  },
  mounted() {
    this.fetchNotifications()
  },
  methods: {
    fetchNotifications() {
      axios.get('/api/notifications')
        .then(response => {
          this.notifications = response.data.data
        })
        .catch(error => console.log(error))
    },
  },
}
</script>
