<script type="text/javascript">
	<?php if(!empty($categories)){?>
	$(function () {
		$('#container').highcharts({
			chart: {
				type: 'line'
			},
			title: {
				text: 'Thu chi'
			},
			subtitle: {
				//text: 'Source: WorldClimate.com'
			},
			xAxis: {
				categories: [<?=$categories;?>]
			},
			yAxis: {
				title: {
					text: 'Triệu đồng'
				}
			},
			plotOptions: {
				line: {
					dataLabels: {
						enabled: true
					},
					enableMouseTracking: false
				}
			},
			series: [{
				name: 'Chi',
				data: [<?=$chis;?>]
			}, {
				name: 'Thu',
				data: [<?=$thus;?>]
			}]
		});
	});
	<?php }?>
</script>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>