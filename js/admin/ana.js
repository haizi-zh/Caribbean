$(document).ready(function(){


    var units = [];

    Highcharts.setOptions({
        global:{
             useUTC:false
        },
        lang: {
            shortMonths: ['一月', '二月', '三月', '四月', '五月', '六月',
                        '七月', '八月', '九月', '十月', '十一月', '十二月'],
            weekdays: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
        },
        credits: {
            enabled: false,
            text: 'zanbai',
            href: 'http://zanbai.com',
            position: {
                align: 'right',
                x: -10,
                verticalAlign: 'bottom',
                y: -2
            },
            style: {
                cursor: 'pointer',
                color: '#909090',
                fontSize: '9px'
            }
        }
    });

    $('#nav_uls').click(function(e){
        if($('#container').highcharts()){
            $('#container').highcharts().destroy();
        }
        var el = e.target || e.srcElement;
        var strArgs = el.getAttribute('node-data');
        
        $.getJSON('/aj/ana/get_chart_data_new', {business:strArgs}, function(ret){
            units = [];
            var data = [];
            for(var i in ret){
                data.push(ret[i]);
                units.push(ret[i].unit);
            }
            $('#container').highcharts('StockChart', {
                rangeSelector : {
                    enabled: false
                },
                title : {
                    text : ''
                },
                xAxis: {
                    dateTimeLabelFormats: {
                        second: '%Y-%m-%d<br/>%H:%M:%S',
                        minute: '%Y-%m-%d<br/>%H:%M',
                        hour: '%Y-%m-%d<br/>%H:%M',
                        day: '%Y<br/>%m-%d',
                        week: '%Y<br/>%m-%d',
                        month: '%Y-%m',
                        year: '%Y'
                     }
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                    min: 0
                },
                series : data,

                tooltip:{
                    xDateFormat: '%Y-%m-%d, %A', //鼠标移动到趋势线上时显示的日期格式
                    formatter: function(){
                        // console.log(Highcharts.dateFormat('%m-%d<br/>%H:%M', this.x));
                        var d = '<b>'+ Highcharts.dateFormat('%m-%d', this.x) +'</b>';
                        var s = '';
                        var count = 0;
                        $.each( this.points , function(i, point) {
                            count = count + point.y;
                            s += '<br/><span style="color:">'+point.series.name+'</span>: <b>'+  Math.ceil(point.y) +'</b> '+units[i];
                        });
                        d += '<br/><span style="color:">总共</span>:<b>'+count+'</b>';
                        return d+s;
                    }
                }
            });
        });
    });

    $('#nav_uls li:first').children().click();

});