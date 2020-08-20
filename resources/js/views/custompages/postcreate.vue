<template>
  <div>
    <app-section-loader :status="loader"></app-section-loader>
    <v-container fluid class="grid-list-xl pt-0 mt-n3">
      <v-row class="mt-4">
        <v-col cols="6" sm="6">
          <app-card>
            <h2 class="mb-4">Create post</h2>
            <v-form v-model="valid" class="mb-5">
              <v-text-field
                label="Name"
                v-model="name"
                :rules="nameRules"
                required
              ></v-text-field>
              <!-- <v-text-field
                label="Days after lastpost"
                v-model="days"
                :rules="daysRules"
                required
              ></v-text-field> -->
              <v-text-field
                label="Url"
                v-model="url"
                :rules="urlRules"
                required
              ></v-text-field>
              <p class="mt-4">Comment</p>
              <textarea
                id="comment"
                v-model="comment"
                :rules="commentRules"
                required
                class="v-textarea-addmembers form-control"
                rows="12"
                cols="41"
              >
              </textarea>
              <v-btn
                large
                @click="createPost"
                block
                color="primary"
                class="mb-3 mt-4"
                >Add New Post
              </v-btn>
            </v-form>
          </app-card>
        </v-col>

        <v-col cols="6" sm="6">
          <v-row>
            <v-col cols="2" sm="2">
              <h6 v-if="countday === 0">Today</h6>
              <h6 v-else>{{countday}} Days</h6>
              <p class="post-days">Last Post</p>
            </v-col>
            <v-col cols="2" sm="2">
              <v-text-field
                label="Days"
                v-model="days"
                :rules="daysRules"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="2" sm="2">
              <h6># Days</h6>
              <p class="post-days">This Post</p>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="4" sm="4" id="image1">
              <div class="post-image-upload">
                <div class="mt-10">
                  <h4>Add Image For Post</h4>
                </div>
                <v-icon class="ic-height">add</v-icon>
                <input
                  type="file"
                  class="post_file_upload"
                  name="image"
                  id="image"
                  @change="onFileChange($event)"
                />
              </div>
            </v-col>
            <v-col cols="4" sm="4" id="image-rm" style="display:none;">
              <img v-if="urlimage" :src="urlimage" id="preview-image" />
              <v-btn
                id="rmbutton"
                style="color:white; margin-left:35%;"
                small
                color="red"
                class="mb-2"
                @click="getFileInput()"
                >Delete
              </v-btn>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
import SessionSliderWidget from "Components/Widgets/SessionSlider";
import AppConfig from "Constants/AppConfig";
import api from "Api";
const axios = require("axios");
export default {
  components: {
    SessionSliderWidget
  },

  data() {
    return {
      loader: true,
      countday: this.countday,
      posts: [],
      publicpath: "../../../../public/images/",
      loader: false,
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
      day: "",
       dayRulrs: [
        v => !!v || "Day is required"
      ],
      url: "",
      urlimage: "",
      urlRules: [v => !!v || "url is required"],
      comment: "",
      commentRules: [v => !!v || "comment is required"],
      days: "",
      daysRules: [v => !!v || "days is required"]
    };
  },
  mounted() {
    this.getGroupData();
  },
  methods: {
    createPost() {
      let self = this;
      let formData = new FormData();
      formData.append("group_id", this.$route.params.id);
      formData.append("name", this.name);
      formData.append("url", this.url);
      formData.append("comment", this.comment);
      formData.append("days_after_post", this.days);
      formData.append("day", this.day);
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
          self.$router.push({
            name: "MyPosts",
            params: { id: self.$route.params.id }
          });
        })
        .catch(function(error) {
          console.log(error);
        });
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
        .post("createpost", formData, {
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
    },
    addfile(event) {
      //  console.log(event.target.files[0]);
      //this.image = event.target.files[0];
    },

    onFileChange(e) {
      const file = e.target.files[0];
      this.urlimage = URL.createObjectURL(file);
      this.image = event.target.files[0];
      document.getElementById('image1').style.display = 'none';
      document.getElementById("image-rm").style.display = "block";
    },

    getFileInput() {
      document.getElementById('image1').style.display = 'block';
      document.getElementById('image-rm').style.display = 'none';
      document.getElementById('preview-image').src = "";
      //document.getElementById('image').src = '#';
      document.getElementById("image").value = '';
      document.getElementById('preview-image').value = "";
    },

    getGroupData() {
    let group_id = this.$route.params.id;
      api
        .get(`group_data/`+group_id)
        .then(response => {
          this.loader = false;
          this.countday = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    }
  },
  created() {}
};
</script>
<style type="text/css">
.v-textarea-addmembers {
  border: 1px solid #ccc;
}
.post-image-upload {
  position: relative;
  border: 1px solid #ccc;
  width: 220px;
  height: 150px;
  line-height: 30px;
  text-align: center;
  color: solid #ccc;
}

.post_file_upload {
  opacity: 0;

  /* IE 8 */
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";

  /* IE 5-7 */
  filter: alpha(opacity=0);

  /* Netscape or and older firefox browsers */
  -moz-opacity: 0;

  /* older Safari browsers */
  -khtml-opacity: 0;

  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  width: 100%;
  height: 100%;
}

#comment {
  border: 1px solid white;
  padding: 10px;
  box-shadow: 0px 0px 0px 2px #E2E2E2;
  width: 100%;
  resize: none;
  background-color:#e0e2e1;
}
.post-days{
  font-size:12px;
}
img{
  max-width:180px;
}
</style>
