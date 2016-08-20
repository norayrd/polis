/**
 * Grid-light theme for Highcharts JS
 * @author Torstein Honsi
 */

// Load the fonts
Highcharts.createElement('link', {
	href: '//fonts.googleapis.com/css?family=Dosis:400,600',
	rel: 'stylesheet',
	type: 'text/css'
}, null, document.getElementsByTagName('head')[0]);

Highcharts.theme = {
	colors: ["#3D93E6", "#FF0000", "#FF7735", "#3D93E6", "#aaeeee", "#ff0066", "#eeaaee",
		"#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
	chart: {
		backgroundColor: null,
		style: {
			fontFamily: "arial, sans-serif"
		}
	},
	title: {
		style: {
			fontSize: '18px',
                        //textTransform: 'uppercase',
			fontWeight: 'bold'
			
		}
	},
	tooltip: {
		borderWidth: 1,
		backgroundColor: 'rgba(255,255,255,0.95)',
		shadow: false
	},
	legend: {
		itemStyle: {
			fontWeight: 'bold',
			fontSize: '13px'
		}
	},
	xAxis: {
		gridLineColor: '#707073',
                labels: {
                   style: {
                      color: '#696969'
                   }
                },
                lineColor: '#707073',
                minorGridLineColor: '#505053',
                tickColor: '#707073',
                title: {
                   style: {
                      color: '#A0A0A3'

                   }
                }
	},
	yAxis: {
		gridLineColor: '#707073',
                labels: {
                   style: {
                      color: '#696969'
                   }
                },
                lineColor: '#707073',
                minorGridLineColor: '#505053',
                tickColor: '#707073',
                tickWidth: 1,
                title: {
                   style: {
                      color: '#A0A0A3'
                   }
                }
	},
	plotOptions: {
		candlestick: {
			lineColor: '#404048'
		}
	},


	// General
	background2: '#F0F0EA'

};

// Apply the theme
Highcharts.setOptions(Highcharts.theme);
