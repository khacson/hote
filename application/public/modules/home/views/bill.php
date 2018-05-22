<script type="text/javascript">
$(function () {
	$('#container').highcharts({
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Thống kê theo đơn hàng xuất'
        },
        subtitle: {
            text: ''
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:f} đơn hàng</b>  <br/>'
        },
        series: [{
            name: 'Ngày',
            colorByPoint: true,
            data: [<?=$bill;?>]
        }],
    });
});
</script>
<div id="container" style="min-width: 310px; max-width: 600px; height: 400px; margin: 0 auto"></div>