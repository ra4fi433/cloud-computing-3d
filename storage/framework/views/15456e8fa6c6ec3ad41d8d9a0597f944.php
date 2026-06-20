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
        <h2 class="font-semibold text-xl text-white leading-tight">
            <?php echo e(__('Daftar Agenda')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8 justify-center">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mx-auto py-8">
                    <h1 class="text-2xl font-bold mb-6 flex justify-center text-4xl">
                        Daftar Agenda
                    </h1>

                    <form method="GET" action="<?php echo e(route('documents.index')); ?>" class="mb-6 px-6 py-2">
                        <div class="flex flex-wrap justify-end items-center space-x-4 mb-4 gap-4">
                            <div class="w-full sm:w-48">
                                <label for="bidang_id" class="block text-sm font-bold text-gray-700" style="font-size: 1.25rem; font-weight: bold; px-6 py-2">Bidang</label>
                                <select name="bidang_id" id="bidang_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2 px-3">
                                    <option value="all" <?php echo e($selectedBidangId == 'all' ? 'selected' : ''); ?>>Semua</option>
                                    <?php $__currentLoopData = $bidangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bidang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($bidang->id); ?>" <?php echo e($selectedBidangId == $bidang->id ? 'selected' : ''); ?>>
                                            <?php echo e($bidang->nama_bidang); ?> 
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="w-full sm:w-48">
                                <label for="tanggal_kegiatan" class="block font-bold text-gray-700" style="font-size: 1.25rem; font-weight: bold; px-6 py-2">Tanggal Kegiatan</label>
                                <input type="date" name="tanggal_kegiatan" id="tanggal_kegiatan"
                                    value="<?php echo e($selectedTanggalKegiatan); ?>"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2 px-3">
                            </div>
                            <div class="flex flex-wrap justify-center gap-2">
                                <button type="submit"
                                    class="w-full sm:w-48 bg-blue-600 text-white px-4 py-2 text-sm font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Terapkan Filter
                                </button>
                                
                                <a href="<?php echo e(url('/documents?bidang_id=all&tanggal_kegiatan=' . now()->toDateString())); ?>"
                                    class="w-full sm:w-48 flex-wrap bg-gray-500 text-white px-4 py-2 text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-center">
                                    Tampilkan Hari Ini
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive overflow-x-auto shadow-md sm:rounded-lg text-center">
                        <table class="w-full table-auto text-base text-gray-800">
                            <thead class="text-white uppercase" style="background-color: #004eb5;">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <?php if(Auth::check()): ?>
                                        <th scope="col" class="px-6 py-4">No Surat</th>
                                    <?php endif; ?>
                                    <th scope="col" class="px-6 py-4">Tanggal Kegiatan</th>
                                    <th scope="col" class="px-6 py-4">Waktu Kegiatan</th>
                                    <th scope="col" class="px-6 py-4">Instansi Pengirim</th>
                                    <th scope="col" class="px-6 py-4">Perihal</th>
                                    <th scope="col" class="px-6 py-4">Tempat Kegiatan</th>
                                    <th scope="col" class="px-6 py-4">Disposisi</th> 
                                    <th scope="col" class="px-6 py-4">Keterangan</th>
                                    <th scope="col" class="px-6 py-4">Lampiran</th>
                                    <th scope="col" class="px-6 py-4">Aksi</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="border-b border-gray-200 text-base font-medium">
                                        <td class="px-6 py-4"><?php echo e($loop->iteration); ?></td>
                                        <?php if(Auth::check()): ?>
                                            <td class="px-6 py-4"><?php echo e($document->no_surat); ?></td>
                                        <?php endif; ?>
                                        <td class="px-6 py-4"><?php echo e(Carbon\Carbon::parse($document->tanggal_kegiatan)->isoFormat('DD MMMM YYYY')); ?></td>
                                        <td class="px-6 py-4"><?php echo e(Carbon\Carbon::parse($document->waktu_kegiatan)->isoFormat('HH:mm')); ?> WIB</td>
                                        <td class="px-6 py-4"><?php echo e($document->instansi_pengirim); ?></td>
                                        <td class="px-6 py-4"><?php echo e($document->perihal); ?></td>
                                        <td class="px-6 py-4"><?php echo e($document->tempat_kegiatan); ?></td>
                                        <td class="px-6 py-4">
                                            <?php $__empty_2 = true; $__currentLoopData = $document->bidangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bidang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mr-1 mb-1">
                                                    <?php echo e($bidang->nama_bidang); ?>

                                                </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4"><?php echo e($document->keterangan); ?></td>
                                        <td class="px-6 py-4">
                                            <?php if($document->lampiran_path): ?>
                                                <a href="<?php echo e(asset('storage/' . $document->lampiran_path)); ?>" target="_blank" class="text-blue-600 hover:underline">
                                                    Unduh Lampiran
                                                </a>
                                            <?php else: ?>
                                                Tidak ada lampiran
                                            <?php endif; ?>
                                        </td>
                                       
                                            <td class="px-6 py-4 text-blue-700">
                                                <a href="<?php echo e(route('documents.show', $document->id)); ?>" class="hover:underline">Lihat Detail</a>
                                                
                                                
                                                
                                            </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="<?php echo e(Auth::check() ? '11' : '9'); ?>" class="px-6 py-4 text-center">Tidak ada agenda tersedia untuk kriteria ini.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH /var/www/html/resources/views/documents/index.blade.php ENDPATH**/ ?>