<?php $__env->startSection('title', 'Trips'); ?>

<?php $__env->startSection('content'); ?>

    <form method="GET" class="mb-6 flex flex-wrap gap-2 max-w-2xl">
        <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Search trip name…"
               class="flex-1 min-w-[200px] rounded-lg border border-black/10 px-3.5 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
        <select name="status" class="rounded-lg border border-black/10 px-3.5 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
            <option value="">All statuses</option>
            <?php $__currentLoopData = ['draft', 'planned', 'active', 'completed', 'archived']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s); ?>" <?php if(request('status') === $s): echo 'selected'; endif; ?>><?php echo e(ucfirst($s)); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button type="submit" class="rounded-lg bg-coral-500 text-white text-sm font-medium px-4 py-2 hover:bg-coral-600 transition">Filter</button>
    </form>

    <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-[11px] font-mono uppercase tracking-wide text-black/40">
                    <th class="px-6 py-3 font-medium">Trip</th>
                    <th class="px-6 py-3 font-medium">Owner</th>
                    <th class="px-6 py-3 font-medium">Members</th>
                    <th class="px-6 py-3 font-medium">Expenses</th>
                    <th class="px-6 py-3 font-medium">Dates</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                <?php $__empty_1 = true; $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-black/[0.02] cursor-pointer" onclick="window.location='<?php echo e(route('admin.trips.show', $trip)); ?>'">
                        <td class="px-6 py-3.5">
                            <p class="font-medium text-ink"><?php echo e($trip->name); ?></p>
                            <p class="text-xs text-black/40"><?php echo e($trip->destination); ?></p>
                        </td>
                        <td class="px-6 py-3.5 text-black/70"><?php echo e($trip->owner?->display_name ?? '—'); ?></td>
                        <td class="px-6 py-3.5 font-mono text-black/70"><?php echo e($trip->members_count); ?></td>
                        <td class="px-6 py-3.5 font-mono text-black/70"><?php echo e($trip->expenses_count); ?></td>
                        <td class="px-6 py-3.5 font-mono text-xs text-black/50"><?php echo e($trip->start_date->format('M j')); ?> – <?php echo e($trip->end_date->format('M j, Y')); ?></td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-mono bg-<?php echo e($trip->statusColor()); ?>-100 text-<?php echo e($trip->statusColor()); ?>-700">
                                <?php echo e(ucfirst($trip->status)); ?>

                            </span>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="px-6 py-10 text-center text-black/40">No trips match those filters.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6"><?php echo e($trips->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Spencer\Downloads\tara-admin\resources\views\admin\trips\index.blade.php ENDPATH**/ ?>