<?php $__env->startSection('title', 'Add Photos'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
            <form action="/photos" name="photo-form" id="photo-form" method="post" enctype="multipart/form-data">
                <input name="photo" onchange="sendImage()" type="file" class="pb-3">
                <span id="photoError"></span>
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
    <script>
        function sendImage() {
            let error = document.getElementById('photoError');
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let url = '/photos';
            let input = document.querySelector('input[type="file"]');
            let headers = {"X-CSRF-TOKEN": token};
            let formData = new FormData();
            formData.append('photo', input.files[0]);

            let option = {
                method: 'POST',
                headers: headers,
                body: formData
            }

            fetch(url, option)
                .then((res) => res.json())
                .then((data) => alert(data))
                .catch((error) => alert(error))
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/photo/create.blade.php ENDPATH**/ ?>