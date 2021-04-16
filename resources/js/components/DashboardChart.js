import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import {Bar} from 'react-chartjs-2';

function DashboardChart() {
    const [labels,setLabels] = useState([1,2,3,4]);
    const [data,setData] = useState([2,4,8,16]);
    /* useEffect(()=>{
      const ctx = document.getElementById("myChart");
      const myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: {labels},
            datasets: [{
              data: {data},
              lineTension: 0,
              backgroundColor: 'transparent',
              borderColor: '#007bff',
              borderWidth: 4,
              pointBackgroundColor: '#007bff'
            }]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: false
                }
              }]
            },
            legend: {
              display: false,
            }
          }
        });
    },[]) */
   
    return (
      <>      
        <h4>Chart</h4>
        <Bar
          width={600}
          height={400}
          data={{
            labels:{labels}
          }}
          />
      </>
    );
}

export default DashboardChart;

if (document.getElementById('react-chart')) {
    ReactDOM.render(<DashboardChart />, document.getElementById('react-chart'));
}
