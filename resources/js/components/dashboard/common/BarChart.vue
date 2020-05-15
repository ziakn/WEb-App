<script>
import { Bar } from "vue-chartjs";

export default {
  extends: Bar,
   props:
      {
             dataList:Object
             
      },
  data() {
    return {
      gradient: null,
      gradient2: null,
   myData:{},
      qunatity_produce:[],
      start_date:[],
      machine:[],
      month:[],
      
    
    };
  },
   watch: {
    dataList() {

      this.myData=this.dataList;
      console.log(this.myData.days['04'])
      let i=0;
      if(this.myData)
          {
          for(let p of this.myData.days['04'])
                      {
                            this.qunatity_produce.push(p.qunatity_produce)
                            this.start_date.push(p.start_date)
                            this.machine.push(p.machine.name)
                      }
                       for(let p of this.myData.days['20'])
                      {
                            this.qunatity_produce.push(p.qunatity_produce)
                            this.start_date.push(p.start_date)
                      }
         
          };
          this.renderChart(
      {
        labels:  this.start_date,
        datasets: [
         
          {
            label: this.machine,
            borderColor: "#05CBE1",
            pointBackgroundColor: "white",
            pointBorderColor: "white",
            borderWidth: 1,
            backgroundColor: this.gradient2,
            data: this.qunatity_produce
          }
        ]
      },
      { responsive: true, maintainAspectRatio: false }
    );
     
    }
  },
  mounted() {
    this.gradient = this.$refs.canvas
      .getContext("2d")
      .createLinearGradient(0, 0, 0, 450);
    this.gradient2 = this.$refs.canvas
      .getContext("2d")
      .createLinearGradient(0, 0, 0, 450);

    this.gradient.addColorStop(0, "rgba(255, 0,0, 0.5)");
    this.gradient.addColorStop(0.5, "rgba(255, 0, 0, 0.25)");
    this.gradient.addColorStop(1, "rgba(255, 0, 0, 0)");

    this.gradient2.addColorStop(0, "rgba(0, 231, 255, 0.9)");
    this.gradient2.addColorStop(0.5, "rgba(0, 231, 255, 0.25)");
    this.gradient2.addColorStop(1, "rgba(0, 231, 255, 0)");

      
      
        
    
      
    
  },
  
  created()
  {
      
      
  },
  

  method:
  {
       
       
  }
};
</script>
