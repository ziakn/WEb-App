<script>
import { Pie } from "vue-chartjs";

export default {
  extends: Pie,
   props:
      {
             dataList:Object
             
      },
       data() {
    return {
    
   myData:{},
   customer:[],
    zone_no:[],
      
    
    };
  },
   watch: {
    dataList() {
      this.myData=this.dataList;
      if(this.myData)
          {
          for(let p of this.myData)
                      {
                          this.customer.push(p.qunatity_produce)
                           this.zone_no.push(p.zone_no)
                      }

                  this.renderChart(
      {
        labels: this.zone_no,
        datasets: [
          {
            
            backgroundColor: [ 
            "#F9EBEA", "#00D8FF", "#D7BDE2","#7FB3D5","#1ABC9C","#229954","#B7950B","#6E2C00","#6E2C00","#6E2C00","#E74C3C",
            "#4A235A","#F4D03F","#E67E22","#F0B27A","#F0B27A","#186A3B","#F8BBD0","#F06292","#03A9F4","#03A9F4","#CCFF66",
            "#CCCC00","#CCCC00", "#33FFFF","D7BDE2","#9900FF","#660099","#FF0033","#330000","#FF9933","#6C3483","#FFFF00",
            "#00FFFF","#E91E63","#F1C40F","#28B463","#0E6251","#6C3483","#2980B9","#E91E63","#330000","#2980B9","#0E6251",
            "#2980B9","#6C3483","#2980B9","#0E6251","#0E6251","#6C3483","#E91E63","#28B463","#FF9933","#33FFFF","#F1C40F",
            "#6C3483","#28B463","#FFFF00","#00FFFF","F0B27A","#FF0033","D7BDE2","#FF9933","#E91E63", "#F1C40F","#2980B9",
            "#660099","F0B27A","#F06292","#03A9F4","#186A3B","#F8BBD0","#03A9F4","#2980B9", "#2980B9","#FFFF00","#33FFFF",
            "#330000","#F1C40F","#0E6251","#00FFFF","#660099","#FF0033","#FF9933","#28B463","#6C3483","#2980B9","#E91E63",
            "#28B463","#CCCC00","#03A9F4","#03A9F4","#F06292","#2980B9","#186A3B","#F8BBD0","#E91E63","#28B463",
          ],
            data: this.customer
          },
          
        ]
      },
      { responsive: true, maintainAspectRatio: false }
    );    
          }
    }
   },
  mounted() {
   

    
    
  },
    
    created()
    {
        
    }
};
</script>