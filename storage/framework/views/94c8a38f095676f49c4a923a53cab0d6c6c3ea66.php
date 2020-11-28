<?php if(config('settings.app.show_countries_charts')): ?>
<?php
	$postsDataArr = json_decode($postsPerCountry->data, true);
	$countPostsLabels = (isset($postsDataArr['labels']) && is_array($postsDataArr['labels']) && count($postsDataArr['labels']) > 1) ? count($postsDataArr['labels']) : 0;
?>

<?php if($postsPerCountry->countCountries > 1): ?>
	<div class="col-lg-6 col-md-12">
		<div class="card rounded shadow-sm">
			<div class="card-body">
				<div class="d-flex">
					<div>
						<h4 class="card-title mb-1 font-weight-bold">
							<span class="lstick d-inline-block align-middle"></span><?php echo e($postsPerCountry->title); ?>

						</h4>
					</div>
					<div class="ml-auto">
					
					</div>
				</div>
				<div class="position-relative chart-responsive">
					<?php if($countPostsLabels > 0): ?>
						<canvas id="pieChartPosts"></canvas>
					<?php else: ?>
						<?php echo trans('admin.No data found'); ?>

					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php $__env->startPush('dashboard_styles'); ?>
	<style>
		canvas {
			-moz-user-select: none;
			-webkit-user-select: none;
			-ms-user-select: none;
		}
	</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('dashboard_scripts'); ?>
	<script>
		<?php if($postsPerCountry->countCountries > 1): ?>
		<?php if($countPostsLabels > 0): ?>
			<?php
				$postsDisplayLegend = ($countPostsLabels <= 15) ? 'true' : 'false';
			?>
			
			var config1 = {
				type: 'pie', /* pie, doughnut */
				data: <?php echo $postsPerCountry->data; ?>,
				options: {
					responsive: true,
					legend: {
						display: <?php echo e($postsDisplayLegend); ?>,
						position: 'left'
					},
					title: {
						display: false
					},
					animation: {
						animateScale: true,
						animateRotate: true
					}
				}
			};
			
			$(function () {
				var ctx = document.getElementById('pieChartPosts').getContext('2d');
				window.myPostsDoughnut = new Chart(ctx, config1);
			});
		<?php endif; ?>
		<?php endif; ?>
	</script>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /home/developer/public_html/resources/views/vendor/admin/dashboard/inc/charts/chartjs/pie/posts-per-country.blade.php ENDPATH**/ ?>