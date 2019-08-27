<?php $__env->startSection('title', 'Add Photos'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
            <form action="/photos" name="photo-form" id="photo-form" method="post" enctype="multipart/form-data">
                <input name="photo" onchange="sendImage()" type="file" class="pb-3">
                <?php echo csrf_field(); ?>
            </form>
            <div id="errors"></div>
            <button id="showImage" class="btn btn-primary">Show images Ajax - fetch request</button>
    </div>

    <script>
        function sendImage() {
            let url = '/photos';
            let errorDiv = document.getElementById('errors');
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let input = document.querySelector('input[type="file"]');
            let headers = new Headers();
            headers.append('X-CSRF-TOKEN', token);
            headers.append('Accept', 'application/json');
            let formData = new FormData();
            formData.append('photo', input.files[0]);

            let option = {
                method: 'POST',
                headers: headers,
                body: formData
            }

            fetch(url, option)
                .then(response => response.json())
                .then(function(response) {
                    response.errors.photo.forEach(function(error){
                        let errorElem = document.createElement('span');
                        errorElem.innerHTML = error;
                        errorDiv.appendChild(errorElem);
                    })
                })
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/photo/create.blade.php ENDPATH**/ ?>