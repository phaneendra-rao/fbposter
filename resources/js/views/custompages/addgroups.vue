<template>
  <v-container fluid class="grid-list-xl pt-0 mt-n3">
    <v-row class="mt-10">
      <v-col cols-8 sm-6>
        <app-card>
          <h2 class="mb-4">Add Groups</h2>
          <v-form v-model="valid" class="mb-5">
            <v-text-field label="Name" v-model="name" required></v-text-field>
            <v-text-field
              label="Client Name"
              v-model="clientName"
              required
            ></v-text-field>
            <v-text-field label="URL" v-model="url" required></v-text-field>
            <v-text-field label="Phone #" v-model="phone"></v-text-field>
            <v-btn
              large
              @click="createNewGroup"
              block
              color="primary"
              class="mb-3 mt-4"
              >Add New Group
            </v-btn>
          </v-form>
        </app-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import SessionSliderWidget from "Components/Widgets/SessionSlider";
import AppConfig from "Constants/AppConfig";
import api from "Api";

export default {
  components: {
    SessionSliderWidget
  },
  data() {
    return {
      elevateOnScroll: false,
      hideOnScroll: false,
      fadeOnScroll: false,
      fadeImgOnScroll: false,
      invertedScroll: false,
      collapse: false,
      collapseOnScroll: false,
      shrinkOnScroll: false,
      extended: false,
      color: "accent",
      colors: ["primary", "accent", "warning lighten-2", "teal", "orange"],
      valid: false,
      name: "",
      clientName: "",
      url: "",
      phone: "",
      appLogo: AppConfig.appLogo2,
      brand: AppConfig.brand
    };
  },
  methods: {
    createNewGroup() {
      let self = this;
      api
        .post("groups", {
          name: this.name,
          clientName: this.clientName,
          url: this.url,
          phone: this.phone
        })
        .then(response => {
          self.$router.push("/default/groups/list");
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>
