<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
<script>
    function displayImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('cimg').setAttribute('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function deleteImg() {
        document.getElementById('cimg').setAttribute('src', './Images/placeholder.jpg');
    }
</script>
<Script>
    // Script For Close alert

    var alert_del = document.querySelectorAll('.alert-del');
    alert_del.forEach((x) =>
        x.addEventListener('click', function() {
            x.parentElement.classList.add('hidden');
        })
    );
</Script>
