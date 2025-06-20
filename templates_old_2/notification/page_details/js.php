<script>
function goBack() {
    if (document.referrer) {
        window.history.back(); 
    } else {
        window.location.href = "your-fallback-url.php"; 
    }
}
</script>
