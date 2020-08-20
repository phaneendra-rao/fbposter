<template>
  <div>
    <app-section-loader :status="loader"></app-section-loader>
    <v-container fluid class="grid-list-xl pt-0 mt-n3">
      <v-row class="mt-10">
        <v-col sm="4" cols="4" v-for="item in posts" :key="item.id">
          <div v-if="members_data.length < 1 || item.memberposts.length < 1">
              <v-card class="elevation-5 con-overlay-bright-demo" v-bind:style="{ backgroundImage: 'url(' + item.image + ')', backgroundSize: 'cover', height: '250px' }">
                  <v-card-title class="mb-3">
                      <v-row>
                          <v-col cols="12" sm="12" style="text-align: center">
                              <h3 class="headline primary--text">{{ item.name }}</h3>
                              <div>
                               <!--    <v-btn class="px-4 primary"  @click="getpostdetails(item)" style="color:#fff;border:1px solid #fff">
                                    Copy <span> <i class="fa fa-clone" aria-hidden="true"></i> </span> 
                                  </v-btn> -->
                                    <img src="/images/right.png" height="100px" class="right-image">
                              </div>
                          </v-col>
                      </v-row>
                  </v-card-title>
                  <v-card-actions class="mt-4">
                      <v-row>
                          <v-col cols="4" sm="4"></v-col>
                          <v-col cols="4" sm="4">
                            <!--    <v-btn class="px-4" outlined color="primary" @click="getpostdetails(item)">
                                Copy <span> <i class="fa fa-clone" aria-hidden="true"></i> </span> 
                              </v-btn> -->
                          </v-col>
                          <v-col cols="4" sm="4"></v-col>
                      </v-row>
                  </v-card-actions>
                  <div class="bg-primary comment-url-font-size mt-4" style="padding:10px;">
                     <a :href="item.url" target="new" class="comment-url-font-size-anchor">Click To Go To Post</a>
                  </div>
              </v-card>
          </div>
          <div v-else>
            <v-card class="elevation-5 con-overlay-shade">
                <img
                  :src="getPostImage(item)"
                  alt="Card Image"
                  class="img-responsive"
                />
                <v-card-title>
                    <v-row>
                        <v-col cols="12" sm="12" style="text-align: center">
                            <h3 class="headline primary--text">{{ item.name }}</h3>
                             <div class="hover_icon_display_shade" style="color:#fff">
                              <v-btn class="px-4 primary copy-btn"  @click="getpostdetails(item)">
                                  copy <span> <i class="fa fa-1x fa-clone" aria-hidden="true"></i> </span> 
                              </v-btn>
                                <!-- <span> <i class="fa fa-check fa-2x" aria-hidden="true"></i> </span>  -->
                            </div>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-actions>
                    <v-row>
                        <v-col cols="4" sm="4"></v-col>
                        <v-col cols="4" sm="4">
                            <!-- <v-btn class="px-4" outlined color="primary" @click="getpostdetails(item)">
                              Copy <span> <i class="fa fa-clone" aria-hidden="true"></i> </span> 
                            </v-btn> -->
                        </v-col>
                        <v-col cols="4" sm="4"></v-col>
                    </v-row>
                </v-card-actions>
                <div class="bg-primary comment-url-font-size" style="padding:10px;">
                   <a :href="item.url" target="new" class="comment-url-font-size-anchor">Click To Go To Post</a>
                </div>
            </v-card>
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
import VueClipboard from 'vue-clipboard2'
 
Vue.use(VueClipboard)
Vue.use(VModal)

const axios = require("axios");


export default {
  components: {
    SessionSliderWidget
  },
  data() {
    return {
      members:[],
      members_data:[],
      members_comment:"",
      posts: [],
      post_image:null,
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
   mounted() {
    this.getMembersData();
  },
  methods: {
    goToAddNewPost() {
      this.$router.push({ name: "CreatePost" });
    },
    getpostdetails(item){
            let post_id = item.id;
            console.log(post_id);
             api.get(`posts/${post_id}/members`)
            .then(response => {
                this.members = response.data;
                console.log(this.members);
                this.members_comment = this.members.toString();
                var copy_text = this.members_comment;
                this.$copyText(copy_text).then(function (e) {
                  alert('Copied')
                  console.log(e)
                  }, function (e) {
                      alert('Can not copy')
                      console.log(e)
                    });

                console.log(this.members_comment);
            })
            .catch(error => {
              console.log(error);
            });
    },
    getMembersData() {
      let group_url = this.$route.params.id;
      api
        .get(`members/${group_url}`)
        .then(response => {
          response.data.forEach((element, index, array) => {
              this.members_data = element.name;
          });
          //this.members_data = response.data;
          //console.log(response.data);
        })
        .catch(error => {
          console.log(error);
        });
    },
    getPostImage(item) {
      let post_image_name = '/group_post_images/'+item.image;
      return post_image_name;
    }
  },
  created() {
    let group_url = this.$route.params.id;
    api
      .get(`group_posts/${group_url}`)
      .then(response => {
        this.loader = false;
        this.posts = response.data;
        console.log(response.data);
      })
      .catch(error => {
        console.log(error);
      });
  },
};
</script>

<style type="text/css" scoped>
  .comment-url-font-size{
    font-size: 15px;
    text-align: center;
  }
  .comment-url-font-size-anchor{
    color: #fff;
  }

  .hover_icon_display_shade{
    opacity: 0;
  }
  .con-overlay-shade:hover{
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100%;
    width: 100%;
    opacity: 0;
    transition: .5s ease;
    background-color: #e3e3e3;
    opacity: 0.8;
  }
   .con-overlay-shade:hover  .hover_icon_display_shade{
    opacity: 1;
   }
  .con-overlay-bright:hover{
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100%;
    width: 100%;
    opacity: 0;
    transition: .5s ease;
    background-color: #008CBA;;
    opacity: 0.8;
  }
  .hover_icon_display{
    opacity: 0;
  }
  .con-overlay-bright:hover .hover_icon_display{
      opacity: 1;
  }
  .copy-btn{
    color:#fff!important;
    border:1px solid #fff!important;
  }
  .con-overlay-bright-demo{
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100%;
    width: 100%;
    transition: .5s ease;
    background-color: #e3e3e3;
    opacity: 0.2;
  }
  .right-image {
    opacity: 1;
  }

   @import url('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
</style>
