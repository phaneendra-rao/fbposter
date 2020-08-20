<template>
  <div>
    <app-section-loader :status="loader"></app-section-loader>
    <v-container fluid class="grid-list-xl pt-0 mt-n3">
      <v-row class="mt-10">
        <v-col sm="4" cols="4" v-for="item in posts" :key="item.id">
          <v-card class="elevation-5">
            <img :src="getPostImage(item)" alt="Card Image" class="img-responsive center" />
            <v-card-title>
              <h3 class="headline primary--text">{{ item.name }}</h3>
            </v-card-title>
            <v-card-text>
              <!-- <p class="mb-0 fs-16">{{ item.url }}</p> -->
            </v-card-text>
            <v-card-actions>
              <v-row>
                <v-col cols="12" align="center">
                  <v-btn
                    class="px-4"
                    color="primary"
                    @click="gotoPostDetails(item)"
                  >
                    <i
                      class="fa fa-pencil-square-o fa-1x"
                      aria-hidden="true"
                    ></i>
                  </v-btn>
                  <v-btn class="px-4" color="warning" @click="deletepost(item)">
                    <i class="fa fa-trash fa-1x" aria-hidden="true"></i>
                  </v-btn>
                </v-col>
              </v-row>
            </v-card-actions>
          </v-card>
        </v-col>
        <v-col sm="4" cols="4">
          <div class="post-data-createpost" @click="goToAddNewPost">
            <div class="mt-10">
              <h2>Add Post</h2>
            </div>
            <v-icon>add</v-icon>
          </div>
        </v-col>
      </v-row>

      <v-row>
        <v-col sm="6" cols="12">
          <modal name="edit-post" height="400">
            <app-card>
              <h2 class="mb-4">Create post</h2>
              <v-form v-model="valid" class="mb-5">
                <v-text-field
                  label="Name"
                  v-model="name"
                  :rules="nameRules"
                  required
                ></v-text-field>
                <v-text-field
                  label="Url"
                  v-model="url"
                  :rules="urlRules"
                  required
                ></v-text-field>
                <v-text-field
                  label="Comment"
                  v-model="comment"
                  :rules="commentRules"
                  required
                ></v-text-field>
                <input
                  type="file"
                  name="image"
                  id="image"
                  @change="addfile($event)"
                />
                <!-- <v-file-input label="File input" @change="addfile($event)" id="image" name="image"></v-file-input> -->
                <v-btn
                  large
                  @click="updatepost"
                  block
                  color="primary"
                  class="mb-3 mt-4"
                  >Update details
                </v-btn>
              </v-form>
            </app-card>
          </modal>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import Vue from "vue";
import VModal from "vue-js-modal";
import SessionSliderWidget from "Components/Widgets/SessionSlider";
import AppConfig from "Constants/AppConfig";
import api from "Api";
import Swal from "sweetalert2";

Vue.use(VModal);

const axios = require("axios");

export default {
  components: {
    SessionSliderWidget
  },
  data() {
    return {
      posts: [],
      update_id: null,
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
    createPost() {
      let formData = new FormData();
      formData.append("group_id", this.$route.params.id);
      formData.append("name", this.name);
      formData.append("url", this.url);
      formData.append("comment", this.comment);
      formData.append("image", this.image);

      // console.log(this.image);
      api
        .post("createpost", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(function(response) {
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    deletepost(item) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        if (result.value) {
          let delete_id = item.id;
          api.delete(`post/${delete_id}`);
          let group_id = this.$route.params.id;
          api
            .get(`group_posts/${group_id}`)
            .then(response => {
              this.posts = [];
              this.posts = response.data;
              console.log(response.data);
            })
            .catch(error => {
              console.log(error);
            });
        }
      });
    },
    gotoPostDetails(item) {
      let groupId = this.$route.params.id;
      this.$router.push({ name: "EditPost", params: { group_id: groupId, id: item.id } });
    },
    getpostdetails(item) {
      let post_id = item.id;
      api
        .get(`post/${post_id}`)
        .then(response => {
          console.log(response.data);
          this.update_id = response.data.id;
          this.name = response.data.name;
          this.url = response.data.url;
          this.comment = response.data.comment;
        })
        .catch(error => {
          console.log(error);
        });
      this.$modal.show("edit-post");
    },
    updatepost() {
      let formData = new FormData();
      formData.append("group_id", this.$route.params.id);
      formData.append("name", this.name);
      formData.append("url", this.url);
      formData.append("comment", this.comment);
      formData.append("image", this.image);

      // console.log(this.image);
      axios
        .post(`post/${this.update_id}`, formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(function(response) {
          console.log(response);
          this.name = "";
          this.url = "";
          this.comment = "";
          this.image = "";
        })
        .catch(function(error) {
          console.log(error);
        });

      let group_id = this.$route.params.id;
      api
        .get(`group_posts/${group_id}`)
        .then(response => {
          this.posts = [];
          this.posts = response.data;
          console.log(response.data);
        })
        .catch(error => {
          console.log(error);
        });

      this.$modal.hide("edit-post");
    },
    addfile(event) {
      //  console.log(event.target.files[0]);
      this.image = event.target.files[0];
    },

    goToAddNewPost() {
      this.$router.push({ name: "CreatePost" });
    },
    show() {
      this.$modal.show("edit-post");
    },
    hide() {
      this.$modal.hide("edit-post");
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
  }
};
</script>

<style type="text/css" scoped>
.post-data-createpost {
  position: relative;
  border: 1px solid #ccc;
  width: 270px;
  height: 270px;
  line-height: 30px;
  text-align: center;
  color: solid #ccc !important;
  cursor: pointer;
  padding-top: 50px;
}
img{
  height:100px;
  width:100px;
  padding:10px;
}
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
  height:auto;
}

@import url("https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
</style>
