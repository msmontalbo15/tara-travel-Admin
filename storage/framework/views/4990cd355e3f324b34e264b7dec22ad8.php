<?php $__env->startSection('title', 'Destinations'); ?>

<?php $__env->startSection('header-actions'); ?>
    <a href="<?php echo e(route('admin.destinations.create')); ?>" class="rounded-lg bg-coral-500 hover:bg-coral-600 text-white text-sm font-medium px-4 py-2 transition">
        Add destination
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <p class="text-sm text-black/50 mb-6">These cards feed the Explore tab in the app directly — changes here are live.</p>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php $__empty_1 = true; $__currentLoopData = $destinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $destination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-xl border border-black/5 p-5">
                <div class="flex items-start justify-between mb-3">
                    <span class="text-3xl"><?php echo e($destination->photo_emoji ?: '🌏'); ?></span>
                    <div class="flex gap-1.5">
                        <?php if($destination->is_trending): ?>
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-mono bg-coral-100 text-coral-700">Trending</span>
                        <?php endif; ?>
                        <?php if($destination->is_weekend_getaway): ?>
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-mono bg-sky-100 text-sky-700">Weekend</span>
                        <?php endif; ?>
                    </div>
                </div>
                <h3 class="font-semibold text-ink mb-0.5"><?php echo e($destination->name); ?></h3>
                <p class="text-xs text-black/40 mb-3"><?php echo e($destination->tag); ?> · <?php echo e($destination->distance_from_metro ?: 'Distance not set'); ?></p>
                <?php if($destination->description): ?>
                    <p class="text-sm text-black/60 mb-3 line-clamp-2"><?php echo e($destination->description); ?></p>
                <?php endif; ?>
                <div class="flex items-center justify-between text-xs font-mono text-black/50 mb-4">
                    <span><?php echo e($destination->avg_cost_range ?: '—'); ?></span>
                    <span><?php echo e($destination->best_mode ?: '—'); ?></span>
                </div>
                <div class="flex gap-2 pt-3 border-t border-black/5">
                    <a href="<?php echo e(route('admin.destinations.edit', $destination)); ?>"
                       class="flex-1 text-center rounded-lg border border-black/10 text-ink text-xs font-medium py-2 hover:bg-black/[0.03] transition">Edit</a>
                    <form method="POST" action="<?php echo e(route('admin.destinations.destroy', $destination)); ?>"
                          onsubmit="return confirm('Remove <?php echo e(addslashes($destination->name)); ?> from Explore?');" class="flex-1">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="w-full rounded-lg border border-rose-200 text-rose-600 text-xs font-medium py-2 hover:bg-rose-50 transition">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-black/40 col-span-full text-center py-10">No destinations yet — add the first one.</p>
        <?php endif; ?>
    </div>

    <div class="mt-6"><?php echo e($destinations->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Spencer\Downloads\tara-admin\resources\views\admin\destinations\index.blade.php ENDPATH**/ ?>