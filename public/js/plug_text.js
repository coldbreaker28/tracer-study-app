// Chart.Chart.pluginService.register({
//     beforeDraw: function(chart) {
//         if (chart.config.centerText.display !== null &&
//             typeof chart.config.centerText.display !== 'undefined' &&
//             chart.config.centerText.display) {
//             drawTotals(chart);
//         }
//     },
// });
// function drawTotals(chart) {
 
//     var width = chart.chart.width,
//     height = chart.chart.height,
//     ctx = chart.chart.ctx;
 
//     ctx.restore();
//     var fontSize = (height / 114).toFixed(2);
//     ctx.font = fontSize + "em sans-serif";
//     ctx.textBaseline = "middle";
 
//     var text = chart.config.centerText.text,
//     textX = Math.round((width - ctx.measureText(text).width) / 2),
//     textY = height / 2;
 
//     ctx.fillText(text, textX, textY);
//     ctx.save();
// }
 
// window.onload = function() {
//     var ctx = document.getElementById("pengisianData").getContext("2d");
//     window.myDoughnut = new Chart(ctx, config);
// };
// Chart.plugins.register({
//     afterDraw: function(chart) {
//         if (chart.config.options.centerText && chart.config.options.centerText.display) {
//             var ctx = chart.chart.ctx;
//             var width = chart.chart.width;
//             var height = chart.chart.height;

//             ctx.restore();
//             var fontSize = (height / 114).toFixed(2);
//             ctx.font = fontSize + "em sans-serif";
//             ctx.textBaseline = "middle";

//             var text = chart.config.options.centerText.text;
//             var textX = Math.round((width - ctx.measureText(text).width) / 2);
//             var textY = height / 2;

//             ctx.fillText(text, textX, textY);
//             ctx.save();
//         }
//     }
// });

const centerTextPlugin = {
    id: 'centerText',
    beforeDraw: function(chart) {
        if (chart.config.options.centerText.display) {
            var width = chart.width,
                height = chart.height,
                ctx = chart.ctx;

            ctx.restore();
            var fontSize = (height / 114).toFixed(2);
            ctx.font = fontSize + "em sans-serif";
            ctx.textBaseline = "middle";

            var text = chart.config.options.centerText.text,
                textX = Math.round((width - ctx.measureText(text).width) / 2),
                textY = height / 2;

            ctx.fillText(text, textX, textY);
            ctx.save();
        }
    }
};
