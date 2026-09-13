<?php $__env->startSection('title', 'Users'); ?>

<?php $__env->startSection('content'); ?>

    <form method="GET" class="mb-6 flex gap-2 max-w-md">
        <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Search name or email…"
               class="flex-1 rounded-lg border border-black/10 px-3.5 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
        <button type="submit" class="rounded-lg bg-coral-500 text-white text-sm font-medium px-4 py-2 hover:bg-coral-600 transition">Search</button>
    </form>

    <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-[11px] font-mono uppercase tracking-wide text-black/40">
                    <th class="px-6 py-3 font-medium">Traveler</th>
                    <th class="px-6 py-3 font-medium">Home city</th>
                    <th class="px-6 py-3 font-medium">Trips</th>
                    <th class="px-6 py-3 font-medium">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-black/[0.02] cursor-pointer" onclick="window.location='<?php echo e(route('admin.users.show', $user)); ?>'">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-coral-100 text-coral-700 flex items-center justify-center text-xs font-semibold shrink-0">
                                    <?php echo e(strtoupper(substr($user->display_name ?: $user->email, 0, 1))); ?>

                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-ink truncate"><?php echo e($user->display_name ?: '(no name set)'); ?></p>
                                    <p class="text-xs text-black/40 truncate"><?php echo e($user->email); ?></p>
                                </div>
                                <?php if($user->is_online): ?>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0" title="Online"></span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 text-black/70"><?php echo e($user->home_city ?: '—'); ?></td>
                        <td class="px-6 py-3.5 font-mono text-black/70"><?php echo e($user->trip_count); ?></td>
                        <td class="px-6 py-3.5 font-mono text-xs text-black/50"><?php echo e($user->created_at->format('M j, Y')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="px-6 py-10 text-center text-black/40">No travelers match that search.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6"><?php echo e($users->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Spencer\Downloads\tara-admin\resources\views\admin\users\index.blade.php ENDPATH**/ ?>