$(document).ready(function () {
    let selectedCategoryId = null;
    let draftPostId = null;

    /** Step Navigation **/
    function showStep(step) {
        $('#step1, #step2, #step3').addClass('d-none');
        $('#step' + step).removeClass('d-none');
    }

    $('.category-item').click(function () {
        $('.category-item').removeClass('active');
        $(this).addClass('active');
        selectedCategoryId = $(this).attr('data-category');
    });
    
    $('#continueStep1').click(function (e) {
        e.preventDefault();
    
        if (selectedCategoryId) {
          
            showStep(2); 
    
          
        } else {
            toastr.warning("Please select a category.", "Warning");
        }
    });
    



    $('#backToStep1').click(() => showStep(1));
    $('#backToStep2').click(() => showStep(2));

   
    function validateStep2() {
    let isValid = true;

    const formFields = {
        postName: $('#postName'),
        description: $('#description'),
        price: $('#price')
    };

    const quantityKg = $('#quantityKg');

    // Clear previous errors
    $('.form-control').removeClass('input-error border-danger');

   
    for (const key in formFields) {
        if (formFields[key].val().trim() === "") {
            isValid = false;
            formFields[key].addClass('input-error border-danger');
        }
    }

    const priceVal = $('#price').val().trim();
    if (!/^\d+(\.\d+)?$/.test(priceVal)) {
        isValid = false;
        $('#price').addClass('input-error border-danger');
    }

    return isValid;
}




    $('#save_details').click(function (e) {
        e.preventDefault();
    
        let isValid = validateStep2(); 
    
        if (isValid) {
            let formData = new FormData();
            formData.append("post_id", draftPostId);
    
            formData.append("item_name", $("#postName").val());
            formData.append("description", $("#description").val());
            formData.append("brand", $("#brand").val());
            formData.append("price", $("#price").val());
            formData.append("baseUrl", baseUrl);
            formData.append("category_id", selectedCategoryId);
             formData.append("quantity_pcs", $("#quantityPcs").val());
            formData.append("quantity_kg", $("#quantityKg").val());

            console.log(formData);
    
            $.ajax({
                url: "templates/demand_post_new/save_demand_details.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                if (response.success) {
                    toastr.success("Demand post saved successfully!");
                    // save_notification_details();
                     window.location.href = `${baseUrl}/manage_demand_post`;
                } else {
                    toastr.error("Error saving demand post: " + (response.message || ""));
                }
            },
                error: function (xhr, status, error) {
                    toastr.error("Something went wrong during Step 2 Save.", "Error");
                }
            });
        } else {
        
        }
    });

    /** Numeric Input Restriction for Quantity & Price **/
    $('#price ').on('input', function () {
        let value = $(this).val();
        if (!/^\d*$/.test(value)) {
            $(this).val(value.replace(/\D/g, ''));
            $(this).addClass('border-danger');
        } else {
            $(this).removeClass('border-danger');
        }
    });



    //   function save_notification_details() {
    //     const nextId = document.getElementById('postName').value;
    //     const userId = document.getElementById('user_id').value;
    //     const notificationData = {
    //         title: "New Demand Post Created",
    //         details: "A new demand post has been created",
    //         notification_url: "demand_post_details/" + nextId,
    //         from_user_id:  userId,
    //         entry_user_code: userId
    //     };

    //     console.log(notificationData);

    //     fetch('templates/demand_post_new/save_notification_details.php', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json'
    //             },
    //             credentials: 'include',
    //             body: JSON.stringify(notificationData),
    //         })
    //         .then(response => response.json()) 
    //         .then(data => {
    //             console.log('Server Response:', data);
                
    //         })
    //         .catch(error => {
    //             console.error('Fetch error:', error.message);
    //             alert('Failed to send data');
    //         });

    //     }

    
});
