<template>
  <div class="text-center ma-2">
    <v-snackbar v-model="show">
      {{ message }}
      <template v-slot:action="{ attrs }">
        <v-btn color="white" text v-bind="attrs" @click="show = false;">
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
  export default {
    name: 'Snackbar',
    props: {
      message: {
        type: String,
        default: "Ops Something went wrong.",
        required: true,
      },
      show: {
        type: Boolean,
        default: false,
        required: true,
      }
    },
    data() {
      return {

      }
    },
  }
</script>