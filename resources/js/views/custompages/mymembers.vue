<template>
  <div>
    <app-section-loader :status="loader"></app-section-loader>
    <v-container fluid class="grid-list-xl pt-0 mt-n3">
      <v-row>
            <v-col sm="4" cols="4"></v-col>
            <v-col sm="4" cols="4"></v-col>
            <v-col sm="4" cols="4">
                <v-btn class="px-4 mx-auto mt-4 float-right" color="primary" @click="AddMembers()">
                  <v-icon >add</v-icon> Add members
                </v-btn>
            </v-col>
      </v-row>
      <v-row class="mt-2">
        <v-col sm="12" cols="12">
          <div  v-if="members.length > 0 "> 
            <v-simple-table>
              <thead>
                <tr>
                  <th class="text-left">Member Name</th>
                  <th class="text-left">Created On</th>
                </tr>
              </thead>
              <tbody>
                  <tr v-for="item in members">
                    <td>{{ item.name }}</td>
                    <td>{{ item.created_at }}</td>
                  </tr>
              </tbody>
            </v-simple-table>
          </div>
          <div v-else align="center">
            No members found
          </div>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import Vue from 'vue'
import VModal from 'vue-js-modal'
import SessionSliderWidget from "Components/Widgets/SessionSlider";
import AppConfig from "Constants/AppConfig";
import api from "Api";
import Swal from 'sweetalert2'

Vue.use(VModal)

const axios = require("axios");


export default {
  components: {
    SessionSliderWidget
  },
  data() {
    return {
      members: [],
      update_id:null,
      publicpath: "../../../../public/images/",
      loader: true,
      image: [],
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
      url: "",
      urlRules: [v => !!v || "url is required"],
      comment: "",
      commentRules: [v => !!v || "comment is required"]
    };
  },
  methods: {
    AddMembers() {
        let group_id = this.$route.params.id;
        this.$router.push({ name: "AddMembers", params: { id: group_id } });
    }
  },
  created() {
    let group_id = this.$route.params.id;
    api
      .get(`members/${group_id}`)
      .then(response => {
        this.members = response.data;
        console.log(this.members);
        this.loader = false;
      })
      .catch(error => {
        console.log(error);
      });
  }
};
</script>
