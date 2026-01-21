<?php
$user = auth()->user();
?>

<div
class="custom-sidebar-footer flex flex-col border-t border-gray-200/50 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02] backdrop-blur-sm transition-all duration-300"
  x-data="{
        isFooterOpen: JSON.parse(localStorage.getItem('isFooterOpen') ?? 'false'),
        toggleFooter() {
            this.isFooterOpen = !this.isFooterOpen;
            localStorage.setItem('isFooterOpen', this.isFooterOpen);
        }
    }"
  class="flex flex-col border-t border-gray-200/50 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02] backdrop-blur-sm transition-all duration-300">
  

  <div
    x-show="isFooterOpen"
    x-collapse
    style="display: none;"
    class="px-3 pt-4 space-y-2">
    <div
      x-data="{
                theme: localStorage.getItem('theme') || 'system',
                setTheme(val) {
                    this.theme = val;
                    localStorage.setItem('theme', val);
                    document.documentElement.classList.toggle('dark', val === 'dark' || (val === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches));
                    window.dispatchEvent(new CustomEvent('theme-changed', { detail: val }));
                }
            }"
      class="p-1 mb-3 bg-gray-200/50 dark:bg-gray-900/50 rounded-lg ring-1 ring-gray-900/5 dark:ring-white/10">
      <div class="flex items-center justify-between w-full">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['light' => 'sun', 'dark' => 'moon', 'system' => 'computer-desktop']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mode => $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <button
          @click="setTheme('<?php echo e($mode); ?>')"
          :class="theme === '<?php echo e($mode); ?>' 
                            ? 'bg-white text-primary-600 shadow-sm dark:bg-gray-800 dark:text-primary-400' 
                            : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
          class="flex-1 flex items-center justify-center py-1.5 rounded-md transition-all duration-200 group"
          title="Tema <?php echo e(ucfirst($mode)); ?>">
          <?php echo e(svg('heroicon-m-'.$icon, 'w-4 h-4 transition-transform group-hover:scale-110')); ?>
        </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
    </div>

    <a
      href="<?php echo e(\App\Filament\Pages\AppSettings::getUrl()); ?>"
      class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-gray-600 transition-all duration-200 rounded-lg hover:bg-gray-100 hover:text-primary-600 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-primary-400 group">
      <div class="flex items-center gap-3">
        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-cog-6-tooth'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 text-gray-400 group-hover:text-primary-500 transition-colors']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
        <span>Pengaturan Aplikasi</span>
      </div>
    </a>
    <a
      href="<?php echo e(\App\Filament\Pages\AccountSettings::getUrl()); ?>"
      class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-gray-600 transition-all duration-200 rounded-lg hover:bg-gray-100 hover:text-primary-600 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-primary-400 group">
      <div class="flex items-center gap-3">
        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-cog-6-tooth'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 text-gray-400 group-hover:text-primary-500 transition-colors']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
        <span>Pengaturan Akun</span>
      </div>
    </a>


    <form action="<?php echo e(filament()->getLogoutUrl()); ?>" method="post">
      <?php echo csrf_field(); ?>
      <button
        type="submit"
        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-gray-500 transition-all duration-200 rounded-lg hover:bg-red-50 hover:text-red-600 dark:text-gray-400 dark:hover:bg-red-500/10 dark:hover:text-red-400 group">
        <div class="flex items-center gap-3">
          <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-arrow-left-on-rectangle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 text-gray-400 group-hover:text-red-500 transition-colors']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
          <span>Keluar Aplikasi</span>
        </div>
      </button>
    </form>

    <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent dark:via-white/10 mt-2"></div>
  </div>

  <button
    @click="toggleFooter()"
    type="button"
    class="flex items-center gap-3 p-3 transition-colors hover:bg-white dark:hover:bg-white/5 group text-start focus:outline-none"
    :class="!$store.sidebar.isOpen && 'justify-center px-0 py-4'">
    <div class="relative shrink-0">
      <?php if (isset($component)) { $__componentOriginalceea4679a368984135244eacf4aafeca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalceea4679a368984135244eacf4aafeca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.avatar.user','data' => ['size' => 'md','user' => $user,'class' => 'ring-2 ring-white dark:ring-gray-800 shadow-sm transition-transform group-hover:scale-105']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::avatar.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'md','user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user),'class' => 'ring-2 ring-white dark:ring-gray-800 shadow-sm transition-transform group-hover:scale-105']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalceea4679a368984135244eacf4aafeca)): ?>
<?php $attributes = $__attributesOriginalceea4679a368984135244eacf4aafeca; ?>
<?php unset($__attributesOriginalceea4679a368984135244eacf4aafeca); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalceea4679a368984135244eacf4aafeca)): ?>
<?php $component = $__componentOriginalceea4679a368984135244eacf4aafeca; ?>
<?php unset($__componentOriginalceea4679a368984135244eacf4aafeca); ?>
<?php endif; ?>
      <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white dark:border-gray-900 rounded-full shadow-sm"></span>
    </div>

    <div
      x-show="$store.sidebar.isOpen"
      x-transition
      class="flex items-center justify-between flex-1 min-w-0">
      <div class="flex flex-col truncate">
        <span class="text-sm font-bold text-gray-900 truncate dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
          <?php echo e($user->name); ?>

        </span>
        <span class="text-xs text-gray-500 truncate dark:text-gray-400">
          <?php echo e($user->role ?? 'Administrator'); ?>

        </span>
      </div>

      <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-chevron-up'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 text-gray-400 transition-transform duration-300','x-bind:class' => 'isFooterOpen && \'rotate-180\'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
    </div>
  </button>
</div><?php /**PATH E:\Magang\Inventaris AlKes\inventory-alkes\resources\views/filament/components/sidebar-footer.blade.php ENDPATH**/ ?>