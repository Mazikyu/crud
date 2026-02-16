<div id="suc-msg"></div>


<script>
    function showSuccessMessage(message) {
        // Remove existing message if present
        const existing = document.getElementById('suc_msg');
        if (existing) {
            existing.remove();
        }


        const div = document.createElement('div');
        div.id = 'suc_msg';
        div.className =
            'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4';
        div.setAttribute('role', 'alert');

        div.innerHTML = `
            <span class="block sm:inline">${message}</span>
            <span id="btn" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                X
            </span>
        `;

        // document.querySelector('body').prepend(div);
        document.getElementById('suc-msg').appendChild(div);

        // Auto hide after 5s
        setTimeout(() => {
            div.style.display = 'none';
        }, 5000);

        // Manual close
        div.querySelector('#btn').onclick = () => {
            div.style.display = 'none';
        };
    }
</script>
