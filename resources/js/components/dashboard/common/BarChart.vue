<script>
import { Bar } from "vue-chartjs";

export default {
  extends: Bar,
   props:
      {
             dataMachineMonthly:Array
             
      },
  data() {
    return {
      gradient: null,
      gradient2: null,
      myData:[],
      qunatity_produce:[],
      start_date:[],
      machine:[],
      month:[],
      
    
    };
  },
   watch: {
    dataMachineMonthly() {

      this.myData=this.dataMachineMonthly;
      if(this.myData)
          {
          for(let p of this.myData)
                      {
                            this.qunatity_produce.push(p.qunatity_produce)
                            this.machine.push(p.machine.name)
                            this.start_date.push(p.start_date)
                      }
          };
    this.renderChart(
      {
        labels:  this.start_date,
        datasets: [
          {
            label: "Last 365 Days " ,
            borderColor: "#05CBE1",
            pointBackgroundColor: "white",
            pointBorderColor: "white",
            borderWidth: 1,
            backgroundColor: this.gradient,
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

    this.gradient.addColorStop(0, "rgba(25, 0, 89, 0.5)");
    this.gradient.addColorStop(0.5, "rgba(155, 0, 10, 0.25)");
    this.gradient.addColorStop(1, "rgba(55, 0, 96, 0)");

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
