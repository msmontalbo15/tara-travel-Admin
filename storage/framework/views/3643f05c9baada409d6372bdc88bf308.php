<?php $__env->startSection('title', 'Edit destination'); ?>

<?php $__env->startSection('content'); ?>

    <a href="<?php echo e(route('admin.destinations.index')); ?>" class="text-sm text-black/50 hover:text-ink mb-5 inline-block">← All destinations</a>

    <div class="bg-white rounded-xl border border-black/5 p-6 max-w-2xl">
        <form method="POST" action="<?php echo e(route('admin.destinations.update', $destination)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <?php echo $__env->make('admin.destinations._form', ['destination' => $destination], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div class="flex items-center gap-3">
                <button type="submit" class="rounded-lg bg-coral-500 hover:bg-coral-600 text-white text-sm font-medium px-5 py-2.5 transition">
                    Save changes
                </button>
                <a href="<?php echo e(route('admin.destinations.index')); ?>" class="text-sm text-black/50 hover:text-ink">Cancel</a>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Spencer\Downloads\tara-admin\resources\views\admin\destinations\edit.blade.php ENDPATH**/ ?>