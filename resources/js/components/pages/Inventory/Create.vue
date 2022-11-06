<template>
    <div>
        <v-card class="pa-5 mt-4">
            <v-toolbar flat class="mt-n5">
                <v-toolbar-title>Create Item</v-toolbar-title>
            </v-toolbar>
            <v-divider class="mr-6"></v-divider>
            <v-card-text>
                <v-col
                    cols="12"
                    md="7"
                >
                    <div>
                        <label for="">
                            <strong>Item name *</strong>
                        </label>
                        <v-text-field
                            outlined
                            dense
                            rounded
                        ></v-text-field>
                    </div>
                    <div>
                        <label for="">
                            <strong>Quantity</strong>
                        </label>
                        <v-text-field
                            type="number"
                            outlined
                            dense
                            rounded
                        ></v-text-field>
                    </div>
                </v-col>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-btn
                        color="#49D9A0"
                        text
                    >
                        Submit
                    </v-btn>
                </v-card-actions>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
    export default {
        name: "InventoryCreate",
    }
</script>