$(function () {
        var date = Date.today().addDays(-30);
        new Date().toString('MMM dd') ;
        var datePoints = [];
        /*for(var i=0; i <= 30; i++){
            datePoints[i] = {x: date, y:i};
            date = date.addDays(1);
        }*/

        //Better to construct options first and then pass it as a parameter
        var options = {
            exportEnabled: true,
            animationEnabled: true,
            axisX:{
                lineColor: "#ebebeb",
                minimum: 0,
                viewportMinimum: 0,
                viewportMaximum: axisXviewportMaximum,
                interval:2,
                intervalType: "day",
                valueFormatString: "MMM-YY"
            },
            axisY:{
                lineColor: "#ebebeb",
                suffix: "",
                minimum: 0,
                viewportMinimum: 0,
                viewportMaximum: axisYviewportMaximum
            },
            data: [
            {
                type: "candlestick", //change it to line, area, bar, pie, etc
                color: "#e7e8e8",
                markerType: "none",
                dataPoints: datePoints
            },
            {
                type: "line", //change it to line, area, bar, pie, etc
                color: "#5A7D5D",
                lineThickness: 3,
                markerType: "none",
                dataPoints: instagramStatPoints
            }
            ]
	};

	$("#chartContainer").CanvasJSChart(options);

});