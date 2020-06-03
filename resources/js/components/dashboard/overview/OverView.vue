<template>
	<v-content>
		<v-container fluid>
			<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
			<AdminOverView :dataList="dataList" :dataDay="dataDay" v-if="user_type_id ==1 "  ></AdminOverView>
			<SubAdminOverView :dataList="dataList" v-if="user_type_id ==2 "></SubAdminOverView>
			<MachineOverView :dataList="dataList" v-if="user_type_id ==3 "></MachineOverView>
		</v-container> 
	</v-content>
</template>

<script>
import AdminOverView from "./../common/AdminOverView";
import SubAdminOverView from "./../common/SubAdminOverView";
import MachineOverView from "./../common/MachineOverView";
export default {
	components: {
		AdminOverView,
		SubAdminOverView,
		MachineOverView
    },
	data: () => ({
        	absolute: true,
			dataList: {},
			dataDay:[],
			user_type_id:null,	
	}),

	props: {
	},
	computed: {	

	},
	watch: {},

	created() {
		this.user_type_id = this.$store.state.authUser.userType
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
			

			try {
				let { data } = await axios({
					method: "get",
					url: "/app/superadmindashboardoverview"
				});
				this.dataDay = data;
				
			} catch (e) {
							this.loading=false;                
			}
			console.log(this.dataDay)
        },
        
		
		
	
	
	
		
	}
};
</script>