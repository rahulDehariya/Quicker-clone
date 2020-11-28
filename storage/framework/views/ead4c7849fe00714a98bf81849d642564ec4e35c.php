
<?php
$disabled = '';
if (
	(isset($xPanel) && !$xPanel->hasAccess('delete'))
	or
	(
		/* Security for Admin Users */
		\Illuminate\Support\Str::contains(\Illuminate\Support\Facades\Route::currentRouteAction(), 'UserController')
		&& (isset($entry) && $entry->can(\App\Models\Permission::getStaffPermissions()))
	)
) {
	$disabled = 'disabled="disabled"';
}
?>
<td class="dt-checkboxes-cell">
	<input name="entryId[]" type="checkbox" value="<?php echo e($entry->{$column['name']}); ?>" class="dt-checkboxes" <?php echo $disabled; ?>>
</td>
<?php /**PATH /home/developer/public_html/resources/views/vendor/admin/panel/columns/checkbox.blade.php ENDPATH**/ ?>