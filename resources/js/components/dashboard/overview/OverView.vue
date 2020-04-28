<template>
	<v-content>
		<v-container fluid>
			<AdminOverView :dataList="dataList"  v-if="user_type_id==1" ></AdminOverView>
		</v-container> 
	</v-content>
</template>

<script>
import AdminOverView from "./../common/AdminOverView";
export default {
	components: {
		AdminOverView,
		
    },
	data: () => ({
        	absolute: true,
			user_type_id:null,
			dataList: {},
	}),

	props: {
	},
	computed: {	

	},
	watch: {},

	created() {
		this.user_type_id = this.$store.state.authUser.user_type_id
		this.initialize();
	},
	methods: {
		async initialize() {
			
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/dashboardoverview"
				});
				this.dataList = data;
			
				
			} catch (e) {
			this.loading=false;                
			}
			
        },
		
	}
};
</script>