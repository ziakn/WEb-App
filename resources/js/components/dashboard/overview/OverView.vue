<template>
	<v-content>
		<v-container fluid>
			<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
			<AdminOverView :dataList="dataList" ></AdminOverView>
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
			dataList: {},
			user_type_id:null,	
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