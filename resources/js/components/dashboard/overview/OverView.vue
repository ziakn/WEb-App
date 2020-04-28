<template>
	<v-content>
		<v-container fluid>
			<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
			<AdminOverView :dataList="dataList" v-if="user_type_id==1" ></AdminOverView>
			<BDMOverView :dataList="dataList" v-if="user_type_id==2" ></BDMOverView>
			<BDEOverView :dataList="dataList" v-if="user_type_id==3"></BDEOverView>
			<TeleSaleOverView :dataList="dataList" v-if="user_type_id==4"></TeleSaleOverView>
			<AccountantOverView :dataList="dataList" v-if="user_type_id==5"></AccountantOverView>
		</v-container> 
	</v-content>
</template>

<script>
import AdminOverView from "./../common/AdminOverView";
import BDMOverView from "./../common/BDMOverView";
import BDEOverView from "./../common/BDEOverView";
import TeleSaleOverView from "./../common/TeleSaleOverView";
import AccountantOverView from "./../common/AccountantOverView";
export default {
	components: {
		AdminOverView,
		BDMOverView,
		BDEOverView ,
		TeleSaleOverView,
		AccountantOverView,
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