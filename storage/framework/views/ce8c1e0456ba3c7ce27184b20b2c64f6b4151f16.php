<?php $__env->startSection('title', 'Add Photos'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
            <form action="/photos" method="post" enctype="multipart/form-data">
                <input name="photo[]" type="file" class="pb-3">
                <input name="photo[]" type="file" class="pb-3">
                <input name="photo[]" type="file" class="pb-3">
                <input name="photo[]" type="file" class="pb-3">
                <input name="photo[]" type="file" class="pb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
                <?php echo csrf_field(); ?>
            </form>
    </div>


<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/photo/create.blade.php ENDPATH**/ ?>