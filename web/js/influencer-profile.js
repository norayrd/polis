$(function () {
    InfluencerProfile.init();
});

var InfluencerProfile = {
    init: function () {
        this.influencersCanvasPopup();
        this.influensersCanvas();

        
        $(window).resize();
        this.initProfileFixedHeaderEvent();
    },

    initProfileFixedHeaderEvent: function () {
        $(window).on('scroll', function () {
            var scrollTop = $(window).scrollTop() + $(".f_header-inner").innerHeight();
            if (scrollTop < $(".f_profile-wrapper").offset().top) {
                $("#profileHeader").addClass("is_hidden");
            } else {
                $("#profileHeader").removeClass("is_hidden");
            }
        });
    },

    influencersCanvasPopup: function () {
        
        
        $(".f_profile-section-footer").on('click', function () {
            $(".f_profile-section-footer").removeClass("is_active");
            $(this).toggleClass("is_active");
        });
        
        $(window).on('click', function (event) {
            if ($(event.target).closest(".f_profile-section-footer").length < 1) {
                $(".f_profile-section-footer").removeClass("is_active");
            }
        });
    },
    influensersCanvas: function(){
        jQuery(function () {
            $(function () {
                $('#container1').highcharts({
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        categories: ['test'],
                        title: {
                            text: null
                        }
                    },
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: '(%)',
                            align: 'high'
                        },
                        labels: {
                            overflow: 'justify'
                        }
                    },
                    tooltip: {
                        valueSuffix: ' %'
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: false
                            }
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: 0,
                        y: 0,
                        floating: false,
                        borderWidth: 0,
                        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#f2f2f2'),
                        shadow: false
                    },
                    credits: {
                        enabled: false
                    },
                    series: keywordData,
                });
                
            });



            $(function () {
                $('#container2').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: ''
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: 0,
                        y: 0,
                        floating: false,
                        borderWidth: 0,
                        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#f2f2f2'),
                        shadow: false
                    },
                    xAxis: {
                        categories: [
                            'Jan'
                        ]
                    },
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: ''
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: engagementData,
                });
            });

            $(function () {
                $('#container3').highcharts({
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        categories: ['Likes', 'Coments'],
                        title: {
                            text: null
                        }
                    },
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: '(%)',
                            align: 'high'
                        },
                        labels: {
                            overflow: 'justify'
                        }
                    },
                    tooltip: {
                        valueSuffix: ' %'
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: false
                            }
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: 0,
                        y: 0,
                        floating: false,
                        borderWidth: 0,
                        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#f2f2f2'),
                        shadow: false
                    },
                    credits: {
                        enabled: false
                    },
                    series: [{
                        name: 'Some Text 1',
                        data: [10, 30]
                    }, {
                        name: 'Some Text 2',
                        data: [20, 10]
                    }, {
                        name: 'Some Text 3',
                        data: [80, 70]
                    }]
                });
            });


            $(function () {
                $('#container4').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: ''
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: 0,
                        y: 0,
                        floating: false,
                        borderWidth: 0,
                        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#f2f2f2'),
                        shadow: false
                    },
                    xAxis: {
                        categories: [
                            'Jan',
                            'Feb'
                        ]
                    },
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: ''
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: 'Tokyo',
                        data: [49.9, 71.5]

                    }, {
                        name: 'New York',
                        data: [83.6, 78.8]

                    }, {
                        name: 'London',
                        data: [48.9, 38.8]

                    }]
                });
            });

        });
    }
};



