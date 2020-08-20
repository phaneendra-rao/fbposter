<template>
	<div>
		<v-row class="mt-10">
        	<v-col sm="12" cols="8">
    		    <app-card class="ml-4">
	    			<h2 class="mt-4">Add members</h2><br/>
					<textarea id="members" v-model="members"  class="v-textarea-addmembers" 
					 rows="6" cols="41"></textarea>
				    <v-btn class="mt-4" @click="addmembers" color="primary">Add members</v-btn>
    		    </app-card>
        	</v-col>
    	</v-row>
	</div>
</template>

<script>
	import api from "Api";
	import Swal from 'sweetalert2'
	import AppConfig from "Constants/AppConfig";
	const axios = require("axios");

	export default{
		data(){
			return{
				members:""
			}
		},
		methods:{
			addmembers(){
				let group_id = this.$route.params.id;
				let self = this;
			      api
			        .post("members", {
			          name: this.members,
			          group_id: group_id,
			        })
			        .then(response => {

			        	console.log(response);
			        	//  Swal.fire(
				        //   'posted!',
				        //   'details are psted.',
				        //   'success'
				        // )
			          self.$router.push("/default/groups/"+group_id+"/members");
			        })
			        .catch(error => {
			          console.log(error);
			        });
			}	
		}
	}
</script>

<style type="text/css">
#members {
  border: 1px solid white;
  padding: 10px;
  box-shadow: 0px 0px 0px 2px #E2E2E2;
  width: 100%;
  resize: none;
  background-color:#e0e2e1;
}
</style>