@if (session()->has('success'))
    <div id="suc_msg" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
        role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
        <span id="btn" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
            X
        </span>
    </div>
@endif


<script>
    const suc_msg = document.getElementById('suc_msg');
    const btn = document.getElementById('btn');

    // Auto hide after 5 seconds
    setTimeout(() => {
        if (suc_msg) {
            suc_msg.style.display = 'none';
        }
    }, 5000);

    // Hide on button click
    if (btn) {
        btn.onclick = () => {
            suc_msg.style.display = 'none';
        };
    }
</script>
