Set-Content -Path "resources\views\partials\alert.blade.php" -Value @'
@if (session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif
'@