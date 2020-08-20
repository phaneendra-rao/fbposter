<template>
  <v-container fluid class="grid-list-xl pt-0 mt-n3">
    <v-row class="mt-10">
      <v-col cols-8 sm-6>
        <app-card>
          <h2 class="mb-4">Add users</h2>
          <v-form v-model="valid" class="mb-5">
            <v-text-field
              label="Name"
              v-model="name"
              :rules="nameRules"
              :counter="20"
              required
            ></v-text-field>
            <v-text-field
              label="E-mail ID"
              v-model="email"
              :rules="emailRules"
              required
            ></v-text-field>
            <v-text-field
              label="Password"
              v-model="password"
              :rules="passwordRules"
              type="password"
              required
            ></v-text-field>
            <v-select
              hide-details
              v-bind:items="scopes"
              v-model="usertype"
              label="User Type"
              single-line
              menu-props="bottom"
            ></v-select>
            <v-btn
              large
              @click="signupWithLaravel"
              block
              color="primary"
              class="mb-3 mt-4"
              >Add New User
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
      usertype: null,
      scopes: [{ text: "Member Manager" }, { text: "Commenter" }],
      valid: false,
      name: "",
      nameRules: [
        v => !!v || "Name is required",
        v => v.length <= 20 || "Name must be less than 20 characters"
      ],
      email: "",
      emailRules: [
        v => !!v || "E-mail is required",
        v =>
          /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
          "E-mail must be valid"
      ],
      password: "",
      passwordRules: [v => !!v || "Password is required"],
      appLogo: AppConfig.appLogo2,
      brand: AppConfig.brand
    };
  },
  methods: {
    submit() {
      if (this.valid) {
        let userDetail = {
          name: this.name,
          email: this.email,
          password: this.password,
          usertype: this.usertype
        };
        this.$store.dispatch("signupUserInFirebase", {
          userDetail,
          router: this.$router
        });
      }
    },
    signupWithLaravel() {
      let userDetail = {
        name: this.name,
        email: this.email,
        password: this.password,
        usertype: this.usertype
      };
      this.$store.dispatch("addNewUserWithLaravelPassport", {
        userDetail
      });
    }
  }
};
</script>
