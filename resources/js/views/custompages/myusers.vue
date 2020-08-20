<template>
  <div>
    <page-title-bar></page-title-bar>
    <app-section-loader :status="loader"></app-section-loader>
    <v-container class="grid-list-xl pt-0 mt-n3" v-if="usersList !== null">
      <div  v-if="usersList.length > 0 "> 
        <v-simple-table>
          <thead>
            <tr>
              <th class="text-left">Name</th>
              <th class="text-left">Email</th>
              <th class="text-left">Type</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in usersList" :key="item.id">
              <td>{{ item.name }}</td>
              <td>{{ item.email }}</td>
              <td>{{ item.type }}</td>
            </tr>
          </tbody>
        </v-simple-table>
      </div>
      <div v-else align="center">
        No user found
      </div>
    </v-container>
  </div>
</template>

<script>
import api from "Api";

export default {
  data() {
    return {
      loader: true,
      usersList: null,
      connectUsersList: null
    };
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    getUsers() {
      api
        .get("users")
        .then(response => {
          this.loader = false;
          this.usersList = response.data.data;
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>
