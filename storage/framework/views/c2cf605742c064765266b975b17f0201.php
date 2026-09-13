<?php $__env->startSection('title', 'Add destination'); ?>

<?php $__env->startSection('content'); ?>

    <a href="<?php echo e(route('admin.destinations.index')); ?>" class="text-sm text-black/50 hover:text-ink mb-5 inline-block">← All destinations</a>

    <div class="bg-white rounded-xl border border-black/5 p-6 max-w-2xl">
        <form method="POST" action="<?php echo e(route('admin.destinations.store')); ?>">
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('admin.destinations._form', ['destination' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <button type="submit" class="rounded-lg bg-coral-500 hover:bg-coral-600 text-white text-sm font-medium px-5 py-2.5 transition">
                Publish destination
            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Spencer\Downloads\tara-admin\resources\views\admin\destinations\create.blade.php ENDPATH**/ ?>