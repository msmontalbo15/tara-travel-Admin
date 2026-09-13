<?php $d = $destination; ?>

<div class="grid sm:grid-cols-2 gap-5 mb-5">
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-ink/80 mb-1.5">Name</label>
        <input type="text" name="name" required value="<?php echo e(old('name', $d?->name)); ?>"
               class="w-full rounded-lg border border-black/10 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
    </div>

    <div>
        <label class="block text-sm font-medium text-ink/80 mb-1.5">Emoji</label>
        <input type="text" name="photo_emoji" maxlength="8" value="<?php echo e(old('photo_emoji', $d?->photo_emoji ?? '🌏')); ?>"
               class="w-full rounded-lg border border-black/10 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
    </div>

    <div>
        <label class="block text-sm font-medium text-ink/80 mb-1.5">Tag</label>
        <input type="text" name="tag" placeholder="Beach, City, Nature…" value="<?php echo e(old('tag', $d?->tag)); ?>"
               class="w-full rounded-lg border border-black/10 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
    </div>

    <div>
        <label class="block text-sm font-medium text-ink/80 mb-1.5">Distance from Metro Manila</label>
        <input type="text" name="distance_from_metro" placeholder="~590 km from Manila" value="<?php echo e(old('distance_from_metro', $d?->distance_from_metro)); ?>"
               class="w-full rounded-lg border border-black/10 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
    </div>

    <div>
        <label class="block text-sm font-medium text-ink/80 mb-1.5">Best mode of transport</label>
        <input type="text" name="best_mode" placeholder="✈️ Plane" value="<?php echo e(old('best_mode', $d?->best_mode)); ?>"
               class="w-full rounded-lg border border-black/10 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
    </div>

    <div>
        <label class="block text-sm font-medium text-ink/80 mb-1.5">Average cost range</label>
        <input type="text" name="avg_cost_range" placeholder="₱8,000–₱15,000" value="<?php echo e(old('avg_cost_range', $d?->avg_cost_range)); ?>"
               class="w-full rounded-lg border border-black/10 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
    </div>

    <div>
        <label class="block text-sm font-medium text-ink/80 mb-1.5">Best time to visit</label>
        <input type="text" name="best_time_to_visit" placeholder="Nov–May" value="<?php echo e(old('best_time_to_visit', $d?->best_time_to_visit ?? 'Year-round')); ?>"
               class="w-full rounded-lg border border-black/10 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-ink/80 mb-1.5">Description</label>
        <textarea name="description" rows="3"
                  class="w-full rounded-lg border border-black/10 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500"><?php echo e(old('description', $d?->description)); ?></textarea>
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-ink/80 mb-1.5">Recommended reason <span class="text-black/40 font-normal">(shown when "Recommended" is on)</span></label>
        <input type="text" name="recommended_reason" placeholder="Popular right now" value="<?php echo e(old('recommended_reason', $d?->recommended_reason)); ?>"
               class="w-full rounded-lg border border-black/10 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
    </div>

    <div class="sm:col-span-2 flex flex-wrap gap-5 pt-1">
        <label class="flex items-center gap-2 text-sm text-ink/80">
            <input type="checkbox" name="is_trending" value="1" <?php if(old('is_trending', $d?->is_trending)): echo 'checked'; endif; ?> class="rounded border-black/20 text-coral-500 focus:ring-coral-500">
            Trending
        </label>
        <label class="flex items-center gap-2 text-sm text-ink/80">
            <input type="checkbox" name="is_weekend_getaway" value="1" <?php if(old('is_weekend_getaway', $d?->is_weekend_getaway)): echo 'checked'; endif; ?> class="rounded border-black/20 text-coral-500 focus:ring-coral-500">
            Weekend getaway
        </label>
        <label class="flex items-center gap-2 text-sm text-ink/80">
            <input type="checkbox" name="is_recommended" value="1" <?php if(old('is_recommended', $d?->is_recommended)): echo 'checked'; endif; ?> class="rounded border-black/20 text-coral-500 focus:ring-coral-500">
            Recommended
        </label>
    </div>
</div>
<?php /**PATH D:\Spencer\Downloads\tara-admin\resources\views\admin\destinations\_form.blade.php ENDPATH**/ ?>