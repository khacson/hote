<script type="text/javascript">
$(function () {
	$('#containersalary').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: 'Doanh thu bán hàng từ <?=$dates;?>'
				},
				subtitle: {
					//text: 'Click the columns to view versions. Source: <a href="#"></a>.'
				},
				xAxis: {
					type: 'category'
				},
				yAxis: {
					title: {
						text: 'Triệu'
					}

				},
				legend: {
					enabled: false
				},
				plotOptions: {
					series: {
						borderWidth: 0,
						dataLabels: {
							enabled: true,
							format: '{point.y:f} triệu'
						}
					}
				},
				tooltip: {
					headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
					pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f} triệu </b> <br/>'
				},

				series: [{
					name: 'Doanh thu bán hàng',
					colorByPoint: true,
					data: [<?=$listdate;?>]
				}]
			});
});
</script>
<div id="containersalary" style="height: 400px; margin: 0 auto"></div>