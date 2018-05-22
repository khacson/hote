<script type="text/javascript">
$(function () {
	$('#container2').highcharts({
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Thống kê theo loại hàng hóa'
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
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:,.0f} sản phẩm</b>  <br/>'
        },
        series: [{
            name: 'Loại sản phẩm',
            colorByPoint: true,
            data: [<?=$billPrice;?>]
        }],
    });
});
</script>
<div id="container2" style="min-width: 310px; max-width: 600px; height: 400px; margin: 0 auto"></div>