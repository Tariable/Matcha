<?php $__env->startSection('title', 'Add Photos'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <form action="/photos" name="photo-form" id="photo-form" method="post" enctype="multipart/form-data">
            <input name="photo" onchange="sendImage()" type="file" class="pb-3">
            <?php echo csrf_field(); ?>
        </form>
        <div id="errorDiv"></div>
        <div id="gallery"></div>
    </div>

    <script>
        async function sendImage() {
            let urlStore = '/photos';

            let headers = new Headers();
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            headers.append('X-CSRF-TOKEN', token);
            headers.append('Accept', 'application/json');

            let formData = new FormData();
            let input = document.querySelector('input[type="file"]');
            formData.append('photo', input.files[0]);

            let option = {
                method: 'POST',
                headers: headers,
                body: formData
            }

            let storeResponse = await fetch(urlStore, option);

            if (storeResponse.ok) {
                removeAllChildElemFrom("errorDiv");
                displayLastPhoto();
            } else {
                let jsonErrors = await storeResponse.json();
                jsonErrors.errors.photo.forEach(function (error) {
                    let errorElem = document.createElement('p');
                    errorElem.innerHTML = error;
                    document.getElementById('errorDiv').appendChild(errorElem);
                })
            }

            async function displayLastPhoto() {
                // removeAllChildElemFrom('gallery');
                let urlShow = "/lastPhoto/<?php echo e($profileId); ?>";
                let showResponse = await fetch(urlShow);
                let photo = await showResponse.json();
                let photoElem = document.createElement('img');
                photoElem.src = photo.path;
                photoElem.id = photo.id;
                photoElem.width = 200;
                document.getElementById('gallery').appendChild(photoElem);
            }

            function removeAllChildElemFrom(Div) {
                let div = document.getElementById(Div);
                while (div.firstChild) {
                    div.removeChild(div.firstChild);
                }
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/photos/create.blade.php ENDPATH**/ ?>