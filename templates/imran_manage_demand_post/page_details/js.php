<script src="templates/imran_manage_demand_post/controller.js?v=<?php echo $version; ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- google API key -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDh2es6pslELdbUx-qh7DL60Rypi7epPZQ&libraries=places"></script>

<script>
  function toggleCategoryOptions() {
    const options = document.getElementById('customCategoryOptions');
    const select = document.querySelector('.custom-select-wrapper .custom-select');
    const isOpen = options.style.display === 'block';
    options.style.display = isOpen ? 'none' : 'block';
    select.classList.toggle('open', !isOpen);
  }

  function filterCategoryOptions(query) {
    let items = document.querySelectorAll('#customCategoryOptions div:not(.custom-search):not(#noCategoryResult)');
    query = query.toLowerCase();
    let matchCount = 0;

    items.forEach(item => {
      const isMatch = item.innerText.toLowerCase().includes(query);
      item.style.display = isMatch ? 'block' : 'none';
      if (isMatch) matchCount++;
    });

    document.getElementById('noCategoryResult').style.display = matchCount === 0 ? 'block' : 'none';
  }

  function selectCategoryOption(elem, value) {
    document.querySelector('.custom-select-wrapper .custom-select').innerText = elem.innerText;
    document.getElementById('category_id').value = value;
    document.getElementById('customCategoryOptions').style.display = 'none';
    get_demand_post_list_category();
  }

  // Optional: Close dropdowns when clicking outside
  document.addEventListener('click', function(e) {
    const catWrapper = document.querySelector('.custom-select-wrapper');
    if (!catWrapper.contains(e.target)) {
      document.getElementById('customCategoryOptions').style.display = 'none';
    }
  });
</script>