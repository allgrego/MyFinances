import React from 'react';
import ReactDOM from 'react-dom';

function DashboardChart() {
    return (
        <canvas className="my-4 chartjs-render-monitor" id="myChart" width="696" height="293" style={{
            display: "block",
            width: "696px",
            height: "293px"
        }}></canvas>
    );
}

export default DashboardChart;

if (document.getElementById('react-chart')) {
    ReactDOM.render(<DashboardChart />, document.getElementById('react-chart'));
}
