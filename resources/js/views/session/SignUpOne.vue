<template>
  <div class="session-wrapper">
    <div class="session-center text-center">
      <div class="session-table-cell">
        <div class="session-content">
          <h2 class="mb-4">{{ $t("message.signUp") }}</h2>
          <p class="fs-14">
            {{ $t("message.havingAnAccount") }}
            <router-link to="/session/login">{{
              $t("message.login")
            }}</router-link>
          </p>
          <v-form v-model="valid" class="mb-5">
            <v-text-field
              label="Username"
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
            <v-btn
              large
              @click="signupWithLaravel"
              block
              color="primary"
              class="mb-3"
              >Signup
            </v-btn>
          </v-form>
        </div>
      </div>
    </div>
  </div>
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
          password: this.password
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
        password: this.password
      };
      this.$store.dispatch("signupUserWithLaravelPassport", {
        userDetail
      });
    },
    signInWithFacebook() {
      this.$store.dispatch("signinUserWithFacebook", {
        router: this.$router
      });
    },
    signInWithGoogle() {
      this.$store.dispatch("signinUserWithGoogle", {
        router: this.$router
      });
    },
    signInWithTwitter() {
      this.$store.dispatch("signinUserWithTwitter", {
        router: this.$router
      });
    },
    signInWithGithub() {
      this.$store.dispatch("signinUserWithGithub", {
        router: this.$router
      });
    }
  }
};
</script>
