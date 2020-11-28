<?php if(config('settings.app.show_countries_charts')): ?>
<?php
	$usersDataArr = json_decode($usersPerCountry->data, true);
	$countUsersLabels = (isset($usersDataArr['labels']) && is_array($usersDataArr['labels']) && count($usersDataArr['labels']) > 1) ? count($usersDataArr['labels']) : 0;
?>

<?php if($usersPerCountry->countCountries > 1): ?>
	<div class="col-lg-6 col-md-12">
		<div class="card rounded shadow-sm">
			<div class="card-body">
				<div class="d-flex">
					<div>
						<h4 class="card-title mb-1 font-weight-bold">
							<span class="lstick d-inline-block align-middle"></span><?php echo e($usersPerCountry->title); ?>

						</h4>
					</div>
					<div class="ml-auto">
					
					</div>
				</div>
				<div class="position-relative chart-responsive">
					<?php if($countUsersLabels > 0): ?>
						<canvas id="pieChartUsers"></canvas>
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
		<?php if($usersPerCountry->countCountries > 1): ?>
		<?php if($countUsersLabels > 0): ?>
			<?php
				$usersDisplayLegend = ($countUsersLabels <= 15) ? 'true' : 'false';
			?>
			
			var config = {
				type: 'pie', /* pie, doughnut */
				data: <?php echo $usersPerCountry->data; ?>,
				options: {
					responsive: true,
					legend: {
						display: <?php echo e($usersDisplayLegend); ?>,
						position: 'right'
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
				var ctx = document.getElementById('pieChartUsers').getContext('2d');
				window.myUsersDoughnut = new Chart(ctx, config);
			});
		<?php endif; ?>
		<?php endif; ?>
    </script>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /home/developer/public_html/resources/views/vendor/admin/dashboard/inc/charts/chartjs/pie/users-per-country.blade.php ENDPATH**/ ?>