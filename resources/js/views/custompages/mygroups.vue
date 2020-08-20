<template>
  <div>
    <app-section-loader :status="loader"></app-section-loader>
    <v-container class="grid-list-xl pt-0 mt-3" v-if="groupsList !== null">
    <div  v-if="groupsList.length > 0 ">
        <v-simple-table>
          <thead>
            <tr>
              <th class="text-left">Facebook Group</th>
              <th class="text-left">Client</th>
              <th class="text-left">Group URL</th>
              <th class="text-left">Phone #</th>
              <th class="text-left">Date</th>
              <th class="text-left">Posts</th>
              <th class="text-left">Comments</th>
              <th class="text-left">Tags</th>
              <th class="text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in groupsList" :key="item.id">
              <td>{{ item.name }}</td>
              <td>{{ item.client_name }}</td>
              <td>
                <v-btn
                  class="mr-3"
                  icon
                  v-clipboard:copy="item.url"
                  color="primary"
                >
                  <v-icon>link</v-icon>
                </v-btn>
              </td>
              <td>{{ item.phone }}</td>
              <td>{{ item.created_at }}</td>
              <td>{{ item.posts }}</td>
              <td>{{ item.comments }}</td>
              <td>{{ item.tags }}</td>
              <td>
                <v-btn
                  v-show="user.usertype == 0"
                  class="mr-3"
                  icon
                  @click="createpost(item)"
                  color="primary"
                >
                  <v-icon>list</v-icon>
                </v-btn>
                <v-btn
                  v-show="user.usertype == 1 || user.usertype == 0"  
                  icon
                  class="mr-3"
                  @click="gotoMymembers(item)"
                  color="primary"
                >
                  <v-icon>account_circle</v-icon>
                </v-btn>

                <v-btn v-show="user.usertype == 2 || user.usertype == 0" icon @click="gotoComments(item)" color="primary">
                  <v-icon>comments</v-icon>
                </v-btn>
              </td>
            </tr>
          </tbody>
        </v-simple-table>
    </div>
    <div v-else align="center">
      No faceboook groups found
    </div>
    </v-container>
  </div>
</template>

<script>
import Vue from "vue";
import api from "Api";
import VueClipboard from "vue-clipboard2";

Vue.use(VueClipboard);

export default {
  data() {
    return {
      loader: true,
      groupsList: null,
      user: null
    };
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    getUsers() {
      this.user = JSON.parse(localStorage.getItem("user"));
      api
        .get("groups")
        .then(response => {
          this.loader = false;
          this.groupsList = response.data.data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    createpost(item) {
      console.log(item.id);
      this.$router.push({ name: "MyPosts", params: { id: item.id } });
    },
    gotoMymembers(item) {
      this.$router.push({ name: "MyMembers", params: { id: item.id } });
    },
    gotoComments(item) {
      this.$router.push({ name: "Comments", params: { id: item.id } });
    }
  }
};
</script>
