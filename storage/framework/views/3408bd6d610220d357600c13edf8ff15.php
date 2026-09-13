<?php $__env->startSection('title', 'Traveler'); ?>

<?php $__env->startSection('content'); ?>

    <a href="<?php echo e(route('admin.users.index')); ?>" class="text-sm text-black/50 hover:text-ink mb-5 inline-block">← All users</a>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-black/5 p-6">
            <div class="w-14 h-14 rounded-full bg-coral-100 text-coral-700 flex items-center justify-center text-xl font-semibold mb-4">
                <?php echo e(strtoupper(substr($user->display_name ?: $user->email, 0, 1))); ?>

            </div>
            <h2 class="text-lg font-semibold text-ink"><?php echo e($user->display_name ?: '(no name set)'); ?></h2>
            <p class="text-sm text-black/50 mb-4"><?php echo e($user->email); ?></p>

            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-black/45">Home city</dt>
                    <dd class="text-ink"><?php echo e($user->home_city ?: '—'); ?></dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-black/45">Status</dt>
                    <dd class="text-ink"><?php echo e($user->is_online ? 'Online now' : ($user->last_seen?->diffForHumans() ?? 'Never seen')); ?></dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-black/45">Health info on file</dt>
                    <dd class="text-ink"><?php echo e($user->has_health_info ? 'Yes (encrypted)' : 'None'); ?></dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-black/45">Joined</dt>
                    <dd class="text-ink font-mono text-xs"><?php echo e($user->created_at->format('M j, Y')); ?></dd>
                </div>
            </dl>
            <p class="text-xs text-black/35 mt-5 pt-4 border-t border-black/5">
                Contact, GCash, and health details are AES-encrypted app-side and aren't readable from this dashboard.
            </p>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
                <div class="px-6 py-4 border-b border-black/5">
                    <h3 class="text-sm font-semibold">Trips owned (<?php echo e($user->ownedTrips->count()); ?>)</h3>
                </div>
                <?php $__empty_1 = true; $__currentLoopData = $user->ownedTrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('admin.trips.show', $trip)); ?>" class="flex items-center justify-between px-6 py-3 text-sm hover:bg-black/[0.02] border-b border-black/5 last:border-0">
                        <span class="font-medium text-ink"><?php echo e($trip->name); ?></span>
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-mono bg-<?php echo e($trip->statusColor()); ?>-100 text-<?php echo e($trip->statusColor()); ?>-700">
                            <?php echo e(ucfirst($trip->status)); ?>

                        </span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="px-6 py-6 text-sm text-black/40">Hasn't organized a trip yet.</p>
                <?php endif; ?>
            </div>

            <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
                <div class="px-6 py-4 border-b border-black/5">
                    <h3 class="text-sm font-semibold">Trip memberships (<?php echo e($user->tripMemberships->count()); ?>)</h3>
                </div>
                <?php $__empty_1 = true; $__currentLoopData = $user->tripMemberships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membership): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('admin.trips.show', $membership->trip)); ?>" class="flex items-center justify-between px-6 py-3 text-sm hover:bg-black/[0.02] border-b border-black/5 last:border-0">
                        <span class="text-ink"><?php echo e($membership->trip->name); ?></span>
                        <span class="text-xs font-mono text-black/40"><?php echo e(collect($membership->roles)->map(fn ($r) => ucfirst($r))->join(', ')); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="px-6 py-6 text-sm text-black/40">Not a member of any trips.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Spencer\Downloads\tara-admin\resources\views/admin/users/show.blade.php ENDPATH**/ ?>