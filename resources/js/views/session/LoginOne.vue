<template>
  <div class="session-wrapper">
    <div class="session-center text-center">
      <div class="session-table-cell">
        <div class="session-content">
          <h2 class="mb-4">{{ $t("message.loginToAdmin") }}</h2>
          <p class="fs-14">
            {{ $t("message.enterUsernameAndPasswordToAccessControlPanelOf") }}
            {{ brand }}.
          </p>
          <v-form v-model="valid" class="mb-5">
            <v-text-field
              label="E-mail ID"
              v-model="email"
              :rules="emailRules"
              required
            ></v-text-field>
            <v-text-field
              label="Password"
              v-model="password"
              type="password"
              :rules="passwordRules"
              required
            ></v-text-field>
            <v-checkbox
              color="primary"
              label="Remember me"
              v-model="checkbox"
            ></v-checkbox>
            <router-link class="mb-2" to="/session/forgot-password"
              >{{ $t("message.forgotPassword") }}?</router-link
            >
            <div>
              <v-btn
                large
                class="mb-2"
                @click="signInWithLaravelPassport"
                block
                color="primary"
                >Login</v-btn
              >
            </div>
          </v-form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import firebase from "firebase/app";
// import { mapGetters } from "vuex";
import SessionSliderWidget from "Components/Widgets/SessionSlider";
import AppConfig from "Constants/AppConfig";

import AuthService from "../../auth/AuthService";

const auth = new AuthService();
// const { login, logout, authenticated, authNotifier } = auth;

const { login } = auth;

export default {
  components: {
    SessionSliderWidget
  },
  data() {
    localStorage.removeItem("user");
    return {
      checkbox: false,
      valid: false,
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
      const user = {
        email: this.email,
        password: this.password
      };

      this.$store.dispatch("signinUserInFirebase", {
        user
      });
    },
    signInWithLaravelPassport() {
      const user = {
        email: this.email,
        password: this.password
      };
      this.$store.dispatch("signInWithLaravelPassport", {
        user
      });
    },
    signInWithFacebook() {
      this.$store.dispatch("signinUserWithFacebook");
    },
    signInWithGoogle() {
      this.$store.dispatch("signinUserWithGoogle");
    },
    signInWithTwitter() {
      this.$store.dispatch("signinUserWithTwitter");
    },
    signInWithGithub() {
      this.$store.dispatch("signinUserWithGithub");
    },
    onCreateAccount() {
      this.$router.push("/session/sign-up");
    },
    signinWithAuth0() {
      login();
    }
  }
};
</script>
