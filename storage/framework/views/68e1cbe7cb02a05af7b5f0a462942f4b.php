<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-white leading-tight ">
            <?php echo e(__('Landing Page')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <!-- ucapan selamat datang -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center" style="font-size: 2rem; font-weight: bold; diplay: inline-block;">
                    <h3>
                             <?php echo e(__("Selamat Datang Di E-Agenda")); ?>

                    </h3>
                    <h4>
                             <?php echo e(__("Dinas Kependudukan dan Pencatatan Sipil Kota Semarang")); ?>

                    </h4>
                </div>

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 20px; margin-bottom: 20px;">
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Kartu: Nomor Urut Surat -->
                            <div class="bg-[#004eb5] overflow-hidden shadow-sm sm:rounded-lg" style="background-color: #004eb5;">
                                    <div class="p-6">
                                        <h3 class="text-xl font-bold text-white mb-2 text-left">
                                            <?php echo e(__("Nomor Urut Surat")); ?>

                                        </h3>
                                        
                                        <div class="text-center text-4xl font-extrabold text-white mt-4">
                                            <h3 class="text-xl font-bold text-gray-900 mb-2 text-center text-blue-600 " style="font-size: 2rem; font-weight: bold; color: #fed324;">
                                                
                                                <?php echo e($nomorUrutTerakhir ?? '0'); ?>

                                            </h3>
                                        </div>
                                    </div>
                            </div>
                        <!-- Kartu: Jumlah Surat keluar -->

                        <!-- Kartu: Kegiatan Hari Ini -->
                            <div class="border border-4px bg-white overflow-hidden shadow-sm sm:rounded-lg" style=" border-color: #004eb5;">
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-[#004eb5] mb-2 text-left" style="color: #004eb5; font-weight: bold;">
                                        <?php echo e(__("Kegiatan Hari Ini")); ?>

                                    </h3>
                                    <div class="text-center text-4xl font-extrabold text-[#fed324] mt-4"style="font-size: 2rem; font-weight: bold; color: #fed324ff;">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 text-center text-blue-600 " style="font-size: 2rem; font-weight: bold; color: #004eb5;">
                                            
                                            <?php echo e($kegiatanHariIni); ?>

                                        </h3>
                                    </div>
                                </div>
                            </div>
                        <!-- Kartu: Jumlah Surat Masuk -->

                        <!-- Kartu: Kegiatan Besok -->
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="background-color: #004eb5;">
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-[#004eb5] mb-2 text-left" style="color: #ffffffff; font-weight: bold;">
                                        <?php echo e(__("Kegiatan Besok")); ?>

                                    </h3>
                                    <div class="text-center text-4xl font-extrabold text-white mt-4">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 text-center text-blue-600 " style="font-size: 2rem; font-weight: bold; color: rgba(255, 255, 255, 1);">
                                            
                                            <?php echo e($kegiatanBesok); ?>

                                        </h3>
                                    </div>
                                </div>
                            </div>
                        <!-- Kartu: Jumlah Surat Masuk -->
                    </div>
                </div>
            </div>
            <!-- selamat-datang -->   
        </div>                 
    </div>
                    
                    
    </div>
    <!-- ucapan selamat datang -->

        
        </div>
                <!-- <div class="p-6 text-center text-gray-700" style="font-size: 1.5rem;">
                    <?php echo e(__("Silahkan uji fitur lainnya")); ?>

                </div>

                <div class="p-6 text-center text-gray-500" style="font-size: 1.2rem;">
                    <?php echo e(__("Terima kasih atas kesabaran Anda.")); ?>

                </div> -->
            </div>
        </div>
    </div>

    <!-- Uncomment this section if you want to add a link to the dashboard -->
    <!-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center" style="font-size: 2rem; font-weight: bold;">
                        <?php echo e(__("Selamat Datang Di E-Agenda Dinas Kependudukan dan Pencatatan Sipil Kota Semarang")); ?>

                    </div>

                    <div class="p-6 text-center" style="font-size: 2rem; font-weight: bold; color: #004eb5; ">
                         <a href="<?php echo e(route('documents.index')); ?>" class="">
                            <?php echo e(__("menuju Dashboard")); ?>

                        </a>
                    </div>
            </div>
        </div>
    </div> -->
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/dashboard.blade.php ENDPATH**/ ?>