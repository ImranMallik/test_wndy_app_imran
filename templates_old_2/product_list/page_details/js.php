<script src="templates/product_list/controller.js?v=<?php echo $version; ?>"></script>
<script>
  function toggleOptions() {
    document.getElementById('customOptions').style.display =
      document.getElementById('customOptions').style.display === 'block' ? 'none' : 'block';
  }


function filterOptions(query) {
  let items = document.querySelectorAll('#customOptions div:not(.custom-search):not(#noResult)');
  query = query.toLowerCase();
  let matchCount = 0;

  items.forEach(item => {
    const isMatch = item.innerText.toLowerCase().includes(query);
    item.style.display = isMatch ? 'block' : 'none';
    if (isMatch) matchCount++;
  });

  document.getElementById('noResult').style.display = matchCount === 0 ? 'block' : 'none';
}

  function selectOption(elem, value) {
    document.querySelector('.custom-select').innerText = elem.innerText;
    document.getElementById('seller_id').value = value;
    document.getElementById('customOptions').style.display = 'none';
    getProductList(); // optional: trigger original function
  }

  // Close if clicked outside
  document.addEventListener('click', function(e) {
    if (!document.querySelector('.custom-select-wrapper').contains(e.target)) {
      document.getElementById('customOptions').style.display = 'none';
    }
  });
  
</script>