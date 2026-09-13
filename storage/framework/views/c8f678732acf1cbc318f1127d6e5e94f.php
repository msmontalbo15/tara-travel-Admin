<?php $__env->startSection('title', 'Settlements'); ?>

<?php $__env->startSection('content'); ?>

    <div class="flex gap-1.5 mb-6">
        <?php $tabs = ['all' => 'All', 'unsettled' => 'Unsettled', 'sent' => 'Sent', 'confirmed' => 'Confirmed']; ?>
        <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('admin.settlements.index', ['status' => $key])); ?>"
               class="rounded-full px-3.5 py-1.5 text-sm font-medium transition
                      <?php echo e($status === $key ? 'bg-coral-500 text-white' : 'bg-white text-black/60 border border-black/10 hover:border-coral-300'); ?>">
                <?php echo e($label); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-[11px] font-mono uppercase tracking-wide text-black/40">
                    <th class="px-6 py-3 font-medium">Trip</th>
                    <th class="px-6 py-3 font-medium">From → To</th>
                    <th class="px-6 py-3 font-medium">Amount</th>
                    <th class="px-6 py-3 font-medium">Method</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                <?php $__empty_1 = true; $__currentLoopData = $settlements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $settlement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-3.5">
                            <a href="<?php echo e(route('admin.trips.show', $settlement->trip)); ?>" class="text-coral-600 hover:text-coral-700"><?php echo e($settlement->trip->name); ?></a>
                        </td>
                        <td class="px-6 py-3.5 text-black/70"><?php echo e($settlement->fromUser?->display_name ?? '—'); ?> → <?php echo e($settlement->toUser?->display_name ?? '—'); ?></td>
                        <td class="px-6 py-3.5 font-mono text-ink">₱<?php echo e(number_format($settlement->amount, 2)); ?></td>
                        <td class="px-6 py-3.5 text-black/60"><?php echo e($settlement->method ? strtoupper($settlement->method) : '—'); ?></td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-mono bg-<?php echo e($settlement->statusColor()); ?>-100 text-<?php echo e($settlement->statusColor()); ?>-700">
                                <?php echo e(ucfirst($settlement->status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-right">
                            <?php if($settlement->status !== 'confirmed'): ?>
                                <form method="POST" action="<?php echo e(route('admin.settlements.confirm', $settlement)); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium px-3 py-1.5 transition">Mark confirmed</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="px-6 py-10 text-center text-black/40">No settlements match this filter.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6"><?php echo e($settlements->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Spencer\Downloads\tara-admin\resources\views\admin\settlements\index.blade.php ENDPATH**/ ?>