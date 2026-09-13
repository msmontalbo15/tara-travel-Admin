<?php $__env->startSection('title', 'Trip'); ?>

<?php $__env->startSection('content'); ?>

    <a href="<?php echo e(route('admin.trips.index')); ?>" class="text-sm text-black/50 hover:text-ink mb-5 inline-block">← All trips</a>

    <div class="bg-white rounded-xl border border-black/5 p-6 mb-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <?php if($trip->cover_emoji): ?><span class="text-xl"><?php echo e($trip->cover_emoji); ?></span><?php endif; ?>
                    <h2 class="text-lg font-semibold text-ink"><?php echo e($trip->name); ?></h2>
                </div>
                <p class="text-sm text-black/50"><?php echo e($trip->destination); ?> · <?php echo e($trip->start_date->format('M j')); ?> – <?php echo e($trip->end_date->format('M j, Y')); ?></p>
            </div>
            <form method="POST" action="<?php echo e(route('admin.trips.status', $trip)); ?>" class="flex items-center gap-2">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <select name="status" class="rounded-lg border border-black/10 px-3 py-1.5 text-xs font-mono bg-white focus:outline-none focus:ring-2 focus:ring-coral-500">
                    <?php $__currentLoopData = ['draft', 'planned', 'active', 'completed', 'archived']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php if($trip->status === $s): echo 'selected'; endif; ?>><?php echo e(ucfirst($s)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="submit" class="rounded-lg bg-coral-500 hover:bg-coral-600 text-white text-xs font-medium px-3 py-1.5 transition">Update</button>
            </form>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6 pt-6 border-t border-black/5">
            <div>
                <p class="text-[11px] font-mono uppercase tracking-wide text-black/40 mb-1">Owner</p>
                <p class="text-sm text-ink"><?php echo e($trip->owner?->display_name ?? '—'); ?></p>
            </div>
            <div>
                <p class="text-[11px] font-mono uppercase tracking-wide text-black/40 mb-1">Budget</p>
                <p class="text-sm font-mono text-ink"><?php echo e($trip->currency); ?> <?php echo e(number_format($trip->budget, 0)); ?></p>
            </div>
            <div>
                <p class="text-[11px] font-mono uppercase tracking-wide text-black/40 mb-1">Type / transport</p>
                <p class="text-sm text-ink"><?php echo e(ucfirst($trip->type)); ?> · <?php echo e(ucfirst($trip->transport_mode)); ?></p>
            </div>
            <div>
                <p class="text-[11px] font-mono uppercase tracking-wide text-black/40 mb-1">Itinerary stops</p>
                <p class="text-sm font-mono text-ink"><?php echo e($trip->itinerary_stops_count); ?></p>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-black/5 overflow-hidden lg:col-span-1">
            <div class="px-6 py-4 border-b border-black/5">
                <h3 class="text-sm font-semibold">Members (<?php echo e($trip->members->count()); ?>)</h3>
            </div>
            <?php $__empty_1 = true; $__currentLoopData = $trip->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between px-6 py-3 text-sm border-b border-black/5 last:border-0">
                    <span class="text-ink truncate pr-2"><?php echo e($member->user?->display_name ?? 'Unknown'); ?></span>
                    <span class="text-xs font-mono text-black/40 shrink-0"><?php echo e(collect($member->roles)->map(fn ($r) => ucfirst($r))->join(', ')); ?></span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="px-6 py-6 text-sm text-black/40">No members yet.</p>
            <?php endif; ?>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
                <div class="px-6 py-4 border-b border-black/5 flex items-center justify-between">
                    <h3 class="text-sm font-semibold">Expenses (<?php echo e($trip->expenses->count()); ?>)</h3>
                    <a href="<?php echo e(route('admin.expenses.index')); ?>" class="text-xs font-medium text-coral-600 hover:text-coral-700">Oversight queue →</a>
                </div>
                <?php $__empty_1 = true; $__currentLoopData = $trip->expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between px-6 py-3 text-sm border-b border-black/5 last:border-0">
                        <div class="min-w-0 pr-3">
                            <p class="text-ink truncate"><?php echo e($expense->description); ?></p>
                            <p class="text-xs text-black/40">Paid by <?php echo e($expense->paidBy?->display_name ?? '—'); ?></p>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="font-mono text-ink">₱<?php echo e(number_format($expense->amount, 0)); ?></p>
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-mono bg-<?php echo e($expense->statusColor()); ?>-100 text-<?php echo e($expense->statusColor()); ?>-700">
                                <?php echo e(ucfirst($expense->status)); ?>

                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="px-6 py-6 text-sm text-black/40">No expenses logged.</p>
                <?php endif; ?>
            </div>

            <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
                <div class="px-6 py-4 border-b border-black/5">
                    <h3 class="text-sm font-semibold">Settlements (<?php echo e($trip->settlements->count()); ?>)</h3>
                </div>
                <?php $__empty_1 = true; $__currentLoopData = $trip->settlements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $settlement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between px-6 py-3 text-sm border-b border-black/5 last:border-0">
                        <span class="text-ink"><?php echo e($settlement->fromUser?->display_name ?? '—'); ?> → <?php echo e($settlement->toUser?->display_name ?? '—'); ?></span>
                        <div class="text-right shrink-0">
                            <span class="font-mono text-ink">₱<?php echo e(number_format($settlement->amount, 0)); ?></span>
                            <span class="ml-2 inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-mono bg-<?php echo e($settlement->statusColor()); ?>-100 text-<?php echo e($settlement->statusColor()); ?>-700">
                                <?php echo e(ucfirst($settlement->status)); ?>

                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="px-6 py-6 text-sm text-black/40">No settlements recorded.</p>
                <?php endif; ?>
            </div>

            <?php if($trip->contributions->isNotEmpty()): ?>
                <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
                    <div class="px-6 py-4 border-b border-black/5">
                        <h3 class="text-sm font-semibold">Contributions (<?php echo e($trip->contributions->count()); ?>)</h3>
                    </div>
                    <?php $__currentLoopData = $trip->contributions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contribution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between px-6 py-3 text-sm border-b border-black/5 last:border-0">
                            <div class="min-w-0 pr-3">
                                <p class="text-ink truncate"><?php echo e($contribution->reason); ?></p>
                                <p class="text-xs text-black/40"><?php echo e($contribution->user?->display_name ?? '—'); ?></p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="font-mono text-ink">₱<?php echo e(number_format($contribution->amount, 0)); ?></p>
                                <p class="text-[11px] text-black/40"><?php echo e($contribution->confirmed ? 'Confirmed' : 'Unconfirmed'); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Spencer\Downloads\tara-admin\resources\views\admin\trips\show.blade.php ENDPATH**/ ?>