<!-- Header Structure -->
<template>
  <div>
    <v-navigation-drawer
      v-if="!horizontal"
      app
      fixed
      v-model="drawer"
      :mini-variant.sync="sidebarState"
      mini-variant-width="70"
      :width="250"
      class="Vuely-sidebar"
      :style="{ backgroundImage: 'url(' + selectedSidebarBgImage.url + ')' }"
      :class="{ 'background-none': !backgroundImage }"
      :right="rtlLayout"
    >
      <!-- App Sidebar -->
      <app-sidebar></app-sidebar>
    </v-navigation-drawer>

    <v-app-bar
      class="Vuely-toolbar"
      app
      :color="activeHeaderFilter.class"
      fixed
    >
      <div class="d-custom-flex align-items-center navbar-left">
        <div v-if="!horizontal">
          <v-app-bar-nav-icon
            @click.stop="drawer = !drawer"
            class="v-step-0"
          ></v-app-bar-nav-icon>
        </div>
        <div
          class="site-logo-wrap d-custom-flex ml-0 align-items-center"
          v-else
        >
          <router-link
            to="/horizontal/dashboard/ecommerce"
            class="grayish-blue site-logo-img"
          >
            <img
              src="/static/img/site-logo.png"
              alt="site logo"
              width="100"
              height="30"
            />
          </router-link>
        </div>
      </div>
      <div class="navbar-right"></div>
    </v-app-bar>
  </div>
</template>

<script>
import Sidebar from "../Sidebar/Sidebar.vue";
import ChatSidebar from "../ChatSidebar/ChatSidebar.vue";
import screenfull from "screenfull";
import LanguageProvider from "./LanguageProvider";
import Notifications from "./Notifications";
import User from "./User";
import Cart from "./Cart";
import QuickLinks from "./QuickLinks";
import MobileSearchForm from "./MobileSearchForm";
import { getCurrentAppLayout } from "Helpers/helpers";
import { mapGetters } from "vuex";

export default {
  props: {
    horizontal: {
      default: false,
      type: Boolean
    }
  },
  data() {
    return {
      collapsed: false, // collapse sidebar
      drawer: null, // sidebar drawer default true
      chatSidebar: false, // chat component right sidebar
      sidebarImages: "", // sidebar background images
      enableDefaultSidebar: false
    };
  },
  computed: {
    ...mapGetters([
      "rtlLayout",
      "backgroundImage",
      "backgroundImage",
      "selectedSidebarBgImage",
      "collapseSidebar",
      "activeHeaderFilter"
    ]),
    sidebarState: {
      get: function() {
        return this.collapseSidebar;
      },
      set: function() {
        return this.collapseSidebar;
      }
    }
  },
  methods: {
    // toggle full screen method
    toggleFullScreen() {
      if (screenfull.enabled) {
        screenfull.toggle();
      }
    },
    sidebarPath(link) {
      this.$store.dispatch("setActiveMenuGroup", { pathURL: link });
      this.$router.push(this.getMenuLink(link));
    },
    getMenuLink(link) {
      return "/" + getCurrentAppLayout(this.$router) + link;
    },
    toggleSearchForm() {
      this.$store.dispatch("toggleSearchForm");
    }
  },
  components: {
    appSidebar: Sidebar,
    ChatSidebar,
    LanguageProvider,
    Notifications,
    Cart,
    QuickLinks,
    MobileSearchForm,
    User
  }
};
</script>
