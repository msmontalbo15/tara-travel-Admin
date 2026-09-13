<?php $__env->startSection('title', 'Expenses'); ?>

<?php $__env->startSection('content'); ?>

    <div class="flex gap-1.5 mb-6">
        <?php
            $tabs = [
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
                'all' => 'All',
            ];
        ?>
        <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('admin.expenses.index', ['status' => $key])); ?>"
               class="rounded-full px-3.5 py-1.5 text-sm font-medium transition
                      <?php echo e($status === $key ? 'bg-coral-500 text-white' : 'bg-white text-black/60 border border-black/10 hover:border-coral-300'); ?>">
                <?php echo e($label); ?>

                <?php if($key !== 'all'): ?>
                    <span class="font-mono text-xs opacity-70"><?php echo e($counts[$key]); ?></span>
                <?php endif; ?>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="bg-white rounded-xl border border-black/5 overflow-hidden" x-data="{ rejecting: null }">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-[11px] font-mono uppercase tracking-wide text-black/40">
                    <th class="px-6 py-3 font-medium">Expense</th>
                    <th class="px-6 py-3 font-medium">Trip</th>
                    <th class="px-6 py-3 font-medium">Paid by</th>
                    <th class="px-6 py-3 font-medium">Amount</th>
                    <th class="px-6 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                <?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-3.5">
                            <p class="font-medium text-ink"><?php echo e($expense->description); ?></p>
                            <p class="text-xs text-black/40"><?php echo e(ucfirst($expense->category)); ?></p>
                        </td>
                        <td class="px-6 py-3.5">
                            <a href="<?php echo e(route('admin.trips.show', $expense->trip)); ?>" class="text-coral-600 hover:text-coral-700"><?php echo e($expense->trip->name); ?></a>
                        </td>
                        <td class="px-6 py-3.5 text-black/70"><?php echo e($expense->paidBy?->display_name ?? '—'); ?></td>
                        <td class="px-6 py-3.5 font-mono text-ink">₱<?php echo e(number_format($expense->amount, 2)); ?></td>
                        <td class="px-6 py-3.5">
                            <?php if($expense->status === 'pending'): ?>
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST" action="<?php echo e(route('admin.expenses.approve', $expense)); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium px-3 py-1.5 transition">Approve</button>
                                    </form>
                                    <button type="button" @click="rejecting = rejecting === '<?php echo e($expense->id); ?>' ? null : '<?php echo e($expense->id); ?>'"
                                            class="rounded-lg bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-medium px-3 py-1.5 transition">
                                        Reject
                                    </button>
                                </div>
                                <div x-cloak x-show="rejecting === '<?php echo e($expense->id); ?>'" class="mt-2">
                                    <form method="POST" action="<?php echo e(route('admin.expenses.reject', $expense)); ?>" class="flex items-center gap-2">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <input type="text" name="rejection_note" placeholder="Reason (optional)"
                                               class="flex-1 rounded-lg border border-black/10 px-2.5 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-rose-400">
                                        <button type="submit" class="rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-medium px-3 py-1.5 transition shrink-0">Confirm</button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <div class="text-right">
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-mono bg-<?php echo e($expense->statusColor()); ?>-100 text-<?php echo e($expense->statusColor()); ?>-700">
                                        <?php echo e(ucfirst($expense->status)); ?>

                                    </span>
                                    <?php if($expense->rejection_note): ?>
                                        <p class="text-xs text-black/40 mt-1 max-w-[220px] ml-auto"><?php echo e($expense->rejection_note); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="px-6 py-10 text-center text-black/40">Nothing here.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6"><?php echo e($expenses->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Spencer\Downloads\tara-admin\resources\views\admin\expenses\index.blade.php ENDPATH**/ ?>